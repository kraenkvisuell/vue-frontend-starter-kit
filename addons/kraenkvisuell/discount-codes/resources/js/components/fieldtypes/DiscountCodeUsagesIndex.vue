<template>
    <div
        class=""
        :class="{
            'text-green-500': !usedUp,
            'text-red-500': usedUp,
        }"
    >
        {{ value.usages }}/{{ value.allowed_usages ? value.allowed_usages : '∞' }}
    </div>
</template>

<script>
export default {
    mixins: [IndexFieldtype],
    computed: {
        usedUp() {
            if (!this.value.allowed_usages) {
                return false
            }

            return this.value.usages / this.value.allowed_usages >= 1
        },
    },
}
</script>
