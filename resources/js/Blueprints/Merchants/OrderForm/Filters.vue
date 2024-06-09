<script setup>

import {useOrderFormStore} from '../../../Stores/Merchants/OrderFormStore.js'
import SelectField from '../../../Forms/SelectField.vue'
import BooleanCheckbox from '../../../Forms/BooleanCheckbox.vue'

const orderFormStore = useOrderFormStore()

</script>

<template>
    <div class="grid md:grid-cols-2 md:gap-[30px]">
        <div class="grid gap-[15px]">
            <SelectField
                v-model="orderFormStore.filteredByKind"
                :options="orderFormStore.kindOptions"
            />

            <SelectField
                v-model="orderFormStore.filteredByCategory"
                :options="orderFormStore.categoryOptions"
            />

            <BooleanCheckbox
                v-model="orderFormStore.filteredByOnlyAvailable"
                :label="$trans.shop.only_available_articles"
            />
        </div>

        <div class="grid gap-[15px]">
            <SelectField
                v-model="orderFormStore.filteredByVolume"
                :options="orderFormStore.volumeOptions"
            />

            <SelectField
                v-model="orderFormStore.filteredByColorGroup"
                :options="orderFormStore.colorGroupOptions"
            />

            <BooleanCheckbox
                v-model="orderFormStore.listAllSkus"
                :label="$trans.shop.list_individually"
            />
        </div>
    </div>
</template>
