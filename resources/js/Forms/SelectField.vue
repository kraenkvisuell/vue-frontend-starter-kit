<script setup>
import FormError from './FormError.vue'
import FormLabel from './FormLabel.vue'
import SelectArrow from '../Svg/SelectArrow.vue'
import { useFormErrors } from '../Composables/useFormErrors.js'

const { hasErrors } = useFormErrors()

const props = defineProps({
    errors: { type: Array, default: [] },
    formBg: { type: String, default: 'grey' },
    label: { type: String, default: '' },
    modelValue: String | Number,
    options: { type: Array, default: [] },
    required: { type: Boolean, default: false },
})
</script>

<template>
    <div>
        <FormLabel v-if="label" :required="required">{{ label }}</FormLabel>

        <div>
            <select
                class="mt-[2px] appearance-none text-copy-base w-full px-[10px] py-[7px] border"
                :class="{
                    'bg-white': formBg === 'grey',
                    'bg-gray-100': formBg !== 'grey',
                    'border-dashed border-error': hasErrors(errors),
                    'border-transparent': !hasErrors(errors),
                }"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
            >
                <option v-for="option in options" :value="option.value">
                    {{ option.label }}
                </option>
            </select>

            <div class="absolute right-[9px] top-[14px] fill-black h-[16px] pointer-events-none">
                <SelectArrow />
            </div>
        </div>

        <FormError :errors="errors" />
    </div>
</template>
