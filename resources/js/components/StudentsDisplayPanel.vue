<template>
    <div>
        <b-form-input
            id="search-input"
            v-model="filter"
            class="mt-2 mb-2"
            placeholder="type to search"
        ></b-form-input>
        <b-table striped
                 hover
                 :sticky-header="true"
                 :items="students"
                 :filter="filter"
                 style="max-height: 70vh"
                 :per-page="perPage"
                 :current-page="currentPage"
        >

        </b-table>
        <div class="row justify-content-center">
            <b-pagination
                v-model="currentPage"
                :total-rows="rows"
                :per-page="perPage"
                aria-controls="my-table"
            ></b-pagination>
        </div>
    </div>
</template>

<script>
    export default {
        name: "StudentsDisplayPanel",
        props:['data'],
        mounted(){
            this.students=JSON.parse(this.data);
        },
        data:function () {
            return {
                filter:null,
                students:[],
                perPage: 20,
                currentPage: 1,
            }
        },
        computed: {
            rows() {
                return this.students.length
            }
        }
    }
</script>

<style scoped>

</style>
