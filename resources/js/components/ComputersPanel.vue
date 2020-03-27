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


        <h1 class="mb-2">Computer IPs</h1>
        <b-table striped
                 hover
                 :sticky-header="true"
                 :items="computerIps"
                 class="mb-2 mt-2"
        >
            <template v-slot:cell(actions)="row">
                <button class="btn btn-success" @click="showDialog(row.item)">Edit Computer IP</button>

            </template>

        </b-table>

        <div class="row justify-content-center" v-if="students.length!=0">
            <b-pagination
                v-model="currentPage"
                :total-rows="count"
                :per-page="perPage"
                aria-controls="my-table"
            ></b-pagination>
        </div>
        <!-- Count Changer Modal-->
        <b-modal
            id="modal-prevent-closing"
            ref="countChanger"
            title="Change Computers Count"
            @shown="resetModal"
            @ok="handleOk"
        >
            <form ref="form" @submit.stop.prevent="handleCountSubmit">
                <b-form-group
                    :state="computerIPState"
                    label="Computer IP Address"
                    label-for="ip-input"
                >
                    <b-form-input
                        id="ip-input"
                        v-model="count"
                        :state="computerIPState"
                      placeholder="xxx.xxx.xxx.xxx"
                        required
                    ></b-form-input>
                    <b-form-invalid-feedback :state="computerIPState">
                        Put correct IP Address
                    </b-form-invalid-feedback>
                    <b-form-valid-feedback :state="computerIPState">
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
            axios.get('/computer-ip/')
                .then(response => {
                    this.computerIps = response.data.ips;
                    this.count=response.data.count;
                    // console.log(response.data);
                }).catch(errors => {

            });
        },
        data: function () {
            return {
                computerIps: [],
                dismissSecs: 5,
                dismissCountDown: 0,
                message: "",
                alert: "danger",
                computerIp: null,
                modifiedIP: {
                    IP:'',
                    computerNumber:0,
                },
                perPage: 50,
                currentPage: 1,
                current: 1,
                count: 0,
            }
        },
        watch: {
            currentPage(newPage, oldPage) {
                this.computerIps = [];
                const self = this;
                const route = '/computer-ip?page=' + newPage;

                // if(this.phoneFilter.length>0)
                // data.append('phone',this.phoneFilter);
                axios.get(route)
                    .then(function (response) {
                        self.computerIps = response.data.ips;
                        self.count=response.data.count;
                    });

                this.$emit('input', newPage);
            }
        },
        computed: {
            computerIPState:function(){
                if (this.modifiedIP.IP.length == 0)
                    return null;
                else
                    this.validateIP(this.modifiedIP.IP);
            },

        },
        methods: {
            validateIP(IP) {
                let re = /^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/;
                return re.test(IP);
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

            showDialog(config) {
                switch (config.id) {
                    case 1:
                    case 8:
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
                bvModalEvt.preventDefault();
                // Trigger submit handler
                switch (this.config.id) {
                    case 1:
                    case 8:
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
