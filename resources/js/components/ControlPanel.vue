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
                    <option disabled>Select Group</option>
                    <option v-for="group in groups" :value="group.id">{{group.name}}</option>

                </select>

            </div>

        </div>
        <div class="form-group row mb-0 justify-content-center">

            <button v-if="this.group!==''" @click="enterExam()" class="btn btn-primary mr-2">
                Enter Exam
            </button>
            <button v-if="this.group!==''" @click="startExam()" class="btn btn-primary mr-2">
                Start Exam
            </button>
            <button v-if="this.group!==''" @click="stopExam()" class="btn btn-primary">
                Stop Exam
            </button>

        </div>
        <h1>Students</h1>
        <b-table striped
                 hover
                 :items="students"
        >
            <template v-slot:cell(actions)="row">
                <button class="btn btn-danger" @click="removeAttempt(row.item.ID)">Remove Attempt</button>
            </template>
        </b-table>


    </div>

</template>

<script>

    export default {
        mounted() {
            axios.get('/reservations/')
                .then(response => {
                    this.reservations = response.data;
                    // console.log(response.data);
                }).catch(errors => {

            });
        },
        data: function () {
            return {
                reservations: [],
                groups: [],
                students: [],
                reservation: '',
                group: '',
                timer: null,
                dismissSecs: 5,
                dismissCountDown: 0,
                message:"",
                alert:"danger",
                enter:false,
                started:false,
                working:false,
                hasExams:false,
            }
        }, methods: {
            getGroups() {
                axios.get('/groups/' + this.reservation)
                    .then(response => {
                        this.groups = response.data;
                        // console.log(response.data);
                    }).catch(errors => {

                });
            },
            getStudents() {
                this.checkIfExamEntered();
                this.checkIfExamStarted();
                this.checkIfExamWorking();
                this.checkIfGroupHasExams();
                axios.get('/students/' + this.group)
                    .then(response => {
                        this.students = response.data;
                        // this.refreshData(this.group);
                        // console.log(response.data);
                    }).catch(errors => {

                });

            },
            enterExam() {
                this.checkIfGroupHasExams();
                if(this.hasExams){
                    this.checkIfExamEntered();
                    if(!this.enter){
                        axios.post('/students/' + this.group + "/enter")
                            .then(response => {
                                this.message="The students can login now";
                                this.alert="success";
                                this.showAlert();
                            }).catch(errors => {

                        });
                    }else{
                        this.message="The exam is already opened,so students can login ";
                        this.showAlert();
                    }
                }else{
                    this.message="Sorry this group doesn't have exams";
                    this.showAlert();
                }


            },
            startExam() {
                this.checkIfExamEntered();
                this.checkIfExamStarted();
                if(!this.enter){
                    this.message="You should allow students to login first.Click on Enter exam button";
                    this.showAlert();
                }else if(this.enter&&!this.started){
                    axios.post('/students/' + this.group + "/start")
                        .then(response => {
                            this.message="The students can solve the exam";
                            this.alert="success";
                            this.showAlert();
                        }).catch(errors => {
                    });
                }
                else{
                    this.message="The students already can solve the exam";
                    this.showAlert();
                }

            },
            stopExam() {

                this.checkIfExamWorking();
                if(this.working){
                    axios.post('/students/' + this.group + "/stop")
                        .then(response => {
                            this.message="The exam stopped successfully";
                            this.alert="success";
                            this.showAlert();
                        }).catch(errors => {
                    });
                }else{
                    this.message="The exam is not started";
                    this.showAlert()
                }

            },
            removeAttempt(id){
                axios.post('/attempt/' + id )
                    .then(response => {
                       this.message=response.data;
                       if(this.message==="Successful deleting")
                           this.alert="success";
                       this.showAlert();
                    }).catch(errors => {

                });
                },
            checkIfExamEntered(){
                axios.get('/students/' + this.group + "/entered")
                    .then(response => {
                        this.enter=response.data.success;

                    }).catch(errors => {

                });
            },
            checkIfExamStarted(){
                axios.get('/students/' + this.group + "/started")
                    .then(response => {
                        this.started=response.data.success;

                    }).catch(errors => {

                });
            },
            checkIfExamWorking(){
                axios.get('/students/' + this.group + "/working")
                    .then(response => {
                       this.working=response.data.success;
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
                if(this.dismissCountDown===0)
                {
                    this.message="";
                    this.alert="danger";
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
