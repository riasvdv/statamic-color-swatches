<script setup>
import { IndexFieldtype } from '@statamic/cms';
import createCssBackgroundFromColors from "./createCssBackgroundFromColors";

const props = defineProps(IndexFieldtype.props);
</script>

<template>
  <div
    class="w-4 h-4 rounded-full"
    :style="'background: ' + createCssBackgroundFromColors(props.value?.value)"
    :title="props.value?.label || ''"
  />
</template>
