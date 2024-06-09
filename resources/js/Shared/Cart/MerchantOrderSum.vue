<script setup>
import money from '../../money.js'
import SmallHeadline from '../SmallHeadline.vue'
import {useCartStore} from '../../Stores/Merchants/CartStore.js'

const cartStore = useCartStore()
</script>

<template>
    <div class="flex justify-between gap-[10px]">
        <SmallHeadline>{{ $trans.shop.brut_invoice_sum }}</SmallHeadline>

        <div class="grid gap-[5px]">
            <div class="font-bold text-copy-2xl leading-none">
                {{ money.formatted(cartStore.currentCart.total) }}&nbsp;{{ $shared.currencySign }}
            </div>
        </div>
    </div>
</template>

