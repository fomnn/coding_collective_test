<script lang="ts">
export const iframeHeight = '800px'
export const description
  = 'A simple sidebar with navigation grouped by section.'
</script>

<script setup lang="ts">
import { Toaster } from '@/components/ui/sonner'
import LayoutDefault from './layouts/LayoutDefault.vue'
import LayoutAdmin from './layouts/LayoutAdmin.vue'
</script>
<template>
  <Toaster />
  <LayoutAdmin v-if="$route.path.startsWith('/admin')" />
  <LayoutDefault v-else />
</template>
