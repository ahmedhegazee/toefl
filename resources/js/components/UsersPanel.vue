<template>
    <div>
        <b-alert
            :show="dismissCountDown"
            dismissible
            fade
            :variant="alert"
            @dismiss-count-down="countDownChanged"
        >
            {{message}}
        </b-alert>


        <h1>Users</h1><br>
        <button class="btn btn-primary" @click="">Add New User</button>

        <b-table striped
                 hover
                 :items="users"
        >

            <template v-slot:cell(actions)="row">
                <button class="btn btn-primary" @click="">Edit Roles</button>
                <button class="btn btn-primary" @click="">Edit Info</button>

            </template>

        </b-table>


    </div>

</template>

<script>

    export default {
        mounted() {
            axios.get('/users')
                .then(response => {
                    this.users = response.data;
                    // console.log(response.data);
                }).catch(errors => {

            });
        },
        data: function () {
            return {
                users: [],
                dismissSecs: 5,
                dismissCountDown: 0,
                message: "",
                alert: "danger",

            }
        },
        methods: {

            countDownChanged(dismissCountDown) {
                this.dismissCountDown = dismissCountDown;
                if (this.dismissCountDown === 0) {
                    this.message = "";
                    this.alert = "danger";
                }
            },
            showAlert() {
                this.dismissCountDown = this.dismissSecs
            },

            showDialog(id,score){

            }


        }
    }
</script>
