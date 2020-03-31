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
        <button class="btn btn-primary mb-2" @click="$refs.addNewUserModal.show()">Add New User</button>
        <!--Add New User Modal-->
        <b-modal
            id="modal-prevent-closing"
            ref="addNewUserModal"
            title="Add User Information"
            @shown="resetNewModal"
            @ok="handleOkForNewUserModal"
        >
            <form ref="form" @submit.stop.prevent="handleNewUserSubmit" autocomplete="off">
                <b-form-group
                    :state="nameState"
                    label="User Name"
                    label-for="name-input"
                >
                    <b-form-input
                        id="name-input"
                        autocomplete="off"
                        v-model="name"
                        :state="nameState"
                        required
                    ></b-form-input>
                    <b-form-invalid-feedback :state="nameState">
                        The name length must be between 5 and 200 characters.
                    </b-form-invalid-feedback>
                </b-form-group>
                <b-form-group

                    label="User Email"
                    label-for="email-input"
                >
                    <b-form-input
                        id="email-input"
                        :type="'email'"
                        v-model="email"
                        :state="emailState"
                        autocomplete="off"
                        required
                    ></b-form-input>
                    <b-form-invalid-feedback :state="emailState">
                        Write correct email please.
                    </b-form-invalid-feedback>
                    <div>
                        <b-form-invalid-feedback :state="isUniqueEmail">
                            Write another email please.This email is token
                        </b-form-invalid-feedback>
                    </div>

                </b-form-group>
                <b-form-group
                    :state="confirmEmailState"
                    label="Confirm Email"
                    label-for="email-input"
                >
                    <b-form-input
                        id="confirm-email-input"
                        :type="'email'"
                        autocomplete="false"
                        v-model="confirmEmail"
                        :state="confirmEmailState"
                        required
                    ></b-form-input>
                    <b-form-invalid-feedback :state="confirmEmailState">
                        Confirm your email correctly.
                    </b-form-invalid-feedback>
                </b-form-group>
                <b-form-group
                    :state="passwordState"
                    label="User Password"
                    label-for="password-input"
                >
                    <b-form-input
                        id="password-input"
                        :type="'password'"
                        :state="passwordState"
                        autocomplete="new-password"
                        v-model="password"
                        required
                    ></b-form-input>
                    <b-form-invalid-feedback :state="passwordState">
                        Write correct password more than 8 characters.
                    </b-form-invalid-feedback>
                </b-form-group>
                <b-form-group
                    :state="confirmPassState"
                    label="Confirm Password"
                    label-for="confirm-password-input"
                >
                    <b-form-input
                        id="confirm-password-input"
                        :type="'password'"
                        autocomplete="new-password"
                        v-model="confirmPassword"
                        :state="confirmPassState"
                        required
                    ></b-form-input>
                    <b-form-invalid-feedback :state="confirmPassState">
                        Confirm your password correctly.
                    </b-form-invalid-feedback>
                </b-form-group>
            </form>
        </b-modal>
        <b-table striped
                 :fields="fields"
                 hover
                 :sticky-header="true"
                 :items="users"
                 style="max-height: 70vh"
        >

            <template v-slot:cell(actions)="row">
                <button class="btn btn-primary mr-2 mb-2" @click="showEditRolesDialog(row.item)">Edit Roles</button>
                <button class="btn btn-primary mr-2 mb-2" @click="showEditInfoDialog(row.item)">Edit Info</button>
                <button class="btn btn-danger mr-2 mb-2" @click="deleteUser(row.item)">Delete</button>

            </template>

        </b-table>
        <!--Edit Info Modal-->
        <b-modal
            id="modal-prevent-closing"
            ref="infoChanger"
            title="Change User Information"
            @shown="resetModal"
            @ok="handleOk"
        >
            <form ref="form" @submit.stop.prevent="handleSubmit" autocomplete="off">
                <b-form-group
                    :state="nameState"
                    label="User Name"
                    label-for="name-input"
                >
                    <b-form-input
                        id="name-input"
                        autocomplete="off"
                        v-model="name"
                        :state="nameState"
                        required
                    ></b-form-input>
                    <b-form-invalid-feedback :state="nameState">
                        The name length must be between 5 and 200 characters.
                    </b-form-invalid-feedback>
                </b-form-group>
                <b-form-group

                    label="User Email"
                    label-for="email-input"
                >
                    <b-form-input
                        id="email-input"
                        :type="'email'"
                        v-model="email"
                        :state="emailState"
                        autocomplete="off"
                        required
                    ></b-form-input>
                    <b-form-invalid-feedback :state="emailState">
                        Write correct email please.
                    </b-form-invalid-feedback>
                    <div>
                        <b-form-invalid-feedback :state="isUniqueEmail">
                            Write another email please.This email is token
                        </b-form-invalid-feedback>
                    </div>

                </b-form-group>
                <b-form-group
                    :state="confirmEmailState"
                    label="Confirm Email"
                    label-for="email-input"
                >
                    <b-form-input
                        id="confirm-email-input"
                        :type="'email'"
                        autocomplete="false"
                        v-model="confirmEmail"
                        :state="confirmEmailState"
                        required
                    ></b-form-input>
                    <b-form-invalid-feedback :state="confirmEmailState">
                        Confirm your email correctly.
                    </b-form-invalid-feedback>

                </b-form-group>
                <b-form-group
                    :state="passwordState"
                    label="User Password"
                    label-for="password-input"
                >
                    <b-form-input
                        id="password-input"
                        :type="'password'"
                        :state="passwordState"
                        autocomplete="new-password"
                        v-model="password"
                        required
                    ></b-form-input>
                    <b-form-invalid-feedback :state="passwordState">
                        Write correct password more than 8 characters.
                    </b-form-invalid-feedback>
                </b-form-group>
                <b-form-group
                    :state="confirmPassState"
                    label="Confirm Password"
                    label-for="confirm-password-input"
                >
                    <b-form-input
                        id="confirm-password-input"
                        :type="'password'"
                        autocomplete="new-password"
                        v-model="confirmPassword"
                        :state="confirmPassState"
                        required
                    ></b-form-input>
                    <b-form-invalid-feedback :state="confirmPassState">
                        Confirm your password correctly.
                    </b-form-invalid-feedback>
                </b-form-group>
            </form>
        </b-modal>
        <!--        Edit Roles Modal-->
        <b-modal
            id="modal-prevent-closing"
            ref="rolesChanger"
            title="Change User Roles"
            @ok="handleRolesDialogOk"
        >
            <form ref="form" @submit.stop.prevent="">
                <b-form-group label="Select Roles">
                    <b-form-checkbox-group
                        v-model="selected"
                        :options="roles"
                        name="roles"
                        stacked
                    ></b-form-checkbox-group>
                </b-form-group>

            </form>
        </b-modal>
    </div>

