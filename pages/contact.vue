<template>
  <div>
    <div class="container section">
      <div class="container">
        <div class="text-detailpage xs-padd-0">
          <h2 class="head-deatilpage">Contact Us</h2>
          <div class="row body-contact">
            <div class="detail-info col l12 m24 m24">
              <h4
                style="font-size:18px;padding-top:20px"
              >CheapAirHub subsidiary Of Fx Trade Consulting Private Limited</h4>
              <p><span style="font-weight:bold">Address :</span>Suit 36, Unit 1701, Express Trade Tower-5,
                7thFloor, Sector-132,
                Noida UP 201301</p>
              <p><span style="font-weight:bold">Phone Number :</span> +91 0120-4203761</p>
              <p><span style="font-weight:bold">Email : </span>support@cheapairhub.com</p>
              <p><span style="font-weight:bold">Customer Service Number</span> <span>Toll Free :</span> 1888-220-3565</p>
              <p
                v-if="form_submitted"
                style="color:green"
              >Your query has been received. We will get back to you soon.</p>
            </div>
            <!-- <hr /> -->
            <div class="fill-info col l12 m24 m24">
              <form id="SendEmailMessageForm">
                <div class="form-group">
                  <div class="row">
                    <div class="col s24 m12 firstname">
                      <label>First Name</label>
                      <input
                        type="text"
                        placeholder="First Name"
                        id="first_name"
                        name="FirstName"
                        class="form-control required _ar_hide_"
                        _ar_hide_="width:540px;height:34px;margin:0px;position:static;display:block;"
                      />
                    </div>
                    <div class="col s24 m12">
                      <label>Last Name</label>
                      <input
                        type="text"
                        placeholder="Last Name"
                        id="last_name"
                        name="LastName"
                        class="form-control required _ar_hide_"
                        _ar_hide_="width:540px;height:34px;margin:0px;position:static;display:block;"
                      />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col s24 firstname">
                      <label>Email</label>
                      <input
                        type="text"
                        placeholder="Email"
                        id="email"
                        name="FirstName"
                        class="form-control required _ar_hide_"
                        _ar_hide_="width:540px;height:34px;margin:0px;position:static;display:block;"
                      />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col s24 firstname">
                      <label>Phone Number</label>
                      <input
                        type="text"
                        placeholder="Phone Number"
                        id="phone"
                        name="phone"
                        class="form-control required _ar_hide_"
                        _ar_hide_="width:540px;height:34px;margin:0px;position:static;display:block;"
                      />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col s24 firstname">
                      <label>Subject</label>
                      <input
                        type="text"
                        placeholder="Subject"
                        id="subject"
                        name="FirstName"
                        class="form-control required _ar_hide_"
                        _ar_hide_="width:540px;height:34px;margin:0px;position:static;display:block;"
                      />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col s24 firstname">
                      <label>Message</label>
                      <textarea placeholder="message" id="message"></textarea>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="footer-contact text-right">
            <p id="send-msg-msg" class></p>
            <button
              class="btn btn-default"
              @click="sendContact"
              id="send-email-to-support"
              type="submit"
            >SEND MESSAGE</button>
            <button type="button" @click="reset" class="btn btn-default" data-dismiss="modal">Clear</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import axios from "axios";
axios.defaults.withCredentials = false;

export default {
  data: () => ({
    form_submitted: false
  }),

  methods: {
    reset: function() {
      $("input").val("");
      $("textarea").val("");
    },
    sendContact: function() {
      var bodyFormData = new FormData();

      bodyFormData.append("first_name", $("#first_name").val());
      bodyFormData.append("last_name", $("#last_name").val());
      bodyFormData.append("email", $("#email").val());
      bodyFormData.append("phone", $("#phone").val());
      bodyFormData.append("subject", $("#subject").val());
      bodyFormData.append("message", $("#message").val());

      axios({
        method: "POST",
        data: bodyFormData,
        url:
          "https://www.cheapairhub.com/api/api.php?sendformContact=sendformContact",

        headers: {
          "Access-Control-Allow-Origin": "*"
        }
      })
        .then(res => {
          console.log(res);

          this.form_submitted = true;
        })
        .catch(err => {
          console.log("error in request1", err);
        });
    }
  }
};
</script>

<style scoped>
input {
  width: 100%;
}

.fill-info {
  padding-top: 20px;
}

textarea {
  outline: 0;
  border: 1px solid #e8e8e8;
  padding: 10px;
  border-radius: 2px;
  width: 100%;
  resize: vertical;
  height: 130px;
}

.btn {
  text-decoration: none;
  color: #fff;
  background-color: #f37638;
  text-align: center;
  letter-spacing: 0.5px;
  -webkit-transition: background-color 0.2s ease-out;
  transition: background-color 0.2s ease-out;
  cursor: pointer;
  margin: 10px 0;
  border: none;
  border-radius: 2px;
  display: inline-block;
  height: 36px;
  line-height: 36px;
  padding: 0 16px;
  text-transform: uppercase;
  vertical-align: middle;
  -webkit-tap-highlight-color: transparent;
  font-size: 12px;
}

.detail-info {
  line-height: 30px;
  padding-bottom: 5px;
}

.detail-info p{
      white-space: pre-line;
      padding-top: 10px
}

hr {
  border: 0;
  border-top: 1px solid #f1f1f1;
}

.text-right {
  text-align: right;
}
</style>