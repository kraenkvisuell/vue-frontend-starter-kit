<script setup>
import Footer from '../../Parts/Footer.vue'
import EmptyMenu from '../../Parts/EmptyMenu.vue'


// console.log(usePage().props)
</script>

<template>
    <main class="font-body text-black bg-gray-100">
        <header>
            <EmptyMenu/>
        </header>

        <main class="pt-[120px] sm:pt-[180px]">
            <slot/>
        </main>

        <footer>
            <Footer/>
        </footer>
    </main>
</template>
