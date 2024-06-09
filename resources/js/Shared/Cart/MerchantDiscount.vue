<script setup>
import {usePage} from '@inertiajs/vue3'
import money from '../../money.js'
import SumItem from './SumItem.vue'
import {useCartStore} from '../../Stores/Merchants/CartStore.js'

const cartStore = useCartStore()

</script>

<template>
    <SumItem>
        <div class="flex justify-between gap-[20px]">
            <div>{{ usePage().props.loggedMerchant.discount_percentage }}% {{ $trans.shop.discount }}</div>

            <div class="font-bold text-error">-{{
                    money.formatted(cartStore.currentCart.discount)
                }}&nbsp;{{ $shared.currencySign }}
            </div>
        </div>
    </SumItem>
</template>

