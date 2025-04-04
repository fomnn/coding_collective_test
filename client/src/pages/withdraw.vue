<script lang="ts" setup>
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label'
import { Button } from '@/components/ui/button'
import { reactive } from 'vue';
import apiFetch from '@/lib/ofetch';
import { toast } from 'vue-sonner';

const withdrawData = reactive<{
  fullname: string,
  amount?: number
}>({
  fullname: "",
  amount: undefined
})

async function onSubmit() {
  const data = {
    amount: withdrawData.amount,
    timestamp: new Date().toISOString()
  }

  const fullnameBase64 = btoa(withdrawData.fullname)
  await apiFetch("/api/withdraw", {
    method: "POST",
    body: data,
    headers: {
      Authorization: `Bearer ${fullnameBase64}`
    },
    onResponse: ({response}) => {
      if (response.ok) {
        toast('Withdraw Success')
      } else {
        toast('Withdraw Failed')
      }

      withdrawData.amount = undefined
      withdrawData.fullname = ""
    }
  })
}
</script>

<template>
  <div class="w-1/2">
    <h1 class="text-2xl font-semibold">Withdraw</h1>
    <form class="mt-4 flex flex-col gap-2" @submit.prevent="onSubmit">
      <div class="grid w-full max-w-sm items-center gap-1.5">
        <Label for="fullname">Fullname</Label>
        <Input id="fullname" type="text" placeholder="fullname" v-model="withdrawData.fullname" />
      </div>
      <!-- <div class="grid w-full max-w-sm items-center gap-1.5">
        <Label for="order_id">Order id</Label>
        <Input id="order_id" type="text" placeholder="order id" />
      </div> -->
      <div class="grid w-full max-w-sm items-center gap-1.5">
        <Label for="amount">Amount</Label>
        <div class="relative w-full max-w-sm items-center">
          <Input id="amount" type="number" placeholder="amount..." class="pl-10" v-model="withdrawData.amount" />
          <span class="absolute start-0 inset-y-0 flex items-center justify-center px-2">
            <span class="text-zinc-500 text-sm">Rp</span>
          </span>
        </div>
      </div>
      <Button class="max-w-sm mt-2">Withdraw</Button>
    </form>
  </div>
</template>
