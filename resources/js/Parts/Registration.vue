<script setup>
import { useStrings } from '../Composables/useStrings.js'
import FormButton from '../Forms/FormButton.vue'
import Modal from '../Shared/Modal.vue'
import ModalSubmitArea from '../Shared/ModalSubmitArea.vue'
import SelectField from '../Forms/SelectField.vue'
import TextField from '../Forms/TextField.vue'
import { ref, computed } from 'vue'
import { useModalStore } from '../Stores/ModalStore'
import { useFormErrors } from '../Composables/useFormErrors'
import axios from 'axios'
import _ from 'lodash'

const modalStore = useModalStore()
const { jumpToFirstError } = useFormErrors()
const { validateEmail } = useStrings()

const additional_field = ref('')
const city = ref('')
const country_iso = ref('DE')
const email = ref('')
const first_name = ref('')
const last_name = ref('')
const phone = ref('')
const postcode = ref('')
const password = ref('')
const street = ref('')

const isBusy = ref(false)
const errors = ref({})

const canBeSubmitted = computed(() => {
    if (isBusy.value) return false
    if (!_.trim(city.value)) return false
    if (!_.trim(email.value)) return false
    if (!validateEmail(email.value)) return false
    if (!_.trim(first_name.value)) return false
    if (!_.trim(last_name.value)) return false
    if (!_.trim(password.value)) return false
    if (!_.trim(postcode.value)) return false

    return _.trim(street.value)
})

const termsText = computed(() => {
    if ($shared.globals.legal.acceptance_of_terms) {
        return $shared.globals.legal.acceptance_of_terms.text
    }

    return ''
})

const submit = () => {
    isBusy.value = true
    axios.post(route('store.registration'), {
        additional_field: additional_field.value,
        city: city.value,
        country_iso: country_iso.value,
        email: email.value,
        first_name: first_name.value,
        last_name: last_name.value,
        password: password.value,
        phone: phone.value,
        postcode: postcode.value,
        street: street.value,
    }).then((response) => {
        location.reload()
    }).catch((error) => {
        errors.value = error.response.data.errors
        jumpToFirstError(errors.value, 'registrationModal')
        isBusy.value = false
    })
}

const switchToLogin = () => {
    modalStore.close('registrationModal')
    modalStore.open('loginModal')
}

// onMounted(() => {
//     modalStore.open('registrationModal')
// })


// console.log($shared.globals)
</script>

<template>
    <Modal id="registrationModal" width="xl">
        <div class="@container grid gap-[20px]">
            <div class="w-full grid @lg:grid-cols-2 @4xl:grid-cols-3 items-start gap-[30px]">
                <TextField
                    :label="$trans.shop.first_name"
                    v-model="first_name"
                    :required="true"
                    name="first_name"
                    :errors="errors.first_name"
                />

                <TextField
                    :label="$trans.shop.last_name"
                    v-model="last_name"
                    :required="true"
                    name="last_name"
                    :errors="errors.last_name"
                />

                <TextField
                    :label="$trans.shop.email"
                    type="email"
                    v-model="email"
                    :required="true"
                    name="email"
                    :errors="errors.email"
                />

                <TextField
                    :label="$trans.shop.phone"
                    name="phone"
                    type="tel"
                    v-model="phone"
                />

                <TextField
                    :label="$trans.shop.street"
                    name="street"
                    v-model="street"
                    :required="true"
                    :errors="errors.street"
                />

                <TextField
                    :label="$trans.shop.additional_address_field"
                    name="additional_field"
                    v-model="additional_field"
                />

                <div class="w-full flex gap-[30px]">
                    <div class="w-[28%]">
                        <TextField
                            :label="$trans.shop.postcode"
                            name="postcode"
                            v-model="postcode"
                            :required="true"
                            :errors="errors.postcode"
                        />
                    </div>

                    <div class="w-[72%]">
                        <TextField
                            :label="$trans.shop.city"
                            name="city"
                            v-model="city"
                            :required="true"
                            :errors="errors.city"
                        />
                    </div>
                </div>

                <SelectField
                    :label="$trans.shop.country"
                    v-model="country_iso"
                    :required="true"
                    :options="$shared.countryOptions"
                />

                <TextField
                    :label="$trans.shop.your_password"
                    type="password"
                    v-model="password"
                    :required="true"
                    name="password"
                    autocomplete="new-password"
                    :errors="errors.password"
                />

            </div>

            <div class="editor text-copy-sm">
                <div v-html="termsText" />
            </div>
        </div>

        <template v-slot:footer>
            <ModalSubmitArea>
                <button type="button" @click="submit" :disabled="!canBeSubmitted">
                    <FormButton :disabled="!canBeSubmitted">
                        {{ isBusy ? $trans.shop.one_moment_please + '...' : $trans.shop.register }}
                    </FormButton>
                </button>

                <template v-slot:secondary>
                    {{ $trans.shop['already_have_login?'] }}<br>
                    <button type="button" class="underline text-highlight" @click="switchToLogin">
                        {{ $trans.shop.log_in_here }}
                    </button>
                </template>
            </ModalSubmitArea>
        </template>
    </Modal>
</template>

