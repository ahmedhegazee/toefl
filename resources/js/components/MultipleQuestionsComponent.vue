<template>
    <div>

        <b-form-textarea
            id="textarea-plaintext"
            plaintext
            :value="description"
            rows="10"
            no-resize
        ></b-form-textarea>
        <div class="clearfix mb-2 mt-2">
            <b-img center thumbnail :src="img" style="max-width: 70vw;border-width: 3px !important;"
                   alt="Description Image"></b-img>
        </div>
        <b-alert
            :show="dismissCountDown"
            dismissible
            fade
            :variant="alertVariant"
            @dismiss-count-down="countDownChanged"
        >
            {{message}}
        </b-alert>
        <b-alert v-if="alert.show" :variant="alert.variant" show>
            <ul>
                <li v-for="message in alert.message" v-text="message"></li>
            </ul>

        </b-alert>
        <b-form-textarea
            id="textarea-questions"
            placeholder="Write multiple questions using the specific format"
            rows="6"
            v-model="text"
            no-resize
        ></b-form-textarea>
        <b-button v-if="convertStatus" @click="convertQuestions" class="mt-2 mb-2" size="lg" variant="primary">Convert
        </b-button>
        <b-form-input
            id="search-input"
            v-model="filter"
            class="mt-2 mb-2"
            placeholder="type to search"
            v-if="questions.length>0"
        ></b-form-input>
        <b-table
            v-if="questions.length>0"
            striped
            hover
            :sticky-header="true"
            :items="questions"
            :filter="filter"
            :fields="fields"
            sort-by="id"
            style="max-height: 70vh"
        >
            <template v-slot:cell(actions)="row">
                <button v-if="" class="btn btn-danger" @click="deleteQuestion(row.item)">Remove</button>

            </template>

        </b-table>
        <b-button v-if="doneStatus" size="lg" class="mt-2 mb-2" @click="storeQuestions" variant="primary">Done</b-button>

    </div>
</template>

