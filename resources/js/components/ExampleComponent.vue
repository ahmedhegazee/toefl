<template>
    <div>
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
                    <option >Select Group</option>
                    <option v-for="group in groups" :value="group.id">{{group.name}}</option>

                </select>

            </div>

        </div>
        <div class="form-group row mb-0 justify-content-center">

            <button @click="enterExam()" class="btn btn-primary mr-2">
                Enter Exam
            </button>
            <button @click="startExam()" class="btn btn-primary mr-2">
                Start Exam
            </button>
            <button @click="stopExam()" class="btn btn-primary">
                Stop Exam
            </button>

        </div>
        <h1>Students</h1>
        <b-table striped
                 hover
                 :items="students"
        ></b-table>


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

                axios.get('/students/' + this.group)
                    .then(response => {
                        this.students = response.data;
                        // this.refreshData(this.group);
                        // console.log(response.data);
                    }).catch(errors => {

                });

            },
            refreshData(id) {
                this.timer = setInterval(function () {
                    // this.group=null;
                    // console.log(this.group);
                    // this.group=id;

                    axios.get('/students/' + id)
                        .then(response => {
                            this.students = response.data;
                            // console.log(this.dataKey);
                            // console.log(response.data);
                        }).catch(errors => {
                    });
                }, 10000);
            },
            enterExam() {
                axios.get('/students/' + this.group + "/enter")
                    .then(response => {
                        // console.log(response.data);
                    }).catch(errors => {

                });
            },
            startExam() {
                axios.get('/students/' + this.group + "/start")
                    .then(response => {
                        // console.log(response.data);
                    }).catch(errors => {

                });
            },
            stopExam() {
                axios.get('/students/' + this.group + "/stop")
                    .then(response => {
                        // console.log(response.data);
                    }).catch(errors => {

                });
            },
            cancelAutoUpdate() {
                clearInterval(this.timer)
            }

        },
        beforeDestroy() {
            this.cancelAutoUpdate();
        }
    }
</script>
