<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
    <div class="flex gap-[20px]">
        <Link
            v-for="category in $shared.mainCategories"
            :text="category.title"
            :href="$route('shop.category', [$shared.locale, category.slug])"
            class="
                inline-block uppercase font-bold hover:text-gray-800 py-[4px]
                text-copy-base
            "
        />
    </div>
</template>
