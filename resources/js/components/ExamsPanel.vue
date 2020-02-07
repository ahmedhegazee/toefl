<template>
    <div>
        <b-alert :show="show" variant="danger">{{m}}</b-alert>
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
        <div class="form-group row mb-0 justify-content-center" v-if="this.group!==''">
            <button @click="enterExam()" class="btn btn-primary mr-2">
                Enter Exam
            </button>
            <button @click="startExam()" class="btn btn-primary mr-2">
                Start Exam
            </button>
            <button @click="stopExam()" class="btn btn-danger mr-2">
                End Exam
            </button>
            <button @click="closeExam()" class="btn btn-danger">
                Close Exam Session
            </button>
        </div>
        <div class="form-group row mb-0 justify-content-center mt-2" v-if="this.group!==''">
            <h4>
                <b-badge :variant="enter?'success':'danger'" class="mr-2">Exam is Entered</b-badge>
            </h4>
            <h4>
                <b-badge :variant="started?'success':'danger'" class="mr-2">Exam is Started</b-badge>
            </h4>
            <h4>
                <b-badge :variant="!working?'success':'danger'" class="mr-2">Exam is Stopped</b-badge>
            </h4>

        </div>
        <h1>Students</h1>
        <b-table striped
                 hover
                 :sticky-header="true"
                 :items="students"
                 :busy="isBusy"
                 style="max-height: 70vh"
        >
            <template v-slot:table-busy>
                <div class="text-center text-danger my-2">
                    <b-spinner class="align-middle"></b-spinner>
                    <strong>Loading...</strong>
                </div>
            </template>
            <template v-slot:cell(actions)="row">
                <button class="btn btn-danger" @click="removeAttempt(row.item.ID)">Remove Attempt</button>
            </template>
        </b-table>


    </div>

</template>

