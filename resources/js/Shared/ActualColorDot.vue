<script setup>
const props = defineProps({
    title: {type: String, default: ''},
    sorter: {type: Number, default: 0},
    actualColor: {type: String, default: '#aaaaaa'},
    innerBorderColor: {type: String, default: 'transparent'},
    isSelected: {type: Boolean, default: false},
    isVideo: {type: Boolean, default: false},
})
</script>

<template>
    <span class="block w-full aspect-w-1 aspect-h-1">
        <span
            class="group rounded-full border w-full h-full flex justify-center items-center"
            :class="{
                'border-black': isSelected,
                'border-white': !isSelected,
            }"
        >
            <span
                class="flex justify-center items-center rounded-full w-[75%] h-[75%] border"
                :style="{ backgroundColor: actualColor, borderColor: innerBorderColor }"

            >
                <i v-if="isVideo" class="ml-[3px] fa-solid fa-play"></i>
            </span>
        </span>
    </span>
</template>