<script>
    export default {
        name: "MultipleQuestionsComponent",
        props: ['storeRoute', 'isGrammar','redirectRoute'],
        mounted() {
            if (this.isGrammar == 'true') {
                this.img = "/img/grammar_question_description.png";
                this.fields = [
                    'id', 'question', 'question type', 'First Option', 'Second Option',
                    'Third Option', 'Fourth Option', 'Correct Answer',
                    'actions',
                ];
                this.description = 'To add multiple questions .You have to follow specific format.\n' +
                    'Question Content%Question Type%Option 1%Option 2%Option 3%Option 4%the number of correct answer\n ' +
                    'use - to separate between questions\n Question Types :\n 1 for Fill in the space \n 2 for Find the mistake\n' +
                    'For example :\n What is  your name?%1%Ali%Ahmed%Khaled%Waleed%4-What old are you?%2%18%22%32%40%3\n' + 'So the questions will be like this';
            } else {
                this.img = "/img/question_description.png";
                this.fields = [
                    'id', 'question', 'First Option', 'Second Option',
                    'Third Option', 'Fourth Option', 'Correct Answer',
                    'actions',
                ];
                this.description = 'To add multiple questions .You have to follow specific format.\n' +
                    'Question Content%Option 1%Option 2%Option 3%Option 4%the number of correct answer-\n use - to separate between questions\n' +
                    'For example :\n What is  your name?%Ali%Ahmed%Khaled%Waleed%4-What old are you?%18%22%32%40%3\n' +
                    'So the questions will be like this';
            }
        },
        data: function () {
            return {
                img: '',
                fields: [],
                questions: [],
                question: null,
                dismissSecs: 4,
                dismissCountDown: 0,
                message: "",
                alertVariant: "danger",
                alert: {
                    message: [],
                    variant: 'danger',
                    show: false,
                },
                text: '',
                description: '',
                buttonStatus: {
                    convert: false,
                    done: false
                },
                filter: null,
            };
        },
        computed: {
            convertStatus: function () {
                if (this.text.length == 0)
                    return false;
                else
                    return true;
            },
            doneStatus: function () {
                if (this.questions.length == 0)
                    return false;
                else
                    return true;
            }
        },
        methods: {
            countDownChanged(dismissCountDown) {
                this.dismissCountDown = dismissCountDown;
                if (this.dismissCountDown === 0) {
                    this.message = "";
                    this.alertVariant = "danger";
                }
            },
            showAlert(message, alert = "danger") {
                this.message = message;
                this.alertVariant = alert;
                this.dismissCountDown = this.dismissSecs
            },
            getCorrectOption(option) {
                var options = [
                    'First Option',
                    'Second Option',
                    'Third Option',
                    'Fourth Option',
                ];
                return options[option];
            },
            getQuestionTypes(type) {
                var types = [
                    'Fill in the space',
                    'Find the mistake',
                ];
                return types[type];
            },
            convertQuestions() {
                var questions = this.text.split('-');
                this.questions = [];
                this.alert.show = false;
                this.alert.message = [];
                if (this.isGrammar == 'true') {
                    for (var i = 0; i < questions.length; i++) {
                        if (questions[i].length == 0) {
                            this.alert.show = true;
                            this.alert.message.push("write correct question which its id is " + (i + 1) + " using specific format please  ");
                            var question = {
                                'id': (i + 1),
                                'question': '',
                                'question type': '',
                                'First Option': '',
                                'Second Option': '',
                                'Third Option': '',
                                'Fourth Option': '',
                                'Correct Answer': '',
                                'correct': '',
                                'actions': '',
                            };
                            this.questions.push(question);
                        } else {
                            var answers = questions[i].split('%');
                            // console.log(answers);
                            // console.log(answers[6].length == 0);
                            if (answers.length < 7) {
                                this.alert.show = true;
                                this.alert.message.push("write correct options in the question with id " + (i + 1));
                            } else if (answers[6].length == 0) {
                                this.alert.show = true;
                                this.alert.message.push("write correct answer in the question with id " + (i + 1));
                            }
                            var question = {
                                'id': (i + 1),
                                'question': answers[0],
                                'question type': this.getQuestionTypes(answers[1] - 1),
                                'First Option': answers[2],
                                'Second Option': answers[3],
                                'Third Option': answers[4],
                                'Fourth Option': answers[5],
                                'Correct Answer': this.getCorrectOption(answers[6] - 1),
                                'correct': answers[6],
                                'type': answers[1],
                                'actions': '',
                            };
                            this.questions.push(question);
                        }


                    }

                } else {
                    for (var i = 0; i < questions.length; i++) {
                        if (questions[i].length == 0) {
                            this.alert.show = true;
                            this.alert.message.push("write correct question which its id is " + (i + 1) + " using specific format please  ");
                            var question = {
                                'id': (i + 1),
                                'question': '',
                                'First Option': '',
                                'Second Option': '',
                                'Third Option': '',
                                'Fourth Option': '',
                                'Correct Answer': '',
                                'correct': '',
                                'actions': '',
                            };
                            this.questions.push(question);
                        } else {
                            var answers = questions[i].split('%');
                            if (answers.length < 6) {
                                this.alert.show = true;
                                this.alert.message.push("write correct options in the question with id " + (i + 1));
                            } else if (answers[5].length == 0) {
                                this.alert.show = true;
                                this.alert.message.push("write correct answer in the question with id " + (i + 1));
                            }
                            var question = {
                                'id': (i + 1),
                                'question': answers[0],
                                'First Option': answers[1],
                                'Second Option': answers[2],
                                'Third Option': answers[3],
                                'Fourth Option': answers[4],
                                'Correct Answer': this.getCorrectOption(answers[5] - 1),
                                'correct': answers[5],
                                'actions': '',
                            };
                            this.questions.push(question);
                        }


                    }

                }
            },


            deleteQuestion(question) {
                var index = this.questions.indexOf(question);
                if (index > -1) {
                    this.questions.splice(index, 1);
                }
            },
            storeQuestions(){
                if(!this.alert.show){
                    this.$bvModal.msgBoxConfirm('Are you sure about storing these questions ', {
                        title: 'Storing Questions',
                        size: 'sm',
                        buttonSize: 'sm',
                        okVariant: 'success',
                        okTitle: 'YES',
                        cancelTitle: 'NO',
                        footerClass: 'p-2',
                        hideHeaderClose: false,
                        centered: true
                    })
                        .then(value => {
                            if (value == true) {
                                axios.post(this.storeRoute ,{
                                    'questions':this.questions,
                                })
                                    .then(response => {
                                        if (response.status==200) {
                                            this.showAlert('Successfully stored', 'success');
                                            let r=this.redirectRoute;
                                            setTimeout(function () {
                                                // window.history.back();
                                                window.location.replace(r);
                                            }, 3000);
                                        } else{
                                            this.showAlert("Something happened. Please call support");
                                        }


                                    }).catch(error => {
                                    console.log(error);
                                    this.showAlert('Something happened. Please call support');
                                })
                            }
                        })
                        .catch(err => {
                            // An error occurred
                            console.log(err);
                        })
                }else{
                    this.$bvModal.msgBoxOk("Please check the errors for correction them", {
                        title: 'Attention',
                        size: 'sm',
                        buttonSize: 'sm',
                        okVariant: 'primary',
                        okTitle: 'OK',
                        footerClass: 'p-2',
                        hideHeaderClose: false,
                        centered: true}
                        ).then().catch();
                }


            }
        },
    }

</script>

<style scoped>

</style>
