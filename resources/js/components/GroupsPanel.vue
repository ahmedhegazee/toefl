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
        <b-form-input
            id="search-input"
            v-model="filter"
            class="mt-2 mb-2"
            placeholder="type to search"
        ></b-form-input>
        <b-table striped
                 hover
                 :sticky-header="true"
                 :items="groups"
                 :filter="filter"
                 style="max-height: 70vh"
        >
            <template v-slot:cell(actions)="row">
                <button class="btn btn-primary" @click="showStudents(row.item)">Show Students</button>
                <button class="btn btn-success" @click="showDialog(row.item)">Edit</button>

            </template>

        </b-table>

        <b-modal
            id="modal-prevent-closing"
            ref="groupModal"
            title="EditReservation"
            @ok="handleOk"
        >
            <form ref="form" @submit.stop.prevent="handleSubmit">

                <b-form-group
                    :state="nameState"
                    label="Group Name"
                    label-for="name-input"
                >
                    <b-form-input
                        id="hours-input"
                        :type="'text'"
                        v-model="name"
                        :state="nameState"
                        required
                    ></b-form-input>
                    <b-form-invalid-feedback :state="nameState">
                        The name length must be between 5 and 200 characters.                    </b-form-invalid-feedback>
                </b-form-group>
            </form>
        </b-modal>

    </div>
</template>

<script>

    export default {
        name: "GroupsPanel",
        props: [
            'data','resId'
        ],
        mounted() {
            this.groups = JSON.parse(this.data);
                    },
        data: function () {
            return {
                groups: [],
                dismissSecs: 5,
                dismissCountDown: 0,
                message: "",
                alert: "danger",
                group: null,
                name:'',
                filter:null,
            }
        }, computed: {

            nameState: function () {
                if (this.name.length == 0)
                    return null;
               else
                    return this.name.length >=5&&this.name.length <=200&&this.name!=this.group.name;

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
            showStudents(group) {
                window.location.replace("/cpanel/res/"+this.resId+"/group/"+group.id);
            },

            showDialog(group) {
                    this.group=group;
                    this.name=group.name;

                this.$refs.groupModal.show();

            },


            handleOk(bvModalEvt) {
                // Prevent modal from closing
                bvModalEvt.preventDefault()
                // Trigger submit handler
                this.handleSubmit();

            },
            handleSubmit() {
                // Exit when the form isn't valid

                if (!this.nameState) {
                    return
                }
                // Push the name to submitted names

                this.sendChange();

                // Hide the modal manually
                this.$nextTick(() => {
                    this.$refs.groupModal.hide()
                })
            },


            sendChange() {
                axios.patch('/cpanel/res/'+this.resId+'/group/'+this.group.id, {
                    'name': this.name,
                }).then(response => {
                    if (response.data.success) {
                        this.group.name = this.name;
                        this.showAlert("Successfully Updated", "success");
                    } else {
                        if(response.data.message!==undefined )
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

        }
    }
</script>

<style scoped>

</style>
