<template>
  <component :is="layoutComponent">
    <router-view />
  </component>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useRoute } from 'vue-router'

import AppLayout from './layouts/AppLayout.vue'
import ModalLayout from './layouts/ModalLayout.vue'

const route = useRoute()

const layouts: Record<string, any> = {
  default: AppLayout,
  modal: ModalLayout,
}

const layoutComponent = computed(() => {
  return layouts[route.meta.layout as string] || AppLayout
})
</script>
