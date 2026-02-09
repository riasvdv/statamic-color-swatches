<script setup>
import { computed, nextTick } from "vue";
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

function ariaLabel(color) {
  const values = Array.isArray(color.value)
    ? color.value.join(", ")
    : color.value;

  return `${color.label}: ${values}${isActive(color) ? " (selected)" : ""}`;
}

const sizeClass = computed(() => {
  const size = props.config.swatch_size || "medium";
  return `color-swatches-size-${size}`;
});

const containerStyle = computed(() => {
  const columns = props.config.columns || "auto";
  if (columns === "auto") return {};
  return {
    display: "grid",
    gridTemplateColumns: `repeat(${columns}, 1fr)`,
    gap: "8px"
  };
});

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
  <div
    :class="['color-swatches-container', sizeClass]"
    :style="containerStyle"
    role="radiogroup"
    :aria-label="props.meta?.display || 'Color swatches'"
  >
    <div v-if="props.config.allow_blank" class="color-swatches-item">
      <button
        :class="[
          'color-swatches-button',
          'color-swatches-none',
          !props.value ? 'active' : ''
        ]"
        :aria-label="'None' + (!props.value ? ' (selected)' : '')"
        :aria-checked="!props.value"
        role="radio"
        @click="clear"
      />
      <span v-if="props.config.show_labels" class="color-swatches-label">
        None
      </span>
    </div>
    <div
      v-for="configColor in props.config.colors"
      :key="configColor.label"
      class="color-swatches-item"
    >
      <button
        :class="[
          'color-swatches-button',
          isActive(configColor) ? 'active' : ''
        ]"
        :style="
          'background: ' + createCssBackgroundFromColors(configColor.value)
        "
        :aria-label="ariaLabel(configColor)"
        :aria-checked="isActive(configColor)"
        role="radio"
        @click="selectColor(configColor)"
      >
        <svg
          v-if="isActive(configColor)"
          class="color-swatches-checkmark"
          aria-hidden="true"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="3"
          stroke-linecap="round"
          stroke-linejoin="round"
        >
          <polyline points="20 6 9 17 4 12" />
        </svg>
      </button>
      <span v-if="props.config.show_labels" class="color-swatches-label">
        {{ configColor.label }}
      </span>
    </div>
  </div>
</template>
