<script setup>
import Bar from '../../Shared/Bar.vue'
import {useMenuStore} from '../../Stores/MenuStore'
import {useCartPanelStore} from '../../Stores/CartPanelStore'
import {useSearchStore} from '../../Stores/SearchStore'

const menuStore = useMenuStore()
const cartPanelStore = useCartPanelStore()
const searchStore = useSearchStore()

const handleClick = () => {
    menuStore.toggle()
    cartPanelStore.close()
    searchStore.close()
}
</script>

<template>
    <button @click="handleClick">
        <div
            class="
                text-black hover:text-gray-800 fill-black hover:fill-gray-800
                relative cursor-pointer flex items-center justify-center
                h-icon w-[21px]
            "
        >
            <div
                class=" absolute left-0 top-0 h-full flex transition-all duration-300"
                :class="{
                    'rotate-45': menuStore.isOpen,
                    '-mt-[6px]': !menuStore.isOpen,
                }"
            >
                <Bar/>
            </div>

            <div
                class="absolute left-0 top-0 h-full flex transition-all duration-300"
                :class="{
                    'opacity-0': menuStore.isOpen,
                }"
            >
                <Bar/>
            </div>

            <div
                class=" absolute left-0 top-0 h-full flex transition-all duration-300"
                :class="{
                    '-rotate-45': menuStore.isOpen,
                    'mt-[6px]': !menuStore.isOpen,
                }"
            >
                <Bar/>
            </div>
        </div>
    </button>
</template>
