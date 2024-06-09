<template>
    <div
        :class="{
            'rounded shadow shadow-colored p-4': fields.length > 1
        }"
    >
        <div :class="{
            'flex justify-end': fields.length > 1
        }">
            <div
                class="btn-group"
                :class="{
                    'mb-4': fields.length > 1,
                    'mb-2 mt-[-6px]': fields.length === 1
                }"
            >
                <button
                    v-for="(language, languageKey) in languages"
                    class="uppercase"
                    :class="{
                        'btn-primary': languageKey == currentLanguage,
                        'btn': languageKey != currentLanguage,
                        'w-icon px-1 py-1 h-icon': fields.length > 1,
                        'w-[24px] px-1 py-1 h-[24px] text-2xs': fields.length == 1,
                    }"

                    v-text="languageKey"
                    @click="switchLanguage(languageKey)"
                />
            </div>
        </div>

        <div
            class="flex flex-wrap gap-x-12  gap-y-8"
            :class="{
                'mt-4': fields.length > 1
            }"
        >
            <div
                v-for="field in fields"
                :class="{
                    'w-full': !field.width || field.width != 100 || field.width == 'full',
                    'w-1/2': field.width != 50,
                    'w-1/3': field.width != 33,
                    'w-1/4': field.width != 25,
                }"
            >

                <translatable-field
                    v-for="(params, languageKey) in languages"
                    v-show="languageKey == currentLanguage"
                    :key="field.handle"
                    :field="field"
                    :label="fields.length > 1 ? field.display : ''"
                    :value="(data && data[languageKey]) ? data[languageKey][field.handle] : emptyValueForFieldtype(field.type)"
                    :field-path="languageKey+'.'+field.handle"
                    :language-key="languageKey"
                    :parent-name="config.handle"
                    @updated="updateData($event, field.handle, languageKey)"
                    @focus="$emit('focus')"
                    @blur="$emit('blur')"
                    @replicator-preview-updated="previewUpdated(field.handle, $event)"
                />

            </div>
        </div>
    </div>
</template>

<script>
import { eventBus } from '../../eventBus'
import TranslatableField from './Translatable/Field.vue'

export default {
    components: { TranslatableField },
    mixins: [Fieldtype],
    data() {
        return {
            languages: this.meta.languages,
            currentLanguage: 'de',
            data: {},
        }
    },

    watch: {
        data: {
            deep: true,
            handler(data) {
                this.updateDebounced(data)
            },
        },
    },

    methods: {
        updateData(newValue, handle, languageKey) {
            this.data[languageKey][handle] = newValue
        },
        setData() {
            let newData = {}
            _.each(this.languages, (params, languageKey) => {

                newData[languageKey] = {}
                _.each(this.config.sets, (section) => {
                    _.each(section.sets, (set) => {
                        _.each(set.fields, (field) => {
                            if (field.type === 'bard') {
                                if (this.value && this.value[languageKey] && this.value[languageKey][field.handle]) {
                                    if (
                                        typeof (this.value[languageKey][field.handle]) === 'string'
                                        && (
                                            this.value[languageKey][field.handle].substring(0, 2) === '[{'
                                            || this.value[languageKey][field.handle].substring(0, 2) === '[]'
                                        )
                                    ) {
                                        this.value[languageKey][field.handle] = JSON.parse(this.value[languageKey][field.handle])
                                    }
                                }
                            }
                            newData[languageKey][field.handle] =
                                (this.value && this.value[languageKey] && this.value[languageKey][field.handle])
                                    ? this.value[languageKey][field.handle]
                                    : this.emptyValueForFieldtype(field.type)
                        })
                    })
                })

            })
            this.data = newData
        },
        switchLanguage(languageKey) {
            eventBus.$emit('languageChanged', languageKey)
        },
        previewUpdated(handle, value) {
            setTimeout(() => {
                this.$emit('previews-updated', { ...this.previews, [handle]: value })
            }, 0)
        },
        emptyValueForFieldtype(fieldtype) {
            if (fieldtype === 'bard') {
                return []
            }

            return ''
        },
    },
    computed: {
        emptyBardValue() {
            return '[]'
        },
        displayMode() {
            return this.config.display_mode ? this.config.display_mode : 'short'
        },
        fields() {
            let actualFields = []
            _.each(this.config.sets, (section) => {
                _.each(section.sets, (set) => {
                    _.each(set.fields, (field) => {
                        actualFields.push(field)
                    })
                })
            })
            return actualFields
        },
        replicatorPreview() {
            return ''
        },

    },
    mounted() {
        this.setData()
        // console.log(JSON.parse(JSON.stringify(this.config.sets)));
        // console.log(this.config.sets);

        eventBus.$on('languageChanged', (languageKey) => this.currentLanguage = languageKey)
    },
}
</script>
