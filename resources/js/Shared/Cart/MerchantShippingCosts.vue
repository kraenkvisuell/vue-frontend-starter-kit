<script setup>
import {usePage} from '@inertiajs/vue3'
import SumItem from './SumItem.vue'
import money from '../../money.js'
import {useCartStore} from '../../Stores/Merchants/CartStore'
import {useTranslations} from '../../Composables/useTranslations.js'

const {replace} = useTranslations()

const cartStore = useCartStore()
</script>

<template>
    <SumItem>
        <div class="flex justify-between gap-[20px]">
            <div>
                {{ $trans.shop.merchant_shipping_costs }}
                <div class="text-copy-xs leading-tight">
                    {{
                        replace($trans.shop.free_shipping_starting_at_placeholder, {
                            'attribute': money.formatted(usePage().props.loggedMerchant.free_limit)
                                + ' ' + $shared.currencySign,
                        })
                    }}
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

