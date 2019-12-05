<template>
    <div class="w-4 h-4 rounded-full"
         :style="'background: ' + cssBackground"
         :title="value.label"/>
</template>

<script>
    export default {
        mixins: [IndexFieldtype],

        computed: {
            cssBackground: function () {
                return createCssBackgroundFromColors(this.value.value);
            },
        }
    }
</script>
