<template>
  <div>
    <button
      v-for="configColor in config.colors"
      :class="[isActive(configColor) ? 'active' : '']"
      :title="configColor.label"
      :style="'background: ' + cssBackground(configColor.value)"
      @click="isActive(configColor) ? update(null) : update({ label: configColor.label, value: configColor.value })"
    />
  </div>
</template>

<script>
import createCssBackgroundFromColors from "./createCssBackgroundFromColors";

export default {
  mixins: [Fieldtype],

  methods: {
    cssBackground: function(colors) {
      return createCssBackgroundFromColors(colors);
    },
    getReplicatorPreviewText() {
      if (!this.value) return;

      return this.value.label;
    },
    isActive(color) {
      if (! this.value) return false;

      return color.label === this.value.label
    }
  },

  mounted: function() {
    if (this.config.default && this.value === this.config.default) {
      const matches = this.config.colors.filter(
        color => color.label === this.config.default
      );
      if (matches.length > 0) {
        this.$nextTick(() => {
          this.update({
            label: matches[0].label.toString(),
            value: matches[0].value.toString()
          });
        });
      }
    }
  }
};
</script>
