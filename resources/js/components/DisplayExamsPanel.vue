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
             :items="jsonData"
             :filter="filter"
             sort-by="id"
             style="max-height: 70vh"
    >
        <template v-slot:cell(actions)="row">
            <button class="btn btn-primary" @click="showLiveExam(row.item)">Live Exam</button>
            <button v-if="!isReadingExam" class="btn btn-primary" @click="showExam(row.item)">Show</button>
            <button v-if="isReadingExam" class="btn btn-primary" @click="showVocab(row.item)">Show Vocab</button>
            <button v-if="isReadingExam" class="btn btn-primary" @click="showParagraphs(row.item)">Show Paragraphs</button>
            <button class="btn btn-success" @click="showEditExam(row.item)">Edit</button>
            <button class="btn btn-danger" @click="deleteExam(row.item)">Delete</button>

        </template>

    </b-table>
</div>
</template>

<script>
    export default {
        name: "DisplayExamsPanel",
        mounted() {
            // console.log(this.exams);

            this.jsonData=JSON.parse(this.exams);
        },
        props:['exams','liveRoute','route','isReading'],
        data:function(){
            return {
                dismissSecs: 3,
                dismissCountDown: 0,
                message: "",
                alert: "danger",
                jsonData:null,
                filter:null,
            }
        },computed:{
            isReadingExam:function () {
                return this.isReading=='true';
            }
        },
        methods:{
            showLiveExam(exam){
                window.location.replace(this.liveRoute+'/'+exam.id);
            },
            showExam(exam){
                window.location.replace(this.route+'/'+exam.id);
            },
            showParagraphs(exam){
                window.location.replace(this.route+'/'+exam.id+'/paragraph');
            },
            showVocab(exam){
                window.location.replace(this.route+'/'+exam.id+'/vocab');
            },
            showEditExam(exam){
                window.location.replace(this.route+'/'+exam.id+'/edit');
            },
            deleteExam(exam){

                    this.$bvModal.msgBoxConfirm('Are you sure about deleting this exam ' , {
                        title: 'Delete Exam',
                        size:'sm',
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
                                axios.delete(this.route+'/'+exam.id).then(response=>{
                                    var index = this.jsonData.indexOf(exam);
                                    if (index > -1) {
                                        this.jsonData.splice(index, 1);
                                    }

                                    this.showAlert('Successfully deleted','success');
                                }).catch(error=>console.log(error))
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
            showAlert(message,alert="danger") {
                this.message = message;
                this.alert = alert;
                this.dismissCountDown = this.dismissSecs
            },

        },
    }
</script>

<style scoped>

</style>
