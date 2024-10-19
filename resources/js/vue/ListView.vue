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
        <div v-if="items.length" class="flex justify-between">
            <button
                @click="toggleShowCompleted"
                :disabled="!hasCompletedTasks && !showCompleted"
                class="btn btn-secondary text-gray-400 mt-3"
                :class="{
                    'opacity-50 cursor-not-allowed':
                        !hasCompletedTasks && !showCompleted,
                }"
            >
                {{ showCompleted ? "Hide Completed" : "Show Completed" }} -
                {{ completedCount }}
            </button>
            <button
                @click="toggleShowSmallBig"
                :disabled="!filteredItems.length"
                class="btn btn-secondary text-gray-400 mt-3 ms-2"
                :class="{
                    'opacity-50 cursor-not-allowed': !filteredItems.length,
                }"
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
            hasCompletedTasks() {
                return this.completedCount > 0;
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
