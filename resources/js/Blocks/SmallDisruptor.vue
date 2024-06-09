<script setup>
import { computed } from 'vue'
import { useStrings } from '../Composables/useStrings.js'

const { nl2br } = useStrings()

const props = defineProps({
    disruptor: { type: Object, default: {} },
})

const xPosition = computed(() => (props.disruptor.xPosition ? parseInt(props.disruptor.xPosition) : 0) + '%')
const yPosition = computed(() => (props.disruptor.yPosition ? parseInt(props.disruptor.yPosition) : 0) + '%')
</script>

<template>
    <div
        class="
            pointer-events-none absolute inset-0 flex
            h-full w-full items-center justify-center text-center
        "
    >
        <div
            class="small-disruptor pointer-events-auto flex transform flex-col items-center justify-center text-white rotate-[-8deg]"
            :style="{
                '--xPosition': xPosition,
                '--yPosition': yPosition,
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
                    :style="{backgroundColor: disruptor.bgColor}"
                >
                </div>
            </div>


            <div
                class="text-headline-sm @sm:text-headline-base @md:text-headline-lg font-bold leading-tight"
                v-html="nl2br(disruptor.text)"
            />
        </div>
    </div>
</template>

<style scoped>
.small-disruptor {
    margin-left: var(--xPosition);
    margin-top: var(--yPosition);
}
</style>
