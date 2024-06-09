<template>
    <div class="
        mt-[-10px] @card-xl:mt-[-20px] @card-2xl:mt-[-30px] @card-3xl:mt-[-40px] px-[15px] pb-[15px]
        @card-xl:px-[25px] @card-xl:pb-[25px] @card-3xl:px-[30px] @card-3xl:pb-[30px]
    ">
        <h2 class="leading-tight text-copy-xs @card-sm:text-copy-sm">
            <slot name="tagsString" />
        </h2>

        <div class="
            text-gray-800 tracking-normal
            flex flex-col gap-[4px] @card-2xl:gap-[8px] flex-wrap
            @card-2xl:flex-row @card-2xl:justify-between @card-2xl:items-end
        ">
            <div>
                <h3 class="
                    tracking-normal text-black
                    text-copy-sm @card-sm:text-copy-base  leading-tight
                ">
                    <slot name="groupTitle" />
                    &nbsp;
                    <span class="font-bold">
                        <slot name="title" />
                    </span>
                </h3>
            </div>

            <div>
                <slot name="button" />
            </div>
        </div>
    </div>
</template>

