<script setup>
import {Link} from '@inertiajs/vue3'
import {useMenuStore} from '../../Stores/MenuStore'
import {useCartPanelStore} from '../../Stores/CartPanelStore.js'
import AnimatedLogo from './AnimatedLogo.vue'

const menuStore = useMenuStore()
const cartPanelStore = useCartPanelStore()

const closeBoth = () => {
    menuStore.close()
    cartPanelStore.close()
}
</script>

<template>
    <Link
        :href="$route('merchants.news', $shared.locale)"
        @click="closeBoth"
        class="h-[22px] flex cursor-pointer text-black"
    >
        <AnimatedLogo/>
    </Link>
</template>
