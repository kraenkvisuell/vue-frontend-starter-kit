<script setup>
import {useModalStore} from '../../Stores/ModalStore.js'

const modalStore = useModalStore()

import FormButton from '../../Forms/FormButton.vue'
</script>

<template>
    <div class="bg-white rounded px-[20px] py-[15px]">
        <div class="text-center">
            {{ $trans.shop.you_are_ordering_as_guest_would_you }}
            <button @click="modalStore.open('loginModal')" class="ml-[7px] mr-[2px]">
                <FormButton size="small">
                    {{ $trans.shop.log_in }}
                </FormButton>
            </button>
            {{ $trans.shop.or_word }}
            <button @click="modalStore.open('registrationModal')" class="ml-[7px] mr-[2px]">
                <FormButton size="small">
                    {{ $trans.shop.register }}
                </FormButton>
            </button>
            ?
        </div>
    </div>
</template>
