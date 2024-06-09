<script setup>
import CheckMark from '../Svg/CheckMark.vue'
import FormLabel from './FormLabel.vue'
import _ from 'lodash'
import { defineModel, onMounted, ref } from 'vue'
import { useStrings } from '../Composables/useStrings.js'

const { makeId } = useStrings()

const model = defineModel()

const localModel = ref([])

const props = defineProps({
    label: { type: String, default: '' },
    options: { type: Array, default: [] },
    readonly: { type: Array, default: [] },
})

const update = () => model.value = _.map(localModel.value, (item) => item)

onMounted(() => {
    _.forEach(model.value, function(item) {
        localModel.value.push(item)
    })
})

const actualId = makeId()

</script>


<template>
    <div>
        <FormLabel v-if="label">{{ label }}</FormLabel>

        <div class="grid gap-[5px]">
            <div v-for="option in options" class="flex items-center gap-[5px]">
                <div class="flex-shrink-0 h-[20px] w-[20px]">
                    <input
                        type="checkbox"
                        :value="option.value"
                        v-model="localModel"
                        :disabled="readonly.indexOf(option.value) > -1"
                        :id="actualId+'_'+_.snakeCase(option.value)"
                        @change="update()"
                        class="h-full w-full border border-gray-600 bg-white appearance-none"
                        :class="{
                            'checked:border-highlight checked:bg-highlight': readonly.indexOf(option.value) === -1,
                            'checked:border-gray-600 checked:bg-gray-600': readonly.indexOf(option.value) > -1,
                        }"
                    />

                    <div
                        v-show="model.indexOf(option.value) > -1"
                        class="pointer-events-none absolute inset-0 flex items-center justify-center text-white py-[3px]"
                    >
                        <CheckMark />
                    </div>
                </div>

                <label
                    :for="actualId+'_'+_.snakeCase(option.value)"
                    class="w-full"
                    v-html="option.label"
                />
            </div>
        </div>
    </div>
</template>
