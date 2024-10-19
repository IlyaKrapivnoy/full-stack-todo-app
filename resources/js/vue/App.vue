<template>
    <div class="todoListContainer w-[350px] mx-auto rounded-xl">
        <div class="heading bg-[#2F3137] p-2.5">
            <h2 class="text-center text-3xl text-white font-black">
                Todo List
            </h2>
            <add-item-from @reloadlist="getList" />
        </div>
        <list-view :items="items" @reloadlist="getList" />
    </div>
</template>

<script>
    import addItemFrom from "./AddItemFrom.vue";
    import listView from "./ListView.vue";
    import axios from "axios";

    export default {
        name: "App",
        components: {
            addItemFrom,
            listView,
        },
        data() {
            return {
                items: [],
            };
        },
        methods: {
            getList() {
                axios
                    .get("/api/items")
                    .then(response => {
                        this.items = response.data.sort(
                            (a, b) => a.completed - b.completed,
                        );
                    })
                    .catch(err => {
                        console.error("API request error:", err);
                    });
            },
        },
        created() {
            this.getList();
        },
    };
</script>
