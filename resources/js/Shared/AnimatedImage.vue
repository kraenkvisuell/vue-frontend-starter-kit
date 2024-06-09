<script setup>
import { computed, ref, watch } from 'vue'
import { storeToRefs } from 'pinia'
import { useCartStore } from '../Stores/CartStore'
import { useMedia } from '../Composables/useMedia.js'

const { imageLink } = useMedia()
const cartStore = useCartStore()
const { imageIsAnimated } = storeToRefs(cartStore)

const props = defineProps({
    sku: { type: Object, default: {} },
    selectedSkuId: { type: Number, default: 0 },
    parentImage: { type: Object, default: null },
    alt: { type: String, default: 'product image' },
})

let isAnimating = ref(false)
let endTop = ref(40)
let endRight = ref(70)
let endWidth = ref(20)
let startWidth = ref(0)
let startTop = ref(0)
let startRight = ref(0)

const animateImage = () => {
    if (cartStore.selectedCartSkuId === props.sku.id) {
        let windowWidth = window.innerWidth
        let rect = props.parentImage.getBoundingClientRect()

        startWidth = props.parentImage.offsetWidth
        startTop.value = rect.top
        startRight.value = windowWidth - rect.right

        isAnimating.value = true
        setTimeout(() => isAnimating.value = false, 1000)
    }
}

watch(imageIsAnimated, () => {
    animateImage()
})

let isSelected = computed(() => props.selectedSkuId === props.sku.id)
let backgroundImage = computed(() => {
    return isSelected.value ? imageLink(props.sku.image, { fit: [800, 800] }) : '/img/loading01.gif'
})
</script>

<template>
    <Teleport to="body">
        <div
            v-show="isAnimating"
            class="rounded-full bg-white fixed z-[200] pointer-events-none"
            :style="{
               '--startTop': startTop+'px',
               '--startWidth': startWidth+'px',
               '--startRight': startRight+'px',
               '--endTop': endTop+'px',
               '--endRight': endRight+'px',
               '--endWidth': endWidth+'px',
            }"
        >
            <img :src="backgroundImage" :alt="alt" class="rounded-full" />
        </div>


    </Teleport>
</template>

<style scoped>
div {
    animation-name: moveimage;
    animation-duration: .4s;
    animation-iteration-count: 1;
    animation-timing-function: ease;
}

@keyframes moveimage {
    0% {
        top: var(--startTop);
        right: var(--startRight);
        width: var(--startWidth);
        height: var(--startWidth);
    }
    100% {
        top: var(--endTop);
        right: var(--endRight);
        width: var(--endWidth);
        height: var(--endWidth);
    }
}
</style>
