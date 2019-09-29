<template>
  <div class="container section">
    <div class="form">
      <label>Discount Value</label>
      <div style="display:flex;align-items:center">
        <input v-model="disc" style="width: 100px;text-align:center" type="text" min="0" max="100" />
        <button style="width:100px;margin-left: 20px" class="btn" @click="saveDisc">Save</button>
      </div>
    </div>

    <div style="display:flex;justify-content:space-between;align-items:center">
      <p>Booking forms</p>

      <button class="btn" @click="logout">Log out</button>
    </div>

    <table>
      <thead>
        <th>ID</th>
        <th>Transaction ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Travellers</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Flight Info</th>
        <th>Timestamp</th>
        <th>Delete</th>
      </thead>
      <tbody>
        <tr v-for="p in data" :key="p.id">
          <td>{{p.id}}</td>
          <td>{{p.transaction_id}}</td>
          <td>{{p.traveller_info[0].first_name}}</td>
          <td>{{p.traveller_info[0].last_name}}</td>
          <td>{{p.traveller_info.length}}</td>
          <td>{{p.phone}}</td>
          <td>{{p.email}}</td>
          <td>{{p.flight_data['origin']}} -- {{p.flight_data['destination']}}</td>
          <td>{{p.timestamp}}</td>
          <td>
            <button @click="deleteData(p.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <p>Contact us forms</p>

    <table>
      <thead>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Subject</th>
        <th>Message</th>
        <th>Timestamp</th>
        <th>Delete</th>
      </thead>
      <tbody>
        <tr v-for="p in contact" :key="p.id">
          <td>{{p.id}}</td>
          <td>{{p.first_name}}</td>
          <td>{{p.last_name}}</td>
          <td>{{p.phone}}</td>
          <td>{{p.email}}</td>
          <td>{{p.subject}}</td>
          <td>{{p.message}}</td>
          <td>{{p.timestamp}}</td>
          <td>
            <button @click="deleteData1(p.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from "axios";
axios.defaults.withCredentials = false;

export default {
  data: () => ({
    data: [],
    contact: [],
    disc: 0
  }),

  mounted() {
    this.checkSession();
  },

  methods: {
    checkSession: function() {
      axios({
        method: "GET",
        url:
          "https://www.cheapairhub.com/api/api.php?checkSession=checkSession&token=" +
          localStorage.getItem("random"),
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        }
      })
        .then(res => {
          console.log("res", res);

          if (res.data.code == 200) {
            this.getData();
            this.contactData();
            this.sendDisc()
          } else {
            this.$router.push("/login");
          }
        })
        .catch(err => {
          console.log("error in request1", err.response.data.message);
        });
    },
    getData: function() {
      axios({
        method: "GET",
        url: "https://www.cheapairhub.com/api/api.php?getData=getData",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        }
      })
        .then(res => {
          console.log("res", res);
          this.data = res.data;
        })
        .catch(err => {
          console.log("error in request1", err.response.data.message);
        });
    },
    contactData: function() {
      axios({
        method: "GET",
        url:
          "https://www.cheapairhub.com/api/api.php?getDataContact=getDataContact",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        }
      })
        .then(res => {
          console.log("res", res);
          this.contact = res.data;
        })
        .catch(err => {
          console.log("error in request1", err.response.data.message);
        });
    },
    deleteData: function(e) {
      axios({
        method: "POST",
        url:
          "https://www.cheapairhub.com/api/api.php?sendformDelete=sendformDelete&id=" +
          e +
          "&token=" +
          localStorage.getItem("random"),
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        }
      })
        .then(res => {
          console.log("res", res);
          this.getData();
        })
        .catch(err => {
          console.log("error in request1", err.response.data.message);
        });
    },
    saveDisc: function(e) {
      axios({
        method: "POST",
        url:
          "https://www.cheapairhub.com/api/api.php?saveDisc=saveDisc&id=" +
  
          "&discount=" +
          this.disc,
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        }
      })
        .then(res => {
          console.log("res", res);
          alert("Discount % changed successfully")
        })
        .catch(err => {
          console.log("error in request1", err.response.data.message);
        });
    },
    sendDisc: function(e) {
      axios({
        method: "GET",
        url:
          "https://www.cheapairhub.com/api/api.php?sendDisc=sendDisc",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        }
      })
        .then(res => {
          console.log("res", res);
          this.disc = res.data.discount
        })
        .catch(err => {
          console.log("error in request1", err.response.data.message);
        });
    },
    logout: function(e) {
      localStorage.removeItem("random");
      this.$router.push("/login");
    },
    deleteData1: function(e) {
      axios({
        method: "POST",
        url:
          "https://www.cheapairhub.com/api/api.php?contactDelete=contactDelete&id=" +
          e +
          "&token=" +
          localStorage.getItem("random"),
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        }
      })
        .then(res => {
          console.log("res", res);
          this.contactData();
        })
        .catch(err => {
          console.log("error in request1", err.response.data.message);
        });
    }
  }
};
</script>


  <style>
table {
  border-collapse: collapse;
  width: 100%;
  text-align: center;
}
th {
  background: #f5f5f5;
}

th,
td {
  border: 1px solid #000;
  padding: 8px;
}

tr:nth-child(even) {
  background: #efefef;
}

tr:hover {
  background: #d1d1d1;
}

.btn {
  text-decoration: none;
  color: #fff;
  background-color: #f37638;
  text-align: center;
  letter-spacing: 0.5px;
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
}
</style>