<script setup>
import AddressFields from '../Address/AddressFields.vue'
import BooleanCheckbox from '../../../Forms/BooleanCheckbox.vue'
import FormButton from '../../../Forms/FormButton.vue'
import SmallHeadline from '../../../Shared/SmallHeadline.vue'
import axios from 'axios'
import {computed, ref} from 'vue'
import {useCartStore} from '../../../Stores/CartStore'
import {useCheckoutStore} from '../../../Stores/CheckoutStore.js'
import MainErrorMessage from '../../../Forms/MainErrorMessage.vue'

const cartStore = useCartStore()
const checkoutStore = useCheckoutStore()

let isBusy = ref(false)
let errors = ref({})
let success = ref(false)
let shippingSameAsInvoice = ref(!!cartStore.currentCart.shipping_same_as_invoice)
let invoiceAddress = ref(cartStore.currentCart.invoice_address)
let shippingAddress = ref(cartStore.currentCart.shipping_address)
const hasErrors = computed(() => Object.keys(errors.value).length > 0)

const update = () => {
    isBusy.value = true
    axios.post(route('update.checkout-address'), {
        invoice_address: invoiceAddress.value,
        shipping_address: shippingAddress.value,
        shipping_same_as_invoice: shippingSameAsInvoice.value
    }).then((response) => {
        errors.value = {}
        cartStore.loadCart()
        checkoutStore.closeAddressForm()
        isBusy.value = false
    }).catch((error) => {
        console.log(error)
        errors.value = error.response.data.errors
        isBusy.value = false
    });
}
</script>

<template>
    <form>
        <div
            class="pt-[20px] grid gap-[100px] transition-opacity"
            :class="{
                'opacity-50': isBusy,
            }"
        >
            <div class="grid gap-[50px]">
                <div class="pt-[20px] grid gap-[10px]">
                    <div class="ml-[5px]">
                        <SmallHeadline>{{ $trans.shop.invoice_address }}</SmallHeadline>
                    </div>

                    <AddressFields
                        :addressKind="invoiceAddress"
                        :errors="errors"
                        addressKindName="invoice_address"
                    />
                </div>

                <div class="pt-[20px] grid gap-[30px]">
                    <div class="ml-[5px]">
                        <SmallHeadline>{{ $trans.shop.shipping_address }}</SmallHeadline>
                    </div>

                    <div class="">
                        <BooleanCheckbox
                            v-model="shippingSameAsInvoice"
                            :label="$trans.shop.shipping_same_as_invoice"
                        />
                    </div>


                    <AddressFields
                        v-if="!shippingSameAsInvoice"
                        :addressKind="shippingAddress"
                        :errors="errors"
                        addressKindName="shipping_address"
                    />

                </div>
            </div>

            <div class="flex flex-col gap-[30px] justify-center items-center">

                <MainErrorMessage v-if="hasErrors">
                    {{ $trans.shop.check_highlighted_fields }}
                </MainErrorMessage>


                <button
                    type="button"
                    class="w-full max-w-[400px] block"
                    @click="update"
                    :disabled="isBusy"
                >
                    <FormButton :disabled="isBusy">
                        {{ isBusy ? $trans.shop.submitting_data : $trans.shop.continue }}
                    </FormButton>
                </button>
            </div>
        </div>
    </form>
</template>
