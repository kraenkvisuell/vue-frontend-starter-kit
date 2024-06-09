<script setup>
import AccountDropdownIcon from './AccountDropdownIcon.vue'
import DropdownLinksWrapper from './DropdownLinksWrapper.vue'
import axios from 'axios'
import nprogress from 'nprogress'
import {ref} from 'vue'
import {useModalStore} from '../../Stores/ModalStore.js'
import {usePage} from '@inertiajs/vue3'

const modalStore = useModalStore()

let isOpen = ref(false)

const handleClick = () => {
    if (!usePage().props.customerIsLogged) {
        modalStore.open('loginModal')
    } else {
        isOpen.value = !isOpen.value
    }
}

const logOut = () => {
    nprogress.start()
    axios.post(route('store.logout'), {}).then((response) => {
        location.reload()
    }).catch((error) => {
        console.log(error)
        nprogress.done()
    });
}

const showAccount = () => {
    isOpen.value = false
    modalStore.open('accountModal')
}


// console.log($shared.languages)
</script>

<template>
    <div>
        <button @click="handleClick">
            <AccountDropdownIcon/>
        </button>

        <DropdownLinksWrapper v-show="isOpen">
            <button @click="logOut">
                {{ $trans.shop.log_out }}
            </button>

            <button @click="showAccount" class="whitespace-nowrap">
                {{ $trans.shop.my_account }}
            </button>
        </DropdownLinksWrapper>
    </div>
</template>
