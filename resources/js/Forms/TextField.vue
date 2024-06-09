<script setup>
import { useFormErrors } from '../Composables/useFormErrors.js'
import FormLabel from './FormLabel.vue'
import FormError from './FormError.vue'

const { hasErrors } = useFormErrors()

const props = defineProps({
    autocomplete: { type: String, default: null },
    disabled: { type: Boolean, default: false },
    enterMethod: null,
    errors: { type: Array, default: [] },
    formBg: { type: String, default: 'grey' },
    align: { type: String, default: 'left' },
    id: { type: String, default: '' },
    label: { type: String, default: '' },
    modelValue: String | Number,
    name: { type: String, default: '' },
    placeholder: { type: String, default: null },
    required: { type: Boolean, default: false },
    bold: { type: Boolean, default: false },
    type: { type: String, default: 'text' },
})
</script>

<template>
    <div class="grid gap-[4px]">
        <FormLabel v-if="label" :required="required" :bold="required || bold">{{ label }}</FormLabel>

        <div>
            <input
                class="text-copy-base w-full px-[11px] py-[7px] border"
                :disabled="disabled"
                :class="{
                    'opacity-50 cursor-not-allowed': disabled,
                    'bg-white': formBg === 'grey',
                    'bg-gray-100': formBg !== 'grey',
                    'border-dashed border-error': hasErrors(errors),
                    'border-transparent': !hasErrors(errors),
                    'text-center': align === 'center',
                }"
                :autocomplete="autocomplete ? autocomplete : (name ? name : label)"
                :placeholder="placeholder"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
                @keyup.enter="enterMethod"
                :type="type"
                :name="name ? name : label"
                :id="id ? id : null"
            />
        </div>

        <FormError :errors="errors" :name="name" />
    </div>
</template>
