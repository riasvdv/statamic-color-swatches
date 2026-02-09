<script setup>
import { computed, nextTick } from "vue";
import { Fieldtype } from "@statamic/cms";
import createCssBackgroundFromColors from "./createCssBackgroundFromColors";

const emit = defineEmits(Fieldtype.emits);
const props = defineProps(Fieldtype.props);
const { expose, defineReplicatorPreview, update } = Fieldtype.use(emit, props);
defineExpose(expose);

const maxItems = computed(() => props.config.max_items ?? 1);
const minItems = computed(() => props.config.min_items ?? 0);
const isMultiSelect = computed(() => maxItems.value !== 1);

defineReplicatorPreview(() => {
  if (isMultiSelect.value) {
    return (props.value || []).map((item) => item.label).join(", ");
  }

  return props.value?.label || "";
});

function isActive(color) {
  if (!props.value) return false;

  if (isMultiSelect.value) {
    return (props.value || []).some((item) => item.label === color.label);
  }

  return color.label === props.value.label;
}

function selectColor(color) {
  if (isMultiSelect.value) {
    selectMultiple(color);
    return;
  }

  if (isActive(color)) {
    if (props.config.allow_blank) {
      update(null);
    }
    return;
  }

  update({ label: color.label, value: color.value });
}

function selectMultiple(color) {
  const current = Array.isArray(props.value) ? [...props.value] : [];

  const index = current.findIndex((item) => item.label === color.label);

  if (index !== -1) {
    if (minItems.value > 0 && current.length <= minItems.value) {
      return;
    }
    current.splice(index, 1);
    update(current);
    return;
  }

  if (maxItems.value > 0 && current.length >= maxItems.value) {
    return;
  }

  current.push({ label: color.label, value: color.value });
  update(current);
}

function clear() {
  if (isMultiSelect.value) {
    if (minItems.value > 0) return;
    update([]);
    return;
  }

  update(null);
}

function ariaLabel(color) {
  const values = Array.isArray(color.value)
    ? color.value.join(", ")
    : color.value;

  return `${color.label}: ${values}${isActive(color) ? " (selected)" : ""}`;
}

const hasSelection = computed(() => {
  if (isMultiSelect.value) {
    return Array.isArray(props.value) && props.value.length > 0;
  }

  return !!props.value;
});

const isAtMax = computed(() => {
  if (!isMultiSelect.value || maxItems.value <= 0) return false;

  return (props.value || []).length >= maxItems.value;
});

const isAtMin = computed(() => {
  if (!isMultiSelect.value || minItems.value <= 0) return false;

  return (props.value || []).length <= minItems.value;
});

const ariaRole = computed(() => (isMultiSelect.value ? "group" : "radiogroup"));
const itemAriaRole = computed(() =>
  isMultiSelect.value ? "checkbox" : "radio",
);

const sizeClass = computed(() => {
  const size = props.config.swatch_size || "medium";
  return `color-swatches-size-${size}`;
});

const containerStyle = computed(() => {
  const columns = props.config.columns || "auto";
  if (columns === "auto") return {};
  return {
    display: "grid",
    gridTemplateColumns: `repeat(${columns}, min-content)`,
    gap: "8px",
  };
});

if (props.config.default && props.value === props.config.default) {
  const matches = props.config.colors.filter(
    (color) => color.label === props.config.default,
  );
  if (matches.length > 0) {
    nextTick(() => {
      update({
        label: matches[0].label.toString(),
        value: matches[0].value.toString(),
      });
    });
  }
}
</script>

<template>
  <div
    :class="['color-swatches-container', sizeClass]"
    :style="containerStyle"
    :role="ariaRole"
    :aria-label="props.meta?.display || 'Color swatches'"
  >
    <div
      v-if="props.config.allow_blank && !(isMultiSelect && minItems > 0)"
      class="color-swatches-item"
    >
      <button
        :class="[
          'color-swatches-button',
          'color-swatches-none',
          !hasSelection ? 'active' : '',
        ]"
        :aria-label="'None' + (!hasSelection ? ' (selected)' : '')"
        :aria-checked="!hasSelection"
        :role="itemAriaRole"
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
          isActive(configColor) ? 'active' : '',
          isAtMax && !isActive(configColor) ? 'color-swatches-disabled' : '',
        ]"
        :style="
          'background: ' + createCssBackgroundFromColors(configColor.value)
        "
        :aria-label="ariaLabel(configColor)"
        :aria-checked="isActive(configColor)"
        :role="itemAriaRole"
        :disabled="isAtMax && !isActive(configColor)"
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
