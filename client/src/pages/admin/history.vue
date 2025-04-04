<script lang="ts" setup>
import TransactionTable from '@/components/TransactionTable.vue';
import apiFetch from '@/lib/ofetch';
import type { Transaction } from '@/types/Transaction';
import { computed, onMounted, ref } from 'vue';
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select';
import { Input } from '@/components/ui/input';
import { Search } from 'lucide-vue-next';

const transactions = ref<Transaction[]>();

async function fetchTransactions() {
  const res = await apiFetch<{ transactions: Transaction[]; }>("/api/transactions");
  transactions.value = res.transactions;
}

const transactionType = ref('all');
const search = ref('');

const filteredTransactions = computed(() => {
  const transactionsFiltered: Transaction[] = [];
  if (transactionType.value === 'all') {
    if (transactions.value) {
      transactionsFiltered.push(...transactions.value);
    }
  }
  else {
    if (transactions.value) {
      for (const transaction of transactions.value) {
        if (transaction.type === transactionType.value) {
          transactionsFiltered.push(transaction);
        }
      }
    }
  }
  if (search.value) {
    const transactionsFilteredBySearch: Transaction[] = [];
    for (const transaction of transactionsFiltered) {
      if (transaction.user_fullname.toLowerCase().includes(search.value.toLowerCase())) {
        transactionsFilteredBySearch.push(transaction);
      }
    }
    return transactionsFilteredBySearch;
  }
  return transactionsFiltered;
});

onMounted(() => {
  fetchTransactions();
});
</script>

<template>
  <div>
    <h1 class="text-2xl font-bold mb-4">Transaction History</h1>
    <div class="mb-6 flex items-center justify-end gap-8">
      <div class="flex items-center gap-2">
        <span>Transaction type</span>
        <Select v-model="transactionType">
          <SelectTrigger>
            <SelectValue placeholder="Select transaction type" />
          </SelectTrigger>
          <SelectContent>
            <SelectItem value="all">
              All
            </SelectItem>
            <SelectItem value="deposite">
              Deposite
            </SelectItem>
            <SelectItem value="withdraw">
              Withdraw
            </SelectItem>
            <!-- <SelectGroup>
              <SelectLabel>Fruits</SelectLabel>
            </SelectGroup> -->
          </SelectContent>
        </Select>
      </div>
      <div class="relative w-full max-w-sm items-center">
        <Input id="search" type="text" placeholder="Search by user fullname..." class="pl-10" v-model="search" />
        <span class="absolute start-0 inset-y-0 flex items-center justify-center px-2">
          <Search class="size-6 text-muted-foreground" />
        </span>
      </div>
    </div>
    <TransactionTable :transactions="filteredTransactions" v-if="filteredTransactions" />
  </div>
</template>
