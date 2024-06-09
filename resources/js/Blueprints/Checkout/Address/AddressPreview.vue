<script setup>
import SmallHeadline from '../../../Shared/SmallHeadline.vue'
import FormButton from '../../../Forms/FormButton.vue'
import {useCartStore} from '../../../Stores/CartStore'
import {computed} from 'vue'
import {useCheckoutStore} from '../../../Stores/CheckoutStore.js'

const cartStore = useCartStore()
const checkoutStore = useCheckoutStore()

const invoiceAddress = computed(() => cartStore.currentCart.invoice_address)
const shippingAddress = computed(() => cartStore.currentCart.shipping_address)
const shippingSameAsInvoice = computed(() => cartStore.currentCart.shipping_same_as_invoice)

</script>

<template>
    <div class="bg-white rounded px-[20px] py-[15px]">
        <div class="flex justify-end">
            <button @click="checkoutStore.openAddressForm()">
                <FormButton size="small">
                    {{ $trans.shop.edit }}
                </FormButton>
            </button>
        </div>

        <div class="grid sm:grid-cols-2 items-start gap-[50px]">
            <div v-if="invoiceAddress" class="pt-[20px] grid gap-[10px]">
                <div>
                    <SmallHeadline>{{ $trans.shop.invoice_address }}</SmallHeadline>
                </div>

                <div>
                    <p>{{ invoiceAddress.first_name }} {{ invoiceAddress.last_name }}</p>
                    <p>{{ invoiceAddress.street }}</p>

                    <p v-if="invoiceAddress.additional_field">{{ invoiceAddress.additional_field }}</p>

                    <p>{{ invoiceAddress.postcode }} {{ invoiceAddress.city }}</p>
                    <p>{{ invoiceAddress.country }}</p>

                    <br>
                    <p>{{ $trans.shop.email }}: {{ invoiceAddress.email }}</p>

                    <p v-if="invoiceAddress.phone">{{ $trans.shop.phone }}: {{ invoiceAddress.phone }}</p>
                </div>
            </div>

            <div class="pt-[20px] grid gap-[10px]" v-if="invoiceAddress">
                <div>
                    <SmallHeadline>{{ $trans.shop.shipping_address }}</SmallHeadline>
                </div>


                <div v-if="shippingSameAsInvoice">
                    {{ $trans.shop.the_shipping_is_same_as_invoice }}
                </div>

                <div v-else>
                    <p>{{ shippingAddress.first_name }} {{ shippingAddress.last_name }}</p>
                    <p>{{ shippingAddress.street }}</p>

                    <p v-if="shippingAddress.additional_field">{{ shippingAddress.additional_field }}</p>

                    <p>{{ shippingAddress.postcode }} {{ shippingAddress.city }}</p>
                    <p>{{ shippingAddress.country }}</p>

                    <br>
                    <p v-if="shippingAddress.phone">{{ $trans.shop.phone }}: {{ shippingAddress.phone }}</p>
                </div>
            </div>
        </div>
    </div>
</template>
