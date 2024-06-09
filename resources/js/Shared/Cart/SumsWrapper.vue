<template>
    <div class="grid gap-[30px] md:top-[-20px]">
        <div class="mx-[16px] md:mx-0">
            <slot/>
        </div>

        <slot name="checkout-button"/>
    </div>
</template>
