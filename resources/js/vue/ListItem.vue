<template>
    <div
        @click="toggleCheck"
        class="flex justify-center items-center w-full rounded-lg border border-gray-600 px-4 cursor-pointer"
    >
        <div
            class="flex-shrink-0 custom-checkbox-container cursor-pointer relative"
            @click.stop
        >
            <input
                type="checkbox"
                @change="updateCheck"
                :checked="item.completed"
                class="absolute opacity-0 cursor-pointer h-full w-full"
            />
            <div
                :class="[
                    'custom-checkbox',
                    item.completed ? 'bg-[#85474B]' : 'bg-[#404348]',
                ]"
            ></div>
        </div>
        <div class="flex flex-col ml-5 w-full overflow-hidden">
            <span
                :class="[
                    item.completed ? 'line-through text-gray-500' : '',
                    'text-xl truncate',
                ]"
            >
                {{ item.name }}
            </span>
            <p class="text-gray-500 text-[12px]">
                Created: {{ item.created_at_formatted }}
            </p>
            <p
                class="text-gray-500 text-[12px]"
                v-if="item.updated_at_formatted"
            >
                Updated: {{ item.updated_at_formatted }}
            </p>
        </div>
        <button
            @click.stop="removeItem"
            class="bg-transparent border-none text-[#85474B] outline-none ml-2"
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
            toggleCheck() {
                this.updateCheck();
            },
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

<style scoped>
    .custom-checkbox-container {
        width: 15px;
        height: 15px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .custom-checkbox {
        width: 100%;
        height: 100%;
        border-radius: 3px;
    }
</style>
