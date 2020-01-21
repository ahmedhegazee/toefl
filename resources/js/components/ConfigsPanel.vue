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


        <h1 class="mb-2">Exam Configuration</h1>
        <b-table striped
                 hover
                 :sticky-header="true"
                 :items="examConfigs"
                 class="mb-2 mt-2"
        >
            <template v-slot:cell(actions)="row">
                <button class="btn btn-success" @click="showDialog(row.item)">Edit Config</button>

            </template>

        </b-table>
        <hr>
        <h1 class="mt-4 mb-2">Certificates Configuration</h1>
        <b-table striped
                 hover
                 :sticky-header="true"
                 :items="certificateConfigs"
                 class="mt-2 mb-2"
        >
            <template v-slot:cell(actions)="row">
                <button class="btn btn-success" @click="showDialog(row.item)">Edit Config</button>

            </template>

        </b-table>
        <!--        Name Changer Modal-->
        <b-modal
            id="modal-prevent-closing"
            ref="nameChanger"
            title="Change Position Name"
            @ok="handleOk"
        >
            <form ref="form" @submit.stop.prevent="handleNameSubmit">
                <h4>Position Name : {{pos_name}}</h4>
                <h4>Current Name : {{currentName}}</h4>
                <b-form-group
                    :state="nameState"
                    label="Name Changer"
                    label-for="name-input"
                >
                    <b-form-input
                        id="name-input"
                        v-model="name"
                        :state="nameState"
                        required
                    ></b-form-input>
                    <b-form-invalid-feedback :state="nameState">
                        The name length must be between 5 and 200 characters.
                    </b-form-invalid-feedback>
                    <b-form-valid-feedback :state="nameState">
                        Looks Good.
                    </b-form-valid-feedback>
                </b-form-group>
            </form>
        </b-modal>
        <!-- Time Changer Modal-->
        <b-modal
            id="modal-prevent-closing"
            ref="timeChanger"
            title="Change Exam Time"
            @shown="resetModal"
            @ok="handleOk"
        >
            <form ref="form" @submit.stop.prevent="handleTimeSubmit">
                <h4>Current Time = {{currentHours}} H :{{currentMinutes}} M</h4>
                <b-form-group
                    :state="timeState"
                    label="Hours"
                    label-for="name-input"
                >
                    <b-form-input
                        id="hours-input"
                        :type="'number'"
                        v-model="hours"
                        :state="timeState"
                        min="0"
                        max="4"
                        required
                    ></b-form-input>
                </b-form-group>
                <b-form-group
                    :state="timeState"
                    label="Minutes"
                    label-for="name-input"
                >
                    <b-form-input
                        id="minutes-input"
                        :type="'number'"
                        v-model="minutes"
                        :state="timeState"
                        min="0"
                        max="60"
                        required
                    ></b-form-input>
                    <b-form-invalid-feedback :state="timeState">
                        Put correct time
                    </b-form-invalid-feedback>
                </b-form-group>
            </form>
        </b-modal>
        <!-- Count Changer Modal-->
        <b-modal
            id="modal-prevent-closing"
            ref="countChanger"
            title="Change Computers Count"
            @shown="resetModal"
            @ok="handleOk"
        >
            <form ref="form" @submit.stop.prevent="handleCountSubmit">
                <h4>Current Computers Count = {{currentCount}}</h4>
                <b-form-group
                    :state="countState"
                    label="Computers Count"
                    label-for="name-input"
                >
                    <b-form-input
                        id="hours-input"
                        :type="'number'"
                        v-model="count"
                        :state="countState"
                        min="0"
                        max="200"
                        required
                    ></b-form-input>
                    <b-form-invalid-feedback :state="countState">
                        Put correct count
                    </b-form-invalid-feedback>
                    <b-form-valid-feedback :state="countState">
                        Looks Good.
                    </b-form-valid-feedback>
                </b-form-group>
            </form>
        </b-modal>

    </div>

</template>

