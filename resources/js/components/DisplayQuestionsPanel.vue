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
<!--        <b-form-input-->
<!--            id="search-input"-->
<!--            v-model="filter"-->
<!--            class="mt-2 mb-2"-->
<!--            placeholder="type to search"-->
<!--        ></b-form-input>-->
        <b-table striped
                 hover
                 :sticky-header="true"
                 :items="questions"
                 :filter="filter"
                 sort-by="id"
                 style="max-height: 70vh"
                 :busy="busyState"
                 :per-page="perPage"
                 :current-page="current"
        >
            <template v-slot:table-busy>
                <div class="text-center text-danger my-2">
                    <b-spinner class="align-middle"></b-spinner>
                    <strong>Loading...</strong>
                </div>
            </template>
            <template v-slot:cell(actions)="row">

                <button v-if="!canChooseQuestions&&isParagraphs" class="btn btn-primary"
                        @click="showParagraph(row.item)">Show
                </button>
                <button v-if="!canChooseQuestions" class="btn btn-success" @click="showEditQuestion(row.item)">Edit
                </button>
                <button v-if="!canChooseQuestions" class="btn btn-danger" @click="deleteQuestion(row.item)">Remove
                </button>
                <button v-if="canChooseQuestions&&isParagraphs" class="btn btn-primary"
                        @click="showParagraph(row.item)">Show
                </button>
                <button v-if="canChooseQuestions" class="btn btn-success" @click="showEditQuestion(row.item)">Edit
                </button>

            </template>


            <template v-if="canChooseQuestions" v-slot:cell(check)="row">
                <b-form-checkbox-group id="checkbox-group-2" v-model="selected">
                    <b-form-checkbox :value="row.item.id"></b-form-checkbox>
                </b-form-checkbox-group>
            </template>

        </b-table>
        <div class="row justify-content-center">
            <b-pagination
                v-model="currentPage"
                :total-rows="count"
                :per-page="perPage"
                aria-controls="my-table"
                v-if="questions.length!=0"
            ></b-pagination>
        </div>

        <button v-if="canChooseQuestions&&!isParagraphs&&!isAudios"
                class="btn btn-primary"
                @click="storeQuestions"
        >Add Questions
        </button>
        <button v-if="canChooseQuestions&&isParagraphs"
                class="btn btn-primary"
                @click="storeParagraphs"
        >Add Paragraphs
        </button>
        <button v-if="canChooseQuestions&&isAudios"
                class="btn btn-primary"
                @click="storeAudios"
        >Add Audios
        </button>
    </div>
</template>

<script>
    export default {
        name: "DisplayQuestionsPanel",
        mounted() {
            // console.log(this.questions);

            if(window.location.pathname.indexOf('exam')>-1&&(window.location.pathname.indexOf('add')==-1))
                this.showExam=true;
            this.busyState=true;
            var self=this;
            axios.get(this.deleteRoute+'?showExam='+this.showExam).then(response => {
                this.questions = response.data.questions;
                this.count = response.data.count;
                if (this.canChooseQuestions)
                    this.selected = response.data.checked;
            });
            setTimeout(function(){
                if(self.questions.length==0){
                    self.showAlert('No questions is available.Add new one','success');
                }
                self.busyState=false;
            },3000);

            // this.questions = JSON.parse(this.questions);
        },
        props: [
            'route', 'deleteRoute',
            'isParagraph', 'canChoose', 'checked',
            'storeRoute', 'isAudio', 'redirectRoute',
            // 'questions'
        ],
        data: function () {
            return {
                dismissSecs: 3,
                dismissCountDown: 0,
                message: "",
                alert: "danger",
                questions: [],
                selected: [],
                filter: null,
                perPage: 50,
                currentPage: 1,
                current: 1,
                count: 0,
                showExam:false,
                busyState:false,
            }
        },
        watch: {
            currentPage(newPage, oldPage) {
                this.questions = [];
                var self = this;
                axios.get(this.deleteRoute +'?showExam='+this.showExam+ '&&page=' + newPage,{'showExam':this.showExam})
                    .then(function (response) {
                        self.questions = response.data.questions;
                        // self.questions = ;
                        self.count = response.data.count;
                        // if (self.canChooseQuestions)
                        //     self.selected = response.data.checked;
                    });

                this.$emit('input', newPage);
            }
        },
        computed: {
            canChooseQuestions: function () {
                return this.canChoose == 'true';
            },
            isParagraphs: function () {
                return this.isParagraph == 'true';
            },
            isAudios: function () {
                return this.isAudio == 'true';
            },

        },
        methods: {

            showEditQuestion(question) {
                window.location.replace(this.route + '/' + question.id + '/edit');
            },
            showParagraph(paragraph) {
                window.location.replace(this.route + '/' + paragraph.id);
            },
            deleteQuestion(question) {
                this.$bvModal.msgBoxConfirm('Are you sure about removing this question ', {
                    title: 'Remove Question',
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
                            axios.delete(this.deleteRoute + '/' + question.id).then(response => {
                                if (response.data.success) {
                                    var index = this.questions.indexOf(question);
                                    if (index > -1) {
                                        this.questions.splice(index, 1);
                                    }

                                    this.showAlert('Successfully removed', 'success');
                                } else
                                    this.showAlert("You can't remove this question ");

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
            storeQuestions() {
                axios.post(this.storeRoute, {'questions': this.selected})
                    .then(response => {
                        this.showAlert('Successfully Added to the exam', 'success');
                        let r = this.redirectRoute;
                        setTimeout(function () {
                            // window.history.back();
                            window.location.replace(r);
                        }, 4000);

                    }).catch(error => error => {
                    console.log(error);
                    this.showAlert('Something happened. Please call support');
                })
            },
            storeParagraphs() {
                axios.post(this.storeRoute, {'paragraphs': this.selected})
                    .then(response => {
                        this.showAlert('Successfully Added to the exam', 'success');
                        let r = this.redirectRoute;
                        setTimeout(function () {
                            // window.history.back();
                            window.location.replace(r);
                        }, 4000);
                    }).catch(error => error => {
                    console.log(error);
                    this.showAlert('Something happened. Please call support');
                })
            },
            storeAudios() {
                axios.post(this.storeRoute, {'audios': this.selected})
                    .then(response => {
                        this.showAlert('Successfully Added to the exam', 'success');
                        let r = this.redirectRoute;
                        setTimeout(function () {
                            // window.history.back();
                            window.location.replace(r);
                        }, 4000);

                    }).catch(error => error => {
                    console.log(error);
                    this.showAlert('Something happened. Please call support');
                })
            },


        }
    }
</script>

<style scoped>

</style>
