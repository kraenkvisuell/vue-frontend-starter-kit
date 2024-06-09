<script setup>
import AccountDropdownIcon from './AccountDropdownIcon.vue'
import DropdownLinksWrapper from './DropdownLinksWrapper.vue'
import axios from 'axios'
import nprogress from 'nprogress'
import {ref} from 'vue'
import {useModalStore} from '../../Stores/ModalStore.js'

const modalStore = useModalStore()

let isOpen = ref(false)

const toggleDropdown = () => isOpen.value = !isOpen.value

const logOut = () => {
    nprogress.start()
    axios.post(route('merchants.store.logout'), {}).then((response) => {
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
</script>

<template>
    <div>
        <button @click="toggleDropdown">
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
