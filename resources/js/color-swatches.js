import ColorSwatchesFieldtype from "./ColorSwatchesFieldtype.vue";
import ColorSwatchesFieldtypeIndex from "./ColorSwatchesFieldtypeIndex.vue";

Statamic.booting(() => {
  Statamic.$components.register(
    "color_swatches-fieldtype",
    ColorSwatchesFieldtype
  );
  Statamic.$components.register(
    "color_swatches-fieldtype-index",
    ColorSwatchesFieldtypeIndex
  );
});
