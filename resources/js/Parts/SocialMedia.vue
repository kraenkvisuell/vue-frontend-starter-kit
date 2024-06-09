<script setup>

const props = defineProps({
    isFooter: { type: Boolean, default: false },
})

// console.log($shared.globals.website.social_media)
</script>

<template>
    <div class="flex gap-[24px]">
        <a
            v-for="social in $shared.globals.website.social_media"
            :href="social.link"
            target="_blank"
            class="flex cursor-pointer fill-current relative"
        >
            <div class="
                text-white
                flex items-center justify-center
            ">
                <i
                    class="block fa-brands text-[20px]"
                    :class="{
                        'fa-facebook-f': social.icon.value === 'facebook',
                        'fa-instagram': social.icon.value === 'instagram',
                        'fa-pinterest-p': social.icon.value === 'pinterest',
                    }"
                ></i>
            </div>
        </a>
    </div>
</template>
