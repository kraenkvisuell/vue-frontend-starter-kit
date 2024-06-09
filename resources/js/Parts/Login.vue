<script setup>
import FormButton from '../Forms/FormButton.vue'
import Modal from '../Shared/Modal.vue'
import ModalSubmitArea from '../Shared/ModalSubmitArea.vue'
import TextField from '../Forms/TextField.vue'
import _ from 'lodash'
import axios from 'axios'
import { computed, onMounted, ref } from 'vue'
import { useModalStore } from '../Stores/ModalStore'

const modalStore = useModalStore()

const email = ref('')
const password = ref('')
const errorMessage = ref('')
const isBusy = ref(false)
const errors = ref({})

const canBeSubmitted = computed(() => {
    if (isBusy.value) return false

    if (!_.trim(email.value)) return false

    return _.trim(password.value)
})

const submit = () => {
    isBusy.value = true
    errorMessage.value = ''
    errors.value = {}
    axios.post(route('store.login'), {
        email: email.value,
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
        // errors.value = error.response.data.errors
        // jumpToFirstError(errors.value, 'loginModal')
        // isBusy.value = false
    })
}

const switchToRegistration = () => {
    modalStore.close('loginModal')
    modalStore.open('registrationModal')
}
</script>

<template>
    <Modal id="loginModal">
        <div class="w-full grid sm:grid-cols-2 items-start gap-[30px]">
            <TextField
                :label="$trans.shop.your_email"
                v-model="email"
                :required="true"
                name="email"
                type="email"
                autocomplete="username"
                :errors="errors['email']"
            />

            <TextField
                :label="$trans.shop.your_password"
                v-model="password"
                type="password"
                :required="true"
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

        <template v-slot:footer>
            <ModalSubmitArea>
                <button type="button" @click="submit" :disabled="!canBeSubmitted">
                    <FormButton :disabled="!canBeSubmitted">
                        {{ isBusy ? $trans.shop.one_moment_please + '...' : $trans.shop.log_in }}
                    </FormButton>
                </button>

                <template v-slot:secondary>
                    {{ $trans.shop['no_login?'] }}<br>
                    <button type="button" class="underline text-highlight" @click="switchToRegistration">
                        {{ $trans.shop.you_can_register_here }}
                    </button>
                </template>
            </ModalSubmitArea>
        </template>
    </Modal>
</template>

