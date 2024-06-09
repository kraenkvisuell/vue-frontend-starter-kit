<script setup>
import BlockYMargin from '../Shared/BlockYMargin.vue'
import ColorBox from '../Shared/ColorBox.vue'
import Medium from '../Shared/Medium.vue'
import MediumTitle from '../Shared/MediumTitle.vue'
import _ from 'lodash'
import { Link } from '@inertiajs/vue3'
import { computed } from 'vue'
import { useLinks } from '../Composables/useLinks.js'
import { useRatio } from '../Composables/useRatio.js'
import { useStrings } from '../Composables/useStrings.js'

const { getLink, linkType } = useLinks()
const { ratioClasses } = useRatio()
const { stripTags, nl2br } = useStrings()

const props = defineProps({
    block: Object,
})

const bgColor = computed(() => props.block.bg_color ? $shared.colorOptions[props.block.bg_color] : $shared.defaultBgColor)
const caption = computed(() => props.block.caption ? props.block.caption.text : '')
const credits = computed(() => props.block.credits ? props.block.credits.text : '')
const hasText = computed(() => props.block.has_text && _.trim(stripTags(props.block.text.editor_text)))
const mediumWidth = computed(() => props.block.medium_width ? props.block.medium_width.value : 'full')

let computedRatioClasses = (props.block.force_ratio && props.block.ratio.value)
    ? ratioClasses(props.block.ratio.value) : ''
</script>

<template>
    <BlockYMargin>
        <div
            class="mx-auto @container"
            :class="{
                'max-w-screen-lg': mediumWidth === 'full' || !mediumWidth,
                'max-w-screen-md': mediumWidth === 'less',
                'max-w-[512px]': mediumWidth === 'half',
            }"
        >
            <ColorBox :bgColor="hasText ? bgColor : 'transparent'">
                <div class="flex flex-col">
                    <div :class="[computedRatioClasses]">
                        <Medium
                            :forceRatio="!!(block.force_ratio && block.ratio.value)"
                            :ratio="block.ratio.value"
                            :file="block.medium_file"
                            :alt="block.medium_alt ? block.medium_alt.text : ''"
                            :mediumFit="block.medium_fit ? block.medium_fit.value : 'center'"
                        />

                        <MediumTitle
                            v-if="block.title && block.title.text"
                            :title="nl2br(block.title.text)"
                            :position="block.title_position.value"
                            :size="block.title_size.value"
                        />

                        <component
                            v-if="block.has_link"
                            class="absolute inset-0 z-10"
                            :href="getLink(block)"
                            :title="block.title"
                            :is="linkType(block) === 'external' ? 'a' : Link"
                        />
                    </div>

                    <div
                        v-if="caption || credits"
                        class="flex justify-between px-[10px] py-[3px] text-copy-sm"
                        :class="{
                            'text-black': !hasText,
                        }"
                    >
                        <div v-html="caption" class="editor" />
                        <div
                            :class="{
                                'text-gray-600': !hasText,
                            }"
                            v-text="credits"
                        />
                    </div>

                    <div
                        v-if="hasText"
                        class="
                            leading-normal editor
                            px-[30px] @lg:px-[45px] @2xl:px-[60px]
                            py-[20px] @lg:py-[30px] @2xl:py-[40px]
                        "
                        v-html="block.text.editor_text"
                    />
                </div>
            </ColorBox>
        </div>
    </BlockYMargin>
</template>