</template>

<script>

    export default {
        mounted() {
            axios.get('/users')
                .then(response => {
                    this.users = response.data.users;
                    this.roles = response.data.roles;
                    // console.log(response.data);
                }).catch(errors => {

            });
        },
        data: function () {
            return {
                fields: ["id", "name", "email", "roles", "actions"],
                selected: [],
                roles: [],
                users: [],
                dismissSecs: 5,
                dismissCountDown: 0,
                message: "",
                alert: "danger",
                user: '',
                name: '',
                email: '',
                confirmEmail: '',
                password: '',
                confirmPassword: '',
                confirmEmailState: null,
                confirmPassState: null,
                isUniqueEmail: null,
            }
        }, computed: {
            nameState: function () {
                if (this.name.length == 0)
                    return null;
                else {
                    if (this.user != null)
                        return this.name.length >= 5 && this.name.length < 200 && this.validateName(this.name) && this.name != this.user.name;
                    else
                        return this.name.length >= 5 && this.name.length < 200 && this.validateName(this.name);

                }
            },

            passwordState: function () {
                if (this.password.length == 0)
                    return null;
                else
                    return this.password.length >= 8;
            },
            emailState: function () {
                if (this.email.length == 0)
                    return null;
                else
                    return this.validateEmail(this.email);
            }
        },
        methods: {
            validateName(name) {
                let re = /^[A-Za-z ]+$/;
                return re.test(name);
            },
            validateEmail(email) {
                var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
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
            showEditInfoDialog(user) {
                if (user.id != 1) {
                    this.user = user;
                    this.$refs.infoChanger.show();
                } else {
                    this.showAlert("You can't edit this user")
                }

            },
            showEditRolesDialog(user) {
                if (user.id != 1) {
                    this.user = user;
                    this.selected = user.selectedRoles;
                    this.$refs.rolesChanger.show();
                } else {
                    this.showAlert("You can't edit this user")
                }
            },

            resetModal() {
                this.name = '';
                this.password = '';
                this.confirmPassword = '';
                this.email = '';
                this.confirmEmail = '';
                this.confirmPassState = null;
                this.confirmEmailState = null;
                this.isUniqueEmail = null;
            },
            resetNewModal() {
                this.resetModal();
                this.user = null;
            },
            handleOk(bvModalEvt) {
                // Prevent modal from closing
                bvModalEvt.preventDefault()
                // Trigger submit handler
                if (this.emailState)
                    this.checkIsUniqueEmail();
                this.handleSubmit();


            },
            handleOkForNewUserModal(bvModalEvt) {
                // Prevent modal from closing
                bvModalEvt.preventDefault()
                // Trigger submit handler
                this.checkIsUniqueEmail();

                this.handleNewUserSubmit();


            },
            handleRolesDialogOk(bvModalEvt) {
                // Prevent modal from closing
                bvModalEvt.preventDefault();
                // Trigger submit handler
                this.sendRolesUpdate();
                this.$nextTick(() => {
                    this.$refs.rolesChanger.hide()
                })

            },

            handleSubmit() {
                // Exit when the form isn't valid
                if (this.name.length > 0) {
                    if (!this.nameState)
                        return
                } else if (this.email.length > 0)
                    if (!this.emailState) {
                        if (this.email != this.confirmEmail) {
                            this.confirmEmailState = false;
                            return;
                            if (!this.isUniqueEmail)
                                return;
                        }
                    } else if (this.password.length > 0)
                        if (!this.passwordState)
                            if (this.password != this.confirmPassword) {
                                this.confirmPassState = false;
                                return;
                            }

                this.sendChange();
                // Hide the modal manually
                this.$nextTick(() => {
                    this.$refs.infoChanger.hide()
                })
            },
            handleNewUserSubmit() {
                // Exit when the form isn't valid
                if (
                    !this.nameState
                    && !this.passwordState
                    && !this.emailState
                    && !this.isUniqueEmail
                ) {

                    return
                }

                if (this.password != this.confirmPassword) {
                    this.confirmPassState = false;
                    return
                }
                if (this.email != this.confirmEmail) {
                    this.confirmEmailState = false;
                    return
                }
                this.addNewUser();
                // Hide the modal manually
                this.$nextTick(() => {
                    this.$refs.addNewUserModal.hide()
                })

            },

            sendChange() {
                let counter = 0;
                var data = new FormData();
                if (this.name.length > 0) {
                    data.append('name', this.name);
                    counter++;
                }
                if (this.password.length > 0) {
                    data.append('password', this.password);
                    counter++;
                }
                if (this.email.length > 0) {
                    data.append('email', this.email);
                    counter++;
                }
                if (counter > 0) {
                    axios.patch('/users/' + this.user.id, data).then(response => {
                        if (response.data.success) {
                            this.successAction();
                        } else {
                            if(response.data.message!=undefined)
                                this.showAlert(response.data.message);
                            this.showAlert("Something happened when updating . Please call Support");
                        }
                    })
                        .catch(function (error) {
                            console.log(error);
                            this.showAlert("Something happened when updating . Please call Support");
                            // console.log(error);
                        });
                }else{
                    this.showAlert("You didn't change anything.");
                }


            },
            addNewUser() {
                axios.post('/users', {
                    'name': this.name,
                    'email': this.email,
                    'password': this.password,
                }).then(response => {
                    if (response.data.success) {
                        this.showAlert("Successfully Updated", "success");
                        this.users.push(response.data.user);
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
            successAction() {
                if (this.name.length > 0)
                    this.user.name = this.name;
                if (this.email.length > 0)
                    this.user.email = this.email;
                this.showAlert("Successfully Updated", "success");

            },
            getUserRoles() {
                var data = '';
                for (var i = 0; i < this.selected.length; i++) {
                    var role = this.selected[i] - 1;
                    // console.log('index ' + role);
                    // console.log('role ' + this.roles[role]['text']);
                    data += this.roles[role]['text'] + ' ,';
                }
                return data;
            },
            sendRolesUpdate() {
                axios.patch('/roles/' + this.user.id, {
                    'roles': this.selected,
                }).then(response => {
                    if (response.data.success) {
                        this.user.roles = this.getUserRoles();
                        this.user.selectedRoles = this.selected;
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
            checkIsUniqueEmail() {
                axios.post('/users/unique-email', {
                    'email': this.email,
                })
                    .then(response => {
                        this.isUniqueEmail = response.data.check;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            deleteUser(user) {
                if (user.roles.indexOf('Super Admin') == -1 && user.id != 1) {
                    this.$bvModal.msgBoxConfirm('Are you sure about deleting this user ' + user.name, {
                        title: 'Delete User',
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
                                axios.delete('/users/' + user.id)
                                    .then(response => {
                                       if(response.data.success){
                                           var index = this.users.indexOf(user);
                                           if (index > -1) {
                                               this.users.splice(index, 1);
                                           }
                                           this.showAlert("Successfully Deleted", 'success');
                                       }else{
                                           this.showAlert(response.data.message)
                                       }
                                    }).catch(error => {
                                    console.log(error);
                                })
                            }
                        })
                        .catch(err => {
                            // An error occurred
                            console.log(err);
                        })
                } else
                    this.showAlert("You can't delete super admin");

            },

        }
    }
</script>
