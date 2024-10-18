<template>
    <form class="addItem" @submit.prevent="addItem">
        <input type="text" v-model="item.name" />
        <button
            :class="[item.name ? 'active' : 'inactive', 'plus']"
            type="submit"
        >
            <font-awesome-icon :icon="['fas', 'plus-square']" />
        </button>
    </form>
</template>

<script>
    import axios from "axios";

    export default {
        data() {
            return {
                item: {
                    name: "",
                },
            };
        },
        methods: {
            addItem() {
                if (this.item.name === "") {
                    return;
                }

                axios
                    .post("/api/item/store", {
                        item: this.item,
                    })
                    .then(response => {
                        if (response.status === 201) {
                            this.item.name = "";
                            this.$emit("reloadlist");
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
    .addItem {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    input {
        background-color: #f7f7f7;
        border: none;
        outline: none;
        padding: 5px;
        margin-right: 10px;
        width: 100%;
    }

    .plus {
        font-size: 20px;
    }

    .active {
        color: #489c56;
        cursor: pointer;
    }

    .inactive {
        color: #999;
    }
</style>
