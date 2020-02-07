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
        <div class="row mt-2 mb-2 ">
            <button class="btn btn-primary" @click="showDialog(null,false)">Add Reservation</button>
        </div>

        <!--        <b-form-input-->
        <!--            id="search-input"-->
        <!--            v-model="filter"-->
        <!--            class="mt-2 mb-2"-->
        <!--            placeholder="type to search"-->
        <!--        ></b-form-input>-->
        <div class="form-group row mt-2 mb-2">
            <label for="reservation" class="col-md-4 col-form-label left">Filter reservations based on
                start date</label>
            <div class="col-md-6">
                <input id="reservation" v-model="startDataFilter" @change="search()" type="date" class="form-control ">
            </div>

        </div>
        <b-table striped
                 hover
                 :sticky-header="true"
                 :items="reservations"
                 :filter="filter"
                 style="max-height: 70vh"
                 :busy="reservations.length==0"
                 :per-page="perPage"
                 :current-page="current"
        >
            <template v-slot:table-busy>
                <div class="text-center text-danger my-2">
                    <b-spinner class="align-middle"></b-spinner>
                    <strong>Loading...</strong>
                </div>
            </template>
            <template v-slot:cell(actions)="row">
                <button class="btn btn-primary" @click="showGroups(row.item)">Show</button>
                <button class="btn btn-success" @click="showDialog(row.item,true)">Edit</button>

            </template>

        </b-table>
        <div class="row justify-content-center">
            <b-pagination
                v-model="currentPage"
                :total-rows="countOfReservations"
                :per-page="perPage"
                aria-controls="my-table"
            ></b-pagination>
        </div>
        <b-modal
            id="modal-prevent-closing"
            ref="resModal"
            title="EditReservation"
            @shown="resetModal"
            @ok="handleOk"
        >
            <form ref="form" @submit.stop.prevent="handleSubmit">
                <b-form-group
                    :state="dateState"
                    label="Start Date"
                    label-for="date-input"
                >
                    <b-form-input
                        id="date-input"
                        :type="'date'"
                        v-model="date"
                        :state="dateState"
                        :min="today"
                        required
                    ></b-form-input>
                    <b-form-invalid-feedback :state="dateState">
                        Put correct Date
                    </b-form-invalid-feedback>

                </b-form-group>
                <b-form-group
                    :state="countState"
                    label="Students Count"
                    label-for="name-input"
                >
                    <b-form-input
                        id="hours-input"
                        :type="'number'"
                        v-model="count"
                        :state="countState"
                        min="2"

                        required
                    ></b-form-input>
                    <b-form-invalid-feedback :state="countState">
                        Put correct count
                    </b-form-invalid-feedback>
                </b-form-group>
            </form>
        </b-modal>

    </div>
</template>

