<script setup>

import axios from 'axios'
import Cookies from 'js-cookie'
import _ from 'lodash'
import { onMounted, ref } from 'vue'
import { useConsentCookieStore } from '../../Stores/ConsentCookieStore.js'

const cookieConsentStore = useConsentCookieStore()

const id = ref('')
const neededCookieConsent = ref('')

const allowCookies = (method) => {
    cookieConsentStore.addToConsentedTo(neededCookieConsent.value)

    showForm()
}

const formCanBeShown = ref(false)

const showForm = () => {
    formCanBeShown.value = true

    const actualScript = $shared.globals.website.newsletter_form.value

    if (_.trim(actualScript).length > 10) {
        const doc = new DOMParser().parseFromString(actualScript, 'text/xml')
        id.value = doc.firstChild.id
        const jsCode = doc.firstChild.innerHTML

        eval(jsCode)
    }
}


onMounted(() => {
    let needsConsentTo = $shared.globals.website.newsletter_cookie_consent
    if (typeof (needsConsentTo) === 'object') {
        needsConsentTo = needsConsentTo[0]
    }

    neededCookieConsent.value = needsConsentTo

    if (!needsConsentTo || cookieConsentStore.hasConsentedTo(needsConsentTo)) {
        showForm()
    }
})
</script>

<template>
    <div class="text-copy-sm w-full sm:max-w-[220px] grid gap-[12px]">
        <div class="grid gap-[12px]">
            <div class="font-semibold text-copy-base">Newsletter</div>

            <div v-html="$shared.globals.website.newsletter_intro.text" class="text-copy-xs" />
        </div>

        <div v-if="formCanBeShown">
            <div :id="id" class="nl-form"></div>
        </div>

        <div v-else class="grid gap-[12px]">
            <div v-html="$trans.shop.you_need_to_change_cookie_consent" class="text-copy-xs" />

            <button @click="allowCookies"
                    class="border rounded border-white text-white py-[5px] w-full text-center"
            >
                {{ $trans.shop.allow_cookies }}
            </button>
        </div>
    </div>
</template>

<style>
.nl-form button {
    border: 1px solid white !important;
    @apply !bg-transparent !text-white !py-[5px] !w-[100%] !rounded;
}

.nl-form input[type=email] {
    border: 1px solid white !important;
    @apply !bg-transparent !text-white !py-[5px] !w-[100%] !rounded;
}

.nl-form input[type=checkbox] {
    @apply !mr-[4px] !relative !top-[2px] !h-[16px] !w-[16px];
}

.nl-form h2 {
    @apply !text-left;
}

.nl-form label {
    @apply !text-copy-xs;
}

.nl-form label a {
    @apply !underline;
}

.nl-form .checkbox-inline label {
    @apply !hyphens-auto !leading-tightest;
}
</style>
