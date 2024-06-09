<script setup>
import CheckMark from '../Svg/CheckMark.vue'
import { useStrings } from '../Composables/useStrings.js'
import { computed } from 'vue'

const { makeId } = useStrings()

const props = defineProps({
    modelValue: {
        type: Boolean,
        default: false,
    },
    required: {
        type: Boolean,
        default: false,
    },
    id: {
        type: String,
        default: '',
    },
    label: {
        type: String,
        default: '',
    },
})

const actualId = computed(() => props.id ? props.id : makeId())
</script>

<template>
    <div class="flex items-center gap-[10px]">
        <div class="flex-shrink-0 h-[30px] w-[30px]">
            <input
                type="checkbox"
                :checked="modelValue"
                @change="$emit('update:modelValue', $event.target.checked)"
                :id="actualId"
                class="h-full w-full bg-white checked:bg-highlight appearance-none"
            />

            <div
                v-show="modelValue"
                class="pointer-events-none absolute inset-0 flex items-center justify-center text-white py-[5px]"
            >
                <CheckMark />
            </div>
        </div>

        <label
            :for="actualId"
            class="w-full"
            v-html="label"
        />
    </div>
</template>
