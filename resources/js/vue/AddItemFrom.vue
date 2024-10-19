<template>
    <form @submit.prevent="addItem">
        <div class="flex justify-center items-center">
            <input
                type="text"
                v-model="item.name"
                class="bg-gray-100 border-none outline-none p-2 mr-3 w-full"
            />
            <button
                :class="[
                    item.name
                        ? 'text-green-600'
                        : 'text-gray-400 cursor-not-allowed',
                    'bg-transparent border-none p-0 m-0 text-xl',
                ]"
                type="submit"
                :disabled="!item.name"
            >
                <font-awesome-icon :icon="['fas', 'plus-square']" />
            </button>
        </div>
        <p v-if="errorMessage" class="text-red-600 ml-3 text-sm">
            {{ errorMessage }}
        </p>
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
