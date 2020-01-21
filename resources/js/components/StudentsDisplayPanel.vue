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
        >

        </b-table>
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
                students:[]
            }
        }
    }
</script>

<style scoped>

</style>
