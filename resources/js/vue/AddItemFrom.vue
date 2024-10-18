<template>
    <div class="addItem">
        <input type="text" v-model="item.name" />
        <font-awesome-icon
            :icon="['fas', 'plus-square']"
            @click="addItem"
            :class="[item.name ? 'active' : 'inactive', 'plus']"
        />
    </div>
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
