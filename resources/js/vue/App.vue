<template>
    <div class="todoListContainer w-[350px] mx-auto rounded-xl">
        <div class="heading bg-[#2F3137] p-2.5">
            <h2 class="text-center text-3xl text-white font-black">
                Todo List
            </h2>
            <add-item-from @reloadlist="getList" />
        </div>
        <counter-view :items="items" />
        <list-view :items="items" @reloadlist="getList" />
    </div>
</template>

<script>
    import AddItemFrom from "./AddItemFrom.vue";
    import ListView from "./ListView.vue";
    import axios from "axios";
    import CounterView from "./CounterView.vue";

    export default {
        name: "App",
        components: {
            CounterView,
            AddItemFrom,
            ListView,
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