<script>

    export default {
        mounted() {
            axios.get('/reservations/exams')
                .then(response => {
                    this.reservations = response.data;
                    if(this.reservations.length==0){
                        this.m="There is no available closed reservations now";
                        this.show=true;
                    }

                    // console.log(response.data);
                }).catch(errors => {

            });
        },computed:{
            isBusy:function(){
                return this.students.length==0&&this.group!=''&&this.reservation!='';
            }
        },
        data: function () {
            return {
                show:false,
                reservations: [],
                m:'',
                groups: [],
                students: [],
                currentReservation:'',
                reservation: '',
                group: '',
                currentGroup:'',
                timer: null,
                dismissSecs: 5,
                dismissCountDown: 0,
                message: "",
                alert: "danger",
                enter: false,
                started: false,
                working: false,
                hasExams: false,
                reservationExamined:false,
                groupExamined:false,
            }
        }, methods: {
            getGroups() {
                if(
                    (this.enter||this.started)
                    &&this.currentReservation!=this.reservation
                    &&this.reservation!=''
                ){
                    this.message='Sorry you can\'t change reservation when the exam is running';
                    this.showAlert();
                    this.reservation =this.currentReservation;

                }else{
                    this.currentReservation=this.reservation;
                    axios.get('/groups/' + this.reservation)
                        .then(response => {
                            this.groups = response.data;
                            // console.log(response.data);
                        }).catch(errors => {

                    });
                }

            },
            getStudentsData(){
                axios.get('/students/' + this.group)
                    .then(response => {
                        this.students = response.data.students;
                        this.enter = response.data.entered;
                        this.started = response.data.started;
                        this.working = this.enter && this.started;
                        this.hasExams = response.data.has_exams;

                        // console.log(response.data);
                    }).catch(errors => {

                });
            },
            getStudents() {
                if(
                    (this.enter||this.started)
                    &&this.currentGroup!=this.group
                    &&this.group!=''
                ){
                    this.message='Sorry you can\'t change reservation when the exam is running';
                    this.showAlert();
                    this.group=this.currentGroup;
                }else {
                    this.currentGroup=this.group;
                   this.getStudentsData();
                    setTimeout(null,120000);
                    this.refreshData();
                }
            },
            refreshData(){
                var d=this;
                setInterval(function () {
                    this.students=[];
                    // setTimeout(null,1000);
                    if(d.m.length==0)
                    d.getStudentsData();
                },60000);

                // setTimeout(null,60000);
            },
            enterExam() {

                if(this.students.length==0){
                    this.message = 'Wait until the data processing finished';
                    this.showAlert();

                }
                else{
                    this.checkIsGroupExamined();
                    this.checkIfGroupHasExams();
                    setTimeout(null,3000);
                  if(!this.groupExamined){
                      if (this.hasExams) {
                          this.checkIfExamEntered();
                          setTimeout(null,3000);
                          if (!this.enter) {
                              axios.post('/students/' + this.group + "/enter")
                                  .then(response => {
                                      this.message = "The students can login now";
                                      this.alert = "success";
                                      this.showAlert();
                                      this.enter = true;
                                      this.working=this.enter&&this.started;
                                  }).catch(errors => {

                              });
                          } else {
                              this.message = "The exam is already opened,so students can login ";
                              this.showAlert();
                          }
                      } else {
                          this.message = "Sorry this group doesn't have exams";
                          this.showAlert();
                      }
                  }else{
                      this.message = "Sorry this group had been examined";
                      this.showAlert();
                  }
                }



            },
            startExam() {
                // this.checkIfExamEntered();
                this.checkIfExamStarted();
                if (!this.enter) {
                    this.message = "You should allow students to login first.Click on Enter exam button";
                    this.showAlert();
                } else if (this.enter && !this.started) {
                    axios.post('/students/' + this.group + "/start")
                        .then(response => {
                            this.message = "The students can solve the exam";
                            this.started = true;
                            this.working=this.enter&&this.started;
                            this.alert = "success";
                            this.showAlert();
                        }).catch(errors => {
                    });
                } else {
                    this.message = "The students already can solve the exam";
                    this.showAlert();
                }

            },
            stopExam() {
                this.$bvModal.msgBoxConfirm('Are you sure about ending this exam .\n' +
                    'It will close the exam on students and correct all their answers' , {
                    title: 'Ending Exam',
                    size:'lg',
                    buttonSize:'sm',
                    okVariant: 'danger',
                    okTitle: 'YES',
                    cancelTitle: 'NO',
                    footerClass: 'p-2',
                    hideHeaderClose: false,
                    centered: true
                })
                    .then(value => {
                        if (value == true) {
                            this.checkIfExamWorking();
                            if (this.working) {
                                axios.post('/students/' + this.group + "/stop")
                                    .then(response => {
                                        this.message = "The exam stopped successfully";
                                        this.alert = "success";
                                        this.working = false;
                                        this.started = false;
                                        this.enter = false;
                                        this.showAlert();
                                    }).catch(errors => {
                                });
                            } else {
                                this.message = "The exam is not started";
                                this.showAlert()
                            }
                        }
                    })
                    .catch(err => {
                        // An error occurred
                        console.log(err);
                    })

            },
            closeExam() {
                this.$bvModal.msgBoxConfirm('Are you sure about closing this exam .\n' +
                    'This button is used only when you open the exam wrongly' , {
                    title: 'Closing Exam',
                    size:'lg',
                    buttonSize:'sm',
                    okVariant: 'danger',
                    okTitle: 'YES',
                    cancelTitle: 'NO',
                    footerClass: 'p-2',
                    hideHeaderClose: false,
                    centered: true
                })
                    .then(value => {
                        if (value == true) {
                            this.checkIfExamWorking();
                            if (this.started||this.enter) {
                                axios.post('/students/' + this.group + "/close")
                                    .then(response => {
                                        this.message = "The exam is closed successfully";
                                        this.alert = "success";
                                        this.working = false;
                                        this.started = false;
                                        this.enter = false;
                                        this.showAlert();
                                    }).catch(errors => {
                                });
                            } else {
                                this.message = "The exam is not started";
                                this.showAlert()
                            }
                        }
                    })
                    .catch(err => {
                        // An error occurred
                        console.log(err);
                    })


            },
            removeAttempt(id) {
                axios.post('/attempt/' + id)
                    .then(response => {
                        this.message = response.data;
                        if (this.message === "Successful deleting")
                            this.alert = "success";
                        this.showAlert();
                    }).catch(errors => {

                });
            },
            checkIfExamEntered() {
                axios.get('/students/' + this.group + "/entered")
                    .then(response => {
                        this.enter = response.data.success;

                    }).catch(errors => {

                });
            },
            checkIfExamStarted() {
                axios.get('/students/' + this.group + "/started")
                    .then(response => {
                        this.started = response.data.success;

                    }).catch(errors => {

                });
            },
            checkIfExamWorking() {
                axios.get('/students/' + this.group + "/working")
                    .then(response => {
                        this.working = response.data.success;
                    }).catch(errors => {
                });
            },
            checkIsReservationExamined() {
                axios.get('/reservation/' + this.reservation + "/examined")
                    .then(response => {
                        this.reservationExamined = response.data.success;
                    }).catch(errors => {
                });
            },
            checkIsGroupExamined() {
                axios.post('/group/' + this.group + "/examined")
                    .then(response => {
                        this.groupExamined = response.data.success;
                    }).catch(errors => {
                });
            },
            checkIfGroupHasExams(){
                axios.get('/group/' + this.group + "/hasExams")
                    .then(response => {
                       this.hasExams=response.data.success;
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
            cancelAutoUpdate() {
                clearInterval(this.timer)
            }

        },
        beforeDestroy() {
            this.cancelAutoUpdate();
        },

    }
</script>
