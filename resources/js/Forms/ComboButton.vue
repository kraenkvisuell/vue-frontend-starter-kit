<script setup>
import { useColors } from '../Composables/useColors.js'
import { computed } from 'vue'

const { lightOrDark } = useColors()

const props = defineProps({
    disabled: { type: Boolean, default: false },
    size: { type: String, default: 'regular' },
    bgColor: { type: String, default: '' },
})

let textColor = computed(() => props.bgColor && lightOrDark(props.bgColor) !== 'dark' ? 'text-dark' : 'text-white')
let borderColor = computed(() => props.bgColor && lightOrDark(props.bgColor) === 'extralight' ? '#cccccc' : '')
</script>

<template>
    <div
        class="ml-[-6px] p-[5px] border border-transparent rounded-full"

        :class="{
            'hover:border-black': !disabled,
        }"
    >
        <div
            class="
                tracking-wide font-semibold text-center
                flex items-center justify-center leading-none rounded-full
                transition-colors duration-400
                text-copy-base pt-[12px] pb-[12px] px-[35px]
            "

            :class="[
                (bgColor ? textColor : ''),
                {
                    'border': borderColor,
                    'bg-highlight text-white': !bgColor,
                    'cursor-not-allowed opacity-50': disabled,
                }
            ]"

            :style="{
                backgroundColor: bgColor,
                borderColor: borderColor ? borderColor : 'transparent',
            }"
        >
            <slot />
        </div>
    </div>
</template>
