<script setup>
import { useFormErrors } from '../Composables/useFormErrors.js'
import { computed } from 'vue'

const { getErrorString } = useFormErrors()

const props = defineProps({
    errors: { type: Array, default: [] },
    name: { type: String, default: '' },
})

let errorString = computed(() => getErrorString(props.errors))
let id = computed(() => 'error_' + props.name)

</script>

<template>
    <div
        v-show="errorString" class="text-copy-sm text-error pl-[6px]" v-html="errorString"
        :id="id"
    />
</template>
