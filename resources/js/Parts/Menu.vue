<script setup>
import { usePage } from '@inertiajs/vue3'
import HeaderBar from './HeaderBar.vue'
import Cart from './Menu/Cart.vue'
import CartIcon from './Menu/CartIcon.vue'
import Container from './Menu/Container.vue'
import InnerWrapper from './Menu/InnerWrapper.vue'
import Logo from './Menu/Logo.vue'
import MainCategories from './Menu/MainCategories.vue'
import MenuBg from './Menu/MenuBg.vue'
import MenuWrapper from './Menu/MenuWrapper.vue'
import Navigation from './Menu/Navigation.vue'
import SimpleMenuIcon from './Menu/SimpleMenuIcon.vue'
import { computed } from 'vue'
import { useCartPanelStore } from '../Stores/CartPanelStore'
import { useCartStore } from '../Stores/CartStore'
import { useMenuStore } from '../Stores/MenuStore'
import { useSearchStore } from '../Stores/SearchStore'

const cartStore = useCartStore()
const cartPanelStore = useCartPanelStore()
const menuStore = useMenuStore()
const searchStore = useSearchStore()

const closeAll = () => {
    menuStore.close()
    searchStore.close()
    cartPanelStore.close()
}

const handleMenuClick = () => {
    menuStore.toggle()
    cartPanelStore.close()
    searchStore.close()
}

const handleCartIconClick = () => {
    cartPanelStore.toggle()
    menuStore.close()
    searchStore.close()
}

const anyPanelIsOpen = computed(() => menuStore.isOpen || cartPanelStore.isOpen || searchStore.isOpen)
</script>

<template>
    <MenuWrapper>
        <HeaderBar />

        <MenuBg :clickMethod="closeAll" :isOpen="anyPanelIsOpen" />

        <Container :isOpen="menuStore.isOpen" :toggle="menuStore.toggle">
            <Navigation />
        </Container>

        <Container :isOpen="cartPanelStore.isOpen" :toggle="cartPanelStore.toggle">
            <Cart />
        </Container>

        <InnerWrapper>
            <div class="flex-shrink-0">
                <Logo />
            </div>

            <div v-if="!usePage().props.hideMainCategories" class="w-full justify-end hidden sm:flex">
                <MainCategories />
            </div>

            <div class="flex-shrink-0 justify-self-end flex justify-end items-center gap-[20px] text-[10px]">
                <CartIcon :clickMethod="handleCartIconClick" :cartStore="cartStore" />

                <SimpleMenuIcon :clickMethod="handleMenuClick" />
            </div>
        </InnerWrapper>
    </MenuWrapper>
</template>

<style scoped>
.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}
</style>
