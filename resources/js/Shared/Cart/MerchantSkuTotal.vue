<script setup>
import money from '../../money.js'
import SumItem from './SumItem.vue'
import {useCartStore} from '../../Stores/Merchants/CartStore.js'

const cartStore = useCartStore()

</script>

<template>
    <SumItem>
        <div class="flex justify-between gap-[20px]">
            <div>{{ $trans.shop.order_sum }}</div>

            <div class="font-bold">{{
                    money.formatted(cartStore.currentCart.skuTotal)
                }}&nbsp;{{ $shared.currencySign }}
            </div>
        </div>
    </SumItem>
</template>

