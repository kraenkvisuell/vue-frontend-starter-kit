<script setup>
import CheckboxGroup from '../Forms/CheckboxGroup.vue'
import FormButton from '../Forms/FormButton.vue'
import Pane from '../Shared/Pane.vue'
import { onMounted, ref } from 'vue'
import { usePaneStore } from '../Stores/PaneStore'
import { useStrings } from '../Composables/useStrings.js'
import { useConsentCookieStore } from '../Stores/ConsentCookieStore.js'

const consentCookieStore = useConsentCookieStore()
const paneStore = usePaneStore()

const { stripTags } = useStrings()

const detailsAreVisible = ref(false)

const toggleDetails = () => detailsAreVisible.value = !detailsAreVisible.value

consentCookieStore.init()

onMounted(() => {
    if (!consentCookieStore.hasSetCookieConsent) {
        paneStore.open('cookieBannerPane')
    }
})
</script>

<template>
    <Pane id="cookieBannerPane">
        <template v-slot:title>
            Cookies
        </template>

        <div class="editor text-copy-sm">
            <div v-html="$shared.globals.website.cookie_banner_intro.text" />
        </div>

        <div v-show="detailsAreVisible" class="text-copy-sm mb-[20px]">

            <div class="max-w-[200px]">
                <CheckboxGroup
                    v-model="consentCookieStore.selectedConsentGroups"
                    :options="consentCookieStore.consentGroupOptions"
                    :readonly="consentCookieStore.readonlyConsentGroups"
                />
            </div>
        </div>

        <div class="flex justify-between">
            <div
                v-show="consentCookieStore.isBusy"
                class="italic text-copy-sm h-[31px]"
                v-text="$trans.shop.one_moment_please+'...'"
            />


            <div v-show="!consentCookieStore.isBusy" class="flex gap-[20px]">
                <button v-show="detailsAreVisible" @click="consentCookieStore.submit('save')">
                    <FormButton size="small">
                        <span v-text="$trans.shop.save" />
                    </FormButton>
                </button>

                <button v-show="!detailsAreVisible" @click="consentCookieStore.submit('agree')">
                    <FormButton size="small">
                        <span v-text="$trans.shop.agree" />
                    </FormButton>
                </button>

                <button v-show="!detailsAreVisible" @click="consentCookieStore.submit('decline')">
                    <FormButton size="small" mode="secondary">
                        <span v-text="$trans.shop.decline" />
                    </FormButton>
                </button>
            </div>

            <div>
                <button class="text-copy-xs" @click="toggleDetails">
                    <span v-text="detailsAreVisible ? $trans.shop.close_configuration : $trans.shop.configure" />
                </button>
            </div>
        </div>
    </Pane>
</template>

