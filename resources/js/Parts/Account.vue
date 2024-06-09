<script setup>
import { useStrings } from '../Composables/useStrings.js'
import FormButton from '../Forms/FormButton.vue'
import Modal from '../Shared/Modal.vue'
import ModalSubmitArea from '../Shared/ModalSubmitArea.vue'
import { ref, computed } from 'vue'
import { useFormErrors } from '../Composables/useFormErrors'
import axios from 'axios'
import AddressFields from '../Blueprints/Checkout/Address/AddressFields.vue'
import SmallHeadline from '../Shared/SmallHeadline.vue'
import BooleanCheckbox from '../Forms/BooleanCheckbox.vue'
import TextField from '../Forms/TextField.vue'
import _ from 'lodash'
import MainErrorMessage from '../Forms/MainErrorMessage.vue'
import { usePage } from '@inertiajs/vue3'

const $page = usePage()

const { jumpToFirstError } = useFormErrors()
const { validateEmail } = useStrings()

let shippingSameAsInvoice = ref(!!$page.props.loggedCustomer.shipping_same_as_invoice)
let email = ref($page.props.loggedCustomer.email)
let invoiceAddress = ref($page.props.loggedCustomer.invoice_address)
let shippingAddress = ref($page.props.loggedCustomer.shipping_address)
let password = ref('')

const isBusy = ref(false)
const errors = ref({})

const hasErrors = computed(() => Object.keys(errors.value).length > 0)

const canBeSubmitted = computed(() => {
    if (isBusy.value) return false
    if (!_.trim(email.value)) return false
    if (!validateEmail(email.value)) return false
    if (!_.trim(invoiceAddress.value.first_name)) return false
    if (!_.trim(invoiceAddress.value.last_name)) return false
    if (!_.trim(invoiceAddress.value.street)) return false
    if (!_.trim(invoiceAddress.value.postcode)) return false
    if (!_.trim(invoiceAddress.value.city)) return false

    if (!shippingSameAsInvoice.value) {
        if (!_.trim(shippingAddress.value.first_name)) return false
        if (!_.trim(shippingAddress.value.last_name)) return false
        if (!_.trim(shippingAddress.value.street)) return false
        if (!_.trim(shippingAddress.value.postcode)) return false
        if (!_.trim(shippingAddress.value.city)) return false
    }

    return true
})

const submit = () => {
    isBusy.value = true
    axios.post(route('store.account'), {
        invoice_address: invoiceAddress.value,
        shipping_address: shippingAddress.value,
        shipping_same_as_invoice: shippingSameAsInvoice.value,
        email: email.value,
        password: password.value,
    }).then((response) => {
        location.reload()
    }).catch((error) => {
        console.log(error)
        errors.value = error.response.data.errors
        isBusy.value = false
    })
}

const logOut = () => {
    isBusy.value = true
    axios.post(route('store.logout'), {}).then((response) => {
        location.reload()
    }).catch((error) => {
        console.log(error)
        isBusy.value = false
    })
}


// onMounted(() => {
//     modalStore.open('accountModal')
// })
</script>

<template>
    <Modal id="accountModal" width="xl">
        <div class="@container grid gap-[50px]">

            <div class="grid gap-[30px]">
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 items-start gap-[30px]">
                    <TextField
                        :label="$trans.shop.email"
                        v-model="email"
                        type="email"
                        :required="true"
                        name="email"
                        :errors="errors.email"
                    />

                    <TextField
                        :label="$trans.shop.password"
                        v-model="password"
                        type="password"
                        name="password"
                        placeholder="································"
                        :errors="errors.password"
                    />
                </div>

                <AddressFields
                    :addressKind="invoiceAddress"
                    :errors="errors"
                    context="modal"
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

            <MainErrorMessage v-if="hasErrors">
                {{ $trans.shop.check_highlighted_fields }}
            </MainErrorMessage>
        </div>

        <template v-slot:footer>
            <ModalSubmitArea>
                <button type="button" @click="submit" :disabled="!canBeSubmitted">
                    <FormButton :disabled="!canBeSubmitted">
                        {{ $trans.shop.save_changes }}
                    </FormButton>
                </button>

                <template v-slot:secondary>
                    <button class="underline" @click="logOut">
                        {{ $trans.shop.log_out }}
                    </button>
                </template>
            </ModalSubmitArea>
        </template>
    </Modal>
</template>

