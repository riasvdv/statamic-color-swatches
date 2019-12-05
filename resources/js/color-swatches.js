Statamic.booting(() => {
    Statamic.component('color_swatches-fieldtype', require('./ColorSwatchesFieldtype.vue'));
    Statamic.component('color_swatches-fieldtype-index', require('./ColorSwatchesFieldtypeIndex.vue'));
});
