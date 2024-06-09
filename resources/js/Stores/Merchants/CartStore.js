import {usePage} from '@inertiajs/vue3'
import _ from 'lodash'
import {defineStore} from 'pinia'
import axios from 'axios'
import {ref, computed} from 'vue'
import money from '../../money.js'

export const
    useCartStore = defineStore('merchantCartStore', () => {
        const emptyCart = {
            skus: [],
            totalItems: 0,
        }

        const currentCart = ref(emptyCart)
        const paymentKindSlug = ref('merchant_payment')
        const isBusy = ref(false)
        const isLoaded = ref(false)
        const selectedCartSkuId = ref(0)

        const restToFree = computed(() => {
            return usePage().props.loggedMerchant.free_limit - currentCart.value.skuTotalWithDiscount
        })

        const isCloseToFree = computed(() => restToFree.value > 0 && restToFree.value < 10000)

        const closeToFreeMessage = computed(() => {
            if (!isCloseToFree.value) {
                return ''
            }

            let message = $shared.globals.merchants.close_to_free_alert.text

            let limit = money.formatted(usePage().props.loggedMerchant.free_limit) + ' ' + $shared.currencySign
            message = _.replace(message, '{limit}', '<strong>' + limit + '</strong>')

            let rest = money.formatted(restToFree.value) + ' ' + $shared.currencySign
            message = _.replace(message, '{rest}', '<strong>' + rest + '</strong>')

            return message
        })

        const loadCart = () => {
            isBusy.value = true
            axios.get(route('merchants.show.cart')).then((response) => {
                currentCart.value = response.data.cart
                isBusy.value = false
                isLoaded.value = true
            }).catch((error) => {
                console.log(error)
                isBusy.value = false
            });
        }

        const clear = () => {
            currentCart.value = {
                skus: [],
                totalItems: 0,
            }
        }

        const addItem = (id, quantity = 1) => {
            isBusy.value = true
            selectedCartSkuId.value = id

            axios.post(route('merchants.store.cart-sku'), {
                id: id,
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
            });
        }

        const changeItemQuantity = (sku, quantity) => {
            isBusy.value = true

            axios.post(route('merchants.update.cart-sku-quantity'), {
                slug: sku.slug,
                quantity: quantity,
            }).then((response) => {
                currentCart.value = response.data.cart
                isBusy.value = false
            }).catch((error) => {
                console.log(error)
                isBusy.value = false
            });
        }

        const removeItem = (id) => {
            isBusy.value = true
            axios.post(route('merchants.delete.cart-sku'), {
                id: id,
            }).then((response) => {
                currentCart.value = response.data.cart
                isBusy.value = false
            }).catch((error) => {
                console.log(error)
                isBusy.value = false
            });
        }

        const changePaymentKind = (paymentKind) => {
            paymentKindSlug.value = paymentKind
        }


        return {
            currentCart,
            paymentKindSlug,
            isBusy,
            isLoaded,
            selectedCartSkuId,
            isCloseToFree,
            restToFree,
            closeToFreeMessage,
            clear,
            loadCart,
            addItem,
            removeItem,
            changeItemQuantity,
            changePaymentKind,
        }
    })
