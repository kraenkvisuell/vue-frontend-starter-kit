<template>
    <div class="grid gap-[30px]">
        <div class="flex items-center gap-[10px]">
            <div
                class="h-[40px] w-[40px]"
                :class="{
                    'border-[1.4px] border-gray': !value,
                }"
                :style="{
                    'background-color': value ? findRgb(value) : 'transparent',
                }"
            />


            <div
                class="flex gap-[10px] items-center"
                :class="{
                    'text-gray-600': !value,
                }"
            >
                <div
                    class="text-sm"
                    v-text="selectedTitle"
                />

                <button
                    class="btn btn-xs"
                    v-show="value"
                    v-text="'Entfernen'"
                    @click="emptyColor()"
                />
            </div>
        </div>

        <div class="flex flex-wrap gap-[2px]">
            <button
                v-for="color in colors"
                class="relative flex items-center gap-[6px] group"

                :class="{
                   'border-gray': value !== color.slug,
                   'bg-blue-500': value === color.slug,
               }"
                @click="changeColor(color.slug)"
            >
                <div
                    class="
                        flex items-center justify-center leading-tight
                        w-[20px] h-[20px] flex-shrink-0
                        text-white font-bold
                    "
                    :style="{
                        'background-color': color.rgb,
                    }"
                >
                    <span v-show="value === color.slug">&check;</span>
                </div>

                <div
                    class="
                        w-full h-full pointer-events-none
                        absolute bottom-[22px] left-0
                        opacity-0 group-hover:opacity-100
                        flex justify-center
                    "
                >
                    <div
                        class="text-copy-xs whitespace-nowrap bg-blue text-white px-[6px] pt-[2px] rounded"
                        v-text="color.title"
                    />
                </div>
            </button>
        </div>
    </div>
</template>

<script>


export default {
    components: {},
    mixins: [Fieldtype],
    data() {
        return {
            colors: this.meta.colors,
        }
    },

    methods: {
        changeColor(slug) {
            this.update(slug);
        },

        emptyColor() {
            this.update(null);
        },

        findRgb(slug) {
            let foundColor = _.find(this.colors, (color) => color.slug === slug)
            if (foundColor) {
                return foundColor.rgb
            }

            return null
        },
    },
    computed: {
        selectedTitle() {
            if (this.value) {
                let foundColor = _.find(this.colors, (color) => color.slug === this.value)
                if (foundColor) {
                    return foundColor.title
                }
            }

            return 'Keine Farbe gewählt (es wird auf die Default-Farbe zurückgegriffen)';
        }

    },
    mounted() {
        //console.log(this.meta);
    }
};
</script>
