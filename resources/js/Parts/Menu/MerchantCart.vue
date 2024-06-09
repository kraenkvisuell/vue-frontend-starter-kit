<script setup>
import MerchantCart from '../../Shared/MerchantCart.vue'
import SmallHeadline from '../../Shared/SmallHeadline.vue'
import CartWrapper from './CartWrapper.vue'
import TextWrapper from './TextWrapper.vue'
import {useCartStore} from '../../Stores/Merchants/CartStore'
import {useModalStore} from '../../Stores/ModalStore'

const cartStore = useCartStore()
const modalStore = useModalStore()
</script>

<template>
    <CartWrapper :isBusy="cartStore.isBusy">
        <SmallHeadline>
            {{ $trans.shop.cart }}
        </SmallHeadline>

        <MerchantCart v-if="cartStore.currentCart.totalItems"/>

        <div v-else>
            <TextWrapper>
                {{ $trans.shop.no_articles_in_cart }}
            </TextWrapper>
        </div>
    </CartWrapper>
</template>
