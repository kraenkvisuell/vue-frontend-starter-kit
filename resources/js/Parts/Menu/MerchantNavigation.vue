<script setup>
import {useMerchantMenu} from '../../Composables/useMerchantMenu'
import {Link} from '@inertiajs/vue3'
import {useCartPanelStore} from '../../Stores/CartPanelStore.js'
import {useMenuStore} from '../../Stores/MenuStore.js'

const menuStore = useMenuStore()
const cartPanelStore = useCartPanelStore()

const {pages} = useMerchantMenu()

const closeBoth = () => {
    menuStore.close()
    cartPanelStore.close()
}
</script>

<template>
    <div>

        <div class="px-[30px] pt-[60px] md:pt-[30px] pb-[30px]">
            <div class="grid md:grid-cols-2 md:gap-[30px]">
                <div v-for="page in pages" class="text-copy-sm">
                    <Link :href="page.url" @click="closeBoth" v-text="page.title"/>
                </div>
            </div>
        </div>

    </div>
</template>
