<script setup>
import ProductCard from './ProductCard.vue'
import ProductCardImage from './ProductCardImage.vue'
import ProductCardMain from './ProductCardMain.vue'
import { Link } from '@inertiajs/vue3'
import { computed } from 'vue'
import { useMedia } from '../Composables/useMedia.js'

const { imageLink } = useMedia()

const props = defineProps({
    sku: Object,
})

const url = computed(() => {
    return props.sku.product.url + '#' + props.sku.colors[0].slug
})
</script>

<template>
    <ProductCard>
        <div>
            <Link :href="url">
                <ProductCardImage>
                    <div class="w-full h-full absolute top-0 left-0 flex items-center justify-center">
                        <img
                            :src="imageLink(sku.image, { fit: [800, 800] })"
                            :alt="sku.product.title+' '+sku.title"
                            class="w-[90%] h-[90%] object-contain object-top"
                            loading="lazy"
                        />
                    </div>
                </ProductCardImage>
            </Link>

            <ProductCardMain>
                <template v-slot:tagsString>{{ sku.product.tagsString }}</template>

                <template v-slot:groupTitle>{{ sku.product.group_title }}</template>

                <template v-slot:title>{{ sku.product.reduced_title }}</template>
            </ProductCardMain>
        </div>
    </ProductCard>
</template>
