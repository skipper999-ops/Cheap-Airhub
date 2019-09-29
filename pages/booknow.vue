<template>
  <div class="container section">
    <div class="section">
      <h3 style="padding:0 0.75rem 16px">Booking Form</h3>
      <div class="row">
        <div class="col s24 m12 l16">
          <div
            style="background-color: #a21e23;border-radius: 5px 5px 0 0;padding: 8px 15px;overflow: hidden;"
          >
            <p style="color:white;">Traveler Detail</p>
          </div>

          <div class="row traveller" style="border:1px solid #ededed">
            <div class="col s24" v-for="(p , index) in total" :key="p.id">
              <div class="form">
                <p style="font-weight:bold;color:#a21e23">Traveller {{index + 1}}</p>
              </div>
              <div class="form">
                <label>First Name</label>
                <input :id="'first_name-' + index" type="text" />
              </div>
              <div class="form">
                <label>Last Name</label>
                <input :id="'last_name-' + index" type="text" />
              </div>
              <div class="form">
                <label>Date of Birth</label>
                <div class="input-form-add select-dateofbirth">
                  <select
                    class="form-control dateofbirth required _ar_hide_ valid"
                    data-val="true"
                    data-val-number="The field Day must be a number."
                    data-val-required="The Day field is required."
                    :id="'b_date-' + index"
                    name="passenger.BirthDate.Day"
                    aria-required="true"
                    _ar_hide_="width:119.766px;height:34px;margin:0px 0px 15px;position:static;display:block;"
                    aria-invalid="false"
                  >
                    <option value>Day</option>
                    <option selected="selected" value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                    <option value="31">31</option>
                  </select>

                  <select
                    class="form-control dateofbirth required _ar_hide_ valid"
                    data-val="true"
                    data-val-number="The field Month must be a number."
                    data-val-required="The Month field is required."
                    :id="'b_month-' + index"
                    name="passenger.BirthDate.Month"
                    aria-required="true"
                    _ar_hide_="width:119.766px;height:34px;margin:0px 0px 15px;position:static;display:block;"
                    aria-invalid="false"
                  >
                    <option value>Month</option>
                    <option selected="selected" value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                  </select>

                  <select
                    class="form-control dateofbirth required _ar_hide_"
                    data-val="true"
                    data-val-number="The field Year must be a number."
                    data-val-required="The Year field is required."
                    :id="'b_year-' + index"
                    name="passenger.BirthDate.Year"
                    aria-required="true"
                    _ar_hide_="width:119.766px;height:34px;margin:0px 0px 15px;position:static;display:block;"
                  >
                    <option value="2007">2007</option>
                    <option value="2006">2006</option>
                    <option value="2005">2005</option>
                    <option value="2004">2004</option>
                    <option value="2003">2003</option>
                    <option value="2002">2002</option>
                    <option value="2001">2001</option>
                    <option value="2000">2000</option>
                    <option value="1999">1999</option>
                    <option value="1998">1998</option>
                    <option value="1997">1997</option>
                    <option value="1996">1996</option>
                    <option value="1995">1995</option>
                    <option value="1994">1994</option>
                    <option value="1993">1993</option>
                    <option value="1992">1992</option>
                    <option value="1991">1991</option>
                    <option value="1990">1990</option>
                    <option value="1989">1989</option>
                    <option value="1988">1988</option>
                    <option value="1987">1987</option>
                    <option value="1986">1986</option>
                    <option value="1985">1985</option>
                    <option value="1984">1984</option>
                    <option value="1983">1983</option>
                    <option value="1982">1982</option>
                    <option value="1981">1981</option>
                    <option value="1980">1980</option>
                    <option value="1979">1979</option>
                    <option value="1978">1978</option>
                    <option value="1977">1977</option>
                    <option value="1976">1976</option>
                    <option value="1975">1975</option>
                    <option value="1974">1974</option>
                    <option value="1973">1973</option>
                    <option value="1972">1972</option>
                    <option value="1971">1971</option>
                    <option value="1970">1970</option>
                    <option value="1969">1969</option>
                    <option value="1968">1968</option>
                    <option value="1967">1967</option>
                    <option value="1966">1966</option>
                    <option value="1965">1965</option>
                    <option value="1964">1964</option>
                    <option value="1963">1963</option>
                    <option value="1962">1962</option>
                    <option value="1961">1961</option>
                    <option value="1960">1960</option>
                    <option value="1959">1959</option>
                    <option value="1958">1958</option>
                    <option value="1957">1957</option>
                    <option value="1956">1956</option>
                    <option value="1955">1955</option>
                    <option value="1954">1954</option>
                    <option value="1953">1953</option>
                    <option value="1952">1952</option>
                    <option value="1951">1951</option>
                    <option value="1950">1950</option>
                    <option value="1949">1949</option>
                    <option value="1948">1948</option>
                    <option value="1947">1947</option>
                    <option value="1946">1946</option>
                    <option value="1945">1945</option>
                    <option value="1944">1944</option>
                    <option value="1943">1943</option>
                    <option value="1942">1942</option>
                    <option value="1941">1941</option>
                    <option value="1940">1940</option>
                    <option value="1939">1939</option>
                    <option value="1938">1938</option>
                    <option value="1937">1937</option>
                    <option value="1936">1936</option>
                    <option value="1935">1935</option>
                    <option value="1934">1934</option>
                    <option value="1933">1933</option>
                    <option value="1932">1932</option>
                    <option value="1931">1931</option>
                    <option value="1930">1930</option>
                    <option value="1929">1929</option>
                    <option value="1928">1928</option>
                    <option value="1927">1927</option>
                    <option value="1926">1926</option>
                    <option value="1925">1925</option>
                    <option value="1924">1924</option>
                    <option value="1923">1923</option>
                    <option value="1922">1922</option>
                    <option value="1921">1921</option>
                    <option value="1920">1920</option>
                    <option value="1919">1919</option>
                    <option value="1918">1918</option>
                    <option value="1917">1917</option>
                    <option value="1916">1916</option>
                    <option value="1915">1915</option>
                    <option value="1914">1914</option>
                    <option value="1913">1913</option>
                    <option value="1912">1912</option>
                    <option value="1911">1911</option>
                    <option value="1910">1910</option>
                    <option value="1909">1909</option>
                    <option value="1908">1908</option>
                    <option value="1907">1907</option>
                  </select>
                </div>
              </div>
              <div class="form">
                <label>Gender</label>
                <select :id="'gender-' + index">
                  <option value="1">Male</option>
                  <option value="2">Female</option>
                  <option value="3">Other</option>
                </select>
              </div>
            </div>
            <div class="col s24" style="padding-bottom: 20px">
              <div class="form">
                <p style="font-weight:bold;color:#a21e23">General Information</p>
              </div>
              <div class="form">
                <label>Email</label>
                <input id="email" type="text" />
              </div>
              <div class="form">
                <label>Country</label>
                <select id="country_select" v-model="country_id" @change="getState">
                  <option
                    v-bind:value="p.countryID"
                    v-for="p in countryList"
                    :key="p.id"
                  >{{p.countryName}}</option>
                </select>
              </div>
              <div class="form">
                <label>State</label>
                <select id="state_select" v-model="state_id">
                  <option
                    v-bind:value="p.stateID"
                    v-for="p in stateList"
                    :key="p.id"
                  >{{p.stateName}}</option>
                </select>
              </div>
              <div class="form">
                <label>Address</label>
                <input id="address" type="text" />
              </div>
              <div class="form">
                <label>City</label>
                <input id="city" type="text" />
              </div>

              <div class="form">
                <label>ZIP</label>
                <input id="zip" type="text" />
              </div>
              <div class="form">
                <label>Phone</label>
                <input id="phone" type="text" />
              </div>
              <div class="form">
                <button class="btn-sub" @click="submitForm">SUBMIT</button>
              </div>
            </div>
          </div>
        </div>
        <div class="col s24 m12 l8">
          <div
            style="background-color: #a21e23;border-radius: 5px 5px 0 0;padding: 8px 15px;overflow: hidden;"
          >
            <p style="color:white;">Flight Summary Detail</p>
          </div>

          <div class="row" style="border:1px solid #ededed">
            <div class="col s24" style="padding-bottom:20px;padding:10px">
              <p class="city-des-tra-lca payment-pri">
                {{ori}}, {{from_airport}}, {{to_airport}}
                <span>|</span>
                {{total}} Passenger(s)
                <span>|</span>
                <span v-if="flight_data.isRound == 0">Oneway</span>
                <span v-if="flight_data.isRound == 1">Round Trip</span>
                <span>|</span>
                {{travel_class}}
              </p>
            </div>
          </div>

          <div
            style="background-color: #a21e23;border-radius: 5px 5px 0 0;padding: 8px 15px;overflow: hidden;"
          >
            <p style="color:white;">Price</p>
          </div>

          <div class="row" style="border:1px solid #ededed">
            <div style="display:flex; justify-content:space-between;padding:10px">
              <div style="text-align:center">
                <p>Price</p>
              </div>
              <div style="text-align:center">
                <p style="font-weight:bold">{{flight_data.price}}</p>
              </div>
            </div>
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
    countryList: "",
    stateList: "",
    flight_data: [],
    des: "",
    ori: "",
    total: 0,
    from_airport: "",
    to_airport: "",
    country_id: 101,
    state_id: 0,
    gender: 1,
    travel_class: "",
    traveller_count: 0
  }),

  mounted() {
    this.getCountry();
    this.getState();

    this.flight_data = JSON.parse(localStorage.getItem("flight_data"));
    this.ori = localStorage.getItem("from_des");
    this.des = localStorage.getItem("to_arr");
    this.from_airport = localStorage.getItem("from_airport");
    this.to_airport = localStorage.getItem("to_airport");
    this.travel_class = localStorage.getItem("travel_class");
    this.total =
      parseInt(localStorage.getItem("adult")) +
      parseInt(localStorage.getItem("children")) +
      parseInt(localStorage.getItem("infants"));
  },

  methods: {
    getCountry: function() {
      axios({
        method: "GET",
        url:
          "https://www.cheapairhub.com/api/api.php?getCountries=getCountries",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        data:
          "client_id=i5t5vHAMFeApnN7kGNlV5zabRd8BxvcZ&client_secret=qzGD0OTlANAChgXs&grant_type=client_credentials"
      })
        .then(res => {
          console.log("res", res);
          this.countryList = res.data;
        })
        .catch(err => {
          console.log("error in request1", err.response.data.message);
        });
    },

    getState: function() {
      axios({
        method: "GET",
        url:
          "https://www.cheapairhub.com/api/api.php?getStates=getStates&country_id=" +
          this.country_id,
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        data:
          "client_id=i5t5vHAMFeApnN7kGNlV5zabRd8BxvcZ&client_secret=qzGD0OTlANAChgXs&grant_type=client_credentials"
      })
        .then(res => {
          console.log("res", res);
          this.stateList = res.data;
          console.log(this.stateList[0].stateID);
          this.state_id = this.stateList[0].stateID;
        })
        .catch(err => {
          console.log("error in request1", err.response.data.message);
        });
    },
    submitForm: function() {
      var bodyFormData = new FormData();

      var travellers = [];

      for (var i = 0; i < this.total; i++) {
        var temp = {};

        temp.first_name = $("#first_name-" + i).val();
        temp.last_name = $("#last_name-" + i).val();
        temp.b_day =
          $("#b_date-" + i).val() +
          "-" +
          $("#b_month-" + i).val() +
          "-" +
          $("#b_year-" + i).val();
        temp.gender = $("#gender-" + i + " option:selected").html();

        travellers.push(temp);
      }

      console.log(travellers);

      bodyFormData.append("traveller_info", JSON.stringify(travellers));
      bodyFormData.append("phone", $("#phone").val());
      bodyFormData.append("city", $("#city").val());
      bodyFormData.append("zip", $("#zip").val());
      bodyFormData.append("email", $("#email").val());
      bodyFormData.append("address", $("#address").val());
      bodyFormData.append(
        "country",
        $("#country_select option:selected").html()
      );
      bodyFormData.append("state", $("#state_select option:selected").html());
      bodyFormData.append("formed_data", localStorage.getItem("flight_data"));

      axios({
        method: "POST",
        data: bodyFormData,
        url: "https://www.cheapairhub.com/api/api.php?sendform=sendform",

        headers: {
          "Access-Control-Allow-Origin": "*"
        }
      })
        .then(res => {
          console.log("res", res);
          console.log("Info Added");

          if (res.data.status == 200) {
            this.transaction_id = res.data.transaction_id;

            localStorage.setItem("transaction", this.transaction_id);

            $("#after-form").removeClass("hide");

            $("#form-container").addClass("hide");

            this.$router.push("/confirmation");
          }
        })
        .catch(err => {
          console.log("error in request1", err);
        });
    }
  }
};
</script>

<style scoped>
select {
  outline: 0;
  border: 1px solid #e8e8e8;
  padding: 10px;
  border-radius: 2px;
}

.container .row {
  margin-left: auto;
  margin-right: auto;
}

.btn-sub {
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

.traveller .col {
  border-bottom: 1px solid rgb(237, 237, 237);
  padding: 15px 20px 30px;
}
</style>