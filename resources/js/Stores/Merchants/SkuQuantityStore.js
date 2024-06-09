import _ from 'lodash'
import {defineStore} from 'pinia'
import {useCartStore} from './CartStore.js'
import {ref, watch} from 'vue'
import {useDebounce} from '../../Composables/useDebounce.js'
import {storeToRefs} from 'pinia'

export const useSkuQuantityStore =
    (sku) => defineStore('skuQuantityStore_' + sku.id, () => {
        const cartStore = useCartStore()

        const {currentCart} = storeToRefs(cartStore)

        const {debounce} = useDebounce()

        const quantity = ref(0)

        const increment = () => {
            quantity.value++
            debouncedUpdateCart()
        }

        const decrement = () => {
            quantity.value > 0 ? quantity.value-- : null
            debouncedUpdateCart()
        }

        watch(currentCart, () => {
            debouncedUpdateLocalSkus(currentCart.value)
        })

        const debouncedUpdateLocalSkus = debounce((changedCart) => {
            if (changedCart.skus.length) {
                let cartSku = _.find(changedCart.skus, (item) => item.slug === sku.slug)

                if (cartSku) {
                    quantity.value = cartSku.quantity
                } else {
                    quantity.value = 0
                }
            }
        }, 1100)

        const debouncedUpdateCart = debounce(() => {
            cartStore.changeItemQuantity(sku, quantity.value)
        }, 1000)

        return {
            quantity,
            increment,
            decrement,
        }
    })()
