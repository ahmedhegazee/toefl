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

        <div class="form-group row">
            <label for="reservation" class="col-md-4 col-form-label text-md-right">Select Reservation</label>
            <div class="col-md-6">
                <select @change="getStudents()" id="reservation" name="reservation" class="form-control"
                        v-model="reservation">
                    <option value="" disabled>Select Reservation</option>
                    <option v-for="res in reservations" :value="res.id">{{res.start}}</option>
                </select>
            </div>
        </div>


        <h1>Students</h1>
        <b-table striped
                 hover
                 :items="students"
        >
            <template v-slot:cell(actions)="row">
                <button class="btn btn-success" @click="showDialog(row.item.ID,row.item.Score)">Edit Marks</button>

            </template>

        </b-table>


    </div>

</template>

<script>

    export default {
        mounted() {
            axios.get('/reservations/')
                .then(response => {
                    this.reservations = response.data;
                    // console.log(response.data);
                }).catch(errors => {

            });
        },
        data: function () {
            return {
                reservations: [],
                students: [],
                reservation: '',
                dismissSecs: 5,
                dismissCountDown: 0,
                message: "",
                alert: "danger",

            }
        }, methods: {
            getStudents() {
                axios.get('/students/' + this.reservation + '/failed')
                    .then(response => {
                        this.students = response.data;
                    }).catch(errors => {
                });
            },
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
