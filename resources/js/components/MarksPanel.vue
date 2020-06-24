<template>
  <div>
    <b-alert
      :show="dismissCountDown"
      dismissible
      fade
      :variant="alert"
      @dismiss-count-down="countDownChanged"
    >{{message}}</b-alert>
    <b-alert :show="show" variant="danger">{{msg}}</b-alert>
    <div class="form-group row">
      <label for="reservation" class="col-md-4 col-form-label text-md-right">Select Reservation</label>
      <div class="col-md-6">
        <select
          @change="getGroups()"
          id="reservation"
          name="reservation"
          class="form-control"
          v-model="reservation"
        >
          <option value disabled>Select Reservation</option>
          <option v-for="res in reservations" :value="res.id">{{res.start}}</option>
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label for="reservation" class="col-md-4 col-form-label text-md-right">Select Group</label>
      <div class="col-md-6">
        <select
          @change="getStudents()"
          id="group"
          name="group"
          class="form-control"
          v-model="group"
        >
          <option disabled value>Select Group</option>
          <option v-for="group in groups" :value="group.id">{{group.name}}</option>
        </select>
      </div>
    </div>

    <h1>Students' Scores</h1>
    <b-table
      striped
      hover
      :sticky-header="true"
      :items="students"
      style="max-height: 70vh"
      :per-page="perPage"
      :current-page="currentPage"
    >
      <template v-slot:cell(actions)="row">
        <button class="btn btn-success" @click="showDialog(row.item)">Edit Marks</button>
      </template>
    </b-table>
    <div class="row justify-content-center" v-if="students.length!=0">
      <b-pagination
        v-model="currentPage"
        :total-rows="rows"
        :per-page="perPage"
        aria-controls="my-table"
      ></b-pagination>
    </div>
    <b-modal
      id="modal-prevent-closing"
      ref="modal"
      title="Submit Your Name"
      @hidden="resetModal"
      @ok="handleOk"
    >
      <form ref="form" @submit.stop.prevent="handleSubmit">
        <h4>Student Name : {{st_name}}</h4>
        <h4>Current Score : {{currentScore}}</h4>
        <h4>Required Score : {{requiredScore}}</h4>
        <b-form-group :state="scoreState" label="Student Marks" label-for="name-input">
          <b-form-input
            :type="'number'"
            id="name-input"
            v-model="score"
            :state="scoreState"
            min="0"
            max="500"
            required
          ></b-form-input>
          <b-form-invalid-feedback
            :state="scoreState"
          >The score must be higher than the old one and less than 677.</b-form-invalid-feedback>
          <b-form-valid-feedback :state="scoreState">Looks Good.</b-form-valid-feedback>
        </b-form-group>
      </form>
    </b-modal>
  </div>
</template>

<script>
export default {
  mounted() {
    axios
      .get("/reservations/examined")
      .then(response => {
        this.reservations = response.data;
        if (this.reservations.length == 0) {
          this.msg = "  Sorry there is no available reservations";
          this.show = true;
        }

        // console.log(response.data);
      })
      .catch(errors => {});
  },
  data: function() {
    return {
      reservations: [],
      students: [],
      reservation: "",
      dismissSecs: 5,
      dismissCountDown: 0,
      message: "",
      alert: "danger",
      score: 0,
      currentScore: 0,
      requiredScore: 0,
      st_name: "",
      student: null,
      perPage: 20,
      currentPage: 1,
      msg: "",
      show: false,
      groups: [],
      group: ""
    };
  },
  computed: {
    rows() {
      return this.students.length;
    },
    scoreState: function() {
      if (this.score == 0) return null;
      else
        return (
          parseInt(this.score, 10) > this.currentScore &&
          parseInt(this.score, 10) >= this.requiredScore &&
          parseInt(this.score, 10) < 677
        );
    }
  },
  methods: {
    clearMessage() {
      this.show = false;
      this.msg = "";
    },
    getGroups() {
      this.clearMessage();
      axios
        .get(`/groups/${this.reservation}/examined`)
        .then(response => {
          this.groups = response.data;
          if (this.groups.length == 0)
            this.showAlert("This reservation doesn't have examined groups");
          // console.log(response.data);
        })
        .catch(errors => {});
    },
    getStudents() {
      axios
        .get("/students/" + this.group + "/failed")
        .then(response => {
          this.students = response.data;
        })
        .catch(errors => {});
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
      this.dismissCountDown = this.dismissSecs;
    },

    showDialog(student) {
      this.student = student;
      this.requiredScore = student.required_score;
      this.currentScore = student.score;
      this.score = student.score;
      this.st_name = student.english_name;
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
      bvModalEvt.preventDefault();
      // Trigger submit handler
      this.handleSubmit();
    },
    handleSubmit() {
      // Exit when the form isn't valid
      if (!this.scoreState) {
        return;
      }
      // Push the name to submitted names
      this.sendMarksChange();
      // Hide the modal manually
      this.$nextTick(() => {
        this.$refs.modal.hide();
      });
    },
    sendMarksChange() {
      axios
        .patch("/students/marks", {
          id: this.student.ID,
          score: this.score
        })
        .then(response => {
          if (response.data.success) {
            var index = this.students.indexOf(this.student);
            if (index > -1) {
              this.students.splice(index, 1);
            }
            this.showAlert("Successfully Updated", "success");
          } else {
            this.showAlert(
              "Something happened when updating . Please call Support"
            );
          }
        })
        .catch(function(error) {
          this.showAlert(
            "Something happened when updating . Please call Support"
          );
          console.log(error);
        });
    }
  }
};
</script>
