<script setup lang="ts">
import {
  Sidebar,
  SidebarContent,
  SidebarGroup,
  SidebarGroupContent,
  SidebarGroupLabel,
  SidebarHeader,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
  type SidebarProps,
  SidebarRail,
} from '@/components/ui/sidebar'

// import {useRoute} from 'vue'

const props = defineProps<SidebarProps>()
// const route = useRoute()

// This is sample data.
const data = {
  navMain: [
    {
      title: 'Transaction',
      url: '/admin/dashboard',
      items: [
        {
          title: 'history',
          url: '/admin/history',
        },
        // {
        //   title: 'Withdraw',
        //   url: '/withdraw',
        // },
      ],
    },
  ],
}
</script>

<template>
  <Sidebar v-bind="props">
    <SidebarHeader>
      <div class="">
        Test Coding Collective | Admin
      </div>
    </SidebarHeader>
    <SidebarContent>
      <SidebarGroup v-for="item in data.navMain" :key="item.title">
        <SidebarGroupLabel>{{ item.title }}</SidebarGroupLabel>
        <SidebarGroupContent>
          <SidebarMenu>
            <SidebarMenuItem v-for="childItem in item.items" :key="childItem.title">
              <SidebarMenuButton as-child :is-active="false">
                <RouterLink :to="childItem.url">{{ childItem.title }}</RouterLink>
              </SidebarMenuButton>
            </SidebarMenuItem>
          </SidebarMenu>
        </SidebarGroupContent>
      </SidebarGroup>
    </SidebarContent>
    <SidebarRail />
  </Sidebar>
</template>