<script>

    export default {
        name: "ReservationsPanel",
        props: [
            'dataRoute'
        ],
        mounted() {
            // this.reservations = JSON.parse(this.res);
            this.getReservations();
            var today = new Date();
            this.today = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0') + '-' + String(today.getDate()).padStart(2, '0');

        },
        data: function () {
            return {
                reservations: [],
                dismissSecs: 5,
                dismissCountDown: 0,
                message: "",
                alert: "danger",
                reservation: null,
                today: '',
                date: '',
                edit: false,
                count: 0,
                currentDate: '',
                currentCount: 0,
                filter: null,
                perPage: 10,
                currentPage: 1,
                current: 1,
                countOfReservations: 0,
                startDataFilter: '',
            }
        },
        watch: {
            currentPage(newPage, oldPage) {
                this.reservations = [];
                var self = this;
                var route=this.dataRoute+'?page='+newPage;

                // if(this.phoneFilter.length>0)
                // data.append('phone',this.phoneFilter);
                if(this.startDataFilter.length>0)
                    route+='&&filter='+this.startDataFilter;
                axios.get(route)
                    .then(function (response) {
                        self.reservations = response.data.reservations;
                        // self.questions = ;
                        self.countOfReservations = response.data.count;
                    });

                this.$emit('input', newPage);
            }
        }, computed: {

            countState: function () {
                if (parseInt(this.count) == 0)
                    return null;
                    // else if(this.edit)
                //     return parseInt(this.count) >2&&parseInt(this.count)!=this.currentCount;
                else
                    return parseInt(this.count) > 2
            },
            dateState: function () {
                if (this.date.length == 0)
                    return null;
                    // else if(this.edit)
                //     return Date.parse(this.date)>=Date.parse(this.today)&&Date.parse(this.date)!=Date.parse(this.currentDate);
                else
                    return Date.parse(this.date) >= Date.parse(this.today);
            },
        },
        methods: {
            getReservations() {
                axios.get(this.dataRoute)
                    .then(response => {
                        this.reservations = response.data.reservations;
                        this.countOfReservations = response.data.count;
                    })
                    .catch(error => {
                        console.log(error)
                    });

            },
            countDownChanged(dismissCountDown) {
                this.dismissCountDown = dismissCountDown;
                if (this.dismissCountDown === 0) {
                    this.message = "";
                    this.alert = "danger";
                }
            },
            showAlert(message, alert = "danger") {
                this.message = message;
                this.alert = alert;
                this.dismissCountDown = this.dismissSecs
            },
            showGroups(res) {
                window.location.replace("/cpanel/res/" + res.id);
            },

            showDialog(res = null, edit = false) {
                this.edit = edit;
                this.reservation = res;
                if (edit) {
                    if (this.reservation['open/close'] == 'Closed') {
                        this.showAlert('Sorry you can\'t edit closed reservations');
                    } else {
                        this.currentDate = res.start;
                        this.currentCount = res['Max Students Count'];
                        this.date = this.currentDate;
                        this.count = this.currentCount;
                        this.$refs.resModal.show();
                    }

                } else {
                    this.date = this.today;
                    this.count = 2;
                    this.$refs.resModal.show();
                }


            },

            resetModal() {
            },
            handleOk(bvModalEvt) {
                // Prevent modal from closing
                bvModalEvt.preventDefault()
                // Trigger submit handler
                this.handleSubmit();

            },
            handleSubmit() {
                // Exit when the form isn't valid
                if (!this.countState) {
                    return
                }
                if (!this.dateState) {
                    return
                }
                // Push the name to submitted names
                if (this.edit)
                    this.sendChange();
                else
                    this.createReservation();
                // Hide the modal manually
                this.$nextTick(() => {
                    this.$refs.resModal.hide()
                })
            },


            sendChange() {
                axios.patch('/cpanel/res/' + this.reservation.id, {
                    'start': this.date,
                    'max_students': this.count,
                }).then(response => {
                    if (response.data.success) {
                        this.reservation['Max Students Count'] = this.count;
                        this.reservation.start = this.date;
                        this.showAlert("Successfully Updated", "success");
                    } else {
                        if (response.data.message !== undefined)
                            this.showAlert(response.data.message);
                        else
                            this.showAlert("Something happened when updating . Please call Support");
                    }
                })
                    .catch(function (error) {
                        console.log(error);
                        this.showAlert("Something happened when updating . Please call Support");
                        // console.log(error);
                    });

            },
            createReservation() {
                axios.post('/cpanel/res', {
                    'start': this.date,
                    'max_students': this.count,
                }).then(response => {
                    if (response.data.success) {
                        this.reservations = JSON.parse(response.data.res);
                        this.showAlert("Successfully Added", "success");
                    } else {
                        if (response.data.message !== undefined)
                            this.showAlert(response.data.message);
                        else
                            this.showAlert("Something happened when processing . Please call Support");
                    }
                })
                    .catch(function (error) {
                        console.log(error);
                        this.showAlert("Something happened when processing . Please call Support");
                        // console.log(error);
                    });

            },
            search() {
                this.reservations = [];
                if(this.startDataFilter.length>0){
                    axios.get(this.dataRoute+'?filter=' + this.startDataFilter).then(response => {
                        if (response.data.reservations.length == 0) {
                            this.showAlert('Sorry there is no reservations with this date');
                            setTimeout(null, 2000);
                            this.getReservations();
                        } else {
                            this.reservations = response.data.reservations;
                            this.count = response.data.count;
                        }
                    }).catch(error => {
                        console.log(error)
                    });
                }else{
                    this.currentPage=1;
                    this.getReservations();
                }

            },
        }
    }
</script>

<style scoped>

</style>
