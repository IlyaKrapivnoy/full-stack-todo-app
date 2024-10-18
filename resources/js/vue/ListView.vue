<template>
    <div>
        <div v-for="(item, i) in items" :key="i">
            <list-item
                :item="item"
                class="item"
                @itemchanged="handleItemChanged"
            />
        </div>
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

<style scoped>
    .item {
        background-color: #e6e6e6;
        padding: 5px;
        margin-top: 5px;
    }
</style>
