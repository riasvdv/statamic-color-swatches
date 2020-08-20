import ColorSwatchesFieldtype from "./ColorSwatchesFieldtype";
import ColorSwatchesFieldtypeIndex from "./ColorSwatchesFieldtypeIndex";

Statamic.booting(() => {
  Statamic.component("color_swatches-fieldtype", ColorSwatchesFieldtype);
  Statamic.component(
    "color_swatches-fieldtype-index",
    ColorSwatchesFieldtypeIndex
  );
});
