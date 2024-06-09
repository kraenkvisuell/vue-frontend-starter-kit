import {defineStore} from 'pinia'
import {ref} from 'vue'
import {useModalStore} from '../ModalStore.js'

export const useOrderFormModalsStore = defineStore('orderFormModalsStore', () => {
    const modalStore = useModalStore()

    const currentSku = ref(null)
    const currentProduct = ref(null)

    const open = (sku, product) => {
        console.log({sku, product})
        currentProduct.value = product
        currentSku.value = sku

        modalStore.open('productInfoModal')
    }

    return {
        currentSku,
        currentProduct,
        open,
    }
})
