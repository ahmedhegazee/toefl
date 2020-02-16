<template>
    <div class="mt-3">

        <b-alert
            :show="dismissCountDown"
            dismissible
            fade
            :variant="alert"
            @dismiss-count-down="countDownChanged"
        >
            {{message}}
        </b-alert>

        <h1>Students</h1>
        <div class="form-group row mt-2 mb-2">
            <label for="reservation" class="col-md-4 col-form-label left">Filter students based on
                Reservation</label>
            <div class="col-md-6">
                <input id="reservation" v-model="reservationFilter" @change="search()" type="date" class="form-control ">
            </div>

        </div>
        <div class="form-group row mt-2 mb-2">
            <div class="col-md-10">
                <input id="search"  v-model="phoneFilter" type="search" class="form-control "
                       placeholder="write student phone number ">
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary" @click="searchByPhone()">Search</button>
            </div>
        </div>


        <b-table striped
                 :sticky-header="true"
                 :fields="fields"
                 hover
                 :items="students"
                 style="max-height: 70vh"
                 :busy="busyState"
                 :per-page="perPage"
                 :current-page="current"
                 v-if="showTable"
        >
            <template v-slot:table-busy>
                <div class="text-center text-danger my-2">
                    <b-spinner class="align-middle"></b-spinner>
                    <strong>Loading...</strong>
                </div>
            </template>
            <template v-slot:cell(actions)="row">
                <button v-if="row.item.verified!='Verified'" class="btn btn-primary mr-1 mb-1"
                        @click="verifyStudent(row.item)">Verify
                </button>
                <button class="btn btn-primary mr-1 mb-1" @click="showEditInfoDialog(row.item)">Edit Info</button>
                <button class="btn btn-primary mr-1 mb-1" @click="showEditImagesDialog(row.item)">Change Images</button>
                <button v-if="!row.item.failed" class="btn btn-primary mr-1 mb-1"
                        @click="showReservationsDialog(row.item)">New Res
                </button>
                <button v-if="row.item.has_certificates" class="btn btn-primary mr-1 mb-1"
                        @click="showPrintDialog(row.item)">Print
                </button>

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
                    :state="englishNameState"
                    label="English Name"
                    label-for="english-name-input"
                >
                    <b-form-input
                        id="english-name-input"
                        autocomplete="off"
                        v-model="englishName"
                        :state="englishNameState"
                        required
                    ></b-form-input>
                    <b-form-invalid-feedback :state="englishNameState">
                        The english name length must be between 5 and 200 characters.
                    </b-form-invalid-feedback>
                </b-form-group>
                <b-form-group
                    :state="englishNameState"
                    label="Arabic Name"
                    label-for="arabic-name-input"
                >
                    <b-form-input
                        id="arabic-name-input"
                        autocomplete="off"
                        v-model="arabicName"
                        :state="arabicNameState"
                        required
                    ></b-form-input>
                    <b-form-invalid-feedback :state="arabicNameState">
                        The arabic name length must be between 5 and 200 arabic characters.
                    </b-form-invalid-feedback>
                </b-form-group>
                <b-form-group

                    label="Student Email"
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
                    :state="phoneState"
                    label="User Phone"
                    label-for="phone-input"
                >
                    <b-form-input
                        id="phone-input"
                        :type="'tel'"
                        :state="phoneState"
                        v-model="phone"
                        required
                    ></b-form-input>
                    <b-form-invalid-feedback :state="phoneState">
                        Write correct phone number.
                    </b-form-invalid-feedback>
                    <div>
                        <b-form-invalid-feedback :state="isUniquePhone">
                            Write another phone number please.This phone number is token
                        </b-form-invalid-feedback>
                    </div>
                </b-form-group>
                <b-form-group
                    :state="confirmPhoneState"
                    label="Confirm Phone"
                    label-for="confirm-phone-input"
                >
                    <b-form-input
                        id="confirm-phone-input"
                        :type="'tel'"
                        v-model="confirmPhone"
                        :state="confirmPhoneState"
                        required
                    ></b-form-input>
                    <b-form-invalid-feedback :state="confirmPhoneState">
                        Confirm your phone correctly.
                    </b-form-invalid-feedback>
                </b-form-group>
                <b-form-group
                    :state="requiredScoreState"
                    label="Required Score"
                    label-for="required-score-input"
                >
                    <b-form-input
                        id="required-score-input"
                        :type="'number'"
                        min="300"
                        max="700"
                        v-model="requiredScore"
                        :state="requiredScoreState"
                        required
                    ></b-form-input>
                    <b-form-invalid-feedback :state="requiredScoreState">
                        Write correct Score.
                    </b-form-invalid-feedback>
                </b-form-group>
                <b-form-select v-model="studyingDegree" class="mb-2" :options="studyingDegrees"></b-form-select>
                <!--                <b-form-select v-model="groupType" :options="groupTypes"></b-form-select>-->

            </form>
        </b-modal>
        <!--      Move to new reservation-->
        <b-modal
            id="modal-prevent-closing"
            ref="resChanger"
            title="Change Student Reservation"
            @shown="resetModalForRes"
            @ok="handleResChangerOk"
        >
            <form ref="form" @submit.stop.prevent="handleResSubmit" autocomplete="off">
                <b-form-select v-model="reservation" class="mb-2" :options="reservations"></b-form-select>
                <b-form-select v-model="groupType" :options="groupTypes"></b-form-select>
            </form>
        </b-modal>

        <!--        Change Student's Images-->
        <b-modal
            id="modal-prevent-closing"
            ref="imagesChanger"
            title="Change Student's Images"
            @shown="resetImagesChangerModal"
            @ok="handleImagesChangerOk"
        >
            <form ref="form" @submit.stop.prevent="handleImagesSubmit" autocomplete="off" enctype="multipart/form-data">


                <b-form-group label="Personal Image" label-for="personalImage" label-cols-sm="2" label-size="sm">
                    <b-form-file
                        id="personalImage"
                        v-model="images.personalImage"
                        placeholder="Choose a personal image or drop it here..."
                        drop-placeholder="Drop personal image here..."
                        class="mb-2"
                        accept="image/*"
                    ></b-form-file>
                </b-form-group>
                <b-form-group label="National ID Image" label-for="nidImage" label-cols-sm="2" label-size="sm">
                    <b-form-file
                        id="nidImage"
                        v-model="images.nidImage"
                        placeholder="Choose a national ID image or drop it here..."
                        drop-placeholder="Drop national ID image here..."
                        class="mb-2"
                        accept="image/*"
                    ></b-form-file>
                </b-form-group>


                <b-form-group label="Certificate Image" label-for="certificateImage" label-cols-sm="2" label-size="sm">
                    <b-form-file
                        id="certificateImage"
                        v-model="images.certificateImage"
                        placeholder="Choose a certificate image or drop it here..."
                        drop-placeholder="Drop certificate image here..."
                        class="mb-2"
                        accept="image/*"
                    ></b-form-file>
                </b-form-group>


                <b-form-group label="Message Image" label-for="messageImage" label-cols-sm="2" label-size="sm">
                    <b-form-file
                        id="messageImage"
                        v-model="images.messageImage"
                        placeholder="Choose a message image or drop it here..."
                        drop-placeholder="Drop message image here..."
                        class="mb-2"
                        accept="image/*"
                    ></b-form-file>
                </b-form-group>


            </form>
        </b-modal>
