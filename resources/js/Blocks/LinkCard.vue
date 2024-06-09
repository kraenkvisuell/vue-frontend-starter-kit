<script setup>
import { Link } from '@inertiajs/vue3'
import { useLinks } from '../Composables/useLinks.js'
import { useMedia } from '../Composables/useMedia.js'
import { useStrings } from '../Composables/useStrings.js'
import { computed } from 'vue'
import SmallDisruptor from './SmallDisruptor.vue'

const { getLink, linkType } = useLinks()
const { imageLink, videoLink } = useMedia()
const { nl2br } = useStrings()

const props = defineProps({
    card: Object,
})

const bgColor = computed(() => props.card.bg_color ? $shared.colorOptions[props.card.bg_color] : $shared.defaultBgColor)
const objectPosition = computed(() => props.card.medium_fit ? props.card.medium_fit.value : 'center')

const title = computed(() => props.card.title ? props.card.title.title : '')

const medium = computed(() => {
    if (props.card.medium_file) {
        return {
            type: props.card.medium_type ? props.card.medium_type.value : 'image',
            file: props.card.medium_file,
        }
    }

    if (props.card.linked_product && props.card.linked_product.images && props.card.linked_product.images.length > 0) {
        return {
            type: props.card.linked_product.images[0].medium_type,
            file: props.card.linked_product.images[0].medium_file,
        }
    }

    return null
})

const disruptor = computed(() => {
    if (!props.card.has_disruptor) {
        return {}
    }

    return {
        bgColor: props.card.disruptor_bg_color
            ? $shared.colorOptions[props.card.disruptor_bg_color]
            : $shared.defaultBgColor,
        text: props.card.disruptor_label.text,
        xPosition: props.card.disruptor_x,
        yPosition: props.card.disruptor_y,
    }
})
</script>

<template>
    <div
        class="@container rounded text-center overflow-hidden"
        :class="{
            'col-span-2 lg:col-span-4': card.width_in_layout.value === 'full',
        }"
    >
        <div
            :class="{
                'aspect-w-16 aspect-h-9 lg:aspect-w-[48] lg:aspect-h-[18]': card.width_in_layout.value === 'full',
                'aspect-w-2 aspect-h-3 @card-3xl:aspect-w-3 @card-3xl:aspect-h-4':  card.width_in_layout.value !== 'full',
            }"
            :style="{backgroundColor: bgColor}"
        >
            <div class="absolute inset-0">
                <template v-if="medium">
                    <picture v-if="medium.file && medium.file.is_image" class="h-full w-full absolute top-0 left-0">
                        <source
                            :srcset="imageLink(medium.file, {
                                crop: true,
                                fit: card.width_in_layout.value === 'full' ? [2048, 1142] : [1020, 1530],
                                position: objectPosition,
                            })"
                            media="(min-width: 1024px)"
                        />

                        <source
                            :srcset="imageLink(medium.file, {
                                crop: true,
                                fit: card.width_in_layout.value === 'full' ? [1536, 864] : [768, 1152],
                                position: objectPosition,
                            })"
                            media="(min-width: 768px)"
                        />

                        <img
                            :src="imageLink(medium.file, {
                                crop: true,
                                fit: card.width_in_layout.value === 'full' ? [1200, 675] : [510, 765],
                                position: objectPosition,
                            })"
                            :alt="medium.file"
                            class="h-full w-full object-cover"

                        />
                    </picture>

                    <video
                        v-if="medium.file && medium.file.is_video"
                        class="h-full w-full object-cover"
                        playsinline muted autoplay loop
                    >
                        <source :src="videoLink(medium.file)" :type="medium.file.mime_type" />
                    </video>
                </template>

                <div v-if="card.card_type.value === 'image'" class="absolute bottom-0 left-0 w-full">
                    <div class="absolute left-0 bottom-0 bg-darkest w-full h-[1rem] opacity-70" />

                    <div class="absolute left-0 bottom-[1rem] bg-gradient-to-t from-darkest w-full h-[7rem] opacity-70" />

                    <div
                        class="
                            absolute bottom-[1rem] @card-3xl:bottom-[2rem] w-full text-center text-white font-bold
                            tracking-wide @card-3xl:tracking-wider px-[1rem]
                        "
                        :class="{
                            'text-headline-base @card-3xl:text-headline-lg @card-5xl:text-headline-xl'
                                : card.width_in_layout.value === 'full',
                            'text-headline-3xs @card-md:text-headline-2xs @card-lg:text-headline-xs @card-3xl:text-headline-sm @card-5xl:text-headline-base @card-9xl:text-headline-lg'
                                : card.width_in_layout.value !== 'full',
                        }"
                    >
                        {{ title }}
                    </div>
                </div>

                <SmallDisruptor v-if="card.has_disruptor" :disruptor="disruptor" />

                <div v-if="card.card_type.value === 'text'" class="h-full overflow-clip">
                    <div class="
                        w-full text-left p-[10px] @card-3xl:p-[15px] @card-5xl:p-[20px] @card-9xl:p-[30px] text-white
                    ">
                        <h2
                            class="
                                font-bold tracking-wider leading-tightest
                                text-headline-sm @card-@card-9xl:text-headline-base @card-3xl:text-headline-lg
                                @card-5xl:text-headline-xl
                            "
                            v-html="nl2br(title)"
                        />

                        <div
                            class="
                                editor
                                pt-[10px] @card-5xl:pt-[15px] @card-9xl:pt-[20px]
                                tracking-normal leading-tight @card-@card-9xl:leading-snug
                                text-copy-sm @card-@card-9xl:text-copy-base @card-3xl:text-copy-lg
                                hyphens-auto
                            "
                            v-html="card.text.text"
                        />
                    </div>
                </div>

                <component
                    v-if="card.has_link && card.link"
                    class="absolute inset-0"
                    :href="getLink(card.link)"
                    :title="title"
                    :is="linkType(card.link) === 'external' ? 'a' : Link"
                />
            </div>
        </div>
    </div>
</template>
