<template>
    <div class="flex justify-end text-gray-400 mt-2">
        You have {{ todoCounterMessage }}
    </div>
</template>

<script>
    export default {
        props: {
            items: {
                type: Array,
                default: () => [],
            },
        },
        computed: {
            todoCounterMessage() {
                const count = this.items.length;
                return `${count} ${count === 1 ? "todo" : "todos"}`;
            },
        },
    };
</script>
