<script setup>
import EmbedCode from './EmbedCode.vue'
import ImageGallery from './ImageGallery.vue'
import ImageRow from './ImageRow.vue'
import Jobs from './Jobs.vue'
import LinkCards from './LinkCards.vue'
import MediumCard from './MediumCard.vue'
import SelectedProducts from './SelectedProducts.vue'
import Text from './Text.vue'
import _ from 'lodash'


const props = defineProps({
    block: Object,
})

const components = {
    Jobs,
    LinkCards,
    MediumCard,
    Text,
    EmbedCode,
    ImageGallery,
    ImageRow,
    SelectedProducts,
}

const componentName = _.upperFirst(_.camelCase(props.block.type))

// console.log(props.block)
</script>

<template>
    <component :is="components[componentName]" :block="block" />
</template>
