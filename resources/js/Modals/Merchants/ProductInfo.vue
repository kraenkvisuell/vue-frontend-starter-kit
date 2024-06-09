<script setup>
import DetailsInfo from '../../Blueprints/Product/Details/Info.vue'
import DetailsTable from '../../Blueprints/Product/Details/Table.vue'
import FormButton from '../../Forms/FormButton.vue'
import Modal from '../../Shared/Modal.vue'
import ModalSubmitArea from '../../Shared/ModalSubmitArea.vue'
import money from '../../money.js'
import { useMedia } from '../../Composables/useMedia.js'
import { useModalStore } from '../../Stores/ModalStore.js'
import { useOrderFormModalsStore } from '../../Stores/Merchants/OrderFormModalsStore.js'
import { usePage } from '@inertiajs/vue3'
import { useStrings } from '../../Composables/useStrings.js'

const modalStore = useModalStore()
const store = useOrderFormModalsStore()

const { nl2br } = useStrings()
const { imageLink } = useMedia()
</script>

<template>
    <Modal id="productInfoModal">
        <div class="@container grid gap-[40px]" v-if="store.currentSku && store.currentProduct">
            <div class="text-headline-base flex gap-[6px]">
                <span class="font-bold tracking-normal">
                    {{ store.currentProduct.group_title }} {{ store.currentProduct.reduced_title }}
                </span>

                <span class="uppercase">
                    {{ store.currentSku.colors[0].title }}
                </span>
            </div>

            <div class="w-full aspect-w-1 aspect-h-1">
                <div class="w-full h-full">
                    <img
                        :src="imageLink(store.currentSku.image, {width: 1280})"
                        class="w-full object-cover"
                    />
                </div>
            </div>

            <div class="text-copy-lg">
                <span v-if="usePage().props.loggedMerchant.can_see_prices">
                    HEK {{ money.formatted(store.currentSku.price, 'de') }}&nbsp;{{ $shared.currencySign }} &nbsp;/&nbsp;
                </span>

                UVP {{ money.formatted(store.currentSku.selling_price, 'de') }}&nbsp;{{ $shared.currencySign }}
            </div>

            <div class="text-copy-sm">
                <div class="font-bold tracking-normal">
                    {{ $trans.products.product_details }}
                </div>

                <div class="w-full border-b border-gray-600 pt-[20px] sm:pt-[8px]"></div>

                <DetailsTable
                    v-if="store.currentProduct.dimensions"
                    :headline="$trans.products.dimensions"
                    :text="store.currentProduct.dimensions"
                />

                <DetailsTable
                    v-if="store.currentProduct.volume"
                    :headline="$trans.products.volume"
                    :text="store.currentProduct.volume"
                />

                <DetailsTable
                    v-if="store.currentProduct.weight"
                    :headline="$trans.products.weight"
                    :text="store.currentProduct.weight+' g'"
                />

                <DetailsTable
                    v-if="store.currentProduct.material_details"
                    :headline="$trans.products.material"
                    :text="nl2br(store.currentProduct.material_details)"
                />

                <DetailsTable
                    v-if="store.currentProduct.features"
                    :headline="$trans.products.features"
                    :text="nl2br(store.currentProduct.features)"
                />

                <DetailsTable
                    v-if="store.currentProduct.laptop_dimensions"
                    :headline="$trans.products.laptop_dimensions"
                    :text="store.currentProduct.laptop_dimensions+' cm'"
                />

                <DetailsInfo
                    v-if="store.currentProduct.contains_magnets"
                    :headline="$trans.products.attention_magnets"
                    :text="nl2br($trans.products.magnets_warning)"
                />
            </div>

            <div class="editor" v-html="store.currentProduct.description" />


        </div>

        <template v-slot:footer>
            <ModalSubmitArea>
                <button type="button" @click="modalStore.close('productInfoModal')">
                    <FormButton>
                        {{ $trans.shop.close }}
                    </FormButton>
                </button>
            </ModalSubmitArea>
        </template>
    </Modal>
</template>

