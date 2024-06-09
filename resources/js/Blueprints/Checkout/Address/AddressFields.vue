<script setup>
import TextField from '../../../Forms/TextField.vue'
import SelectField from '../../../Forms/SelectField.vue'

const props = defineProps({
    addressKind: Object,
    errors: Object,
    addressKindName: String,
    context: {type: String, default: 'checkout'},
})
</script>


<template>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 items-start gap-[30px]">
        <TextField
            :label="$trans.shop.first_name"
            v-model="addressKind.first_name"
            :required="true"
            name="first_name"
            :errors="errors[addressKindName+'.first_name']"
        />

        <TextField
            :label="$trans.shop.last_name"
            v-model="addressKind.last_name"
            :required="true"
            name="last_name"
            :errors="errors[addressKindName+'.last_name']"
        />

        <TextField
            v-if="addressKindName === 'invoice_address' && context === 'checkout'"
            :label="$trans.shop.email"
            v-model="addressKind.email"
            type="email"
            :required="true"
            name="email"
            :errors="errors[addressKindName+'.email']"
        />

        <div v-else/>

        <TextField
            :label="$trans.shop.phone"
            name="phone"
            type="tel"
            v-model="addressKind.phone"
        />

        <TextField
            :label="$trans.shop.street"
            name="street"
            v-model="addressKind.street"
            :required="true"
            :errors="errors[addressKindName+'.street']"
        />

        <TextField
            :label="$trans.shop.additional_address_field"
            name="additional_field"
            v-model="addressKind.additional_field"
        />

        <div class="sm:col-span-2 lg:col-span-3 w-full flex flex-col sm:flex-row gap-[30px]">
            <div class="sm:w-[170px] flex-shrink-0">
                <TextField
                    :label="$trans.shop.postcode"
                    name="postcode"
                    v-model="addressKind.postcode"
                    :required="true"
                    :errors="errors[addressKindName+'.postcode']"
                />
            </div>

            <div class="w-full">
                <TextField
                    :label="$trans.shop.city"
                    name="city"
                    v-model="addressKind.city"
                    :required="true"
                    :errors="errors[addressKindName+'.city']"
                />
            </div>

            <div class="sm:w-[170px] flex-shrink-0">
                <SelectField
                    :label="$trans.shop.country"
                    v-model="addressKind.country_iso"
                    :required="true"
                    :options="$shared.countryOptions"
                />
            </div>
        </div>
    </div>
</template>
