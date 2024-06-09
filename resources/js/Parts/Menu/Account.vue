<script setup>
import Avatar from '../../Svg/Avatar.vue'
import {useModalStore} from '../../Stores/ModalStore'
import LogOut from '../../Svg/LogOut.vue'

const modalStore = useModalStore()
</script>

<template>
    <div class="text-black fill-gray-800 cursor-pointer flex text-copy-sm tracking-normal">
        <button
            class="flex items-center"
            @click="modalStore.open('accountModal')"
        >
            <div class="h-icon w-icon flex items-center justify-center">
                <div class="h-[18px] ml-[-4px]">
                    <Avatar/>
                </div>
            </div>

            <div class="font-semibold">{{ $trans.shop.my_account }}</div>
        </button>
    </div>
</template>
