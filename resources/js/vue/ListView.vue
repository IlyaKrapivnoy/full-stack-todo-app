<template>
    <div v-for="(item, i) in items" :key="i">
        <list-item
            :item="item"
            @itemchanged="handleItemChanged"
            class="bg-[#2F3137] text-white p-1.5 mt-1.5"
        />
    </div>
</template>

<script>
    import ListItem from "./ListItem.vue";

    export default {
        props: ["items"],
        components: {
            ListItem,
        },
        methods: {
            handleItemChanged() {
                this.$emit("reloadlist");
            },
        },
    };
</script>
