Vue.component('color_swatches-fieldtype', {

    mixins: [Fieldtype],

    template: `
        <div>
            <button 
                v-for="(label, value) in config.colors" 
                :class="[label === data.label ? 'active' : '']"
                :title="label"
                :style="'background: ' + cssBackground(value)"
                @click="data = { label: label, value: value }"
            ></button>
        </div>
    `,

    methods: {
        cssBackground: function (colors) {
            if (! Array.isArray(colors)) {
                return colors;
            }

            var percentage = 100 / colors.length;
            var gradient = 'linear-gradient(to bottom right, ';

            for (var i = 0; i < colors.length; i++) {
                gradient += colors[i] + ' ' + percentage * i + '%, ' + colors[i] + ' ' + percentage * (i + 1) + '%';
                if (i+1 < colors.length) {
                    gradient += ',';
                }
            }

            return gradient + ')';
        },
        getReplicatorPreviewText() {
            if (! this.data) return;

            return this.data.label;
        },
    },

    ready: function() {
        if (this.config.default && this.data === this.config.default) {
            this.data = {
                label: this.config.default,
                value: this.config.colors[this.config.default]
            };
        }
    }
});
