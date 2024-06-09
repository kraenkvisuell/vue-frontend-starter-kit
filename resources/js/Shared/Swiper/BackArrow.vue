<script setup>
import Arrow from '../../Svg/Arrow.vue';

const props = defineProps({
    swiperIsAtStart: { type: Boolean, default: true },
    swipePrev: {
        type: Function, default: () => null
    }
});
</script>

<template>
    <div class="h-full absolute top-0 left-0 flex flex-col justify-center z-10">
        <button
            @click="swipePrev"
            class="pr-[20px]  py-[20px]"
        >
            <span
                class="block fill-gray-800 h-icon w-icon rotate-90"
                :class="{
                    'opacity-20 pointer-events-none': swiperIsAtStart,
                }"
            >
                <Arrow />
            </span>
        </button>
    </div>
</template>
