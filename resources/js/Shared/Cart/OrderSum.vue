<script setup>
import money from '../../money.js'
import SmallHeadline from '../SmallHeadline.vue'
import {useCartStore} from '../../Stores/CartStore.js'

const cartStore = useCartStore()
</script>

<template>
    <div class="flex justify-between gap-[10px]">
        <SmallHeadline>{{ $trans.shop.order_sum }}</SmallHeadline>

        <div class="grid gap-[5px]">
            <div class="font-bold text-copy-2xl leading-none">
                {{ money.formatted(cartStore.currentCart.totalInclVat) }}&nbsp;{{ $shared.currencySign }}
            </div>

            <div class="text-copy-sm">
                {{ $trans.shop.incl_vat }}
            </div>
        </div>
    </div>
</template>

