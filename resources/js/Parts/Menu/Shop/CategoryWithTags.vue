<script setup>
import ShopCategoryLink from '../../../Shared/ShopCategoryLink.vue'
import ButtonWithTagLink from './ButtonWithTagLink.vue'
import ButtonWithTags from './ButtonWithTags.vue'

const props = defineProps({
    category: Object,
    url: String,
    isActive: { type: Boolean, default: false },
    activeTag: { type: String, default: null },
})

const tagIsActive = (tag) => props.activeTag === tag
</script>

<template>
    <ButtonWithTags :isActive="isActive" :activeTag="activeTag">
        <template v-slot:label>
            <ShopCategoryLink :href="url">{{ category.title }}</ShopCategoryLink>
        </template>

        <template v-slot:options>
            <ShopCategoryLink
                v-for="tag in category.tags"
                :href="$route('shop.tag', [$shared.locale, category.slug, tag.slug])"
            >
                <ButtonWithTagLink :isActive="isActive && tagIsActive(tag.slug)">
                    {{ tag.title }}
                </ButtonWithTagLink>
            </ShopCategoryLink>
        </template>
    </ButtonWithTags>
</template>
