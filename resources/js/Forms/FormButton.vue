<script setup>
import { useColors } from '../Composables/useColors.js'
import { computed } from 'vue'

const { lightOrDark } = useColors()

const props = defineProps({
    disabled: { type: Boolean, default: false },
    size: { type: String, default: 'regular' },
    bgColor: { type: String, default: '' },
    mode: { type: String, default: 'primary' },
})

let textColor = computed(() => props.bgColor && lightOrDark(props.bgColor) !== 'dark' ? 'text-dark' : 'text-white')
let borderColor = computed(() => props.bgColor && lightOrDark(props.bgColor) === 'extralight' ? '#cccccc' : '')
</script>

<template>
    <div
        class="ml-[-6px] w-[calc(100%+12px)] p-[5px] border border-transparent rounded-full"
        :class="{
            'hover:border-black': !disabled,
        }"
    >
        <div
            class="
                tracking-wide font-semibold text-center
                flex items-center justify-center leading-none rounded-full
                transition-colors duration-400
            "

            :class="[
                (bgColor ? textColor : ''),
                {
                    'border': borderColor,
                    'bg-highlight text-white': !bgColor && mode === 'primary',
                    'bg-gray-300 text-black': !bgColor && mode === 'secondary',
                    'cursor-not-allowed opacity-50': disabled,
                    'text-copy-xs pt-[3px] pb-[4px] px-[15px]' : size === 'small',
                    'text-copy-base pt-[14px] pb-[15px] px-[35px]' : size === 'regular',
                    'text-copy-xl pt-[20px] pb-[22px] px-[50px]' : size === 'large',
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
