<script setup>
import Message from './FlashMessages/Message.vue'
import {ref} from 'vue'
import _ from 'lodash'

const showMessage = ref([])

_.each($shared.flashMessages, (message, messageIndex) => {
    showMessage.value[messageIndex] = false
})

let timeout = 500

_.each($shared.flashMessages, (message, messageIndex) => {
    setTimeout(() => {
        showMessage.value[messageIndex] = true
        setTimeout(() => showMessage.value[messageIndex] = false, (3000))
    }, timeout)

    timeout += 1000
})
</script>

<template>
    <div
        v-if="$shared.flashMessages"
        class="
            z-[100] fixed w-full top-0 right-0 pointer-events-none
            flex flex-col justify-center items-center gap-[20px]
            pt-[70px] md:pt-[8px]
        "
    >
        <Message
            v-for="(message, messageIndex) in $shared.flashMessages"
            :showMessage="showMessage[messageIndex]"
        >
            <div v-html="message"/>
        </Message>
    </div>
</template>

