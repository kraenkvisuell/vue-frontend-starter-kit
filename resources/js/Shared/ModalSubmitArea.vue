<template>
    <div class="
        flex flex-col sm:flex-row-reverse gap-[12px] sm:gap-[24px]
        sm:justify-between items-center
    ">
        <div class="sm:mr-[-6px] text-center sm:text-right">
            <slot/>
        </div>

        <div class="text-copy-sm text-center sm:text-left">
            <slot name="secondary"/>
        </div>
    </div>
</template>
