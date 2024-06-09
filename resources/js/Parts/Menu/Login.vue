<script setup>
import Avatar from '../../Svg/Avatar.vue'
import {useModalStore} from '../../Stores/ModalStore'

const modalStore = useModalStore()
</script>

<template>
    <div class="text-black cursor-pointer flex text-copy-sm tracking-normal">
        <button
            class="flex items-center"
            @click="modalStore.open('loginModal')"
        >
            <div class="h-icon w-icon flex items-center justify-center">
                <div class="h-[19px] ml-[-4px]">
                    <Avatar/>
                </div>
            </div>

            <div class="font-semibold">Login</div>
        </button>
    </div>
</template>
