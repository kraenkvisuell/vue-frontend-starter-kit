<script setup>
import AddressForm from './Address/AddressForm.vue'
import AddressPreview from './Address/AddressPreview.vue'
import {useCheckoutStore} from '../../Stores/CheckoutStore'
import OrderOverview from './OrderOverview.vue'

const checkoutStore = useCheckoutStore()

</script>

<template>
    <div>
        <AddressForm v-if="checkoutStore.addressFormIsOpen"/>

        <AddressPreview v-else/>
    </div>
</template>
