<script setup>
import DoubleArrow from '../../Svg/DoubleArrow.vue'
import IconButton from '../../Forms/IconButton.vue'
import InputWithButton from '../../Forms/InputWithButton.vue'
import SumItem from './SumItem.vue'
import TextField from '../../Forms/TextField.vue'
import money from '../../money.js'
import { useCartStore } from '../../Stores/CartStore'

const cartStore = useCartStore()

</script>

<template>
    <SumItem>
        <div class="grid gap-[20px]">
            <div v-if="cartStore.currentCart.calculatedDiscountUsages.length">
                <SumItem
                    v-for="calculatedDiscount in cartStore.currentCart.calculatedDiscountUsages"
                    class="flex justify-between gap-[20px]"
                >
                    <div class="leading-tight">
                        <div>
                            Code {{ calculatedDiscount.code }}
                            <span v-if="calculatedDiscount.mode === 'percent'">({{ calculatedDiscount.percent
                                }}%)</span>
                        </div>
                        <button
                            class="underline text-copy-xs"
                            @click="cartStore.removeVoucherCode(calculatedDiscount.id)"
                        >
                            {{ $trans.shop.remove }}
                        </button>
                    </div>

                    <div class="font-bold whitespace-nowrap">
                        – {{ money.formatted(calculatedDiscount.amount) }}&nbsp;{{ $shared.currencySign }}
                    </div>
                </SumItem>
            </div>

            <div class="grid gap-[5px]">
                <div class="text-copy-xs leading-tight">
                    {{ $trans.shop.comma_separate_vouchers }}
                </div>

                <InputWithButton>
                    <TextField
                        v-model="cartStore.voucherCodes"
                        :placeholder="$trans.shop.enter_voucher_code"
                        :disabled="cartStore.voucherCodesAreBusy"
                        :enterMethod="cartStore.submitVoucherCodes"
                    />

                    <template v-slot:button>
                        <button :disabled="cartStore.voucherCodesAreDisabled" @click="cartStore.submitVoucherCodes">
                            <IconButton :disabled="cartStore.voucherCodesAreDisabled">
                                <div class="h-[70%]">
                                    <DoubleArrow />
                                </div>
                            </IconButton>
                        </button>
                    </template>
                </InputWithButton>

                <div class="text-copy-xs leading-tight">
                    <div v-show="cartStore.voucherCodesAreBusy">{{ $trans.shop.one_moment_please }}...</div>

                    <div v-show="cartStore.voucherCodesErrorMessage" class="text-error">
                        {{ cartStore.voucherCodesErrorMessage }}
                    </div>
                </div>
            </div>
        </div>
    </SumItem>
</template>

