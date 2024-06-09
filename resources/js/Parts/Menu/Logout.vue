<script setup>
import LogOut from '../../Svg/LogOut.vue'
import axios from 'axios'
import nprogress from 'nprogress'

const logOut = () => {
    nprogress.start()
    axios.post(route('store.logout'), {}).then((response) => {
        location.reload()
    }).catch((error) => {
        console.log(error)
        nprogress.done()
    });
}
</script>

<template>
    <div class="text-black text-copy-sm tracking-normal">
        <button
            class="flex items-center"
            @click="logOut"
        >
            <div class="h-icon w-icon flex items-center justify-center">
                <div class="w-[23px]">
                    <LogOut/>
                </div>
            </div>

            <div class="font-semibold">{{ $trans.shop.log_out }}</div>
        </button>
    </div>
</template>