<script>

    export default {
        mounted() {
            axios.get('/configs/')
                .then(response => {
                    this.examConfigs = response.data.exam;
                    this.certificateConfigs = response.data.certificate;
                    // console.log(response.data);
                }).catch(errors => {

            });
        },
        data: function () {
            return {
                examConfigs: [],
                certificateConfigs: [],
                dismissSecs: 5,
                dismissCountDown: 0,
                message: "",
                alert: "danger",
                currentName: '',
                name: '',
                pos_name: '',
                config: null,
                newValue: '',
                currentHours: 0,
                currentMinutes: 0,
                hours: 0,
                minutes: 0,
                currentCount: 0,
                count: 0,
            }
        }, computed: {
            nameState: function () {
                if (this.name.length == 0)
                    return null;
                else
                    return this.name.length > 5 && this.name.length < 200 && this.name != this.currentName;
            },
            countState: function () {
                if (parseInt(this.count) == 0)
                    return null;
                else
                    return parseInt(this.count)!=parseInt(this.currentCount);
            },
            timeState: function () {
                if (parseInt(this.hours) == 0 && parseInt(this.minutes) == 0)
                    return null;
                if (parseInt(this.minutes) == 60) {
                    this.minutes = 0;
                    this.hours++;
                }
                if (parseInt(this.hours) == 0)
                    return parseInt(this.minutes) > 30
                        && parseInt(this.minutes) != parseInt(this.currentMinutes);
                else
                    return parseInt(this.minutes) != parseInt(this.currentMinutes)
                        && parseInt(this.hours) != parseInt(this.currentHours);

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

            showDialog(config) {
                switch (config.id) {
                    case 1:
                        this.config = config;
                        this.currentCount = config.value;
                        this.count = config.value;
                        this.$refs.countChanger.show();
                        break;
                    case 2:
                    case 3:
                    case 4:
                        this.config = config;
                        var time = config.value;
                        this.currentHours = time.split(':')[0];
                        this.hours = time.split(':')[0];
                        this.currentMinutes = time.split(':')[1];
                        this.minutes = time.split(':')[1];
                        this.$refs.timeChanger.show();
                        break;
                    case 5:
                    case 6:
                    case 7:
                        this.config = config;
                        this.currentName = config.value;
                        this.name = this.currentName;
                        this.pos_name = config.name;
                        this.$refs.nameChanger.show();
                        break;

                }

            },

            resetModal() {
                // this.hours = 0;
                // this.minutes = 0;
                // this.count = 0;
            },
            handleOk(bvModalEvt) {
                // Prevent modal from closing
                bvModalEvt.preventDefault()
                // Trigger submit handler
                switch (this.config.id) {
                    case 1:
                        this.handleCountSubmit();
                        break;
                    case 2:
                    case 3:
                    case 4:
                        this.handleTimeSubmit();
                        break;
                    case 5:
                    case 6:
                    case 7:
                        this.handleNameSubmit();
                        break;

                }
            },
            handleCountSubmit() {
                // Exit when the form isn't valid
                if (!this.countState) {
                    return
                }
                // Push the name to submitted names
                this.newValue = this.count;
                this.sendChange();
                // Hide the modal manually
                this.$nextTick(() => {
                    this.$refs.countChanger.hide()
                })
            },
            handleNameSubmit() {
                // Exit when the form isn't valid
                if (!this.nameState) {
                    return
                }
                // Push the name to submitted names
                this.newValue = this.name;
                this.sendChange();
                // Hide the modal manually
                this.$nextTick(() => {
                    this.$refs.nameChanger.hide()
                })
            },
            handleTimeSubmit() {
                // Exit when the form isn't valid
                if (!this.timeState) {
                    return
                }
                // Push the name to submitted names
                this.newValue = this.hours + ':' + this.minutes;
                this.sendChange();
                // Hide the modal manually
                this.$nextTick(() => {
                    this.$refs.timeChanger.hide()
                })
            },

            sendChange() {
                axios.patch('/configs/'+this.config.id, {
                    'value': this.newValue,
                }).then(response => {
                    if (response.data.success) {
                        this.config.value = this.newValue;
                        this.showAlert("Successfully Updated", "success");
                    } else {
                        this.showAlert("Something happened when updating . Please call Support");
                    }
                })
                    .catch(function (error) {
                        console.log(error);
                        this.showAlert("Something happened when updating . Please call Support");
                        // console.log(error);
                    });

            },
        }


    }
</script>
