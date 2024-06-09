<script setup>
import FormButton from '../../../Forms/FormButton.vue'
import MerchantCart from '../../../Shared/MerchantCart.vue'
import PaymentKind from './PaymentKind.vue'
import SmallHeadline from '../../../Shared/SmallHeadline.vue'
import Stripe from './Stripe.vue'
import axios from 'axios'
import { ref } from 'vue'
import { useCartStore } from '../../../Stores/Merchants/CartStore'
import { useIterable } from '../../../Composables/useIterable.js'
import { usePage, router } from '@inertiajs/vue3'

const { ensureIterable } = useIterable()

const cartStore = useCartStore()
const isBuying = ref(false)

const buyViaMerchantPayment = () => {
    isBuying.value = true

    axios.post(route('merchants.store.merchant-payment-order')).then((response) => {
        cartStore.clear()
        router.visit(route('merchants.successful-order'))
    }).catch((error) => {
        console.log(error)
        isBuying.value = false
    })
}
</script>


<template>
    <div
        class="pt-[30px] grid gap-[50px] transition-opacity"
        :class="{
            'opacity-50 pointer-events-none': cartStore.isBusy || isBuying,
        }"
    >
        <div class="grid gap-[40px]">
            <div>
                <div class="ml-[5px] mb-[20px]">
                    <SmallHeadline>{{ $trans.shop.your_order }}:</SmallHeadline>
                </div>

                <div class="{cartStore.isBusy ? 'opacity-30 pointer-events-none' : ''}">
                    <MerchantCart context="checkout" />
                </div>
            </div>

            <div
                class="text-copy-sm editor"
                v-html="$shared.globals.merchants.merchant_terms.text"
            />
        </div>

        <div class="grid gap-[20px]">
            <div class="grid {cartStore.isBusy ? 'opacity-30 pointer-events-none' : ''}">
                <div
                    v-if="ensureIterable(usePage().props.paymentKinds).length > 1"
                    class="grid grid-cols-2 items-stretch transition-opacity"
                >
                    <PaymentKind
                        v-for="paymentKind in ensureIterable(usePage().props.paymentKinds)"
                        :paymentKind="paymentKind"
                    />
                </div>

                <div
                    class="bg-white py-[40px] px-[20px] sm:px-[40px] rounded-b flex-col items-center gap-[30px]"
                    :class="{
                        'flex': cartStore.paymentKindSlug === 'merchant_payment',
                        'hidden': cartStore.paymentKindSlug !== 'merchant_payment',
                    }"
                >
                    <button @click="buyViaMerchantPayment">
                        <FormButton size="large">
                            {{ $trans.shop.order_now }}
                        </FormButton>
                    </button>
                </div>

                <div v-if="usePage().props.loggedMerchant.can_pay_online">
                    <div v-show="cartStore.paymentKindSlug === 'stripe'">
                        <Stripe />
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
