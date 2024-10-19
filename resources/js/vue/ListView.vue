<template>
    <div>
        <div v-for="(item, i) in filteredItems" :key="i">
            <list-item
                :item="item"
                @itemchanged="handleItemChanged"
                :show-dates="!showSmall"
                class="bg-[#2F3137] text-white p-1.5 mt-1.5"
            />
        </div>
        <div v-if="filteredItems.length" class="flex justify-between">
            <button
                @click="toggleShowCompleted"
                class="btn btn-secondary text-gray-400 mt-3"
            >
                {{ showCompleted ? "Hide Completed" : "Show Completed" }} -
                {{ completedCount }}
            </button>
            <button
                @click="toggleShowSmallBig"
                class="btn btn-secondary text-gray-400 mt-3 ms-2"
            >
                {{ showSmall ? "Detailed View" : "Simple View" }}
            </button>
        </div>
    </div>
</template>

<script>
    import ListItem from "./ListItem.vue";

    export default {
        props: ["items"],
        data() {
            return {
                showCompleted: false,
                showSmall: false,
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
            toggleShowSmallBig() {
                this.showSmall = !this.showSmall;
            },
        },
    };
</script>
