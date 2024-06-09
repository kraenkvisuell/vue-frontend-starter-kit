<script setup>
import CartIcon from './Menu/CartIcon.vue'
import Container from './Menu/Container.vue'
import InnerWrapper from './Menu/InnerWrapper.vue'
import MenuBg from './Menu/MenuBg.vue'
import MenuWrapper from './Menu/MenuWrapper.vue'
import MerchantAccountDropdown from './Menu/MerchantAccountDropdown.vue'
import MerchantCart from './Menu/MerchantCart.vue'
import MerchantLogo from './Menu/MerchantLogo.vue'
import MerchantNavigation from './Menu/MerchantNavigation.vue'
import SimpleMenuIcon from './Menu/SimpleMenuIcon.vue'
import {computed} from 'vue'
import {useCartPanelStore} from '../Stores/CartPanelStore'
import {useCartStore} from '../Stores/Merchants/CartStore'
import {useMenuStore} from '../Stores/MenuStore'

const cartPanelStore = useCartPanelStore()
const menuStore = useMenuStore()
const cartStore = useCartStore()

const closeAll = () => {
    menuStore.close()
    cartPanelStore.close()
}

const handleMenuClick = () => {
    menuStore.toggle()
    cartPanelStore.close()
}

const handleCartIconClick = () => {
    cartPanelStore.toggle()
    menuStore.close()
}

const anyPanelIsOpen = computed(() => menuStore.isOpen || cartPanelStore.isOpen)
</script>

<template>
    <MenuWrapper>
        <MenuBg :clickMethod="closeAll" :isOpen="anyPanelIsOpen"/>

        <Container :isOpen="menuStore.isOpen" :toggle="menuStore.toggle">
            <MerchantNavigation/>
        </Container>

        <Container :isOpen="cartPanelStore.isOpen" :toggle="cartPanelStore.toggle">
            <MerchantCart/>
        </Container>

        <InnerWrapper>
            <div class="flex items-center gap-[10px] sm:gap-[20px]">
                <MerchantLogo/>

                <div class="text-copy-sm text-black leading-none">
                    {{ $trans.shop.merchant_login }}
                </div>
            </div>

            <div class="flex items-center gap-[20px] text-[10px]">
                <CartIcon :clickMethod="handleCartIconClick" :cartStore="cartStore"/>
                <MerchantAccountDropdown/>
                <SimpleMenuIcon :clickMethod="handleMenuClick"/>
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
