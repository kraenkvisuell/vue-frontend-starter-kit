<script setup>
import { computed } from 'vue'
import { useLinks } from '../../../Composables/useLinks.js'
import { useStrings } from '../../../Composables/useStrings.js'

const { nl2br } = useStrings()
const { getLink } = useLinks()

const props = defineProps({
    disruptor: { type: Object, default: {} },
})

const bgColor = computed(() => {
    return props.disruptor.bg_color ? $shared.colorOptions[props.disruptor.bg_color] : $shared.defaultBgColor
})

const link = computed(() => getLink(props.disruptor))
const xPhone = computed(() => {
    return (props.disruptor.x_phone ? parseInt(props.disruptor.x_phone) : 0) + '%'
})
const yPhone = computed(() => (props.disruptor.y_phone ? parseInt(props.disruptor.y_phone) : 0) + '%')
const xDesktop = computed(() => (props.disruptor.x_desktop ? parseInt(props.disruptor.x_desktop) : 0) + '%')
const yDesktop = computed(() => (props.disruptor.y_desktop ? parseInt(props.disruptor.y_desktop) : 0) + '%')
</script>

<template>
    <div class="pointer-events-none absolute inset-0 flex h-full w-full items-center justify-center text-center">
        <a
            :href="link"
            class="
                disruptor relative pointer-events-auto
                flex flex-col items-center justify-center text-white transform rotate-[-8deg]
            "
            :style="{
                '--xPhone': xPhone,
                '--yPhone': yPhone,
                '--xDesktop': xDesktop,
                '--yDesktop': yDesktop,
            }"
        >
            <div
                class="
                    absolute w-[calc(100%+2rem)] flex-shrink-0 ml-[-1rem]
                    h-full inset-0 flex items-center justify-center
                "
            >
                <div
                    class="w-full rounded-full aspect-w-1 aspect-h-1"
                    :style="{backgroundColor: bgColor}"
                >
                </div>
            </div>


            <div
                v-if="disruptor.text.topline"
                class="leading-tight mt-[-5px]"
                :class="{
                    'text-copy-xs lg:text-copy-sm': disruptor.text_size.value === 'xs'
                                                             || disruptor.text_size.value === 'sm',
                    'text-copy-sm lg:text-copy-base': !disruptor.text_size || !disruptor.text_size.value
                                                             || disruptor.text_size.value === 'default',
                    'text-copy-base lg:text-copy-lg':  disruptor.text_size.value === 'lg'
                                                             || disruptor.text_size.value === 'xl',

                }"
            >
                {{ disruptor.text.topline }}
            </div>

            <div
                class="font-bold leading-tight"
                :class="{
                    'text-headline-xs lg:text-headline-sm': disruptor.text_size.value === 'xs',
                    'text-headline-sm lg:text-headline-base': disruptor.text_size.value === 'sm',
                    'text-headline-base lg:text-headline-lg': !disruptor.text_size || !disruptor.text_size.value
                                                             || disruptor.text_size.value === 'default',
                    'text-headline-lg lg:text-headline-xl':  disruptor.text_size.value === 'lg',
                    'text-headline-xl lg:text-headline-2xl':  disruptor.text_size.value === 'xl',
                }"
                v-html="nl2br(disruptor.text.text)"
            />
        </a>
    </div>
</template>

<style scoped>
.disruptor {
    left: var(--xPhone);
    top: var(--yPhone);
}

@media (orientation: landscape) {
    .disruptor {
        left: var(--xDesktop);
        top: var(--yDesktop);
    }
}
</style>
