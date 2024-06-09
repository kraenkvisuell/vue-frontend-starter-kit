<script setup>
import { useZoomStore } from '../../Stores/ZoomStore.js'
import LargeClose from '../../Svg/LargeClose.vue'
import { ref, watch } from 'vue'
import { useScrollLock } from '../../Composables/useScrollLock.js'

const { lockBody, unlockBody } = useScrollLock()

const zoomStore = useZoomStore()
const dialog = ref(null)

watch(() => zoomStore.isVisible, () => {
    if (zoomStore.isVisible) {
        dialog.value.showModal()
        lockBody()
    } else {
        dialog.value.close()
        unlockBody()
    }
})

// console.log(productStore.product)
</script>

<template>
    <Teleport to="body">
        <dialog
            ref="dialog"
            id="imageZoom"
            class="
                p-0
                bg-white rounded border-0
                shadow-lg w-[calc(100%-60px)] h-[calc(100%-60px)]
            "
        >
            <div class="absolute inset-0 flex items-center justify-center w-full h-full">
                <img src="/img/loading01.gif" class="w-[300px]" />
            </div>

            <div class="flex items-center justify-center w-full h-full">
                <img :src="zoomStore.currentImage" class="w-full h-full object-contain" />
            </div>

            <div class="absolute top-[6px] right-[38px]">
                <button
                    class="fixed w-[32px] h-[32px] flex items-center justify-center bg-white rounded-full"
                    @click="zoomStore.hide()"
                >
                    <span class="block w-[16px] h-[16px]">
                        <LargeClose />
                    </span>
                </button>
            </div>
        </dialog>

    </Teleport>
</template>

<style scoped>
dialog {
    @apply fixed top-0 left-0;
}

dialog::backdrop {
    @apply bg-black/90;
}
</style>
