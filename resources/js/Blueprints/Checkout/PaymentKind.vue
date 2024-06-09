<script setup>
import { useCartStore } from '../../Stores/CartStore'

const cartStore = useCartStore()

const props = defineProps({
    paymentKind: String,
})
</script>


<template>
    <button
        @click="cartStore.changePaymentKind(paymentKind)"
        class="group rounded-t px-[20px] py-[20px] flex flex-col items-center justify-between gap-[30px]"
        :class="{
            'bg-white pointer-events-none cursor-default': cartStore.currentCart.payment_kind.slug === paymentKind,
            'bg-white/50': cartStore.currentCart.payment_kind.slug !== paymentKind,
        }"
    >
        <div class="w-full flex justify-center items-center">
            <div
                class=" font-semibold text-copy-lg sm:text-copy-xl leading-tightest text-center"
                :class="{
                    'opacity-60 group-hover:opacity-100': cartStore.currentCart.payment_kind.slug !== paymentKind,
                }"
            >
                {{ $trans.payment_kinds[paymentKind] }}
            </div>
        </div>
    </button>
</template>
