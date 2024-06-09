<template>
    <div class="w-full flex justify-between items-center gap-[10px]">
        <div class="w-full">
            <slot/>
        </div>

        <div class="flex-0">
            <slot name="button"/>
        </div>
    </div>
</template>
