<script setup>
import { nextTick } from "vue";
import { Fieldtype } from "@statamic/cms";
import createCssBackgroundFromColors from "./createCssBackgroundFromColors";

const emit = defineEmits(Fieldtype.emits);
const props = defineProps(Fieldtype.props);
const { expose, defineReplicatorPreview, update } = Fieldtype.use(emit, props);
defineExpose(expose);

defineReplicatorPreview(() => props.value?.label || "");

function isActive(color) {
  if (!props.value) return false;

  return color.label === props.value.label;
}

function selectColor(color) {
  if (isActive(color)) {
    if (props.config.allow_blank) {
      update(null);
    }
    return;
  }

  update({ label: color.label, value: color.value });
}

function clear() {
  update(null);
}

if (props.config.default && props.value === props.config.default) {
  const matches = props.config.colors.filter(
    color => color.label === props.config.default
  );
  if (matches.length > 0) {
    nextTick(() => {
      update({
        label: matches[0].label.toString(),
        value: matches[0].value.toString()
      });
    });
  }
}
</script>

<template>
  <div>
    <button
      v-if="props.config.allow_blank"
      :class="[
        'color-swatches-button',
        'color-swatches-none',
        !props.value ? 'active' : ''
      ]"
      title="None"
      @click="clear"
    />
    <button
      v-for="configColor in props.config.colors"
      :class="['color-swatches-button', isActive(configColor) ? 'active' : '']"
      :title="configColor.label"
      :style="'background: ' + createCssBackgroundFromColors(configColor.value)"
      @click="selectColor(configColor)"
    />
  </div>
</template>
