<script setup>
import FormButton from '../../Forms/FormButton.vue'
import Bag from '../../Parts/Menu/CartIcon/Bag.vue'
</script>

<template>
    <FormButton>
        <div class="flex items-center justify-center gap-[10px]">
            <div class="fill-white">
                <div class="h-[36px]">
                    <Bag/>
                </div>


                <div class="font-light text-copy-sm absolute left-[6px] top-[12px]">
                    €
                </div>
            </div>

            <div>{{ $trans.shop.to_checkout }}</div>
        </div>
    </FormButton>
</template>