<!--   Print certificates     -->
        <b-modal
            id="modal-prevent-closing"
            ref="printCertificateModal"
            title="Print Student Certificate"
            @shown="certificate=null"
            @ok="handleCertificateOk"
        >
            <form ref="form" @submit.stop.prevent="handleCertificateSubmit" autocomplete="off">
                <b-form-radio-group
                    id="radio-group-1"
                    v-model="certificate"
                    :options="certificates"
                    name="certificate"
                ></b-form-radio-group>
            </form>
        </b-modal>
    </div>

</template>

<script>

    export default {
        mounted() {
            this.busyState=true;
            var self=this;
            setTimeout(function(){
                self.getStudents();
                self.getAvailableReservations();
            },2000);

            setTimeout(function(){
                if(self.students.length==0){
                    self.busyState=false;
                    self.showTable=false;
                    self.showAlert('No student is found','success');
                }
                self.busyState=false;
            },3000);

        },
        props: ['dataRoute'],
        data: function () {

            return {
                fields: ["id", "Arabic Name", "English Name", "Reservation", "phone", "email", "Studying Degree", "Required Score", "verified", "actions"],
                reservation: null,
                groupType: null,
                groupTypes: [],
                reservations: [],
                students: [],
                dismissSecs: 5,
                dismissCountDown: 0,
                message: "",
                alert: "danger",
                student: '',
                englishName: '',
                arabicName: '',
                email: '',
                confirmEmail: '',
                phone: '',
                confirmPhone: '',
                requiredScore: 0,
                studyingDegree: null,
                studyingDegrees: [],
                confirmEmailState: null,
                confirmPhoneState: null,
                isUniqueEmail: null,
                isUniquePhone: null,
                images: {
                    personalImage: null,
                    nidImage: null,
                    certificateImage: null,
                    messageImage: null
                },
                perPage: 50,
                currentPage: 1,
                current: 1,
                count: 0,
                reservationFilter: '',
                phoneFilter: '',
                busyState:false,
                showTable:true,
                certificates:[],
                certificate:null,
            }
        },
        watch: {
            currentPage(newPage, oldPage) {
                this.students = [];
                var self = this;
                var route=this.dataRoute+'?page='+newPage;

                // if(this.phoneFilter.length>0)
                // data.append('phone',this.phoneFilter);
                if(this.reservationFilter.length>0)
                    route+='&&filter='+this.reservationFilter;
                axios.get(route)
                    .then(function (response) {
                        self.students = response.data.students;
                        // self.questions = ;
                        self.count = response.data.count;
                    });

                this.$emit('input', newPage);
            }
        },
        computed: {
            englishNameState: function () {
                if (this.englishName.length == 0)
                    return null;
                else {
                    if (this.student != null)
                        return this.englishName.length >= 5 && this.englishName.length < 200 && this.validateName(this.englishName) && this.englishName != this.student['English Name'];
                    else
                        return this.englishName.length >= 5 && this.englishName.length < 200 && this.validateName(this.englishName);

                }
            },
            arabicNameState: function () {
                if (this.arabicName.length == 0)
                    return null;
                else {
                    if (this.student != null)
                        return this.arabicName.length >= 5 && this.arabicName.length < 200 && this.validateArabicName(this.arabicName) && this.arabicName != this.student['Arabic Name'];
                    else
                        return this.arabicName.length >= 5 && this.arabicName.length < 200 && this.validateArabicName(this.arabicName);
                }
            },

            phoneState: function () {
                if (this.phone.length == 0)
                    return null;
                else {
                    return this.phone.length == 11 && this.validatePhone(this.phone);
                }

            },
            emailState: function () {
                if (this.email.length == 0)
                    return null;
                else
                    return this.validateEmail(this.email);
            },
            requiredScoreState: function () {
                if (parseInt(this.requiredScore) == 0)
                    return null;
                else
                    return parseInt(this.requiredScore) >= 300 && parseInt(this.requiredScore) < 700 && parseInt(this.requiredScore) != parseInt(this.student['Required Score']);
            },
        },
        methods: {
            getStudents() {
                axios.get('/student')
                    .then(response => {
                        this.students = response.data.students;
                        // self.questions = ;
                        this.count = response.data.count;
                        // console.log(response.data);
                    }).catch(errors => {

                });
            },
            validateEmail(email) {
                var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            },
            validateName(name) {
                var re = /^[A-Za-z ]+$/;
                return re.test(name);
            },
            validateArabicName(name) {
                var re = /^[\u0621-\u064A0-9 ]+$/;
                return re.test(name);
            },
            validatePhone(phone) {
                var re = /^(010|011|012|015){1}[0-9]{8}$/;
                return re.test(phone);
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
            showEditInfoDialog(student) {
                this.student = student;
                this.$refs.infoChanger.show();
            },

            showEditImagesDialog(student) {
                this.student = student;
                this.$refs.imagesChanger.show();
            },

            showReservationsDialog(student) {
                this.getAvailableReservations();
                var self=this;
                setTimeout(function () {
                    if (self.reservations.length == 1) {
                        self.showAlert('Sorry there is no available reservations')
                    } else {
                        self.student = student;
                        self.$refs.resChanger.show();
                    }
                }, 3000);


            },

            verifyStudent(student) {
                window.location.replace('/student/' + student.id);
            },

            resetModal() {
                this.englishName = '';
                this.arabicName = '';
                this.phone = '';
                this.confirmPhone = '';
                this.email = '';
                this.confirmEmail = '';
                this.confirmPhoneState = null;
                this.confirmEmailState = null;
                this.isUniqueEmail = null;
                this.isUniquePhone = null;
                this.studyingDegree = null;
                // this.groupType = null;
                this.requiredScore = 0;
            },
            resetNewModal() {
                this.resetModal();
                this.student = null;
            },
            resetModalForRes() {
                this.reservation = null;
                this.groupType = null;
            },
            resetImagesChangerModal() {
                // this.student=null;
                this.images.certificateImage = null;
                this.images.nidImage = null;
                this.images.personalImage = null;
                this.images.messageImage = null;
            },
            handleOk(bvModalEvt) {
                // Prevent modal from closing
                bvModalEvt.preventDefault()
                // Trigger submit handler
                if (this.emailState)
                    this.checkIsUniqueEmail();
                if (this.phoneState)
                    this.checkIsUniquePhone();
                this.handleSubmit();


            },
            handleResChangerOk(bvModalEvt) {
                // Prevent modal from closing
                bvModalEvt.preventDefault();

                this.handleResSubmit();

            },
            handleResSubmit() {
                if (!this.reservation)
                    return;
                if (!this.groupType)
                    return;
                this.sendResUpdate();

                this.$nextTick(() => {
                    this.$refs.resChanger.hide()
                })
            },
            handleImagesChangerOk(bvModalEvt) {
                // Prevent modal from closing
                bvModalEvt.preventDefault();

                this.handleImagesSubmit();

            },
            handleImagesSubmit() {

                this.sendImagesUpdate();

                this.$nextTick(() => {
                    this.$refs.imagesChanger.hide()
                })
            },
            // handleOkForNewUserModal(bvModalEvt) {
            //     // Prevent modal from closing
            //     bvModalEvt.preventDefault()
            //     // Trigger submit handler
            //     this.checkIsUniqueEmail();
            //
            //     this.handleNewUserSubmit();
            //
            //
            // },


            handleSubmit() {
                // Exit when the form isn't valid
                if (this.arabicName.length > 0) {
                    if (!this.arabicNameState)
                        return
                } else if (this.englishName.length > 0) {
                    if (!this.englishNameState)
                        return
                } else if (this.email.length > 0)
                    if (!this.emailState) {
                        if (this.email != this.confirmEmail) {
                            this.confirmEmailState = false;
                            return;
                            if (!this.isUniqueEmail)
                                return;
                        }
                    } else if (this.phone.length > 0)
                        if (!this.phoneState)
                            if (this.phone != this.confirmPhone) {
                                this.confirmPhoneState = false;
                                return;
                                if (!this.isUniquePhone)
                                    return;
                            } else if (!this.requiredScoreState)
                                return;
                this.sendChange();
                // Hide the modal manually
                this.$nextTick(() => {
                    this.$refs.infoChanger.hide()
                })
            },

            // handleNewUserSubmit() {
            //     // Exit when the form isn't valid
            //     if (
            //         !this.englishNameState
            //         && !this.passwordState
            //         && !this.emailState
            //         && !this.isUniqueEmail
            //     ) {
            //
            //         return
            //     }
            //
            //     if (this.password != this.confirmPhone) {
            //         this.confirmPhoneState = false;
            //         return
            //     }
            //     if (this.email != this.confirmEmail) {
            //         this.confirmEmailState = false;
            //         return
            //     }
            //     this.addNewUser();
            //     // Hide the modal manually
            //     this.$nextTick(() => {
            //         this.$refs.addNewUserModal.hide()
            //     })
            //
            // },

            sendChange() {
                axios.patch('/student/' + this.student.id, {
                    'name': this.englishName,
                    'email': this.email,
                    'phone': this.phone,
                    'arabic_name': this.arabicName,
                    'required_score': this.requiredScore,
                    'studying': this.studyingDegree,
                    // 'group_type': this.groupType,
                }).then(response => {
                    if (response.data.success) {
                        this.successAction();
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
                if (this.englishName.length > 0)
                    this.student['English Name'] = this.englishName;
                if (this.arabicName.length > 0)
                    this.student['Arabic Name'] = this.arabicName;
                if (this.email.length > 0)
                    this.student.email = this.email;
                if (this.phone.length > 0)
                    this.student.phone = this.phone;
                if (this.requiredScore > 0)
                    this.student['Required Score'] = this.requiredScore;
                if (this.studyingDegree != null) {
                    this.student['Studying Degree'] = this.studyingDegrees[this.studyingDegree]['text'];
                }
                this.showAlert("Successfully Updated", "success");

            },
            // addNewUser() {
            //     axios.post('/students/store', {
            //         'name': this.name,
            //         'email': this.email,
            //         'password': this.password,
            //     }).then(response => {
            //         if (response.data.success) {
            //             this.showAlert("Successfully Updated", "success");
            //             this.students.push(response.data.student);
            //         } else {
            //             this.showAlert("Something happened when updating . Please call Support");
            //         }
            //     })
            //         .catch(function (error) {
            //             console.log(error);
            //             this.showAlert("Something happened when updating . Please call Support");
            //             // console.log(error);
            //         });
            // },


            sendResUpdate() {
                axios.patch('/student/' + this.student.id + '/new-reservation', {
                    'res': this.reservation,
                    'type': this.groupType,
                }).then(response => {
                    if (response.data.success) {
                        this.student.failed = true;
                        this.showAlert("Successfully Updated", "success");
                        this.students=[];
                        this.getStudents();
                    } else {
                        this.showAlert(response.data.message);
                    }
                    this.reservation = null;
                })
                    .catch(function (error) {
                        console.log(error);
                        this.showAlert("Something happened when updating . Please call Support");
                        // console.log(error);
                    });

            },
            sendImagesUpdate() {
                var data = new FormData();
                let counter = 0;
                if (this.images.personalImage != null) {
                    counter++;
                    data.append('personalImage', this.images.personalImage);
                }

                if (this.images.nidImage != null) {
                    data.append('nidImage', this.images.nidImage);
                    counter++;
                }

                if (this.images.certificateImage != null) {
                    data.append('certificateImage', this.images.certificateImage);
                    counter++;
                }

                if (this.images.messageImage != null) {
                    counter++;
                    data.append('messageImage', this.images.messageImage);
                }
                if (counter > 0) {
                    axios.post('/student/' + this.student.id + '/images', data, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(response => {
                        if (response.data.success) {

                            this.showAlert("Successfully Updated", "success");
                        } else {
                            this.showAlert(response.data.message);
                        }
                        this.student = null;
                    })
                        .catch(function (error) {
                            console.log(error);
                            this.showAlert("Something happened when updating . Please call Support");
                            // console.log(error);
                        });
                } else {
                    this.showAlert("You didn't choose images");
                }

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
            checkIsUniquePhone() {
                axios.post('/students/unique-phone', {
                    'phone': this.phone,
                })
                    .then(response => {
                        this.isUniquePhone = response.data.check;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            getAvailableReservations() {
                axios.get('/reservations/available')
                    .then(response => {
                        this.reservations = response.data.reservations;
                        this.reservations.unshift({value: null, text: "Select Reservation", disabled: true})
                        this.groupTypes = response.data.groupTypes;
                        this.groupTypes.unshift({value: null, text: "Select Group Type", disabled: true})
                        this.studyingDegrees = response.data.studyingDegrees;
                        this.studyingDegrees.unshift({value: null, text: "Select Studying Degree", disabled: true})
                        // console.log(response.data);
                    }).catch(errors => {

                });
            },
            showPrintDialog(student) {
                this.getStudentCertifications(student);
                var self=this;
                setTimeout(function(){
                    if (self.certificates.length == 0) {
                        self.showAlert('Sorry there is no certificates to this student');
                    } else {
                        self.student = student;
                        self.$refs.printCertificateModal.show();
                    }
                }, 3000);


            },
            getStudentCertifications(student) {
                axios.get(`/student/${student.id}/certificate`)
                    .then(response => {
                        this.certificates=response.data;

                        // console.log(response.data);
                    }).catch(errors => {

                });
            },
            handleCertificateOk(bvModalEvt) {
                // Prevent modal from closing
                bvModalEvt.preventDefault();

                this.handleCertificateSubmit();

            },
            handleCertificateSubmit() {
                if (this.certificate==null)
                    return;
                this.printCertificate();

                this.$nextTick(() => {
                    this.$refs.printCertificateModal.hide()
                })
            },
            printCertificate(){
                window.location.replace(`/student/${this.student.id}/certificate/${this.certificate}/print`)
            },
            search() {
                this.students = [];
                if(this.reservationFilter.length>0){
                    axios.get('/student?filter=' + this.reservationFilter).then(response => {
                        if (response.data.students.length == 0) {
                            this.showAlert('Sorry there is no students with this reservation date');
                            setTimeout(null, 2000);
                            this.getStudents();
                        } else {
                            this.students = response.data.students;
                            this.count = response.data.count;
                        }
                    }).catch(error => {
                        console.log(error)
                    });
                }else{
                    this.currentPage=1;
                    this.getStudents();
                }

            },
            searchByPhone() {
                if(this.phoneFilter=='')
                    this.getStudents();

                else if (this.validatePhone(this.phoneFilter)) {
                    this.students = [];
                    axios.get('/student?phone=' + this.phoneFilter).then(response => {

                        if (response.data.students.length == 0) {
                            this.showAlert('Sorry there is no student with this phone number');
                            setTimeout(null, 2000);
                            this.getStudents();
                        } else {
                            this.students = response.data.students;
                            this.count = response.data.count;
                        }
                    }).catch(error => {
                        console.log(error)
                    });

                } else {
                    this.showAlert('Write correct phone number');
                }

            },


        }
    }
</script>
