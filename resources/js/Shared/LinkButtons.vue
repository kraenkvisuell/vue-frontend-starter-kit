<script setup>
import FormButton from '../Forms/FormButton.vue'
import { useLinks } from '../Composables/useLinks.js'

const { getLink } = useLinks()

const props = defineProps({
    linkButtons: { type: Array, default: [] },
})
</script>


<template>
    <div class="flex flex-wrap gap-[20px]">
        <a v-for="linkButton in linkButtons" :href="getLink(linkButton)">
            <FormButton
                :bgColor="linkButton.bg_color ? $shared.colorOptions[linkButton.bg_color] : $shared.defaultBgColor"
            >
                {{ linkButton.text }}
            </FormButton>
        </a>
    </div>
</template>


