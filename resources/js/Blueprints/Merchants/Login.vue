<script setup>
import {Head} from '@inertiajs/vue3'

import AuthContainer from '../Shared/AuthContainer.vue'
import AuthLayout from '../../Layouts/Merchants/AuthLayout.vue'
import FormButton from '../../Forms/FormButton.vue'
import TextField from '../../Forms/TextField.vue'
import _ from 'lodash'
import axios from 'axios'
import {computed, ref} from 'vue'

defineOptions({layout: AuthLayout})

const number = ref('')
const password = ref('')
const errorMessage = ref('')
const isBusy = ref(false)
const errors = ref({})

const canBeSubmitted = computed(() => {
    if (isBusy.value) return false

    if (!_.trim(number.value)) return false

    return _.trim(password.value)
})

const submit = () => {
    isBusy.value = true
    errorMessage.value = ''
    errors.value = {}
    axios.post(route('merchants.store.login'), {
        number: number.value,
        password: password.value,
    }).then((response) => {
        location.reload()
    }).catch((error) => {
        isBusy.value = false
        console.log(error)
        if (error.response.status === 422) {
            errors.value = error.response.data.errors
        }

        if (error.response.status === 401) {
            errorMessage.value = error.response.data.message
        }
    });
}

console.log('login')
</script>

<template>
    <Head :title="$shared.websiteName+' | '+$trans.shop.merchant_login"/>

    <div id="maincontent" class="scroll-mt-[120px]">
        <AuthContainer>
            <div class="w-full max-w-[600px] grid items-start gap-[50px]">
                <div class="text-headline-base font-bold" v-text="$trans.shop.merchant_login"/>

                <div class="w-full grid sm:grid-cols-2 items-start gap-[30px]">
                    <TextField
                        :label="$trans.shop.your_customer_number"
                        v-model="number"
                        :bold="true"
                        name="email"
                        autocomplete="username"
                        :errors="errors['number']"
                    />

                    <TextField
                        :label="$trans.shop.your_password"
                        v-model="password"
                        type="password"
                        :bold="true"
                        name="password"
                        autocomplete="current-password"
                        :errors="errors['password']"
                    />
                </div>

                <div
                    v-if="errorMessage"
                    class="
                            mt-[30px] text-copy-sm text-error text-sm text-center
                            border border-dashed border-error px-[10px] py-[8px]
                        "
                >
                    {{ errorMessage }}
                </div>


                <div>
                    <button type="button" @click="submit" :disabled="!canBeSubmitted">
                        <FormButton :disabled="!canBeSubmitted">
                            {{ isBusy ? $trans.shop.one_moment_please + '...' : $trans.shop.log_in }}
                        </FormButton>
                    </button>
                </div>
            </div>

        </AuthContainer>
    </div>
</template>
