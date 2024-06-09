<script setup>
import { useStrings } from '../Composables/useStrings.js'
import FormButton from '../Forms/FormButton.vue'
import Modal from '../Shared/Modal.vue'
import ModalSubmitArea from '../Shared/ModalSubmitArea.vue'
import TextField from '../Forms/TextField.vue'
import _ from 'lodash'
import axios from 'axios'
import { ref, computed } from 'vue'
import { useFormErrors } from '../Composables/useFormErrors'
import { useModalStore } from '../Stores/ModalStore.js'

const { validateEmail } = useStrings()
const { jumpToFirstError } = useFormErrors()
const modalStore = useModalStore()

const props = defineProps({
    slug: String,
})

let email = ref('')
const isBusy = ref(false)
const isSubmitted = ref(false)
const errors = ref({})

const hasErrors = computed(() => Object.keys(errors.value).length > 0)

const canBeSubmitted = computed(() => {
    if (isBusy.value) return false
    if (!_.trim(email.value)) return false
    if (!validateEmail(email.value)) return false
    return true
})

const submit = () => {
    isBusy.value = true
    axios.post(route('store.message-when-available'), {
        email: email.value,
        slug: props.slug,
        locale: $shared.locale,
    }).then((response) => {
        isBusy.value = false
        isSubmitted.value = true
        email.value = ''
        setTimeout(() => isSubmitted.value = false, 4000)
        setTimeout(() => modalStore.close('messageWhenAvailableModal'), 3000)
    }).catch((error) => {
        console.log(error)
        errors.value = error.response.data.errors
        isBusy.value = false
    })
}

// onMounted(() => {
//     modalStore.open('accountModal')
// })
</script>

<template>
    <Modal id="messageWhenAvailableModal">
        <div v-if="isSubmitted">
            {{ $trans.shop.you_will_be_notified_when_available_again }}
        </div>

        <div v-if="!isSubmitted" class="@container grid gap-[50px]">
            <div class="grid gap-[30px]">
                <div class="grid sm:grid-cols-2 items-end gap-[20px]">
                    <div>
                        {{ $trans.shop.notify_me_when_available_again }}
                    </div>

                    <TextField
                        :label="$trans.shop.email"
                        v-model="email"
                        type="email"
                        :required="true"
                        name="email"
                        :errors="errors.email"
                    />
                </div>
            </div>
        </div>

        <template v-slot:footer>
            <ModalSubmitArea>
                <button type="button" @click="submit" :disabled="!canBeSubmitted">
                    <FormButton :disabled="!canBeSubmitted">
                        {{ $trans.shop.submit }}
                    </FormButton>
                </button>
            </ModalSubmitArea>
        </template>
    </Modal>
</template>

