import { defineStore } from 'pinia'
import axios from 'axios'
import { computed, ref } from 'vue'


export const useCartStore = defineStore('cartStore', () => {
    const emptyCart = {
        skus: [],
        totalItems: 0,
        invoice_address: {},
        shipping_address: {},
    }

    const currentCart = ref(emptyCart)
    const isBusy = ref(false)
    const isLoaded = ref(false)
    const iconIsAnimated = ref(false)
    const imageIsAnimated = ref(false)
    const selectedCartSkuId = ref(0)
    const voucherCodes = ref('')
    const voucherCodesAreBusy = ref(false)
    const voucherCodesErrorMessage = ref('')

    const voucherCodesAreDisabled = computed(() => voucherCodesAreBusy.value || voucherCodes.value.length < 3)

    const loadCart = () => {
        isBusy.value = true
        axios.post(route('store.cart'), {
            cart: currentCart.value,
        }).then((response) => {
            currentCart.value = response.data.cart
            isBusy.value = false
            isLoaded.value = true
        }).catch((error) => {
            console.log(error)
            isBusy.value = false
        })
    }

    const clear = () => {
        currentCart.value = {
            skus: [],
            totalItems: 0,
            invoice_address: {},
            shipping_address: {},
        }
    }

    const addItem = (id, quantity = 1) => {
        isBusy.value = true
        selectedCartSkuId.value = id
        imageIsAnimated.value = true
        setTimeout(() => imageIsAnimated.value = false, 1000)
        setTimeout(() => {
            iconIsAnimated.value = true
            setTimeout(() => iconIsAnimated.value = false, 600)
        }, 400)
        axios.post(route('store.cart-sku'), {
            id: id,
            cartToken: currentCart.value.token,
            quantity: quantity,
        }).then((response) => {
            setTimeout(() => {
                currentCart.value = response.data.cart
            }, 500)
            isBusy.value = false
            selectedCartSkuId.value = 0

        }).catch((error) => {
            console.log(error)
            isBusy.value = false
        })
    }

    const changeItemQuantity = (sku, quantity) => {
        isBusy.value = true
        axios.post(route('update.cart-sku-quantity'), {
            id: sku.id,
            quantity: quantity,
        }).then((response) => {
            currentCart.value = response.data.cart
            isBusy.value = false
        }).catch((error) => {
            console.log(error)
            isBusy.value = false
        })
    }

    const removeItem = (id) => {
        isBusy.value = true
        axios.post(route('delete.cart-sku'), {
            id: id,
        }).then((response) => {
            currentCart.value = response.data.cart
            isBusy.value = false
        }).catch((error) => {
            console.log(error)
            isBusy.value = false
        })
    }

    const changePaymentKind = (paymentKind) => {
        isBusy.value = true
        axios.post(route('update.cart-payment-kind'), {
            paymentKind: paymentKind,
        }).then((response) => {
            currentCart.value = response.data.cart
            isBusy.value = false
        }).catch((error) => {
            console.log(error)
            isBusy.value = false
        })
    }

    const submitVoucherCodes = () => {
        isBusy.value = true
        voucherCodesAreBusy.value = true
        voucherCodesErrorMessage.value = ''

        axios.post(route('store.use-voucher-codes'), {
            codes: voucherCodes.value,
        }).then((response) => {
            currentCart.value = response.data.cart
            voucherCodes.value = ''
            voucherCodesAreBusy.value = false
            isBusy.value = false
        }).catch((error) => {
            voucherCodesErrorMessage.value = error.response.data.message
            voucherCodesAreBusy.value = false
            isBusy.value = false
        })
    }

    const removeVoucherCode = (id) => {
        isBusy.value = true

        axios.post(route('store.remove-voucher-code'), {
            id: id,
        }).then((response) => {
            currentCart.value = response.data.cart
            isBusy.value = false
        }).catch((error) => {
            isBusy.value = false
        })
    }

    return {
        currentCart,
        isBusy,
        isLoaded,
        iconIsAnimated,
        imageIsAnimated,
        selectedCartSkuId,
        voucherCodes,
        voucherCodesAreBusy,
        voucherCodesErrorMessage,
        voucherCodesAreDisabled,
        clear,
        loadCart,
        addItem,
        removeItem,
        changePaymentKind,
        changeItemQuantity,
        submitVoucherCodes,
        removeVoucherCode,
    }
})
