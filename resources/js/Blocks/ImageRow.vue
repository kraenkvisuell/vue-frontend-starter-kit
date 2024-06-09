<script setup>
import { useLinks } from '../Composables/useLinks.js'
import { useMedia } from '../Composables/useMedia.js'

const { imageLink } = useMedia()
const { ensureUrl } = useLinks()

const props = defineProps({
    block: Object,
})
</script>

<template>
    <div class="grid gap-[22px]">
        <div
            v-if="block.intro && block.intro.text"
            class="max-w-screen-md mx-auto editor px-[20px] sm:px-[35px]"
            v-html="block.intro.text"
        />

        <div class="w-full px-[20px] flex gap-[15px] md:gap-[20px] items-center justify-center flex-wrap">
            <template v-for="image in block.image_row">
                <component
                    v-if="image.image"
                    :is="image.link ? 'a' : 'div'"
                    :href="image.link ? ensureUrl(image.link) : null"
                    :target="image.link ? '_blank' : null"
                    class="block h-[72px] md:h-[96px] flex-shrink-0"
                    :title="image.title ? image.title.text : null"
                >
                    <img
                        :src="imageLink(image.image, {width: 400})"
                        :alt="image.alt ? image.alt.text : null"
                        class="h-full w-auto"
                    />
                </component>
            </template>
        </div>
    </div>
</template>


