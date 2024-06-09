<script setup>
import { useModalStore } from '../Stores/ModalStore'
import { ref, useSlots, watch } from 'vue'
import LargeClose from '../Svg/LargeClose.vue'
import { useScrollLock } from '../Composables/useScrollLock'

const { lockBody, unlockBody } = useScrollLock()

const modalStore = useModalStore()

const slots = useSlots()

const props = defineProps({
    id: { type: String, default: '' },
    width: { type: String, default: 'md' },
})

const dialog = ref(null)
const isOpen = ref(false)

watch(() => modalStore.openModals, () => {
    if (!isOpen.value && modalStore.openModals.indexOf(props.id) > -1) {
        isOpen.value = true
        dialog.value.showModal()
        lockBody()
        dialog.value.scrollTo(0, 0)
    } else if (isOpen.value) {
        isOpen.value = false
        dialog.value.close()
        unlockBody()
    }
}, { deep: true })
</script>

<template>
    <Teleport to="body">
        <dialog
            ref="dialog"
            :id="id"
            class="
                p-0 max-h-popup md:max-h-md-popup scroll-smooth
                bg-gray-100 rounded border-0
                shadow-lg w-[95%]
            "
            :class="{
                'max-w-[700px]': width === 'md',
                'max-w-[900px]': width === 'lg',
                'max-w-[1200px]': width === 'xl',
            }"
        >
            <div class="">
                <form @submit.prevent>
                    <div class="overflow-auto px-[20px] sm:px-[30px] pt-[50px] pb-[20px]">
                        <slot />
                    </div>

                    <div v-if="slots.footer" class="bg-gray-200 px-[20px] sm:px-[30px] py-[17px]">
                        <slot name="footer" />
                    </div>
                </form>
            </div>

            <div class="absolute top-[6px] right-[38px]">
                <button
                    class="fixed w-[32px] h-[32px] flex items-center justify-center bg-gray-100 rounded-full"
                    @click="modalStore.close(id)"
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
