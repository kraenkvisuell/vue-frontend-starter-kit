<script setup>
import FormButton from '../Forms/FormButton.vue'
import MainErrorMessage from '../Forms/MainErrorMessage.vue'
import Modal from '../Shared/Modal.vue'
import ModalSubmitArea from '../Shared/ModalSubmitArea.vue'
import TextField from '../Forms/TextField.vue'
import _ from 'lodash'
import axios from 'axios'
import {ref, computed} from 'vue'
import {useFormErrors} from '../Composables/useFormErrors'
import {usePage} from '@inertiajs/vue3'

const $page = usePage()

const {jumpToFirstError} = useFormErrors()

let password = ref('')

const isBusy = ref(false)
const errors = ref({})

const hasErrors = computed(() => Object.keys(errors.value).length > 0)

const canBeSubmitted = computed(() => {
    if (!_.trim(password.value)) return false

    return true
})

const submit = () => {
    isBusy.value = true
    axios.post(route('merchants.store.account'), {
        password: password.value,
    }).then((response) => {
        location.reload()
    }).catch((error) => {
        console.log(error)
        errors.value = error.response.data.errors
        isBusy.value = false
    });
}

const logOut = () => {
    isBusy.value = true
    axios.post(route('merchants.store.logout'), {}).then((response) => {
        location.reload()
    }).catch((error) => {
        console.log(error)
        isBusy.value = false
    });
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
                        :label="$trans.shop.password"
                        v-model="password"
                        type="password"
                        name="password"
                        autocomplete="new-password"
                        placeholder="································"
                        :errors="errors.password"
                    />
                </div>

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

