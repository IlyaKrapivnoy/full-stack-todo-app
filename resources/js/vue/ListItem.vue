<template>
    <div class="item">
        <input
            type="checkbox"
            @change="updateCheck"
            :checked="item.completed"
        />
        <div class="flex flex-col">
            <span :class="[item.completed ? 'completed' : '', 'itemText']">{{
                item.name
            }}</span>
            <span>{{ item.created_at_formatted }}</span>
        </div>
        <button @click="removeItem" class="trashcan">
            <font-awesome-icon icon="trash" />
        </button>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        props: ["item"],
        methods: {
            updateCheck() {
                const updatedStatus = !this.item.completed;
                this.item.completed = updatedStatus;
                axios
                    .put(`/api/item/${this.item.id}`, {
                        item: { completed: updatedStatus },
                    })
                    .then(res => {
                        if (res.status === 200) {
                            this.$emit("itemchanged");
                        }
                    })
                    .catch(err => {
                        console.error("API request error:", err);
                    });
            },
            removeItem() {
                axios
                    .delete(`/api/item/${this.item.id}`)
                    .then(res => {
                        if (res.status === 200) {
                            this.$emit("itemchanged");
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
    .item {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
    }

    input {
        flex-shrink: 0;
    }

    .itemText {
        width: 100%;
        margin-left: 20px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .completed {
        text-decoration: line-through;
        color: #999;
    }

    .trashcan {
        background-color: #e6e6e6;
        border: none;
        color: #ff0000;
        outline: none;
        margin-left: 10px;
    }
</style>
