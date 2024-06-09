<script setup>
import { useTranslations } from '../Composables/useTranslations.js'
import Close from '../Shared/Close.vue'
import FormLabel from './FormLabel.vue'
import _ from 'lodash'
import { filesize } from 'filesize'
import { computed, defineModel, ref } from 'vue'
import { useStrings } from '../Composables/useStrings.js'

const { makeId } = useStrings()
const { replace } = useTranslations()

const model = defineModel()

const localModel = ref([])

const props = defineProps({
    label: { type: String, default: '' },
    savedItems: { type: Array, default: [] },
    accept: { type: String, default: '' },
    multiple: { type: Boolean, default: true },
    overwriteSelection: { type: Boolean, default: false },
    maxSize: { type: Number, default: 100000000 },
})

const actualId = makeId()

const computedAccept = computed(() => {
    if (props.accept) {
        return props.accept
    }

    return '*'
})

const update = () => {
    model.value = _.filter(localModel.value, (item) => item.file.size <= props.maxSize)
}

const remove = (id) => {
    localModel.value = _.filter(localModel.value, (item) => item.id !== id)
    update()
}

const selectFiles = (target) => {
    console.log(target.files)
    if (props.overwriteSelection) {
        localModel.value = []
    }

    _.each(target.files, (file) => {
        let error = ''
        if (file.size > props.maxSize) {
            error = $trans.files.will_not_be_uploaded
            error += '<br>'
                + replace(
                    $trans.files.size_exceeds_placeholder,
                    { 'attribute': filesize(props.maxSize) },
                )
        }

        if (_.startsWith(file.type, 'image')) {
            let fileReader = new FileReader()
            fileReader.onload = () => {
                localModel.value.push({
                    src: fileReader.result,
                    file: file,
                    name: file.name,
                    error: error,
                    id: makeId(),
                })

                update()
            }
            fileReader.readAsDataURL(file)
        } else {
            localModel.value.push({
                file: file,
                name: file.name,
                error: error,
                id: makeId(),
            })

            update()
        }
    })
}
</script>


<template>
    <div>
        <FormLabel v-if="label">{{ label }}</FormLabel>

        <div class="w-full">
            <div class="w-full cursor-pointer mb-[10px]">
                <input
                    type="file"
                    :id="actualId"
                    @input="selectFiles($event.target)"
                    :accept="computedAccept"
                    :multiple="multiple"
                    class="relative z-10 block w-full cursor-pointer opacity-0"
                />

                <div class="w-full h-[32px] absolute top-0 left-0 z-0 cursor-pointer">
                    <div
                        class="
                            z-0 flex h-full w-full items-center justify-center
                            text-sm font-semibold text-white bg-black rounded
                        ">
                        <span>{{ multiple ? $trans.files.select_files : $trans.files.select_file }}</span>
                    </div>
                </div>
            </div>

            <div class="grid gap-[10px]">
                <div
                    v-for="queuedFile in localModel"
                    :key="queuedFile"
                    class="px-[8px] py-[8px] flex leading-tight text-copy-sm bg-white"
                    :class="{
                        'border border-red-500': queuedFile.error,
                    }"
                >
                    <div
                        v-if="queuedFile.src"
                        class="w-[96px] h-[96px] mr-4 flex-shrink-0 bg-black  opacity-50"
                    >
                        <img
                            :src="queuedFile.src"
                            class="h-full w-full object-contain"
                        />
                    </div>

                    <div class="text-sm">
                        <div
                            v-text="queuedFile.file.name"
                            class="font-semibold"
                        />

                        <div
                            v-if="queuedFile.error"
                            v-html="queuedFile.error"
                            class="mt-4 text-red-600"
                        />
                    </div>

                    <button
                        class="
                            block text-headline-base md:text-headline-lg leading-none font-extralight
                            absolute top-[5px] right-[5px] h-[12px]
                        "
                        :class="{
                            'text-red-500': queuedFile.error,
                            'text-black': !queuedFile.error,
                        }"
                        @click="remove(queuedFile.id)"
                    >
                        <Close />
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
