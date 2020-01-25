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
                <select @change="getStudents()" id="reservation" name="reservation" class="form-control"
                        v-model="reservation">
                    <option value="" disabled>Select Reservation</option>
                    <option v-for="res in reservations" :value="res.id">{{res.start}}</option>
                </select>
            </div>
        </div>


        <h1>Students</h1>
        <b-table striped
                 hover
                 :sticky-header="true"
                 :items="students"
                 style="max-height: 70vh"
        >
            <template v-slot:cell(actions)="row">
                <button class="btn btn-success" @click="showDialog(row.item)">Edit Marks</button>

            </template>

        </b-table>
        <b-modal
            id="modal-prevent-closing"
            ref="modal"
            title="Submit Your Name"
            @hidden="resetModal"
            @ok="handleOk"
        >
            <form ref="form" @submit.stop.prevent="handleSubmit">
                <h4 >Student Name : {{st_name}}</h4>
                <h4>Current Score : {{currentScore}}</h4>
                <h4>Required Score : {{requiredScore}}</h4>
                <b-form-group
                    :state="scoreState"
                    label="Student Marks"
                    label-for="name-input"
                >
                    <b-form-input
                        :type="'number'"
                        id="name-input"
                        v-model="score"
                        :state="scoreState"
                        min="0"
                        max="500"
                        required
                    ></b-form-input>
                    <b-form-invalid-feedback :state="scoreState">
                        The score must be higher than the old one and less than 500.
                    </b-form-invalid-feedback>
                    <b-form-valid-feedback :state="scoreState">
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
                students: [],
                reservation: '',
                dismissSecs: 5,
                dismissCountDown: 0,
                message: "",
                alert: "danger",
                score: 0,
                currentScore:0,
                requiredScore:0,
                st_name:'',
                student:null,
            }
        }, computed:{
            scoreState:function(){
                if(this.score==0)
                    return null;
                else
                    return parseInt(this.score,10)>this.currentScore&&parseInt(this.score,10)>=this.requiredScore&&parseInt(this.score,10)<500;
            }
        },
        methods: {
            getStudents() {
                axios.get('/students/' + this.reservation + '/failed')
                    .then(response => {
                        this.students = response.data;
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
            showAlert(message,alert="danger") {
                this.message = message;
                this.alert = alert;
                this.dismissCountDown = this.dismissSecs
            },

            showDialog(student) {
                this.student=student;
                this.requiredScore=student.required_score;
                this.currentScore=student.score;
                this.score=student.score;
                this.st_name=student.english_name;
                this.$refs.modal.show();
            },

            resetModal() {
                // this.id=0;
                // this.requiredScore=0;
                // this.currentScore=0;
                // this.st_name='';
            },
            handleOk(bvModalEvt) {
                // Prevent modal from closing
                bvModalEvt.preventDefault()
                // Trigger submit handler
                this.handleSubmit()
            },
            handleSubmit() {
                // Exit when the form isn't valid
                if (!this.scoreState) {
                    return
                }
                // Push the name to submitted names
                this.sendMarksChange();
                // Hide the modal manually
                this.$nextTick(() => {
                    this.$refs.modal.hide()
                })
            },
            sendMarksChange(){
                axios.patch('/students/marks',{
                    'id':this.student.ID,
                    'score':this.score
                }).then(response=>{
                    if(response.data.success){
                        var index = this.students.indexOf(this.student);
                        if (index > -1) {
                            this.students.splice(index, 1);
                        }
                        this.showAlert("Successfully Updated","success");
                    }else{
                        this.showAlert("Something happened when updating . Please call Support");
                    }
                })
                    .catch(function (error) {
                        this.showAlert("Something happened when updating . Please call Support");
                        console.log(error);
                    });

            },
        }



    }
</script>
