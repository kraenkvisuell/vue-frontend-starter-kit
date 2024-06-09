<script setup>
import SumItem from './SumItem.vue'
import money from '../../money.js'
import {useCartStore} from '../../Stores/CartStore'
import {useModalStore} from '../../Stores/ModalStore'

const cartStore = useCartStore()
const modalStore = useModalStore()

</script>

<template>
    <SumItem>
        <div class="flex justify-between gap-[20px]">
            <div>
                {{ $trans.shop.shipping_costs }}
                <div class="text-copy-xs leading-tight">
                    {{ $trans.shop.co2_neutral_shipping }}<br>
                    <button class="underline" @click="modalStore.open('shippingExplanation')">
                        {{ $trans.shop.free_shipping_in_eu }}*
                    </button>
                </div>
            </div>

            <div class="font-bold">
                {{
                    money.formatted(cartStore.currentCart.shippingCosts)
                }}&nbsp;{{
                    $shared.currencySign
                }}
            </div>
        </div>
    </SumItem>
</template>

