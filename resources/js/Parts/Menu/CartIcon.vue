<script setup>
import Bag from './CartIcon/Bag.vue'

const props = defineProps({
    clickMethod: Function,
    cartStore: Object,
})
</script>

<template>
    <button @click="clickMethod">
        <div
            class="
                text-black font-bold hover:text-gray-800 fill-black hover:fill-gray-800
                relative cursor-pointer flex items-center justify-center
                h-[32px] w-[21px]
            "
        >
            <div
                class="absolute top-0 left-0 h-full flex"
                :class="{
                    'animate-cart': cartStore.iconIsAnimated,
                }"
            >
                <Bag/>
            </div>

            <div
                class="tracking-wide pt-[2px]"
                :class="{
                    'animate-cartnumber': cartStore.iconIsAnimated,
                }"
            >
                {{ cartStore.currentCart.totalItems }}
            </div>
        </div>
    </button>
</template>
