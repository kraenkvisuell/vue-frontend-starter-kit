<script setup>
import { usePaneStore } from '../Stores/PaneStore'
import { ref, useSlots, watch } from 'vue'
import LargeClose from '../Svg/LargeClose.vue'
import { useScrollLock } from '../Composables/useScrollLock'

const { lockBody, unlockBody } = useScrollLock()

const paneStore = usePaneStore()

const slots = useSlots()

const props = defineProps({
    id: { type: String, default: '' },
})

const isOpen = ref(false)

watch(() => paneStore.openPanes, () => {
    if (!isOpen.value && paneStore.openPanes.indexOf(props.id) > -1) {
        isOpen.value = true
    } else if (isOpen.value) {
        isOpen.value = false
    }
}, { deep: true })
</script>

<template>
    <Teleport to="body">
        <div
            :id="id"
            class="fixed z-50 w-full flex justify-center"
            :class="{
                'hidden': !isOpen,
                'block bottom-0': isOpen,
            }"
        >
            <div
                class="
                    p-0 max-h-popup md:max-h-md-popup scroll-smooth bg-white rounded-t border-0
                    shadow-reverse w-full max-w-screen-lg
                "
            >
                <div class="overflow-auto px-[20px] sm:px-[30px] pt-[11px]">
                    <div class="min-h-[25px] pr-[30px] text-copy-lg pointer-events-none">
                        <slot name="title" />
                    </div>

                    <form @submit.prevent>
                        <div class="pt-[10px] pb-[20px]">
                            <slot />
                        </div>
                    </form>
                </div>

                <div class="absolute top-[6px] right-[38px] z-10">
                    <button
                        class="fixed w-[32px] h-[32px] flex items-center justify-center bg-white rounded-full"
                        @click="paneStore.close(id)"
                    >
                            <span class="block w-[16px] h-[16px]">
                                <LargeClose />
                            </span>
                    </button>
                </div>
            </div>
        </div>

    </Teleport>
</template>
