<template>
    <div>
        <b-form-textarea
            id="textarea-plaintext"
            plaintext
            value="This panel is used only if the student couldn't submit his answers.
            For Example,The server is failed in submitting his answers"
            no-resize
        ></b-form-textarea>
        <b-alert
            :show="dismissCountDown"
            dismissible
            fade
            :variant="alertVariant"
            @dismiss-count-down="countDownChanged"
        >
            <b-form-textarea
                id="textarea-plaintext"
                plaintext
                :value="message"
                no-resize
                :style="alertVariant=='danger'?'color: #721B24':'color:#155623'"
            ></b-form-textarea>

        </b-alert>
        <b-alert
            :show="data.length==0"
            variant="danger"
        >
            Sorry there is no student data here
        </b-alert>
        <div
            v-if="data.length>0">
            <b-form-input
                id="search-input"
                v-model="filter"
                class="mt-2 mb-2"
                placeholder="type to search"
            ></b-form-input>
            <b-table
                striped
                hover
                :sticky-header="true"
                :items="data"
                :fields="fields"
                :filter="filter"
                style="max-height: 70vh"
            >
                <template v-slot:cell(actions)="row">
                    <b-form-checkbox-group id="checkbox-group-2" style="display: inline;" v-model="row.item.selected"
                                           name="">
                        <!--                        <b-form-checkbox value="0" >All Answers</b-form-checkbox>-->
                        <b-form-checkbox value="1">Grammar Answers</b-form-checkbox>
                        <b-form-checkbox value="2">Reading Answers</b-form-checkbox>
                        <b-form-checkbox value="3">Listening Answers</b-form-checkbox>

                        <button class="btn btn-primary" @click="sendStudentAnswers(row.item)">Send</button>
                    </b-form-checkbox-group>
                </template>

            </b-table>
        </div>


    </div>
</template>

<script>
    export default {
        name: "StoredDataPanel",
        mounted() {
         this.getData();
            /*    if(document.cookie.indexOf('student-'+id+'-'+name+'-reading-vocab')>-1&&document.cookie.indexOf('student-'+id+'-'+name+'-reading-paragraph')>-1){
*/
        },
        data: function () {
            return {
                filter: null,
                data: [],
                sendedData: [],
                selected: [],
                fields: ['id', 'student_name', 'actions'],
                dismissSecs: 4,
                dismissCountDown: 0,
                message: "",
                alertVariant: "danger",
            }
        }, methods: {
            getData() {
                var arr = document.cookie.split(';');
                let id = [];
                let student_name = [];
                let scores = [];
                for (var i = 0; i < arr.length - 1; i++) {
                    if (arr[i].indexOf('student-') > -1) {
                        scores.push(arr[i]);
                        var a = arr[i].split('-');
                        if (
                            id.indexOf(a[1]) === -1 && a[1] != null
                            && student_name.indexOf(a[2]) == -1 && a[2] !== null
                        ) {
                            id.push(a[1]);
                            student_name.push(a[2]);
                        }
                    }
                }
                let student = {
                    id: 0,
                    student_name: '',
                    grammar: [],
                    vocab: [],
                    paragraph: [],
                    listening: [],
                };

                for (var i = 0; i < id.length; i++) {
                    for (var j = 0; j < scores.length; j++) {
                        if (scores[j].indexOf('student-' + id[i] + '-' + student_name[i] + '-grammar') > -1) {
                            var answers = scores[j].split('=')[1];
                            student.grammar = JSON.parse(answers);
                        }
                        if (scores[j].indexOf('student-' + id[i] + '-' + student_name[i] + '-reading-vocab') > -1) {
                            var answers = scores[j].split('=')[1];
                            student.vocab = JSON.parse(answers);
                        }
                        if (scores[j].indexOf('student-' + id[i] + '-' + student_name[i] + '-reading-paragraph') > -1) {
                            var answers = scores[j].split('=')[1];
                            student.paragraph = JSON.parse(answers);
                        }
                        if (scores[j].indexOf('student-' + id[i] + '-' + student_name[i] + '-listening') > -1) {
                            var answers = scores[j].split('=')[1];
                            student.listening = JSON.parse(answers);
                        }
                    }
                    student.id = id[i];
                    student.student_name = student_name[i];
                    this.data.push(student);
                    student = {
                        id: 0,
                        student_name: '',
                        grammar: [],
                        vocab: [],
                        paragraph: [],
                        listening: [],
                    };
                }

            },

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
            sendStudentAnswers(student) {
                let data = {};
                for (var i = 0; i < student.selected.length; i++) {
                    if (student.selected[i] == 1) {
                        if (student.grammar.length>0)
                            data.grammar = student.grammar;
                        else
                            this.message += "The student doesn't have grammar answers\n"
                    }
                    if (student.selected[i] == 2) {
                        if (student.vocab.length>0 && student.paragraph.length>0) {
                            data.vocab = student.vocab;
                            data.paragraph = student.paragraph;
                        } else
                            this.message += "The student doesn't have reading answers\n"
                    }
                    if (student.selected[i] == 3) {
                        if (student.listening.length>0)
                            data.listening = student.listening;
                        else
                            this.message += "The student doesn't have listening answers\n"
                    }
                }
                if (student.selected.length == 0) {
                    this.showAlert("Please check the required checkbox");
                }
                if (this.message != '')
                    this.showAlert(this.message);
                else {
                    axios.patch('/cpanel/student/' + student.id + '/edit', {
                        'data': JSON.stringify(data)
                    })
                        .then(response => {
                            this.showAlert('Successfully Updated', 'success');
                            // window.location.replace('/cpanel');
                        }).catch(error => console.log(error));
                }
                // console.log(data);
            }
        }

    }
</script>

<style scoped>

</style>
