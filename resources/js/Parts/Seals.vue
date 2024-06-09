<script setup>
import { useLinks } from '../Composables/useLinks.js'
import { useMedia } from '../Composables/useMedia.js'

const { imageLink } = useMedia()
const { ensureUrl } = useLinks()
</script>

<template>
    <div class="
        absolute left-0 bottom-[calc(100%+40px)] md:bottom-[calc(100%+80px)] w-full px-[20px]
        flex gap-[15px] md:gap-[20px] items-center justify-center flex-wrap
    ">
        <template v-for="seal in $shared.globals.website.seals">
            <component
                v-if="seal.image"
                :is="seal.link ? 'a' : 'div'"
                :href="seal.link ? ensureUrl(seal.link) : null"
                :target="seal.link ? '_blank' : null"
                class="block h-[72px] md:h-[96px] flex-shrink-0"
                :title="seal.title ? seal.title.text : null"
            >
                <img
                    :src="imageLink(seal.image, {width: 400})"
                    :alt="seal.alt ? seal.alt.text : null"
                    class="h-full w-auto"
                />
            </component>
        </template>
    </div>
</template>
