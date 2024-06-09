<script setup>
import SmallestHeadline from '../../Shared/SmallestHeadline.vue'
import NavigationLink from './NavigationLink.vue'

const props = defineProps({
    title: {
        type: String,
        default: '',
    },
    pages: Array,
})
</script>

<template>
    <div class="grid gap-[10px]">
        <SmallestHeadline v-if="title">
            {{ title }}
        </SmallestHeadline>

        <div class="w-full">
            <div class="text-copy-sm tracking-normal">
                <NavigationLink
                    v-for="(page) in pages"
                    :page="page"
                    class="block py-[4px] hyphens-auto md:hyphens-none leading-tight text-gray-800 hover:text-black"
                />
            </div>
        </div>
    </div>
</template>
