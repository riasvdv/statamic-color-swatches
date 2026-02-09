<script setup>
import { computed } from "vue";
import { IndexFieldtype } from "@statamic/cms";
import createCssBackgroundFromColors from "./createCssBackgroundFromColors";

const props = defineProps(IndexFieldtype.props);

const items = computed(() => {
  if (Array.isArray(props.value)) {
    return props.value;
  }

  if (props.value) {
    return [props.value];
  }

  return [];
});
</script>

<template>
  <div class="flex items-center gap-1">
    <div
      v-for="(item, index) in items"
      :key="index"
      class="w-4 h-4 rounded-full"
      :style="'background: ' + createCssBackgroundFromColors(item.value)"
      :title="item.label || ''"
    />
  </div>
</template>
