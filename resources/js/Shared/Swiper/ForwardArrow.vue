<script setup>
import Arrow from '../../Svg/Arrow.vue';

const props = defineProps({
    swiperIsAtEnd: { type: Boolean, default: true },
    swipeNext: {
        type: Function, default: () => null
    }
});
</script>

<template>
    <div class="h-full absolute top-0 right-0 flex flex-col justify-center z-10">
        <button
            @click="swipeNext"
            class="pl-[20px]  py-[20px]"
        >
            <span
                class="block fill-gray-800 h-icon w-icon -rotate-90"
                :class="{
                    'opacity-20 pointer-events-none': swiperIsAtEnd,
                }"
            >
                <Arrow />
            </span>
        </button>
    </div>
</template>
