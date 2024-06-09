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
                {{ cartStore.currentCart.vatPercentage }}% {{ $trans.shop.vat }}
            </div>

            <div class="font-bold">
                {{
                    money.formatted(cartStore.currentCart.totalVat)
                }}&nbsp;{{
                    $shared.currencySign
                }}
            </div>
        </div>
    </SumItem>
</template>

