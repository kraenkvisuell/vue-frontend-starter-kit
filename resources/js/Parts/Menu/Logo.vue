<script setup>
import { Link } from '@inertiajs/vue3'
import { computed } from 'vue'
import { useMenuStore } from '../../Stores/MenuStore'
import { useCartPanelStore } from '../../Stores/CartPanelStore.js'
import { useSearchStore } from '../../Stores/SearchStore.js'
import AnimatedLogo from './AnimatedLogo.vue'

const menuStore = useMenuStore()
const cartPanelStore = useCartPanelStore()
const searchStore = useSearchStore()

const closeBoth = () => {
    menuStore.close()
    cartPanelStore.close()
    searchStore.close()
}

const link = computed(() => $shared.locale === 'de' ? '/' : '/' + $shared.locale + '/home')
</script>

<template>
    <Link
        @click="closeBoth"
        :href="link"
        class="h-[22px] flex cursor-pointer text-black left-[-7px]"
    >
        <AnimatedLogo />
    </Link>
</template>
