<template>
    <div class="mt-3">
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
        <b-form-input
            v-if="students.length!=0"
            id="search-input"
            v-model="filter"
            class="mt-2 mb-2"
            placeholder="type to search"
        ></b-form-input>
        <b-table striped
                 hover
                 :sticky-header="true"
                 :items="students"
                 :filter="filter"
                 sort-by="id"
                 style="max-height: 70vh"
                 :per-page="perPage"
                 :current-page="currentPage"
        >


            <template  v-slot:cell(check)="row">
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
                v-if="students.length!=0"
            ></b-pagination>

        </div>
        <div class="row justify-content-end pr-5 "  v-if="students.length!=0">
            <button class="btn btn-primary" @click="retakeExamAgain">Retake the exam again</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "DisplayQuestionsPanel",
        mounted() {
            // console.log(this.questions);
            axios.get('/reservations/closed')
                .then(response => {
                    this.reservations = response.data;
                    if(this.reservations.length==0){
                        this.m="There is no available closed reservations now";
                        this.show=true;
                    }

                    // console.log(response.data);
                }).catch(errors => {

            });
            // this.questions = JSON.parse(this.questions);
        },
        data: function () {
            return {
                dismissSecs: 3,
                dismissCountDown: 0,
                message: "",
                alert: "danger",
                selected: [],
                filter: null,
                perPage: 50,
                currentPage: 1,
                count: 0,
                show:false,
                reservations: [],
                m:'',
                groups: [],
                students: [],
                reservation: '',
                group: '',
            }
        },

        methods: {

            getGroups() {

                    axios.get(`/groups/${this.reservation}/examined`)
                        .then(response => {
                            this.groups = response.data;
                            if(this.groups.length==0)
                                this.showAlert("This reservation doesn't have examined groups");
                            // console.log(response.data);
                        }).catch(errors => {

                    });

            },
            getStudents(){
                axios.get(`/students/${this.group}/examined`)
                    .then(response => {
                        this.students = response.data.students;
                        this.count = response.data.count;
                        this.selected=[];
                        // console.log(response.data);
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
            showAlert(message, alert = "danger") {
                this.message = message;
                this.alert = alert;
                this.dismissCountDown = this.dismissSecs
            },
            retakeExamAgain() {
                this.show=false;
                this.m='';
                axios.patch("/students/retake-exam", {
                    'students': this.selected,
                    'reservation':this.reservation,
                    'group':this.group
                })
                    .then(response => {
                        var changed=response.data;
                        var unchanged=[];
                        for(var i=0;i<this.selected.length;i++){
                            if(changed.indexOf(this.selected[i])==-1)
                                unchanged.push(this.selected[i]);
                        }
                        console.log(changed);
                        console.log(unchanged);
                        if(changed.length>0)
                        {
                            this.showAlert(`Students with id {${changed}} can take the exam again`, 'success');
                        }
                        if(unchanged.length>0){
                            this.m=`Students with id {${unchanged}} cannot take the exam again because they are succeeded`;
                            this.show=true;
                        }


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
