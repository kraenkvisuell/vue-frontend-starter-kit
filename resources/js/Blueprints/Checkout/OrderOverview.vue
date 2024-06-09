<script setup>
import Cart from '../../Shared/Cart.vue'
import FormButton from '../../Forms/FormButton.vue'
import PaymentKind from './PaymentKind.vue'
import SmallHeadline from '../../Shared/SmallHeadline.vue'
import Stripe from './Stripe.vue'
import axios from 'axios'
import { ref } from 'vue'
import { useCartStore } from '../../Stores/CartStore'
import { useIterable } from '../../Composables/useIterable.js'
import { usePage, router } from '@inertiajs/vue3'

const { ensureIterable } = useIterable()

const cartStore = useCartStore()
const isBuying = ref(false)

const buyViaPrepayment = () => {
    isBuying.value = true

    axios.post(route('store.prepayment-order'), {
        token: cartStore.currentCart.token,
    }).then((response) => {
        cartStore.clear()
        router.visit(route('successful-order', [$shared.locale, 'prepayment']))
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
        <div class="grid">
            <div class="ml-[5px] mb-[20px]">
                <SmallHeadline>{{ $trans.shop.your_order }}:</SmallHeadline>
            </div>

            <div class="{cartStore.isBusy ? 'opacity-30 pointer-events-none' : ''}">
                <Cart context="checkout" />
            </div>

            <div
                class="text-copy-sm editor"
                v-html="$shared.globals.legal.short_terms_and_conditions.text"
            />
        </div>

        <div class="grid gap-[20px]">
            <div class="grid {cartStore.isBusy ? 'opacity-30 pointer-events-none' : ''}">
                <div class=" grid grid-cols-2 items-stretch transition-opacity">
                    <PaymentKind
                        v-for="paymentKind in ensureIterable(usePage().props.paymentKinds)"
                        :paymentKind="paymentKind"
                    />
                </div>

                <div
                    class="bg-white py-[40px] px-[20px] sm:px-[40px] rounded-b flex-col items-center gap-[30px]"
                    :class="{
                        'flex': cartStore.currentCart.payment_kind_slug === 'prepayment',
                        'hidden': cartStore.currentCart.payment_kind_slug !== 'prepayment',
                    }"
                >
                    <div v-html="$shared.globals.legal.prepayment_explanation.text" />

                    <button @click="buyViaPrepayment">
                        <FormButton size="large">
                            {{ $trans.shop.buy_now }}
                        </FormButton>
                    </button>
                </div>

                <div v-show="cartStore.currentCart.payment_kind_slug === 'stripe'">
                    <Stripe />
                </div>
            </div>
        </div>
    </div>

</template>
