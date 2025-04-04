<script setup lang="ts">
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'

import type { Transaction } from '@/types/Transaction';

defineProps<{
  transactions: Transaction[]
}>()
</script>

<template>
  <Table>
    <TableCaption>A list of transactions.</TableCaption>
    <TableHeader>
      <TableRow>
        <TableHead class="w-[140px]">Order id</TableHead>
        <TableHead class="">
          Amount
        </TableHead>
        <TableHead>Transaction Type</TableHead>
        <TableHead>User</TableHead>
        <TableHead class="text-right">
          Time
        </TableHead>
      </TableRow>
    </TableHeader>
    <TableBody>
      <TableRow v-for="transaction in transactions" :key="transaction.id">
        <TableCell class="font-medium">{{ transaction.order_id }}</TableCell>
        <TableCell class="">
          {{ transaction.amount }}
        </TableCell>
        <TableCell>{{ transaction.type }}</TableCell>
        <TableCell>{{ transaction.user_fullname }}</TableCell>
        <TableCell class="text-right">
          {{new Date(transaction.timestamp).toLocaleDateString("id") }} {{ new Date(transaction.timestamp).toLocaleTimeString("id") }}
        </TableCell>
      </TableRow>
    </TableBody>
  </Table>
</template>
