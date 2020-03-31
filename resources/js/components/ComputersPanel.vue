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
        <button class="btn btn-primary mb-2" @click="$refs.IPAddressAdderModal.show()">Add New Computer IP</button>

        <b-table striped
                 hover
                 :fields="fields"
                 :sticky-header="true"
                 :items="computerIps"
                 class="mb-2 mt-2"
        >
            <template v-slot:cell(actions)="row">
                <button class="btn btn-success" @click="showDialog(row.item)">Edit Computer IP</button>
                <button class="btn btn-danger mr-2 mb-2" @click="deleteIP(row.item)">Delete</button>

            </template>

        </b-table>

        <div class="row justify-content-center mt-2" v-if="computerIps.length!=0">
            <b-pagination
                v-model="currentPage"
                :total-rows="count"
                :per-page="perPage"
                aria-controls="my-table"
            ></b-pagination>
        </div>
        <!-- IP Changer Modal-->
        <b-modal
            id="modal-prevent-closing"
            ref="IPAddressChangerModal"
            title="Change IP Address"
            @ok="handleOk"
        >
            <form ref="form" @submit.stop.prevent="handleSubmit">
                <b-form-group
                    :state="computerIPState"
                    label="Computer IP Address"
                    label-for="ip-input"
                >
                    <b-form-input
                        id="ip-input"
                        v-model="modifiedIP.IP"
                        :state="computerIPState"
                        placeholder="xxx.xxx.xxx.xxx"
                        required

                    ></b-form-input>
                    <!--                        @blur="checkIPIsUnique"-->
                    <b-form-invalid-feedback :state="computerIPState">
                        {{ipStateMessage}}

                    </b-form-invalid-feedback>

                    <b-form-valid-feedback :state="computerIPState">
                        Looks Good.
                    </b-form-valid-feedback>
                </b-form-group>
            </form>
        </b-modal>
        <!--        IP Adder Modal-->
        <b-modal
            id="modal-prevent-closing"
            ref="IPAddressAdderModal"
            title="Add IP Address"
            @reset="resetModal"
            @ok="handleAdderModalOk"
        >
            <form ref="form" @submit.stop.prevent="handleAdderModalSubmit">
                <b-form-group
                    :state="computerIPState"
                    label="Computer IP Address"
                    label-for="ip-input"
                >
                    <b-form-input
                        id="ip-input"
                        v-model="modifiedIP.IP"
                        :state="computerIPState"
                        placeholder="xxx.xxx.xxx.xxx"
                        required

                    ></b-form-input>
                    <!--                        @blur="checkIPIsUnique"-->
                    <b-form-invalid-feedback :state="computerIPState">
                        {{ipStateMessage}}

                    </b-form-invalid-feedback>

                    <b-form-valid-feedback :state="computerIPState">
                        Looks Good.
                    </b-form-valid-feedback>
                </b-form-group>
                <b-form-group
                    :state="computerIPState"
                    label="Computer Number"
                    label-for="computer-number-input"
                >
                    <b-form-input
                        id="computer-number-input"
                        v-model="modifiedIP.computerNumber"
                        :type="'number'"
                        required
                        :state="computerNumberState"
                    ></b-form-input>
                    <b-form-invalid-feedback :state="computerNumberState">
                        This Computer has IP Address
                    </b-form-invalid-feedback>
                    <b-form-valid-feedback :state="computerNumberState">
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
            axios.get('/ip/')
                .then(response => {
                    this.computerIps = response.data.ips;
                    this.count = response.data.count;
                    // console.log(response.data);
                }).catch(errors => {

            });
        },
        data: function () {
            return {
                fields:['computer_number','computer_ip','actions'],
                computerIps: [],
                dismissSecs: 5,
                dismissCountDown: 0,
                message: "",
                alert: "danger",
                computerIp: null,
                modifiedIP: {
                    IP: '',
                    computerNumber: 0,
                },
                ipStateMessage: '',
                perPage: 30,
                currentPage: 1,
                current: 1,
                count: 0,
                uniqueCheck:{
                    IP:null,
                    computerNumber:null,
                },
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
                        self.count = response.data.count;
                    });

                this.$emit('input', newPage);
            }
        },
        computed: {
            computerIPState: function () {
                if (this.modifiedIP.IP.length == 0)
                    return null;
                else if (!this.validateIP(this.modifiedIP.IP)) {
                    this.ipStateMessage = ' Put correct IP Address';
                    return false;
                } else {
                    // console.log(this.checkIPIsUnique());
                    // if(this.computerIP['computer ip']!==this.modifiedIP.IP)
                    this.checkIPIsUnique();
                    if (!this.uniqueCheck.IP) {
                        this.ipStateMessage = 'This IP is token by another computer device';
                        return false;
                    }

                    return true;
                }

            },
            computerNumberState: function () {
                if (this.modifiedIP.computerNumber == 0)
                    return null;
                else {
                    this.checkComputerNumberIsUnique();
                    return  this.uniqueCheck.computerNumber;
                    // if(this.checkComputerNumberIsUnique())
                    // return true;
                    // else
                    //     return false;
                }
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
            checkIPIsUnique() {

                var data = new FormData();
                data.append('ip', this.modifiedIP.IP);
                 axios.post('/unique-ip', data).then(response => {
                    // console.log(response.data.unique);
                    this.uniqueCheck.IP= response.data.unique;
                }).catch(error => console.log(error));
            },
            checkComputerNumberIsUnique() {
                if(this.modifiedIP.computerNumber.length!=0){
                    var data = new FormData();
                    data.append('computer-number', this.modifiedIP.computerNumber);
                     axios.post('/unique-number', data).then(response => {
                       this.uniqueCheck.computerNumber=response.data.unique;
                    }).catch(error => console.log(error));

                }

            },
            showDialog(ip) {

                    this.computerIp=ip;
                    this.modifiedIP.IP = ip['computer_ip'];
                    this.modifiedIP.computerNumber = ip['computer_number'];

                this.$refs.IPAddressChangerModal.show();
            },

            resetModal() {
                this.modifiedIP.IP = '';
                this.modifiedIP.computerNumber = 0;
            },

            handleAdderModalOk(bvModalEvent) {
                bvModalEvent.preventDefault();
                this.handleAdderModalSubmit();

            },
            handleAdderModalSubmit() {
                if (!this.computerIPState)
                    return
                if (!this.computerNumberState)
                    return
                this.storeIP();
                //send the new computer
                this.$nextTick(() => {
                    this.$refs.IPAddressAdderModal.hide();
                });
            },
            storeIP() {

                var data = new FormData();
                data.append('ip', this.modifiedIP.IP);
                data.append('computer_number', this.modifiedIP.computerNumber);
                axios.post('/ip',data).then(response=>{
                   if(response.data.success){

                       let ip ={
                           computer_number:this.modifiedIP.computerNumber,
                           computer_ip:this.modifiedIP.IP,
                           actions:''
                       };
                       this.computerIps.push(ip);
                       this.showAlert("Successfully Added", "success");
                   }
                   else
                       this.showAlert("Something happened when adding . Please call Support");

                }).catch((error)=>console.log(erorr));
            },
            handleOk(bvModalEvt) {
                // Prevent modal from closing
                bvModalEvt.preventDefault();
                // Trigger submit handler
                this.handleSubmit();
            },
            handleSubmit(){
                if (!this.computerIPState)
                    return

                this.updateIP();
                //send the new computer
                this.$nextTick(() => {
                    this.$refs.IPAddressChangerModal.hide();
                });
            },
            updateIP() {
                axios.patch('/ip/' + this.computerIp.id, {
                    'ip': this.modifiedIP.IP,
                }).then(response => {
                    if (response.data.success) {
                        this.computerIp.computer_ip = this.modifiedIP.IP;
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
            deleteIP(ip) {

                    this.$bvModal.msgBoxConfirm('Are you sure about deleting this computer ' + ip.computer_ip, {
                        title: 'Delete IP',
                        size: 'sm',
                        buttonSize: 'sm',
                        okVariant: 'danger',
                        okTitle: 'YES',
                        cancelTitle: 'NO',
                        footerClass: 'p-2',
                        hideHeaderClose: false,
                        centered: true
                    })
                        .then(value => {
                            if (value == true) {
                                axios.delete('/ip/' + ip.id)
                                    .then(response => {
                                        var index = this.computerIps.indexOf(ip);
                                        if (index > -1) {
                                            this.computerIps.splice(index, 1);
                                        }
                                        this.showAlert("Successfully Deleted", 'success');
                                    }).catch(error => {
                                    console.log(error);
                                })
                            }
                        })
                        .catch(err => {
                            // An error occurred
                            console.log(err);
                        })


            },
        }


    }
</script>
