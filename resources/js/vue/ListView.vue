<template>
    <div>
        <div v-for="(item, i) in filteredItems" :key="i">
            <list-item
                :item="item"
                @itemchanged="handleItemChanged"
                class="bg-[#2F3137] text-white p-1.5 mt-1.5"
            />
        </div>
        <button
            @click="toggleShowCompleted"
            class="btn btn-secondary text-gray-400 mt-3"
        >
            {{ showCompleted ? "Hide Completed" : "Show Completed" }} -
            {{ completedCount }}
        </button>
    </div>
</template>

<script>
    import ListItem from "./ListItem.vue";

    export default {
        props: ["items"],
        data() {
            return {
                showCompleted: false,
            };
        },
        computed: {
            filteredItems() {
                return this.showCompleted
                    ? this.items
                    : this.items.filter(item => !item.completed);
            },
            completedCount() {
                return this.items.filter(item => item.completed).length;
            },
        },
        components: {
            ListItem,
        },
        methods: {
            handleItemChanged() {
                this.$emit("reloadlist");
            },
            toggleShowCompleted() {
                this.showCompleted = !this.showCompleted;
            },
        },
    };
</script>
