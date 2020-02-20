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
        <b-alert
            :show="show"
            variant="danger"
        >
          {{msg}}
        </b-alert>
        <div class="form-group row">
            <label for="reservation" class="col-md-4 col-form-label text-md-right">Select Reservation</label>
            <div class="col-md-6">
                <select @change="getGroups()" id="reservation" name="reservation" class="form-control"
                        v-model="reservation">
                    <option value="" disabled>Select Reservation</option>
                    <option v-for="res in reservations" :value="res.id">{{res.start}}</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="reservation" class="col-md-4 col-form-label text-md-right">Select Group</label>
            <div class="col-md-6">
                <select @change="getStudents()" id="group" name="group" class="form-control" v-model="group">
                    <option disabled value="">Select Group</option>
                    <option v-for="group in groups" :value="group.id">{{group.name}}</option>
                </select>
            </div>
        </div>

        <div class="form-group row mb-0 justify-content-center">

            <button @click="chooseDates()" class="btn btn-primary mr-2">
               Print
            </button>
<!--            <button @click="print()" class="btn btn-primary mr-2">-->
<!--               Print-->
<!--            </button>-->
        </div>
        <h1>Students</h1>
        <b-table striped
                 hover
                 :sticky-header="true"
                 :items="students"
                 style="max-height: 70vh"
                 :per-page="perPage"
                 :current-page="currentPage"

        ></b-table>
        <div class="row justify-content-center" v-if="students.length!=0">
            <b-pagination
                v-model="currentPage"
                :total-rows="rows"
                :per-page="perPage"
                aria-controls="my-table"
            ></b-pagination>
        </div>

        <b-modal ref="my-modal" hide-footer title="Reservation Dates">
            <div class="d-block text-center">
                <h3>Please enter start and end dates of this reservation</h3>
            </div>
            <b-container fluid>
                <b-row class="my-1">
                    <b-col sm="3">
                        <label for="input-start">Start Date</label>
                    </b-col>
                    <b-col sm="9">
                        <b-form-input
                            id="input-start"
                            v-model="startDate"
                            type="date"
                            :state="startState"
                        ></b-form-input>
                        <b-form-invalid-feedback id="input-start-feedback">
                            Choose Correct Start Date
                        </b-form-invalid-feedback>
                    </b-col>
                </b-row>
                <b-row class="my-1">
                    <b-col sm="3">
                        <label for="input-end">End Date</label>
                    </b-col>
                    <b-col sm="9">
                        <b-form-input
                            id="input-end"
                            v-model="endDate"
                            type="date"
                            :state="endState"
                        ></b-form-input>
                        <b-form-invalid-feedback id="input-end-feedback">
                            Choose Correct End Date
                        </b-form-invalid-feedback>
                    </b-col>
                </b-row>
                <b-row class="my-1">
                    <b-button class="mt-3" variant="outline-success" block @click="hideModal">Done</b-button>
                </b-row>
            </b-container>
        </b-modal>
    </div>
</template>

<script>

    export default {
        name: "CertificatePanel",
        mounted() {
            axios.get('/reservations/closed')
                .then(response => {
                    this.reservations = response.data;
                    if(this.reservations.length==0){
                        this.msg='  Sorry there is no available reservations';
                        this.show=true;
                    }

                    // console.log(response.data);
                }).catch(errors => {

            });
        },
        data: function () {
            return {
                reservations: [],
                students: [],
                reservation: '',
                groups: [],
                group: '',
                dismissSecs: 5,
                dismissCountDown: 0,
                message: "",
                alert: "danger",
                startDate: '',
                endDate: '',
                perPage: 20,
                currentPage: 1,
                msg:'',
                show:false,
        }
        }, computed: {
            rows() {
                return this.students.length
            },
            startState() {
                    return this.startDate.length != 0;
            },
            endState() {
                var startDate = new Date(this.startDate);
                var endDate = new Date(this.endDate);
                    return  (startDate < endDate) && this.endDate.length != 0;
            }
        },
        methods: {
            clearMessage(){
                this.show=false;
                this.msg='';
            },
            getGroups() {
                this.clearMessage();
                axios.get(`/groups/${this.reservation}/examined`)
                    .then(response => {
                        this.groups = response.data;
                        if(this.groups.length==0)
                            this.showAlert("This reservation doesn't have examined groups");
                        // console.log(response.data);
                    }).catch(errors => {

                });

            },
            getStudents(){
                this.clearMessage();
                axios.get(`/students/${this.group}/certificates`)
                    .then(response => {
                        this.students = response.data;
                        if(this.students.length==0){
                            this.msg='Sorry there is no succeeded students in this group';
                            this.show=true;
                        }
                        // console.log(response.data);
                    }).catch(errors => {

                });
            },


            chooseDates() {
                if (this.students.length > 0)
                    this.showModal();
                else
                {
                    this.message="Please choose reservation";
                    this.showAlert();
                }
                // axios.get('/students/' + this.reservation + "/print")
                //     .then(response => {
                //         console.log(response.data);
                //     }).catch(errors => {
                //
                // });
            },
            print(){
                // if (this.endState && this.startState)
                    axios.post("/students/" + this.group + "/print",{
                        'start':this.startDate,
                        'end':this.endDate,
                    }).then(response=>{

                        document.write(response.data);
                    })
                    .catch(error=>console.log(error));
                // else
                // {
                //     this.message="Please choose correct dates";
                //     this.showAlert();
                // }
            },
            showModal() {
                this.$refs['my-modal'].show()
            },
            hideModal() {
                if (this.endState && this.startState){
                    this.$refs['my-modal'].hide();
                    this.print();
                }


            },
            countDownChanged(dismissCountDown) {
                this.dismissCountDown = dismissCountDown;
                if(this.dismissCountDown===0)
                {
                    this.message="";
                    this.alert="danger";
                }
            },
            showAlert() {
                this.dismissCountDown = this.dismissSecs
            },
        }
    }
</script>
