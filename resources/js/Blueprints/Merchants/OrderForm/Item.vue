<template>
    <div class="mb-[2px] h-[80px] text-copy-sm flex items-stretch">
        <div class="w-full flex-grow-1">
            <slot />
        </div>

        <div class=" h-full w-[31px] flex-grow-0 uppercase text-copy-xs text-white font-semibold flex justify-end">
            <slot name="flags" />
        </div>
    </div>
</template>

