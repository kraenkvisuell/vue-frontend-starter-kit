<script setup>
import LinkButtons from '../Shared/LinkButtons.vue'
import BlockYMargin from '../Shared/BlockYMargin.vue'

const props = defineProps({
    block: Object,
})

// console.log(props.block)
</script>

<template>
    <BlockYMargin>
        <div class="w-full mx-auto max-w-screen-md grid gap-[12px]">
            <div
                class="
                    editor text-black
                    text-copy-sm sm:text-copy-base lg:text-copy-lg
                "
                :class="{
                    'has-check-list': block.has_check_list
                }"
                v-html="block.text.editor_text"
            />

            <LinkButtons v-if="block.link_buttons.length" :linkButtons="block.link_buttons"/>
        </div>
    </BlockYMargin>
</template>
