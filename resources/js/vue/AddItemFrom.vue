<template>
    <form @submit.prevent="addItem">
        <div class="addItem">
            <input type="text" v-model="item.name" />
            <button
                :class="[item.name ? 'active' : 'inactive', 'plus']"
                type="submit"
            >
                <font-awesome-icon :icon="['fas', 'plus-square']" />
            </button>
        </div>
        <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
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
                errorMessage: "",
            };
        },
        methods: {
            addItem() {
                this.errorMessage = "";

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
                        if (err.response && err.response.status === 409) {
                            this.errorMessage =
                                "Item with this name already exists.";
                        } else {
                            console.error("API request error:", err);
                        }
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

    button {
        background: none;
        border: none;
        padding: 0;
        margin: 0;
        cursor: pointer;
    }

    .plus {
        font-size: 20px;
    }

    .active {
        color: #489c56;
    }

    .inactive {
        color: #999;
        cursor: not-allowed;
    }

    .error {
        color: red;
        margin-left: 10px;
        font-size: 14px;
    }
</style>
