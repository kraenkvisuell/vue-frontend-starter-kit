<script setup>
import {Link} from '@inertiajs/vue3'
import {useMenuStore} from '../../Stores/MenuStore.js'

const menuStore = useMenuStore()
</script>

<template>
    <div class="
        w-full max-w-screen-md mx-auto lg:mx-0
         pt-[50px] md:pt-[40px] pb-[30px] px-[30px] lg:px-[40px]
        grid gap-[20px]
    ">
        <div class="text-headline-2xl uppercase tracking-wide font-extrabold">
            {{ $trans.shop.shop }}
        </div>

        <div class="py-[5px]">
            <Link
                v-for="category in $shared.categories"
                @click="menuStore.close"
                :text="category.title"
                :href="$route('shop.category', [$shared.locale, category.slug])"
                class="block uppercase font-bold hover:text-gray-800 py-[4px]"
            />

        </div>
    </div>
</template>
