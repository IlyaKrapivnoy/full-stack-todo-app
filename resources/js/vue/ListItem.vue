<template>
    <div class="flex justify-center items-center w-full">
        <input
            type="checkbox"
            @change="updateCheck"
            :checked="item.completed"
            class="flex-shrink-0"
        />
        <div class="flex flex-col ml-5 w-full overflow-hidden">
            <span
                :class="[
                    item.completed ? 'line-through text-gray-500' : '',
                    'truncate',
                ]"
                >{{ item.name }}</span
            >
            <span>Created: {{ item.created_at_formatted }}</span>
            <span v-if="item.updated_at_formatted"
                >Updated: {{ item.updated_at_formatted }}</span
            >
        </div>
        <button
            @click="removeItem"
            class="bg-gray-200 border-none text-red-600 outline-none ml-2"
        >
            <font-awesome-icon icon="trash" />
        </button>
    </div>
</template>

<script>
    import axios from "axios";
    import _ from "lodash";

    export default {
        props: ["item"],
        methods: {
            updateCheck: _.debounce(function () {
                const updatedStatus = !this.item.completed;
                this.item.completed = updatedStatus;
                axios
                    .put(`/api/item/${this.item.id}`, {
                        item: { completed: updatedStatus },
                    })
                    .then(res => {
                        if (res.status === 200) {
                            this.$emit("itemchanged");
                        } else {
                            console.error("Update failed:", res);
                        }
                    })
                    .catch(err => {
                        console.error("API request error:", err);
                    });
            }, 300),
            removeItem() {
                axios
                    .delete(`/api/item/${this.item.id}`)
                    .then(res => {
                        if (res.status === 200) {
                            this.$emit("itemchanged");
                        } else {
                            console.error("Delete failed:", res);
                        }
                    })
                    .catch(err => {
                        console.error("API request error:", err);
                    });
            },
        },
    };
</script>
