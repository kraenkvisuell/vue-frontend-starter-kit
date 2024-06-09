<script setup>
import NavigationLink from '../Navigations/NavigationLink.vue'

const props = defineProps({
    title: String,
    pages: Array,
})
</script>

<template>
    <div class="w-full grid gap-[10px]">
        <div class="font-bold text-white">
            {{ title }}
        </div>

        <div class="w-full">
            <div class="text-copy-sm tracking-normal lg:columns-2">
                <NavigationLink
                    v-for="page in pages"
                    :page="page"
                    class="block py-[4px] hyphens-auto md:hyphens-none leading-tight text-white hover:text-gray-100"
                />
            </div>
        </div>
    </div>
</template>
