<script setup>
import FormButton from '../../Forms/FormButton.vue'
import Modal from '../../Shared/Modal.vue'
import SmallHeadline from '../../Shared/SmallHeadline.vue'
import CartWrapper from './CartWrapper.vue'
import TextWrapper from './TextWrapper.vue'
import { useCartStore } from '../../Stores/CartStore'
import { useModalStore } from '../../Stores/ModalStore'
import Cart from '../../Shared/Cart.vue'

const cartStore = useCartStore()
const modalStore = useModalStore()
</script>

<template>
    <CartWrapper :isBusy="cartStore.isBusy">
        <TextWrapper>
            <SmallHeadline>
                {{ $trans.shop.cart }}
            </SmallHeadline>
        </TextWrapper>

        <Cart v-if="cartStore.currentCart.totalItems" />

        <div v-else>
            <TextWrapper>
                {{ $trans.shop.no_articles_in_cart }}
            </TextWrapper>
        </div>
    </CartWrapper>

    <Modal id="shippingExplanation">
        <div class="editor" v-html="$shared.globals.shop.shipping_popup_text.text" />

        <br>
        <hr />
        <br>
        <br>

        <div class="editor" v-html="$shared.globals.legal.revocation_explanation.text" />

        <template v-slot:footer>
            <div class="flex gap-[24px]">
                <button @click="modalStore.close('shippingExplanation')">
                    <FormButton>
                        {{ $trans.shop.close }}
                    </FormButton>
                </button>
            </div>
        </template>
    </Modal>
</template>
