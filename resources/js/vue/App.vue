<template>
    <div class="todoListContainer">
        <div class="heading">
            <h2 id="title">Todo List</h2>
            <add-item-from />
        </div>

        <list-view :items="items" v-on:reloadlist="getlist()" />
    </div>
</template>

<script>
    import addItemFrom from "./AddItemFrom.vue";
    import listView from "./ListView.vue";

    export default {
        name: "App",
        components: {
            addItemFrom,
            listView,
        },
        data: function () {
            return {
                items: [],
            };
        },
        methods: {
            getList() {
                axios
                    .get("/api/items")
                    .then(response => {
                        this.items = response.data;
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

<style scoped>
    .todoListContainer {
        width: 350px;
        margin: auto;
    }

    .heading {
        background-color: #e6e6e6;
        padding: 10px;
    }

    #title {
        text-align: center;
    }
</style>
