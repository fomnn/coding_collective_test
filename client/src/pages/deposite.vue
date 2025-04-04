<script lang="ts" setup>
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label'
import { Button } from '@/components/ui/button'
import apiFetch from '@/lib/ofetch';
import { reactive } from 'vue';
import { toast } from 'vue-sonner'

const depositeData = reactive<{
  fullname: string,
  order_id: string,
  amount?: number
}>({
  fullname: "",
  order_id: "",
  amount: undefined
})

async function onSubmit() {
  const data = {
    order_id: depositeData.order_id,
    amount: depositeData.amount,
    timestamp: new Date().toISOString()
  }

  const fullnameBase64 = btoa(depositeData.fullname)
  await apiFetch("/api/deposite", {
    method: "POST",
    body: data,
    headers: {
      Authorization: `Bearer ${fullnameBase64}`
    },
    onResponse: ({response}) => {
      if (response.ok) {
        toast('Deposite Success')
      } else {
        toast('Deposite Failed')
      }

      depositeData.amount = undefined
      depositeData.fullname = ""
      depositeData.order_id = ""
    }
  })
}
</script>

<template>
  <div class="w-1/2">
    <h1 class="text-2xl font-semibold">Deposite</h1>
    <form class="mt-4 flex flex-col gap-2" @submit.prevent="onSubmit">
      <div class="grid w-full max-w-sm items-center gap-1.5">
        <Label for="fullname">Fullname</Label>
        <Input id="fullname" type="text" placeholder="fullname" v-model="depositeData.fullname" />
      </div>
      <div class="grid w-full max-w-sm items-center gap-1.5">
        <Label for="order_id">Order id</Label>
        <Input id="order_id" type="text" placeholder="order id" v-model="depositeData.order_id" />
      </div>
      <div class="grid w-full max-w-sm items-center gap-1.5">
        <Label for="amount">Amount</Label>
        <div class="relative w-full max-w-sm items-center">
          <Input id="amount" type="number" placeholder="amount..." class="pl-10" v-model="depositeData.amount" />
          <span class="absolute start-0 inset-y-0 flex items-center justify-center px-2">
            <span class="text-zinc-500 text-sm">Rp</span>
          </span>
        </div>
      </div>
      <Button class="max-w-sm mt-2">Deposite</Button>
    </form>
  </div>
</template>
