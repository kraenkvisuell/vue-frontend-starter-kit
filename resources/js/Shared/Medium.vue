<script setup>
import _ from 'lodash'
import { useMedia } from '../Composables/useMedia.js'
import { computed } from 'vue'

const { imageLink, videoLink } = useMedia()

const props = defineProps({
    file: { type: Object, default: null },
    type: { type: String, default: 'file' },
    embedCode: { type: String, default: '' },
    forceRatio: { type: Boolean, default: false },
    ratio: { type: String, default: '' },
    alt: { type: String, default: '' },
    objectFit: { type: String, default: 'object-cover' },
    mediumFit: { type: String, default: '' },
})

const params = computed(() => {
    let params = {}
    const widths = {
        sm: 1152,
        md: 1536,
        lg: 2048,
    }

    if (props.forceRatio && props.ratio) {
        let ratioArr = _.map(props.ratio.split(':'), (value) => parseInt(value))
        let ratio = ratioArr[1] / ratioArr[0]
        let position = props.mediumFit ? props.mediumFit : 'center'
        params = {
            sm: { crop: true, fit: [widths.sm, Math.round(ratio * widths.sm)], position: position },
            md: { crop: true, fit: [widths.md, Math.round(ratio * widths.md)], position: position },
            lg: { crop: true, fit: [widths.lg, Math.round(ratio * widths.lg)], position: position },
        }
    } else {
        params = {
            sm: { width: widths.sm },
            md: { width: widths.md },
            lg: { width: widths.lg },
        }
    }

    return params
})
</script>

<template>
    <template v-if="type === 'file' && file">
        <picture v-if="file.is_image">
            <source media="(min-width: 1024px)" :srcset="imageLink(file, params.lg)" :type="file.mime_type">

            <source media="(min-width: 768px)" :srcset="imageLink(file, params.md)" :type="file.mime_type">

            <img
                :src="imageLink(file, params.sm)"
                :alt="alt"
                loading="lazy"
                class="w-full h-full"
                :class="[objectFit]"
            />
        </picture>


        <video v-if="file.is_video" class="h-full w-full object-cover" playsinline muted autoplay loop>
            <source :src="videoLink(file)" :type="file.mime_type" />
        </video>
    </template>
</template>
