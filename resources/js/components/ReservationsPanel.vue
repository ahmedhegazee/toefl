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
        <div class="btn btn-primary mt-2 mb-2" @click="showDialog(null,false)">Add Reservation</div>
        <b-form-input
            id="search-input"
            v-model="filter"
            class="mt-2 mb-2"
            placeholder="type to search"
        ></b-form-input>
        <b-table striped
                 hover
                 :sticky-header="true"
                 :items="reservations"
                 :filter="filter"
                 style="max-height: 70vh"
        >
            <template v-slot:cell(actions)="row">
                <button class="btn btn-primary" @click="showGroups(row.item)">Show</button>
                <button class="btn btn-success" @click="showDialog(row.item,true)">Edit</button>

            </template>

        </b-table>

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
            'res'
        ],
        mounted() {
            this.reservations = JSON.parse(this.res);
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
        }
    }
</script>

<style scoped>

</style>
