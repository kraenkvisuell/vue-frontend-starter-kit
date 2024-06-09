<script setup>
import axios from 'axios'
import _ from 'lodash'
import { computed, ref } from 'vue'
import { useFormErrors } from '../Composables/useFormErrors.js'
import FormButton from '../Forms/FormButton.vue'
import MainErrorMessage from '../Forms/MainErrorMessage.vue'
import MultiFileUpload from '../Forms/MultiFileUpload.vue'
import TextAreaField from '../Forms/TextAreaField.vue'
import TextField from '../Forms/TextField.vue'
import SmallHeadline from './SmallHeadline.vue'

const { jumpToFirstError } = useFormErrors()

const props = defineProps({
    job: Object,
})

const isBusy = ref(false)
const isSubmitted = ref(false)
const errors = ref({})
const success = ref(false)

const coverLetter = ref('')
const email = ref('')
const files = ref([])
const links = ref('')
const name = ref('')
const phone = ref('')

const hasErrors = computed(() => Object.keys(errors.value).length > 0)

const send = () => {
    isBusy.value = true
    axios({
        method: 'post',
        url: route('store.job-application'),
        data: {
            coverLetter: coverLetter.value,
            email: email.value,
            files: files.value,
            links: links.value,
            name: name.value,
            phone: phone.value,
            jobId: props.job.id,
        },
        headers: { 'Content-Type': 'multipart/form-data' },
    }).then((response) => {
        errors.value = {}
        isBusy.value = false
        isSubmitted.value = true
    }).catch((error) => {
        console.log(error)
        isBusy.value = false
        errors.value = error.response.data.errors
        jumpToFirstError(errors.value)
    })
}
</script>

<template>
    <div>
        <form v-show="!isSubmitted" @submit.prevent>
            <div
                class="transition-opacity grid gap-[50px]"
                :class="{
                    'opacity-50': isBusy,
                }"
            >
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-[30px] items-start">

                    <div class="sm:col-span-2 lg:col-span-1">
                        <TextField
                            :label="$trans.shop.name"
                            v-model="name"
                            :required="true"
                            name="name"
                            :errors="errors.name"
                        />
                    </div>

                    <TextField
                        :label="$trans.shop.email"
                        v-model="email"
                        :required="true"
                        name="email"
                        type="email"
                        :errors="errors.email"
                    />

                    <TextField
                        :label="$trans.shop.phone"
                        v-model="phone"
                        name="phone"
                        type="tel"
                        :errors="errors.phone"
                    />
                </div>

                <div class="grid gap-[30px] md:grid-cols-2">
                    <TextAreaField
                        :label="$trans.shop.cover_letter"
                        v-model="coverLetter"
                        name="coverLetter"
                        :required="true"
                        :errors="errors.coverLetter"
                    />

                    <TextAreaField
                        :label="$trans.shop.links_etc"
                        v-model="links"
                        name="links"
                        :errors="errors.links"
                    />
                </div>

                <div class="grid gap-[30px]">
                    <div class="text-center">
                        <div class="grid gap-[10px]">
                            <SmallHeadline>{{ $trans.shop.jobform_files_headline }}</SmallHeadline>

                            <div class="text-copy-sm">{{ $trans.shop.jobform_files_subheadline }}</div>
                        </div>
                    </div>

                    <div>
                        <MultiFileUpload v-model="files" accept=".mp4, .mov, .pdf" />
                    </div>
                </div>

                <div class="flex flex-col gap-[30px] justify-center items-center">

                    <MainErrorMessage v-if="hasErrors">
                        {{ $trans.shop.check_highlighted_fields }}
                    </MainErrorMessage>


                    <button
                        class="w-full max-w-[400px] block"
                        @click="send"
                        :disabled="isBusy"
                    >
                        <FormButton :disabled="isBusy">
                            {{ isBusy ? $trans.shop.submitting_data : $trans.shop.submit }}
                        </FormButton>
                    </button>
                </div>
            </div>
        </form>

        <div v-show="isSubmitted" class="editor">
            <div
                class="bg-highlight text-white p-[12px] text-center rounded"
                v-html="$shared.globals.jobs.form_success_message.text"
            />
        </div>
    </div>
</template>
