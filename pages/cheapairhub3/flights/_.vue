<template>
  <div>
    <div class="popup_form hide" id="form-container">
      <div class="form_body" style="padding-top:25px;max-width: 600px">
        <p
          @click="close_popup"
          style="position:absolute;right:10px;top:0;font-size:25px;cursor:pointer"
        >x</p>
        <div class="row">
          <div class="col s24">
            <nuxt-link to="/">
              <img
                src="~static/logo.png"
                style="height: 60px;width: 100%;object-fit: contain;padding:7px 0;object-position: center;"
              />
            </nuxt-link>
          </div>
          <div class="col s24">
            <h4 style="padding-bottom:20px">Fill up this form for the best offers</h4>
          </div>
          <div class="col s12">
            <div class="form">
              <label>First Name</label>
              <input id="first_name" type="text" placeholder="First Name" autocomplete="off" />
            </div>
          </div>
          <div class="col s12">
            <div class="form">
              <label>last Name</label>
              <input id="last_name" type="text" placeholder="Last Name" autocomplete="off" />
            </div>
          </div>
          <div class="col s12">
            <div class="form">
              <label>Email</label>
              <input id="email" type="email" autocomplete="off" placeholder="Email Address" />
            </div>
          </div>
          <div class="col s12">
            <div class="form">
              <label>Phone Number</label>
              <input id="phone" type="text" autocomplete="off" placeholder="Phone Number" />
            </div>
          </div>
          <div class="col s24">
            <div style="display: flex; justify-content: flex-end;margin-top:25px">
              <button class="btn" type="submit" @click="submitForm">Submit</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="popup_form hide" id="after-form">
      <div class="form_body" style="padding:30px">
        <p
          @click="close_popup_after"
          style="position:absolute;right:10px;top:0;font-size:25px;cursor:pointer"
        >x</p>
        <div class="row">
          <div class="col s24">
            <h4 style="padding-bottom:10px">Please save the transaction ID for future reference</h4>
            <p style="padding-bottom:10px">
              Transaction ID:
              <span style="color:black;font-weight:bold">{{ transaction_id }}</span>
            </p>
            <p
              style="padding-bottom:10px"
            >Call the below Toll free Number to confirm your booking at the lowest fare</p>
            <p style="color:black;font-weight:bold">1844 842 9401</p>
          </div>
        </div>
      </div>
    </div>

    <div class style="background-color:#673AB7">
      <div
        class="container"
        style="display: flex;align-items: center;justify-content: center;height: 100%;"
      >
        <div>
          <div class="card flight_search">
            <div style="display: flex;align-items: center;margin-left: -10px;">
              <p>
                <input
                  type="radio"
                  id="test1"
                  name="radio-group"
                  value="oneway"
                  checked
                  v-model="picked"
                />
                <label for="test1">ONEWAY</label>
              </p>
              <p>
                <input
                  type="radio"
                  id="test2"
                  name="radio-group"
                  value="roundtrip"
                  v-model="picked"
                />
                <label for="test2">ROUND TRIP</label>
              </p>
            </div>

            <p class="error-class"></p>

            <div class="row" style="box-shadow:0px 9px 13px 0px #1a1a1a52">
              <div class="col s24 m12 l6 makemytrip-border">
                <div class="form">
                  <label>FROM</label>
                  <input
                    id="from_des"
                    @keydown="clearCountdown"
                    @keyup="startCountdown"
                    type="text"
                    class="location"
                    autocomplete="off"
                    placeholder="From"
                  />
                  <p class="from_airport hide clamp1 airportName"></p>
                  <input type="hidden" id="from_iata" value />
                  <div class="dropdown des hide">
                    <ul v-if="airportDepListError == false">
                      <li
                        v-for="p in airportList"
                        :key="p.id"
                        class="airport_select"
                        :id="'airport_dep-' + p.id"
                        @click="selectDep(p.id)"
                      >
                        <div style="display:flex;flex-direction:column;margin-bottom: 10px">
                          <div>{{ p.municipality }},{{ p.iso_country }}</div>
                          <div style="font-size:12px;line-height:12px;color:#666">{{ p.name }}</div>
                        </div>
                      </li>
                    </ul>
                    <ul v-if="airportDepListError == true">
                      <li>
                        <p>No Airport Info found</p>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>

              <div class="col s24 m12 l6 makemytrip-border">
                <div class="form">
                  <label>To</label>
                  <input
                    id="to_arr"
                    @keydown="clearCountdown_to"
                    @keyup="startCountdownArr"
                    type="text"
                    class="location"
                    autocomplete="off"
                    placeholder="Destination"
                  />
                  <p class="to_airport hide airportName clamp1"></p>
                  <input type="hidden" id="to_iata" value />
                  <div class="dropdown arr hide">
                    <ul v-if="airportArrListError == false">
                      <li
                        v-for="p in airportListArr"
                        :key="p.id"
                        class="airport_select"
                        :id="'airport_dep-' + p.id"
                        @click="selectArr(p.id)"
                      >
                        <div style="display:flex;flex-direction:column;margin-bottom: 10px">
                          <div>{{ p.municipality }},{{ p.iso_country }}</div>
                          <div style="font-size:12px;line-height:12px;color:#666">{{ p.name }}</div>
                        </div>
                      </li>
                    </ul>

                    <ul v-if="airportArrListError == true">
                      <li>
                        <p>No Airport Info found</p>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>

              <div class="col s12 m8 l4 makemytrip-border">
                <div class="form">
                  <label for="dep_date">
                    <span>Departure</span>
                    <p class="blackText font20" id="departure_date"></p>
                    <p class="departure_day"></p>
                    <input
                      type="text"
                      class="datepicker-here datepickerstyle location"
                      data-position="bottom left"
                      data-language="en"
                      data-date-format="DD,d,M,yyyy,dd,mm"
                      placeholder="Departure"
                      readonly="readonly"
                      id="dep_date"
                    />
                    <input type="hidden" id="dep_date_hidden" />
                  </label>
                </div>
              </div>
              <div
                v-bind:class="[ picked != 'roundtrip' ? 'roundtrip' : '']"
                class="col s12 m8 l4 makemytrip-border"
              >
                <div class="form">
                  <label for="ret_date">
                    <span>Return</span>
                    <p class="blackText font20" id="return_date"></p>
                    <p class="return_day"></p>
                    <input
                      :disabled="picked != 'roundtrip'"
                      type="text"
                      class="datepickerReturn datepickerstyle location"
                      data-position="bottom left"
                      data-language="en"
                      data-date-format="DD,d,M,yyyy,dd,mm"
                      placeholder="Return"
                      readonly="readonly"
                      id="ret_date"
                    />
                    <input type="hidden" id="ret_date_hidden" />
                  </label>
                </div>
              </div>
              <div class="col s24 m8 l4 makemytrip-border">
                <div class="form">
                  <label @click="showDetails">
                    <span>Travellers & Class</span>
                    <p class="font20 code">
                      <span class="appendRight10">
                        <span class="font30 latoBlack">{{traveller}}</span> Traveller
                      </span>
                    </p>

                    <p>{{travelClass}}</p>
                  </label>

                  <div
                    class="hide travel_details"
                    style="background-color: white;
    position: absolute;
    top: 88px;
    width: 256px;
    right: 0;
    z-index:99;
    box-shadow: 0 1px 6px 0 rgba(0,0,0,.2);
    padding: 14px"
                  >
                    <div class="row" style="margin-bottom:0">
                      <div class="col s24">
                        <div class="form">
                          <label>Adult</label>
                          <div class="drop-down drop-down_ui">
                            <div class="selected">
                              <p>
                                <span>Economy</span>
                                <span class="value">ECONOMY</span>
                              </p>
                            </div>
                            <div class="options">
                              <ul>
                                <li>
                                  <p>
                                    Economy
                                    <span class="value">ECONOMY</span>
                                  </p>
                                </li>
                                <li>
                                  <p>
                                    Business
                                    <span class="value">BUSINESS</span>
                                  </p>
                                </li>
                                <li>
                                  <p>
                                    First
                                    <span class="value">FIRST</span>
                                  </p>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col s8">
                        <div class="form">
                          <label>Adult</label>
                          <div class="drop-down1 drop-down_ui">
                            <div class="selected">
                              <p>
                                <span>1</span>
                                <span class="value">1</span>
                              </p>
                            </div>
                            <div class="options">
                              <ul>
                                <li>
                                  <p>
                                    1
                                    <span class="value">1</span>
                                  </p>
                                </li>
                                <li>
                                  <p>
                                    2
                                    <span class="value">2</span>
                                  </p>
                                </li>
                                <li>
                                  <p>
                                    3
                                    <span class="value">3</span>
                                  </p>
                                </li>
                                <li>
                                  <p>
                                    4
                                    <span class="value">4</span>
                                  </p>
                                </li>
                                <li>
                                  <p>
                                    5
                                    <span class="value">5</span>
                                  </p>
                                </li>
                                <li>
                                  <p>
                                    6
                                    <span class="value">6</span>
                                  </p>
                                </li>
                                <li>
                                  <p>
                                    7
                                    <span class="value">7</span>
                                  </p>
                                </li>
                                <li>
                                  <p>
                                    8
                                    <span class="value">8</span>
                                  </p>
                                </li>
                                <li>
                                  <p>
                                    9
                                    <span class="value">9</span>
                                  </p>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col s8">
                        <div class="form">
                          <label>Children</label>
                          <div class="drop-down2 drop-down_ui">
                            <div class="selected">
                              <p>
                                <span>0</span>
                                <span class="value">0</span>
                              </p>
                            </div>
                            <div class="options">
                              <ul>
                                <li>
                                  <p>
                                    0
                                    <span class="value">0</span>
                                  </p>
                                </li>
                                <li>
                                  <p>
                                    1
                                    <span class="value">1</span>
                                  </p>
                                </li>
                                <li>
                                  <p>
                                    2
                                    <span class="value">2</span>
                                  </p>
                                </li>
                                <li>
                                  <p>
                                    3
                                    <span class="value">3</span>
                                  </p>
                                </li>
                                <li>
                                  <p>
                                    4
                                    <span class="value">4</span>
                                  </p>
                                </li>
                                <li>
                                  <p>
                                    5
                                    <span class="value">5</span>
                                  </p>
                                </li>
                                <li>
                                  <p>
                                    6
                                    <span class="value">5</span>
                                  </p>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col s8">
                        <div class="form">
                          <label>Infants</label>
                          <div class="drop-down3 drop-down_ui">
                            <div class="selected">
                              <p>
                                <span>0</span>
                                <span class="value">0</span>
                              </p>
                            </div>
                            <div class="options">
                              <ul>
                                <li>
                                  <p>
                                    0
                                    <span class="value">0</span>
                                  </p>
                                </li>
                                <li>
                                  <p>
                                    1
                                    <span class="value">1</span>
                                  </p>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row" style="margin-bottom: 0; margin-top: 10px">
                      <div class="col s24">
                        <button type="button" @click="saveChanges" class="btn bold">Apply</button>
                      </div>
                    </div>
                  </div>

                  <!-- <select id="travel-class">
                <option>ECONOMY</option>
                <option>BUSINESS</option>
                  </select>-->
                  <!-- <div class="drop-down drop-down_ui">
                    <div class="selected">
                      <a href="#">
                        <span>Economy</span>
                        <span class="value">ECONOMY</span>
                      </a>
                    </div>
                    <div class="options">
                      <ul>
                        <li>
                          <a href="#">
                            Economy
                            <span class="value">ECONOMY</span>
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            Business
                            <span class="value">BUSINESS</span>
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            First
                            <span class="value">FIRST</span>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>-->
                </div>
              </div>
              <!-- 
          <div class="col l6">
            <button type="button" @click="submit" class="btn bold">Search</button>
              </div>-->

              <div class="col s24 l24 search_button" style="padding-top: 10px">
                <button type="button" @click="newSearch" class="btn bold">Search</button>
              </div>

              <!-- <div class="col s24 l24">
            <p>These are for testing purpose only</p>
          </div>
          <div class="col s24 l24">
            <div style="display: flex;align-items: center;">
              <p>
                <input
                  type="radio"
                  id="source"
                  name="radio-group1"
                  value="amadeus"
                  checked
                  v-model="source"
                />
                <label for="source">Amadeus</label>
              </p>
              <p>
                <input
                  type="radio"
                  id="source1"
                  name="radio-group1"
                  value="goibibo"
                  v-model="source"
                />
                <label for="source1">GoIbibo</label>
              </p>
            </div>
              </div>-->
            </div>

            <!-- <div style="border:1px solid #e8e8e8; border-radius: 5px; margin: 10px 0; padding: 10px 0">
				<input type="text">
			</div>
            -->
          </div>
        </div>
      </div>
    </div>


    <div class id="result_section" style="background-color: #f1f1f1;padding-top:30px">
      <div class="container section">
        <!-- <h3>Search Results</h3> -->

        <h3 style="text-align:center;color: red">Flat 30% Off on this Route. Only few tickets left. Calling this provider before booking is recommended.</h3>

        <div class="processing">
          <p style="text-align:center;padding-bottom: 20px">Fetching Data</p>
          <div class="loader" style="text-align:center">
            <svg
              class="spinner"
              width="35px"
              height="35px"
              viewBox="0 0 66 66"
              xmlns="http://www.w3.org/2000/svg"
            >
              <circle
                class="path"
                fill="none"
                stroke-width="6"
                stroke-linecap="round"
                cx="33"
                cy="33"
                r="30"
              />
            </svg>
          </div>
        </div>

        <div class="card hide" id="error_log">
          <p style="text-align:center;">No flight found</p>
        </div>

        <div class="row">
          <div class="col s24">
            <div id="amadeus">
              <div class="card oneseg" v-for="(p, index) in amadeus" :key="p.id">
                <div class="oneway">
                  <div class="flight_data row">
                                        <div class="flight_name  col s24  m12 l3">
                    <img
                      class="carrier_icon"
                      :src="
                        'https://www.amadeus.net/assets/img/static/airlines/medium/' +
                          p.carrier_icon +
                          '.png'
                      "
                    />
                    <p>{{ p.carrier_name }}</p>
                  </div>
                    <div class="flight_price col s24  m12 l4" style="text-align:center">
                      <h3 style="font-size:30px">
                        <span style="color:grey;font-size:12px">fr</span>
                        $ {{ p.price.toFixed(2) }}
                      </h3>
                      <p style="color:red;font-size:13px">Limited Time Offer*</p>
                    </div>
                    <div class="flight_departure_time col s12  m12 l4">
                      <div class="flight_origin">
                        <h5>{{ p.origin }}</h5>
                        <p class="clamp1" style="width: 130px;">{{ p.origin_fullname }}</p>
                      </div>
                      <p class="flight_departure">{{ p.dep_time }}</p>
                    </div>
                    <div class="extra_duration extar_flight_origin center col s12 m3">
                      <p style="font-size:11px;color:#b5b5b5">Flight Duration</p>
                      <h5>{{ p.duration }}</h5>
                      <p
                        v-if="p.seg.length - 1 > 0"
                        style="font-size: 11px;color: rgb(181, 181, 181);"
                      >{{ p.seg.length - 1 }} stop(s)</p>
                      <p
                        v-if="p.seg.length - 1 == 0"
                        style="font-size: 11px;color: rgb(181, 181, 181);"
                      >Non-stop</p>
                    </div>
                    <div class="flight_arrival_time col s12  m12 l4">
                      <div class="flight_origin">
                        <h5>{{ p.destination }}</h5>
                        <p class="clamp1" style="width: 130px;">{{ p.destination_fullname }}</p>
                      </div>
                      <p class="flight_arrival">{{ p.arr_time }}</p>
                    </div>

                    <div
                      class="flight_book col s24 m6"
                      style="display: flex;align-items: center;flex-direction:column;height: inherit;"
                    >
                      <p style="padding-left: 10px;line-height:25px;height:25px">Phone only offer</p>
                      <div style="display:flex;align-items:center">
                        <img
                          style="width: 50px;height: 100%;object-fit: contain;"
                          src="~static/call-now.gif"
                        />
                        <p style="font-size:25px;padding: 7px 15px;line-height:25px;height:25px">1844-842-9401</p>
                      </div>
                      <a
                        class="btn"
                        href="tel:18448429401"
                        style="color:white; text-decoration:none;margin-top: 20px"
                      >Call Now</a>
                    </div>
                  </div>
                </div>

                <hr v-if="p.isRound == 1" class="dashed-line" />

                <div class="return" v-if="p.isRound == 1">

                  <div class="flight_data row">
                                        <div class="flight_name col s24 m12 l3">
                    <img
                      class="carrier_icon"
                      :src="
                        'https://www.amadeus.net/assets/img/static/airlines/medium/' +
                          p.round_carrier_icon +
                          '.png'
                      "
                    />
                    <p>{{ p.round_carrier_name }}</p>
                  </div>
                    <div class="flight_price col s24  m12 l4">
                      <h3 style="font-size:30px">
                        <span style="color:grey;font-size:12px">fr</span>
                        $ {{ p.round_price.toFixed(2) }}
                      </h3>
                      <p style="color:red;font-size:13px">Limited Time Offer*</p>
                    </div>

                    <div class="flight_departure_time col s12  m12 l4">
                      <div class="flight_origin">
                        <h5>{{ p.round_origin }}</h5>
                        <p class="clamp1" style="width: 130px;">{{ p.round_origin_fullname }}</p>
                      </div>
                      <p class="flight_departure">{{ p.round_dep_time }}</p>
                    </div>
                    <div class="extra_duration extar_flight_origin center col s12 m3">
                      <p style="font-size:11px;color:#b5b5b5">Flight Duration</p>
                      <h5>{{ p.round_duration }}</h5>
                    </div>
                    <div class="flight_arrival_time col s12 m4">
                      <div class="flight_origin">
                        <h5>{{ p.round_destination }}</h5>
                        <p class="clamp1" style="width: 130px;">{{ p.round_destination_fullname }}</p>
                      </div>
                      <p class="flight_arrival">{{ p.round_arr_time }}</p>
                    </div>

                    <div class="flight_book col s12 m4">
                      <button type="button" style="opacity:0" class="btn">Book Now</button>
                    </div>
                  </div>
                </div>

                <div
                  style="display:flex;justify-content: space-between;padding-right:20px;padding-top: 20px"
                >
                  <div v-if="isInternationDep == 0">
                    <p
                      style="font-size:12px;font-style:italic;color:#515151;font-family:'Manjari'"
                    >Cabin: 7kg | Check-in: 15kg | Refundable</p>
                    <p style="font-size:12px;font-style:italic;color:#515151;font-family:'Manjari'">
                      Seems not found what you are looking for ? Call Now For Dirt Cheap Fares
                      <a
                        href="tel:1844 842 9401"
                      >1844-842-9401</a>
                    </p>
                  </div>
                  <div v-if="isInternationDep == 1">
                    <p
                      style="font-size:12px;font-style:italic;color:#515151;font-family:'Manjari'"
                    >Cabin: 7kg | Check-in: 25kg | Refundable</p>
                    <p style="font-size:12px;font-style:italic;color:#515151;font-family:'Manjari'">
                      Seems not found what you are looking for ? Call Now For Dirt Cheap Fares
                      <a
                        href="tel:1844 842 9401"
                      >1844-842-9401</a>
                    </p>
                  </div>
                  <p class="show_flight" @click="showDetail(index)">Flight Details</p>
                </div>

                <div class="flight_details hide" :id="'fd-' + index">
                  <div class="flight_details_border">
                    <div v-for="(q, qIndex) in amadeus[index].seg" :key="q.id">
                      <hr v-if="qIndex != 0" class="dashed-line" />
                      <div class="extra_flight_data row">
                        <div class="extra_flight_name col s12 m6">
                          <img
                            class="extra_carrier_icon"
                            :src="
                              'https://www.amadeus.net/assets/img/static/airlines/medium/' +
                                q.carrier_icon +
                                '.png'
                            "
                          />
                          <p>{{ q.carrier_name }}</p>
                          <p>{{ q.carrier_icon }} - {{ q.flight_number }}</p>
                        </div>
                        <div class="flight_departure_time col s12 m6">
                          <div class="extar_flight_origin">
                            <h5>{{ q.origin }}</h5>
                            <p class="extra_flight_departure">{{ q.dep_time }}</p>
                          </div>
                          <p class="extra_destination">{{ q.origin_fullname }}</p>
                        </div>
                        <div class="extra_duration extar_flight_origin center col s12 m6">
                          <p style="font-size:11px;color:#b5b5b5">Flight Duration</p>
                          <h5>{{ q.duration }}</h5>
                        </div>
                        <div class="flight_arrival_time col s12 m6">
                          <div class="f extar_flight_origin">
                            <h5>{{ q.destination }}</h5>
                            <p class="extra_flight_arrival">{{ q.arr_time }}</p>
                          </div>

                          <p class="extra_destination">{{ q.destination_fullname }}</p>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div v-if="p.isRound == 1" class="flight_details_border">
                    <div v-for="(q, qIndex) in amadeus[index].round_seg" :key="q.id">
                      <hr v-if="qIndex != 0" class="dashed-line" />
                      <div class="extra_flight_data row">
                        <div class="extra_flight_name col s12 m6">
                          <img
                            class="extra_carrier_icon"
                            :src="
                              'https://www.amadeus.net/assets/img/static/airlines/medium/' +
                                q.round_carrier_icon +
                                '.png'
                            "
                          />
                          <p>{{ q.round_carrier_name }}</p>
                          <p>
                            {{ q.round_carrier_icon }} -
                            {{ q.round_flight_number }}
                          </p>
                        </div>
                        <div class="flight_departure_time col s12 m6">
                          <div class="extar_flight_origin">
                            <h5>{{ q.round_origin }}</h5>
                            <p class="extra_flight_departure">{{ q.round_dep_time }}</p>
                          </div>
                          <p class="extra_destination">{{ q.round_origin_fullname }}</p>
                        </div>
                        <div class="extra_duration extar_flight_origin center col s12 m6">
                          <p style="font-size:11px;color:#b5b5b5">Flight Duration</p>
                          <h5>{{ q.round_duration }}</h5>
                        </div>
                        <div class="flight_arrival_time col s12 m6">
                          <div class="extar_flight_origin">
                            <h5>{{ q.round_destination }}</h5>
                            <p class="extra_flight_arrival">{{ q.round_arr_time }}</p>
                          </div>
                          <p class="extra_destination">{{ q.round_destination_fullname }}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col s12">
            <div id="loop_here"></div>
          </div>
          <div class="col s12">
            <div id="loop_hereRe"></div>
          </div>
          <div class="col s24">
            <div id="goibibo_internation">
              <!-- <div class="car">
              <div class="flight_name">
                <p>Aeroflot Russian Airlines</p>
                <p class="pl-5">SU - 103</p>
              </div>
              <div class="flight_data flex-between">
                <div class="flight_departure_time">
                  <div class="flex-center flight_origin">
                    <h5>JFK</h5>
                  </div>
                  <p class="flight_departure">19:20</p>
                </div>

                <div class="flight_duration">
                  <div class="flex-center flight_change">
                    <span>-</span>
                    <h5>SOV</h5>
                    <span>-</span>
                  </div>
                  <p class="flight_departure">22h 40m</p>
                </div>

                <div class="flight_arrival_time">
                  <div class="flex-center flight_origin">
                    <h5>DEL</h5>
                  </div>
                  <p class="flight_arrival">03:20</p>
                </div>
                <div class="flight_price">
                  <h3>₹63263</h3>
                </div>
                <div class="flight_book">
                  <button type="button" @click="submit" class="btn">Book Now</button>
                </div>
              </div>
              </div>-->
            </div>
          </div>
        </div>

        <!-- <div id="loop_here">
         <div class="card">
          <div class="flight_name">
            <p>Air India</p>
            <p class="pl-5">SG - 12345</p>
          </div>

          <div class="flight_data flex-between">
            <div class="flight_departure_time">v
              <div class="flex-center flight_origin">
                <h5>GAU</h5>
                <h5 class="pl-5">Guwahati, India</h5>
              </div>
              <p class="flight_departure">18:10</p>
            </div>
            <div class="flight_arrival_time">
              <div class="flex-center flight_origin">
                <h5>GAU</h5>
                <h5 class="pl-5">Hyderabad, India</h5>
              </div>
              <p class="flight_arrival">02:45</p>
            </div>
            <div class="flight_price">
              <h3>7000</h3>
            </div>
            <div class="flight_book">
              <button type="button" @click="submit" class="btn">Book Now</button>
            </div>
          </div>
        </div>
        </div>-->
        <p
          class
          style="font-size: 12px;
    color: #9f9f9f;"
        >*Offer valid for selected dates | Subject to Availability | Terms and Conditions Apply</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
axios.defaults.withCredentials = false;

export default {
  data: () => ({
    token: "https://api.amadeus.com/v1/security/oauth2/token",
    flight_search: "https://api.amadeus.com/v1/shopping/flight-offers?",
    flight_search_ibibo: "http://developer.goibibo.com/api/search/?",
    access_token: "",
    origin: "",
    destination: "",
    departureDate: "",
    nonStop: "",
    adults: 1,
    children: 0,
    infants: 0,
    currency: [],
    travelClass: [],
    airportList: [],
    airportListArr: [],
    typingTimer: 0,
    typingTimer_to: 0,
    picked: "roundtrip",
    disc: 0,
    source: "amadeus",
    isInternationDep: 0,
    isInternationArr: 0,
    // base_url: "http://localhost",
    base_url: "https://www.cheapairhub.com",
    amadeus: [],
    amadeusReturn: [],
    carrier_list: [],
    transaction_id: 0,
    airportDepListError: true,
    airportArrListError: true,
    formed_data: [],
    traveller: 1,
    isInternationDep: 0,
    travelClass: "Economy"
  }),

  mounted() {

        $(".telephone").attr("href" , '1844-944-4491')

    $(".telephone").html('1844-944-4491')


    console.log(this.$route.params.pathMatch)
      console.log(this.$route.query)

    var first_part = this.$route.params.pathMatch
    var second_part = this.$route.query


     var ori_ = first_part.split('/')[0]
     var des_ = first_part.split('/')[1]
     var start_date_ = first_part.split('/')[2]
     var end_date_ = first_part.split('/')[3]

    //  for (const [key, value] of Object.entries(second_part)) {

         
    //     console.log(key, value);
    
    
    // }



          localStorage.setItem("from", ori_);
          localStorage.setItem("to", des_);
          localStorage.setItem("departure", "20" + start_date_[0] + start_date_[1] + "-" + start_date_[2] + start_date_[3] + "-" + start_date_[4] + start_date_[5]);


            if(second_part.rtn == 1){
                localStorage.setItem("way", 'roundtrip');
                localStorage.setItem("return", "20" + end_date_[0] + end_date_[1] + "-" + end_date_[2] + end_date_[3] + "-" + end_date_[4] + end_date_[5]);
            }else if(second_part.rtn == 0){
                localStorage.setItem("way", 'oneway');
                localStorage.setItem("return", "20" + start_date_[0] + start_date_[1] + "-" + start_date_[2] + start_date_[3] + "-" + start_date_[4] + start_date_[5]);
            }


          localStorage.setItem("travel_class", second_part.cabinclass.toUpperCase());
          localStorage.setItem("adult", second_part.adults);
          localStorage.setItem("children", second_part.children);
          localStorage.setItem("infants", second_part.infants);
        //   localStorage.setItem("currency", second_part.currency);
        //   localStorage.setItem("nonStop", second_part.nonStop);


      axios({
        method: "GET",
        url: "https://www.cheapairhub.com/api/api.php?getAirport=getAirport&query=" + ori_,
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        }
      })
        .then(res => {
         console.log("resssssssssssssssssssssssss");
         console.log("res", res.data.name);
          
          localStorage.setItem("from_airport", res.data.iata_code + " , " + res.data.name);
          localStorage.setItem("from_des", res.data.municipality);

          console.log("sdsds")



      axios({
        method: "GET",
        url: "https://www.cheapairhub.com/api/api.php?getAirport=getAirport&query=" + des_,
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        }
      })
        .then(res => {
          console.log("res", res.data.name);
          
          localStorage.setItem("to_airport", res.data.iata_code + " , " + res.data.name);
          localStorage.setItem("to_arr", res.data.municipality);



    if (
      localStorage.getItem("from") != null &&
      localStorage.getItem("from") != "" &&
      (localStorage.getItem("to") != null && localStorage.getItem("to") != "")
    ) {
      $(".processing").removeClass("hide");

      $("#from_des").val(localStorage.getItem("from_des"));
      $("#from_iata").val(localStorage.getItem("from"));

      if (
        localStorage.getItem("isInternationDep") == "0" ||
        localStorage.getItem("isInternationDep") == "1"
      ) {
        this.isInternationDep = localStorage.getItem("isInternationDep");
      }

      this.picked = localStorage.getItem("way");

      $(".from_airport")
        .html(localStorage.getItem("from_airport"))
        .removeClass("hide");

      $("#to_arr").val(localStorage.getItem("to_arr"));
      $("#to_iata").val(localStorage.getItem("to"));
      $(".to_airport")
        .html(localStorage.getItem("to_airport"))
        .removeClass("hide");

      $(".drop-down .selected span")
        .eq(0)
        .html(localStorage.getItem("travel_class"));
      $(".drop-down .selected .value").html(
        localStorage.getItem("travel_class")
      );

      $(".drop-down1 .selected span")
        .eq(0)
        .html(localStorage.getItem("adult"));
      $(".drop-down1 .selected .value").html(localStorage.getItem("adult"));

      $(".drop-down2 .selected span")
        .eq(0)
        .html(localStorage.getItem("children"));
      $(".drop-down2 .selected .value").html(localStorage.getItem("children"));

      $(".drop-down3 .selected span")
        .eq(0)
        .html(localStorage.getItem("infants"));
      $(".drop-down3 .selected .value").html(localStorage.getItem("infants"));

      this.saveChanges();
    } else {
      $(".processing").addClass("hide");
    }



    var dp1 = $(".datepickerReturn")
      .datepicker({
        autoClose: true,
        onSelect: function onSelect(fd, date) {
          console.log(fd);

          var day = fd.split(",")[0];
          var _date = fd.split(",")[1];
          var month = fd.split(",")[2];
          var year = fd.split(",")[3];
          var date_0 = fd.split(",")[4];
          var month_0 = fd.split(",")[5];

          $("#return_date").empty();

          $("#ret_date_hidden").val(year + "-" + month_0 + "-" + date_0);

          var d1 = document.getElementById("return_date");
          d1.insertAdjacentHTML(
            "beforeend",
            '<span class="font30" style="padding-right:5px">' +
              _date +
              "</span><span  style='padding-right:5px'>" +
              month +
              '</span><span class="shortYear">' +
              year +
              "</span>"
          );

          $(".return_day").html(day);
        }
      })
      .data("datepicker");

    var dp = $(".datepicker-here")
      .datepicker({
        autoClose: true,
        minDate: new Date(),
        onSelect: function onSelect(fd, date) {
          console.log(fd);

          var day = fd.split(",")[0];
          var _date = fd.split(",")[1];
          var month = fd.split(",")[2];
          var year = fd.split(",")[3];
          var date_0 = fd.split(",")[4];
          var month_0 = fd.split(",")[5];

          $("#departure_date").empty();

          var d1 = document.getElementById("departure_date");
          d1.insertAdjacentHTML(
            "beforeend",
            '<span class="font30"  style="padding-right:5px">' +
              _date +
              "</span><span  style='padding-right:5px'>" +
              month +
              '</span><span class="shortYear">' +
              year +
              "</span>"
          );

          $("#dep_date_hidden").val(year + "-" + month_0 + "-" + date_0);

          $(".departure_day").html(day);

          $("#return_date").empty();

          var d1 = document.getElementById("return_date");
          d1.insertAdjacentHTML(
            "beforeend",
            '<span class="font30">' +
              _date +
              "</span><span>" +
              month +
              '</span><span class="shortYear">' +
              year +
              "</span>"
          );

          $(".return_day").html(day);

          dp1.selectDate(new Date(date));
          dp1.update("minDate", date);
        }
      })
      .data("datepicker");

    dp.selectDate(new Date(localStorage.getItem("departure")));
    dp1.selectDate(new Date(localStorage.getItem("return")));

    //TOGGLING NESTED ul
    $(".drop-down .selected p").click(function() {
      $(".drop-down .options ul").toggle();
    });

    //SELECT OPTIONS AND HIDE OPTION AFTER SELECTION
    $(".drop-down .options ul li p").click(function() {
      var text = $(this).html();
      $(".drop-down .selected p span").html(text);
      $(".drop-down .options ul").hide();
    });

    //HIDE OPTIONS IF CLICKED ANYWHERE ELSE ON PAGE
    $(document).bind("click", function(e) {
      var $clicked = $(e.target);
      if (!$clicked.parents().hasClass("drop-down"))
        $(".drop-down .options ul").hide();
    });

    //TOGGLING NESTED ul
    $(".drop-down1 .selected p").click(function() {
      $(".drop-down1 .options ul").toggle();
    });

    //SELECT OPTIONS AND HIDE OPTION AFTER SELECTION
    $(".drop-down1 .options ul li p").click(function() {
      var text = $(this).html();
      $(".drop-down1 .selected p span").html(text);
      $(".drop-down1 .options ul").hide();
    });

    //HIDE OPTIONS IF CLICKED ANYWHERE ELSE ON PAGE
    $(document).bind("click", function(e) {
      var $clicked = $(e.target);
      if (!$clicked.parents().hasClass("drop-down1"))
        $(".drop-down1 .options ul").hide();
    });

    //TOGGLING NESTED ul
    $(".drop-down2 .selected p").click(function() {
      $(".drop-down2 .options ul").toggle();
    });

    //SELECT OPTIONS AND HIDE OPTION AFTER SELECTION
    $(".drop-down2 .options ul li p").click(function() {
      var text = $(this).html();
      $(".drop-down2 .selected p span").html(text);
      $(".drop-down2 .options ul").hide();
    });

    //HIDE OPTIONS IF CLICKED ANYWHERE ELSE ON PAGE
    $(document).bind("click", function(e) {
      var $clicked = $(e.target);
      if (!$clicked.parents().hasClass("drop-down2"))
        $(".drop-down2 .options ul").hide();
    });

    //TOGGLING NESTED ul
    $(".drop-down3 .selected p").click(function() {
      $(".drop-down3 .options ul").toggle();
    });

    //SELECT OPTIONS AND HIDE OPTION AFTER SELECTION
    $(".drop-down3 .options ul li p").click(function() {
      var text = $(this).html();
      $(".drop-down3 .selected p span").html(text);
      $(".drop-down3 .options ul").hide();
    });

    //HIDE OPTIONS IF CLICKED ANYWHERE ELSE ON PAGE
    $(document).bind("click", function(e) {
      var $clicked = $(e.target);
      if (!$clicked.parents().hasClass("drop-down3"))
        $(".drop-down3 .options ul").hide();
    });

    //function init() here

    this.getToken();

        })
        .catch(err => {
          console.log("error in request1", err.response.data.message);
        });


        })
        .catch(err => {
          console.log("error in request1", err.response.data.message);
        });







    //  var dp = $(".datepicker-here").datepicker({
    //     autoClose: true,
    //     minDate: new Date()
    //   }).data("datepicker")

    //  var dp1 = $(".datepickerReturn").datepicker({
    //     autoClose: true,
    //     minDate: new Date()
    //   }).data("datepicker")

    //    dp.selectDate(new Date())
    //    dp.selectDate(new Date())

  },

  methods: {
    newSearch: function(){



        var newstring1 = $("#dep_date_hidden").val().substring(2).replace(/-/g, '')
        var newstring2 = $("#ret_date_hidden").val().substring(2).replace(/-/g, '')

      var rtn = 0
        if(this.picked == 'roundtrip'){
            rtn = 1
        }

        window.location.href = "/cheapairhub3/flights/" + $("#from_iata").val().toLowerCase()  + "/" + $("#to_iata").val().toLowerCase() + "/" + newstring1 + "/" + newstring2 + "/?adults=" + $(".drop-down1 .selected .value").html() + "&children=" + $(".drop-down2 .selected .value").html() + "&infants=" + $(".drop-down3 .selected .value").html() + "&cabinclass=" + $(".drop-down .selected .value").html() + "&rtn=" + rtn + "&utm_campaign=skyscanner" 
   
    },
    sendDisc: function(e) {
      axios({
        method: "GET",
        url: "https://www.cheapairhub.com/api/api.php?sendDisc=sendDisc",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        }
      })
        .then(res => {
          console.log("res", res);
          this.disc = parseInt(res.data.discount);
          this.submit();
        })
        .catch(err => {
          console.log("error in request1", err.response.data.message);
        });
    },
    onResize: function() {
      // $(".bg-image").height("100%");
    },
    getToken: function() {
      if ($("#from_iata").val() == "") {
        $(".error-class").html("Please select a valid origin airport");
      } else if ($("#to_iata").val() == "") {
        $(".error-class").html("Please select a valid destination airport");
      } else {
        axios({
          method: "POST",
          url: this.token,
          headers: {
            "Content-Type": "application/x-www-form-urlencoded"
          },
          data:
            "client_id=jDNcAANoXo8GtYAEK9B3wXeWIYGrSFm9&client_secret=cYMkUnsf4KUrx0u0&grant_type=client_credentials"
        })
          .then(res => {
            console.log("res", res);
            console.log("Token Generated");
            console.log(res.data.access_token);
            this.access_token = res.data.access_token;
            localStorage.setItem("access_token", res.data.access_token);

            this.sendDisc();
          })
          .catch(err => {
            console.log("error in request1", err.response.data.message);
          });

        // $.ajax({
        //   url: this.token,
        //   dataType: "json",
        //   type: "POST",
        //   data: {
        //     client_id: "i5t5vHAMFeApnN7kGNlV5zabRd8BxvcZ",
        //     client_secret: "qzGD0OTlANAChgXs",
        //     grant_type: "client_credentials"
        //   },
        //   success: function(data, status) {
        //     console.log("Token Generated");
        //     console.log(data.access_token);
        //     this.access_token = data.access_token;
        //   }
        // });
      }
    },

    //     radioClicked: function(){

    //  $('.datepicker-here').datepicker()

    //     },
    submit: function() {
      if ($("#from_iata").val() == "") {
        $(".error-class").html("Please select a valid origin airport");
      } else if ($("#to_iata").val() == "") {
        $(".error-class").html("Please select a valid destination airport");
      } else {
        $("#result_section").removeClass("hide");
        $(".processing").removeClass("hide");
        $("#amadeus").empty();
        $("#loop_here").empty();
        $("#loop_hereRe").empty();
        $("#goibibo_internation").empty();

        $("#error_log").addClass("hide");

        this.amadeus = [];

        if (this.source == "amadeus") {
          this.origin = $("#from_iata").val();
          this.destination = $("#to_iata").val();
          this.departureDate = $("#dep_date_hidden").val();
          this.returnDate = $("#ret_date_hidden").val();
          this.adults = $(".drop-down1 .selected .value").html();
          this.children = $(".drop-down2 .selected .value").html();
          this.infants = $(".drop-down3 .selected .value").html();
          this.nonStop = false;
          this.currency = "USD";
          this.travelClass = $(".drop-down .selected .value").html();

          console.log("Thjis si also");

        //   localStorage.setItem("from", this.origin);
        //   localStorage.setItem("to", this.destination);
        //   localStorage.setItem("departure", this.departureDate);
        //   localStorage.setItem("return", this.returnDate);
        //   localStorage.setItem("travel_class", this.travelClass);
        //   localStorage.setItem("adult", this.adults);
        //   localStorage.setItem("children", this.children);
        //   localStorage.setItem("infants", this.infants);
        //   localStorage.setItem("currency", this.currency);
        //   localStorage.setItem("nonStop", this.nonStop);

        //   localStorage.setItem("from_des", $("#from_des").val());
        //   localStorage.setItem("from_airport", $(".from_airport").html());

        //   localStorage.setItem("to_arr", $("#to_arr").val());
        //   localStorage.setItem("to_airport", $(".to_airport").html());

          var url = "";

          if (this.picked == "oneway") {
            url =
              this.flight_search +
              "origin=" +
              this.origin +
              "&destination=" +
              this.destination +
              "&departureDate=" +
              this.departureDate +
              "&adults=" +
              this.adults +
              "&children=" +
              this.children +
              "&infants=" +
              this.infants +
              "&nonStop=" +
              this.nonStop +
              "&currency=" +
              this.currency +
              "&travelClass=" +
              this.travelClass +
              "";
          } else {
            url =
              this.flight_search +
              "origin=" +
              this.origin +
              "&destination=" +
              this.destination +
              "&departureDate=" +
              this.departureDate +
              "&returnDate=" +
              this.returnDate +
              "&adults=" +
              this.adults +
              "&children=" +
              this.children +
              "&infants=" +
              this.infants +
              "&nonStop=" +
              this.nonStop +
              "&currency=" +
              this.currency +
              "&travelClass=" +
              this.travelClass +
              "";
          }

          axios({
            method: "GET",
            url: url,
            headers: {
              Authorization: "Bearer " + this.access_token
            }
          })
            .then(res => {
              console.log("res", res);

              var data = res.data;

              $(".processing").addClass("hide");

              // var data = JSON.parse(localStorage.getItem("data"));

              console.log(data.data);

              $("#amadeus").empty();
              $("#loop_here").empty();

              var currency_name = data.meta.currency;
              this.carrier_list = data.dictionaries.carriers;
              var places_list = data.dictionaries.locations;

              var symbol = "$";

              // switch (currency_name) {
              //   case "USD":
              //     symbol = "$";
              //     break;

              //   case "INR":
              //     symbol = "₹";
              //     break;
              // }

              data.data = this.getSortedData(data.data, 1);

              for (var i = 0; i < data.data.length; i++) {
                var temp = {};
                var seg = [];
                var round_seg = [];
                var duration = 0;
                var round_duration = 0;

                for (
                  var j = 0;
                  j < data.data[i].offerItems[0].services[0].segments.length;
                  j++
                ) {
                  var tmp = {};

                  tmp.carrier_name = this.capitalizeFirstLetter(
                    this.getJSONKeyValue(
                      this.carrier_list,
                      data.data[i].offerItems[0].services[0].segments[j]
                        .flightSegment.carrierCode
                    )
                  );

                  tmp.carrier_icon =
                    data.data[i].offerItems[0].services[0].segments[
                      j
                    ].flightSegment.carrierCode;

                  tmp.origin =
                    data.data[i].offerItems[0].services[0].segments[
                      j
                    ].flightSegment.departure.iataCode;

                  tmp.origin_fullname = this.capitalizeFirstLetter(
                    this.getJSONKeyValue(
                      places_list,
                      data.data[i].offerItems[0].services[0].segments[j]
                        .flightSegment.departure.iataCode
                    ).detailedName
                  );

                  var a = data.data[
                    i
                  ].offerItems[0].services[0].segments[
                    j
                  ].flightSegment.departure.at


                  var zone = " AM";

                  var b = a
                    .split("T")
                    ["1"].split("-")
                    ["0"].split(":");

                  if (b[0] > 12) {
                    b[0] = b[0] - 12;
                    if(b[0] < 10){
                      b[0] = "0" + b[0].toString()
                    }
                    zone = " PM"
                  }

                  tmp.dep_time = b.slice(0, 2).join(":") + zone







                  tmp.destination =
                    data.data[i].offerItems[0].services[0].segments[
                      j
                    ].flightSegment.arrival.iataCode;

                  tmp.destination_fullname = this.capitalizeFirstLetter(
                    this.getJSONKeyValue(
                      places_list,
                      data.data[i].offerItems[0].services[0].segments[j]
                        .flightSegment.arrival.iataCode
                    ).detailedName
                  );



                  var a = data.data[i].offerItems[0].services[0].segments[
                    j
                  ].flightSegment.arrival.at


                  var zone = " AM";

                  var b = a
                    .split("T")
                    ["1"].split("-")
                    ["0"].split(":");

                  if (b[0] > 12) {
                    b[0] = b[0] - 12;
                    if(b[0] < 10){
                      b[0] = "0" + b[0].toString()
                    }
                    zone = " PM"
                  }
                  tmp.arr_time = b.slice(0, 2).join(":") + zone


                  console.log(tmp.arr_time)

                  tmp.flight_number =
                    data.data[i].offerItems[0].services[0].segments[
                      j
                    ].flightSegment.number;

                  var temp_d =
                    data.data[i].offerItems[0].services[0].segments[j]
                      .flightSegment.duration;

                  var day = temp_d.split("DT")[0];

                  var hour = temp_d.split("DT")[1].split("H")[0];

                  var minute = temp_d
                    .split("DT")[1]
                    .split("H")[1]
                    .split("M")[0];

                  var seconds = day * 3600 * 24 + hour * 3600 + minute * 60;

                  duration = duration + seconds;

                  tmp.duration = this.seconds_to_date(seconds);

                  seg.push(tmp);
                }

                temp.duration = this.seconds_to_date(duration);

                temp.carrier_name = this.capitalizeFirstLetter(
                  this.getJSONKeyValue(
                    this.carrier_list,
                    data.data[i].offerItems[0].services[0].segments[
                      data.data[i].offerItems[0].services[0].segments.length - 1
                    ].flightSegment.carrierCode
                  )
                );

                temp.carrier_icon =
                  data.data[i].offerItems[0].services[0].segments[
                    data.data[i].offerItems[0].services[0].segments.length - 1
                  ].flightSegment.carrierCode;

                temp.origin =
                  data.data[
                    i
                  ].offerItems[0].services[0].segments[0].flightSegment.departure.iataCode;

                temp.origin_fullname = this.capitalizeFirstLetter(
                  this.getJSONKeyValue(
                    places_list,
                    data.data[i].offerItems[0].services[0].segments[0]
                      .flightSegment.departure.iataCode
                  ).detailedName
                );

               var a = data.data[
                  i
                ].offerItems[0].services[0].segments[0].flightSegment.departure.at


                                    var zone = " AM";

                  var b = a
                    .split("T")
                    ["1"].split("-")
                    ["0"].split(":");

                  if (b[0] > 12) {
                    b[0] = b[0] - 12;
                    if(b[0] < 10){
                      b[0] = "0" + b[0].toString()
                    }
                    zone = " PM"
                  }
                  
                  temp.dep_time = b.slice(0, 2).join(":") + zone





                temp.destination =
                  data.data[i].offerItems[0].services[0].segments[
                    data.data[i].offerItems[0].services[0].segments.length - 1
                  ].flightSegment.arrival.iataCode;

                temp.destination_fullname = this.capitalizeFirstLetter(
                  this.getJSONKeyValue(
                    places_list,
                    data.data[i].offerItems[0].services[0].segments[
                      data.data[i].offerItems[0].services[0].segments.length - 1
                    ].flightSegment.arrival.iataCode
                  ).detailedName
                );


                
                  var a = data.data[i].offerItems[0].services[0].segments[
                  data.data[i].offerItems[0].services[0].segments.length - 1
                ].flightSegment.arrival.at

                  var b = a
                    .split("T")
                    ["1"].split("-")
                    ["0"].split(":");

                  var zone = " AM";
                  
                  var b = a
                    .split("T")
                    ["1"].split("-")
                    ["0"].split(":");

                  if (b[0] > 12) {
                    b[0] = b[0] - 12;
                    if(b[0] < 10){
                      b[0] = "0" + b[0].toString()
                    }
                    zone = " PM"
                  }
                  temp.arr_time = b.slice(0, 2).join(":") + zone

                var a = data.data[i].offerItems[0].services[0].segments[
                  data.data[i].offerItems[0].services[0].segments.length - 1
                ].flightSegment.arrival.at


                
                  var zone = " AM";
                  
                  var b = a
                    .split("T")
                    ["1"].split("-")
                    ["0"].split(":");

                  if (b[0] > 12) {
                    b[0] = b[0] - 12;
                    if(b[0] < 10){
                      b[0] = "0" + b[0].toString()
                    }
                    zone = " PM"
                  }
                  temp.arr_time = b.slice(0, 2).join(":") + zone

                temp.price =
                  data.data[i].offerItems[0].price.total -
                  parseFloat(
                    (this.disc / 100) * data.data[i].offerItems[0].price.total
                  ).toFixed(2);

                temp.seg = seg;

                temp.isRound = 0;

                if (data.data[i].offerItems[0].services.length == 2) {
                  temp.isRound = 1;

                  for (
                    var j = 0;
                    j < data.data[i].offerItems[0].services[1].segments.length;
                    j++
                  ) {
                    var tmp = {};

                    tmp.round_carrier_name = this.capitalizeFirstLetter(
                      this.getJSONKeyValue(
                        this.carrier_list,
                        data.data[i].offerItems[0].services[1].segments[j]
                          .flightSegment.carrierCode
                      )
                    );

                    tmp.round_carrier_icon =
                      data.data[i].offerItems[0].services[1].segments[
                        j
                      ].flightSegment.carrierCode;

                    tmp.round_origin =
                      data.data[i].offerItems[0].services[1].segments[
                        j
                      ].flightSegment.departure.iataCode;

                    tmp.round_origin_fullname = this.capitalizeFirstLetter(
                      this.getJSONKeyValue(
                        places_list,
                        data.data[i].offerItems[0].services[1].segments[j]
                          .flightSegment.departure.iataCode
                      ).detailedName
                    );

                    var a = data.data[
                      i
                    ].offerItems[0].services[1].segments[
                      j
                    ].flightSegment.departure.at

                                                          var zone = " AM";

                  var b = a
                    .split("T")
                    ["1"].split("-")
                    ["0"].split(":");

                  if (b[0] > 12) {
                    b[0] = b[0] - 12;
                    if(b[0] < 10){
                      b[0] = "0" + b[0].toString()
                    }
                    zone = " PM"
                  }
                  
                  tmp.round_dep_time = b.slice(0, 2).join(":") + zone


                    tmp.round_destination =
                      data.data[i].offerItems[0].services[1].segments[
                        j
                      ].flightSegment.arrival.iataCode;

                    tmp.round_destination_fullname = this.capitalizeFirstLetter(
                      this.getJSONKeyValue(
                        places_list,
                        data.data[i].offerItems[0].services[1].segments[j]
                          .flightSegment.arrival.iataCode
                      ).detailedName
                    );


 
                  var a =  data.data[
                      i
                    ].offerItems[0].services[1].segments[
                      j
                    ].flightSegment.arrival.at

                  var zone = " AM";
                  
                  var b = a
                    .split("T")
                    ["1"].split("-")
                    ["0"].split(":");

                  if (b[0] > 12) {
                    b[0] = b[0] - 12;
                    if(b[0] < 10){
                      b[0] = "0" + b[0].toString()
                    }
                    zone = " PM"
                  }
                  tmp.arr_time = b.slice(0, 2).join(":") + zone





                    tmp.round_flight_number =
                      data.data[i].offerItems[0].services[1].segments[
                        j
                      ].flightSegment.number;

                    var temp_d =
                      data.data[i].offerItems[0].services[1].segments[j]
                        .flightSegment.duration;

                    var day = temp_d.split("DT")[0];

                    var hour = temp_d.split("DT")[1].split("H")[0];

                    var minute = temp_d
                      .split("DT")[1]
                      .split("H")[1]
                      .split("M")[0];

                    var seconds = day * 3600 * 24 + hour * 3600 + minute * 60;

                    round_duration = round_duration + seconds;

                    tmp.round_duration = this.seconds_to_date(seconds);

                    round_seg.push(tmp);
                  }

                  temp.round_duration = this.seconds_to_date(round_duration);

                  temp.round_carrier_name = this.capitalizeFirstLetter(
                    this.getJSONKeyValue(
                      this.carrier_list,
                      data.data[i].offerItems[0].services[1].segments[
                        data.data[i].offerItems[0].services[1].segments.length -
                          1
                      ].flightSegment.carrierCode
                    )
                  );

                  temp.round_carrier_icon =
                    data.data[i].offerItems[0].services[1].segments[
                      data.data[i].offerItems[0].services[1].segments.length - 1
                    ].flightSegment.carrierCode;

                  temp.round_origin =
                    data.data[
                      i
                    ].offerItems[0].services[1].segments[0].flightSegment.departure.iataCode;

                  temp.round_origin_fullname = this.capitalizeFirstLetter(
                    this.getJSONKeyValue(
                      places_list,
                      data.data[i].offerItems[0].services[1].segments[0]
                        .flightSegment.departure.iataCode
                    ).detailedName
                  );

                  var a = data.data[
                    i
                  ].offerItems[0].services[1].segments[0].flightSegment.departure.at


                    
                                                          var zone = " AM";

                  var b = a
                    .split("T")
                    ["1"].split("-")
                    ["0"].split(":");

                  if (b[0] > 12) {
                    b[0] = b[0] - 12;
                    if(b[0] < 10){
                      b[0] = "0" + b[0].toString()
                    }
                    zone = " PM"
                  }
                  
                  temp.round_dep_time = b.slice(0, 2).join(":") + zone
                    

                  temp.round_destination =
                    data.data[i].offerItems[0].services[1].segments[
                      data.data[i].offerItems[0].services[1].segments.length - 1
                    ].flightSegment.arrival.iataCode;

                  temp.round_destination_fullname = this.capitalizeFirstLetter(
                    this.getJSONKeyValue(
                      places_list,
                      data.data[i].offerItems[0].services[1].segments[
                        data.data[i].offerItems[0].services[1].segments.length -
                          1
                      ].flightSegment.arrival.iataCode
                    ).detailedName
                  );

                  temp.round_arr_time = data.data[
                    i
                  ].offerItems[0].services[1].segments[
                    data.data[i].offerItems[0].services[1].segments.length - 1
                  ].flightSegment.arrival.at


                  
                  var zone = " AM";
                  
                  var b = a
                    .split("T")
                    ["1"].split("-")
                    ["0"].split(":");

                  if (b[0] > 12) {
                    b[0] = b[0] - 12;
                    if(b[0] < 10){
                      b[0] = "0" + b[0].toString()
                    }
                    zone = " PM"
                  }
                  temp.round_arr_time = b.slice(0, 2).join(":") + zone


                                  var a =  data.data[
                    i
                  ].offerItems[0].services[1].segments[
                    data.data[i].offerItems[0].services[1].segments.length - 1
                  ].flightSegment.arrival.at


                  var zone = " AM";
                  
                  var b = a
                    .split("T")
                    ["1"].split("-")
                    ["0"].split(":");

                  if (b[0] > 12) {
                    b[0] = b[0] - 12;
                    if(b[0] < 10){
                      b[0] = "0" + b[0].toString()
                    }
                    zone = " PM"
                  }
                  temp.round_arr_time = b.slice(0, 2).join(":") + zone

                  temp.round_price =
                    data.data[i].offerItems[0].price.total -
                    parseFloat(
                      (this.disc / 100) * data.data[i].offerItems[0].price.total
                    ).toFixed(2);

                  temp.round_seg = round_seg;
                }

                this.amadeus.push(temp);

                this.amadeus = this.sortAmadeusData(this.amadeus, 1);
              }

              $(".disclainer").removeClass("hide");

              // for (var i = 0; i < data.data.length; i++) {

              //             this.amadeusReturn.push(temp);

              //             console.log(this.amadeusReturn);
              //           }

              // for (var i = 0; i < data.data.length; i++) {
              //   var pricing = data.data[i].offerItems[0].price.total;

              //   if (data.data[i].offerItems[0].services[0].segments.length == 1) {
              //     console.log("one");

              //     console.log(
              //       this.getJSONKeyValue(
              //         places_list,
              //         data.data[i].offerItems[0].services[0].segments[0]
              //           .flightSegment.departure.iataCode
              //       )
              //     );

              //     var loop =
              //       '<div class="card oneseg"> <div class="flight_name"> <p>' +
              //       this.capitalizeFirstLetter(
              //         this.getJSONKeyValue(
              //           carrier_list,
              //           data.data[i].offerItems[0].services[0].segments[0]
              //             .flightSegment.carrierCode
              //         )
              //       ) +
              //       '</p> <p class="pl-5">' +
              //       data.data[i].offerItems[0].services[0].segments[0]
              //         .flightSegment.operating.carrierCode +
              //       " - " +
              //       data.data[i].offerItems[0].services[0].segments[0]
              //         .flightSegment.operating.number +
              //       '</p> </div> <div class="flight_data flex-between"> <div class="flight_departure_time"> <div class="flex-center flight_origin"> <h5>' +
              //       data.data[i].offerItems[0].services[0].segments[0]
              //         .flightSegment.departure.iataCode +
              //       '</h5> <h5 class="pl-5">' +
              //       this.capitalizeFirstLetter(
              //         this.getJSONKeyValue(
              //           places_list,
              //           data.data[i].offerItems[0].services[0].segments[0]
              //             .flightSegment.departure.iataCode
              //         ).detailedName
              //       ) +
              //       '</h5> </div> <p class="flight_departure">' +
              //       data.data[
              //         i
              //       ].offerItems[0].services[0].segments[0].flightSegment.departure.at
              //         .split("T")
              //         ["1"].split("-")
              //         ["0"].split(":")
              //         .slice(0, 2)
              //         .join(":") +
              //       '</p> </div> <div class="flight_arrival_time"> <div class="flex-center flight_origin"> <h5>' +
              //       data.data[i].offerItems[0].services[0].segments[0]
              //         .flightSegment.arrival.iataCode +
              //       '</h5> <h5 class="pl-5">' +
              //       this.capitalizeFirstLetter(
              //         this.getJSONKeyValue(
              //           places_list,
              //           data.data[i].offerItems[0].services[0].segments[0]
              //             .flightSegment.arrival.iataCode
              //         ).detailedName
              //       ) +
              //       '</h5> </div> <p class="flight_arrival">' +
              //       data.data[
              //         i
              //       ].offerItems[0].services[0].segments[0].flightSegment.arrival.at
              //         .split("T")
              //         ["1"].split("-")
              //         ["0"].split(":")
              //         .slice(0, 2)
              //         .join(":") +
              //       '</p> </div> <div class="flight_price"> <h3>' +
              //       symbol +
              //       pricing +
              //       '</h3> </div> <div class="flight_book"> <button type="button" @click="submit" class="btn">Book Now</button> </div> </div> </div>';
              //   } else if (
              //     data.data[i].offerItems[0].services[0].segments.length == 2
              //   ) {
              //     console.log("two");
              //     var loop =
              //       '<div class="card twoseg"> <div class="flight_name"> <p>' +
              //       this.capitalizeFirstLetter(this.getJSONKeyValue(
              //         carrier_list,
              //         data.data[i].offerItems[0].services[0].segments[0]
              //           .flightSegment.carrierCode
              //       )) +
              //       '</p> <p class="pl-5">' +
              //       data.data[i].offerItems[0].services[0].segments[0]
              //         .flightSegment.operating.carrierCode +
              //       " - " +
              //       data.data[i].offerItems[0].services[0].segments[0]
              //         .flightSegment.operating.number +
              //       '</p> </div> <div class="flight_data flex-between"> <div class="flight_departure_time"> <div class="flex-center flight_origin"> <h5>' +
              //       data.data[i].offerItems[0].services[0].segments[0]
              //         .flightSegment.departure.iataCode +
              //       '</h5> <h5 class="pl-5">' +
              //       this.capitalizeFirstLetter(this.getJSONKeyValue(
              //         places_list,
              //         data.data[i].offerItems[0].services[0].segments[0]
              //           .flightSegment.departure.iataCode
              //       ).detailedName) +
              //       '</h5> </div> <p class="flight_departure">' +
              //       data.data[
              //         i
              //       ].offerItems[0].services[0].segments[0].flightSegment.departure.at
              //         .split("T")
              //         ["1"].split("-")
              //         ["0"].split(":")
              //         .slice(0, 2)
              //         .join(":") +
              //       '</p> </div> <div class="flight_arrival_time"> <div class="flex-center flight_origin"> <h5>' +
              //       data.data[i].offerItems[0].services[0].segments[1]
              //         .flightSegment.arrival.iataCode +
              //       '</h5> <h5 class="pl-5">' +
              //       this.capitalizeFirstLetter(this.getJSONKeyValue(
              //         places_list,
              //         data.data[i].offerItems[0].services[0].segments[1]
              //           .flightSegment.arrival.iataCode
              //       ).detailedName) +
              //       '</h5> </div> <p class="flight_arrival">' +
              //       data.data[
              //         i
              //       ].offerItems[0].services[0].segments[1].flightSegment.arrival.at
              //         .split("T")
              //         ["1"].split("-")
              //         ["0"].split(":")
              //         .slice(0, 2)
              //         .join(":") +
              //       '</p> </div> <div class="flight_price"> <h3>' +
              //       symbol +
              //       pricing +
              //       '</h3> </div> <div class="flight_book"> <button type="button" @click="submit" class="btn">Book Now</button> </div> </div> </div>';
              //   } else {
              //     console.log("more");
              //   }

              //   var d1 = document.getElementById("amadeus");
              //   d1.insertAdjacentHTML("beforeend", loop);
              // }
            })
            .catch(err => {
              console.log(err);
              console.log(err.response);

              $("#error_log").removeClass("hide");
              $(".processing").addClass("hide");
              $(".disclainer").addClass("hide");

              switch (err.response.status) {
                case 400:
                  if (err.response.data.errors[0].code == 4926) {
                    $("#error_log p").html(
                      "Invalid Data received." +
                        err.response.data.errors[0].detail +
                        " ( Error code 4926 )"
                    );
                  } else {
                    $("#error_log p").html(
                      "No available flight found. ( Code 400 )"
                    );
                  }

                  break;

                case 401:
                  console.log("Token Expired");
                  $("#error_log p").html(
                    "Access Token Expired. Please contact support@cheapairhub.com. ( Error code 401 )"
                  );
                  break;

                case 404:
                  console.log("Not found");
                  $("#error_log p").html(
                    "No available flight found. ( Code 404 )"
                  );
                  break;

                case 500:
                  console.log("Not found");
                  $("#error_log p").html(
                    "System error has occured. Please contact support@cheapairhub.com. ( Error code 500 )"
                  );
                  break;

                default:
                  $("#error_log p").html(
                    "Something is wrong. Please contact support@cheapairhub.com. ( Error code 503 )"
                  );
              }
            });
        } else if (this.source == "goibibo") {
          this.origin = "JFK";
          this.destination = "LAX";
          this.departureDate = 20190901;
          this.arrival = 20190920;
          this.adults = 1;
          this.nonStop = false;
          this.currency = "USD";
          this.seatingclass = "E";

          axios({
            method: "GET",
            url:
              this.flight_search_ibibo +
              "app_id=b7f6ec04" +
              "&app_key=8f77e825ac8eb70ac5e4bf90bcdbb162" +
              "&format=json" +
              "&source=" +
              $("#from_iata").val() +
              "&destination=" +
              $("#to_iata").val() +
              "&dateofdeparture=" +
              this.departureDate +
              "&dateofarrival=" +
              this.arrival +
              "&seatingclass=" +
              this.seatingclass +
              "&adults=" +
              this.adults +
              "&children=" +
              0 +
              "&infants=" +
              0 +
              "&counter=0"
          })
            .then(res => {
              console.log("res", res.data.data.onwardflights);

              var data = res.data.data.onwardflights;
              var returnflights = res.data.data.returnflights;

              data = this.getSortedDataGo(data, 1);
              returnflights = this.getSortedDataGo(returnflights, 1);

              var symbol = "₹";

              //  console.log(this.fixData(res.data.data.onwardflights))

              if (this.isInternationDep == 0) {
                for (var i = 0; i < data.length; i++) {
                  console.log("one");

                  console.log(parseInt(data[i].stops));

                  if (parseInt(data[i].stops) == 0) {
                    var loop =
                      '<div class="card no-stops"> <div class="flight_name"> <p>' +
                      data[i].airline +
                      '</p> <p class="pl-5">' +
                      data[i].carrierid +
                      " - " +
                      data[i].flightno +
                      '</p> </div> <div class="flight_data flex-between"> <div class="flight_departure_time"> <div class="flex-center flight_origin"> <h5>' +
                      data[i].origin +
                      '</h5></div> <p class="flight_departure">' +
                      data[i].deptime +
                      '</p> </div> <div class="flight_arrival_time"> <div class="flex-center flight_origin"> <h5>' +
                      data[i].destination +
                      '</h5></div> <p class="flight_arrival">' +
                      data[i].arrtime +
                      '</p> </div> <div class="flight_price"><h3>' +
                      symbol +
                      data[i].fare["totalfare"] +
                      '</h3> </div> <div class="flight_book"> <button type="button" @click="submit" class="btn">Book Now</button> </div> </div> </div>';

                    var d1 = document.getElementById("loop_here");
                    d1.insertAdjacentHTML("beforeend", loop);
                  } else if (parseInt(data[i].stops) > 0) {
                    var loop =
                      '<div class="card"> <div class="flight_name"> <p>' +
                      data[i].airline +
                      '</p> <p class="pl-5">' +
                      data[i].carrierid +
                      " - " +
                      data[i].flightno +
                      '</p> </div> <div class="flight_data flex-between"> <div class="flight_departure_time"> <div class="flex-center flight_origin"> <h5>' +
                      data[i].origin +
                      '</h5></div> <p class="flight_departure">' +
                      data[i].deptime +
                      '</p> </div> <div class="flight_arrival_time"> <div class="flex-center flight_origin"> <h5>' +
                      data[i].onwardflights[0].destination +
                      '</h5>  </div> <p class="flight_arrival">' +
                      data[i].onwardflights[0].arrtime +
                      '</p> </div> <div class="flight_price"><h3>' +
                      symbol +
                      data[i].fare["totalfare"] +
                      '</h3> </div> <div class="flight_book"> <button type="button" @click="submit" class="btn">Book Now</button> </div> </div> </div>';

                    var d1 = document.getElementById("loop_here");
                    d1.insertAdjacentHTML("beforeend", loop);
                  }
                }

                for (var i = 0; i < returnflights.length; i++) {
                  console.log("one");

                  console.log(parseInt(returnflights[i].stops));

                  if (parseInt(returnflights[i].stops) == 0) {
                    var loop =
                      '<div class="card"> <div class="flight_name"> <p>' +
                      returnflights[i].airline +
                      '</p> <p class="pl-5">' +
                      returnflights[i].carrierid +
                      " - " +
                      returnflights[i].flightno +
                      '</p> </div> <div class="flight_data flex-between"> <div class="flight_departure_time"> <div class="flex-center flight_origin"> <h5>' +
                      returnflights[i].origin +
                      '</h5></div> <p class="flight_departure">' +
                      returnflights[i].deptime +
                      '</p> </div> <div class="flight_arrival_time"> <div class="flex-center flight_origin"> <h5>' +
                      returnflights[i].destination +
                      '</h5></div> <p class="flight_arrival">' +
                      returnflights[i].arrtime +
                      '</p> </div> <div class="flight_price"><h3>' +
                      symbol +
                      returnflights[i].fare["totalfare"] +
                      '</h3> </div> <div class="flight_book"> <button type="button" @click="submit" class="btn">Book Now</button> </div> </div> </div>';

                    var d1 = document.getElementById("loop_hereRe");
                    d1.insertAdjacentHTML("beforeend", loop);
                  } else if (parseInt(returnflights[i].stops) > 0) {
                    var loop =
                      '<div class="card"> <div class="flight_name"> <p>' +
                      returnflights[i].airline +
                      '</p> <p class="pl-5">' +
                      returnflights[i].carrierid +
                      " - " +
                      returnflights[i].flightno +
                      '</p> </div> <div class="flight_data flex-between"> <div class="flight_departure_time"> <div class="flex-center flight_origin"> <h5>' +
                      returnflights[i].origin +
                      '</h5></div> <p class="flight_departure">' +
                      returnflights[i].deptime +
                      '</p> </div> <div class="flight_arrival_time"> <div class="flex-center flight_origin"> <h5>' +
                      returnflights[i].onwardflights[0].destination +
                      '</h5>  </div> <p class="flight_arrival">' +
                      returnflights[i].onwardflights[0].arrtime +
                      '</p> </div> <div class="flight_price"><h3>' +
                      symbol +
                      returnflights[i].fare["totalfare"] +
                      '</h3> </div> <div class="flight_book"> <button type="button" @click="submit" class="btn">Book Now</button> </div> </div> </div>';

                    var d1 = document.getElementById("loop_hereRe");
                    d1.insertAdjacentHTML("beforeend", loop);
                  }
                }
              } else {
                console.log("Internation result");

                for (var i = 0; i < data.length; i++) {
                  console.log(data[i].returnfl.length);
                  if (data[i].returnfl.length == 0) {
                    var loop =
                      '<div class="card"> <div class="flight_name"> <p>' +
                      data[i].airline +
                      '</p> <p class="pl-5">' +
                      data[i].carrierid +
                      " - " +
                      data[i].flightno +
                      '</p> </div> <div class="flight_data flex-between"> <div class="flight_departure_time"> <div class="flex-center flight_origin"> <h5>' +
                      data[i].origin +
                      '</h5></div> <p class="flight_departure">' +
                      data[i].deptime +
                      '</p> </div> <div class="flight_arrival_time"> <div class="flex-center flight_origin"> <h5>' +
                      data[i].onwardflights[0].destination +
                      '</h5>  </div> <p class="flight_arrival">' +
                      data[i].onwardflights[0].arrtime +
                      '</p> </div> <div class="flight_price"><h3>' +
                      symbol +
                      data[i].fare["totalfare"] +
                      '</h3> </div> <div class="flight_book"> <button type="button" @click="submit" class="btn">Book Now</button> </div> </div> </div>';

                    var d1 = document.getElementById("goibibo_internation");
                    d1.insertAdjacentHTML("beforeend", loop);
                  } else {
                    console.log(data[i].returnfl[0].destination);
                    console.log(i);

                    var onwardflights,
                      arrtime,
                      returnflights,
                      returnflightsArr,
                      originStops,
                      returnedStops;

                    if (data[i].onwardflights.length == 0) {
                      onwardflights = data[i].destination;
                      returnflights = data[i].returnfl[0].destination;

                      arrtime = data[i].arrtime;
                    } else {
                      console.log(data[i].onwardflights.length - 1);

                      onwardflights =
                        data[i].onwardflights[data[i].onwardflights.length - 1]
                          .destination;

                      if (data[i].returnfl.length == 0) {
                        returnflights = data[i].returnfl[0].destination;
                        returnflightsArr = data[i].returnfl[0].arrtime;
                      } else {
                        var originStops = "";
                        var returnedStops = "";

                        var returned_length = 0;
                        var origin_length = 0;

                        if (data[i].returnfl[0].onwardflights.length == 1) {
                          returned_length = 1;
                        } else {
                          returned_length =
                            data[i].returnfl[0].onwardflights.length;
                        }

                        if (data[i].onwardflights.length == 1) {
                          origin_length = 1;
                        } else {
                          origin_length = data[i].onwardflights.length;
                        }

                        for (var j = 0; j < returned_length; j++) {
                          returnedStops = returnedStops.concat(
                            " - " + data[i].returnfl[0].onwardflights[j].origin
                          );
                        }

                        console.log("origin_length");
                        console.log(origin_length);

                        for (var j = 0; j < origin_length; j++) {
                          console.log(originStops);

                          originStops = originStops.concat(
                            " - " + data[i].onwardflights[j].origin
                          );
                        }

                        returnflights =
                          data[i].returnfl[0].onwardflights[
                            data[i].returnfl[0].onwardflights.length - 1
                          ].destination;

                        returnflightsArr =
                          data[i].returnfl[0].onwardflights[
                            data[i].returnfl[0].onwardflights.length - 1
                          ].arrtime;
                      }

                      arrtime = data[i].onwardflights[0].arrtime;
                    }

                    var loop =
                      '<div class="card multi"> <div class="flight_name"> <p>' +
                      data[i].airline +
                      '</p> <p class="pl-5">' +
                      data[i].carrierid +
                      " - " +
                      data[i].flightno +
                      '</p> </div> <div class="flight_data flex-between"> <div class="flight_departure_time"> <div class="flex-center flight_origin"> <h5>' +
                      data[i].origin +
                      '</h5></div> <p class="flight_departure">' +
                      data[i].deptime +
                      '</p> </div> <div class="flight_duration"><div class="flex-center flight_change"><span> - </span><h5>' +
                      originStops +
                      '</h5> <span> - </span></div><p class="flight_duration">' +
                      data[i].duration +
                      '</p></div> <div class="flight_arrival_time"> <div class="flex-center flight_origin"> <h5>' +
                      onwardflights +
                      '</h5>  </div> <p class="flight_arrival">' +
                      arrtime +
                      '</p> </div> <div class="flight_price"><h3>' +
                      symbol +
                      data[i].fare["totalfare"] +
                      '</h3> </div> <div class="flight_book"> <button type="button" @click="submit" class="btn">Book Now</button> </div> </div><hr class="dashed-line"/><div class="flight_name"> <p>' +
                      data[i].returnfl[0].airline +
                      '</p> <p class="pl-5">' +
                      data[i].returnfl[0].carrierid +
                      " - " +
                      data[i].returnfl[0].flightno +
                      '</p> </div> <div class="flight_data flex-between"> <div class="flight_departure_time"> <div class="flex-center flight_origin"> <h5>' +
                      data[i].returnfl[0].origin +
                      '</h5></div> <p class="flight_departure">' +
                      data[i].returnfl[0].deptime +
                      '</p> </div> <div class="flight_duration"><div class="flex-center flight_change"><span> - </span><h5>' +
                      returnedStops +
                      '</h5> <span> - </span></div><p class="flight_duration">' +
                      data[i].duration +
                      '</p></div> <div class="flight_arrival_time"> <div class="flex-center flight_origin"> <h5>' +
                      returnflights +
                      '</h5>  </div> <p class="flight_arrival">' +
                      returnflightsArr +
                      '</p> </div> <div class="flight_price" style="opacity:0"><h3>₹0ffffff</h3> </div> <div class="flight_book"><button type="button" style="opacity:0" class="btn">Book Now</button></div> </div> </div>';

                    var d1 = document.getElementById("goibibo_internation");
                    d1.insertAdjacentHTML("beforeend", loop);
                  }
                }
              }
            })
            .catch(err => {
              console.log(err);
            });
        }
      }
    },
    getSortedData: function(data, isAsc) {
      return data.sort((a, b) => {
        return (
          (a.offerItems[0].price < b.offerItems[0].price.total 
            ? -1
            : 1) * (isAsc ? 1 : -1)
        );
      });
    },
    sortAmadeusData: function(data, isAsc) {
      return data.sort((a, b) => {
        return (
          (a.price < b.price 
            ? -1
            : 1) * (isAsc ? 1 : -1)
        );
      });
    },
    getSortedDataGo: function(data, isAsc) {
      return data.sort((a, b) => {
        return (
          (a.fare.totalfare < b.fare.totalfare ? -1 : 1) * (isAsc ? 1 : -1)
        );
      });
    },
    capitalizeFirstLetter: function(string) {
      console.log("char");
      console.log(string);

      if (string != undefined && string != "") {
        console.log(
          "ss" + string.charAt(0).toUpperCase() + string.toLowerCase().slice(1)
        );

        return string
          .toLowerCase()
          .split(" ")
          .map(s => s.charAt(0).toUpperCase() + s.substring(1))
          .join(" ");
      }
    },
    startCountdown: function(e) {
      $(".from_airport").addClass("hide");
      $("#from_iata").val("");
      clearTimeout(this.typingTimer);
      this.typingTimer = setTimeout(this.getAirport, 500);
    },
    startCountdownArr: function(e) {
      $(".to_airport").addClass("hide");
      $("#to_iata").val("");
      clearTimeout(this.typingTimer_to);
      this.typingTimer_to = setTimeout(this.getAirportArr, 500);
    },
    showDetails: function(e) {
      $(".travel_details").removeClass("hide");
    },
    saveChanges: function(e) {
      this.traveller =
        parseInt($(".drop-down1 .selected .value").html()) +
        parseInt($(".drop-down2 .selected .value").html()) +
        parseInt($(".drop-down3 .selected .value").html());
      this.travelClass = $(".drop-down .selected .value").html();

      $(".travel_details").addClass("hide");
    },
    clearCountdown: function(e) {
      $(".des").addClass("hide");
      $(".arr").addClass("hide");
      $("#from_iata").val();
      clearTimeout(this.typingTimer);
    },
    clearCountdown_to: function(e) {
      $(".des").addClass("hide");
      $(".arr").addClass("hide");
      $("#to_iata").val();
      clearTimeout(this.typingTimer_to);
    },
    seconds_to_date: function(seconds) {
      // day, h, m and s
      var days = Math.floor(seconds / (24 * 60 * 60));
      seconds -= days * (24 * 60 * 60);
      var hours = Math.floor(seconds / (60 * 60));
      seconds -= hours * (60 * 60);
      var minutes = Math.floor(seconds / 60);
      seconds -= minutes * 60;
      return (0 < days ? days + " day, " : "") + hours + "h " + minutes + "m";
    },
    getAirport: function(e) {
      if ($("#from_des").val() !== "") {
        axios({
          method: "POST",
          url:
            this.base_url +
            "/api/api.php?search=search&query=" +
            $("#from_des").val(),
          headers: {
            "Access-Control-Allow-Origin": "*"
          }
        })
          .then(res => {
            console.log("res", res);
            console.log("Token Generated");
            if (res.data.length == 0) {
              this.airportDepListError = true;
            } else {
              this.airportList = res.data;
              this.airportDepListError = false;
            }
            $(".des").removeClass("hide");
          })
          .catch(err => {
            console.log("error in request1", err);
          });
      }
    },
    selectDep: function(id) {
      console.log(id);

      if (this.airportList.filter(v => v.id == id).length > 0) {
        var data_ins = this.airportList.filter(v => v.id == id)[0].municipality;

        $(".from_airport").html(
          this.airportList.filter(v => v.id == id)[0].iata_code +
            " , " +
            this.airportList.filter(v => v.id == id)[0].name
        );

        $(".from_airport").removeClass("hide");

        $("#from_iata").val(
          this.airportList.filter(v => v.id == id)[0].iata_code
        );

        $("#from_des").val(data_ins);
        $(".des").addClass("hide");

        if (this.airportList.filter(v => v.id == id)[0].iso_country != "IN") {
          this.isInternationDep = 1;
          localStorage.setItem("isInternationDep", this.isInternationDep);
        } else {
          this.isInternationDep = 0;
          localStorage.setItem("isInternationDep", this.isInternationDep);
        }
      }
    },
    getAirportArr: function(e) {
      if ($("#to_arr").val() !== "") {
        axios({
          method: "POST",
          url:
            this.base_url +
            "/api/api.php?search=search&query=" +
            $("#to_arr").val(),
          headers: {
            "Access-Control-Allow-Origin": "*"
          }
        })
          .then(res => {
            console.log("res", res);
            console.log("Token Generated");

            if (res.data.length == 0) {
              this.airportArrListError = true;
            } else {
              this.airportListArr = res.data;
              this.airportArrListError = false;
            }

            console.log(res);

            $(".arr").removeClass("hide");
          })
          .catch(err => {
            console.log("error in request1", err);
          });
      }
    },
    selectArr: function(id) {
      console.log(id);

      if (this.airportListArr.filter(v => v.id == id).length > 0) {
        var data_ins = this.airportListArr.filter(v => v.id == id)[0]
          .municipality;

        $(".to_airport").html(
          this.airportListArr.filter(v => v.id == id)[0].iata_code +
            " , " +
            this.airportListArr.filter(v => v.id == id)[0].name
        );

        $(".to_airport").removeClass("hide");

        $("#to_arr").val(data_ins);
        $(".arr").addClass("hide");
        $("#to_iata").val(
          this.airportListArr.filter(v => v.id == id)[0].iata_code
        );

        if (
          this.airportListArr.filter(v => v.id == id)[0].iso_country != "IN"
        ) {
          this.isInternationArr = 1;
          this.isInternationDep = 1;
          localStorage.setItem("isInternationDep", this.isInternationDep);
        } else {
          if (this.isInternationDep == 0) {
            this.isInternationDep = 0;
            localStorage.setItem("isInternationDep", this.isInternationDep);
          }
        }
      }
    },
    getJSONKeyValue: function(json, value) {
      console.log("value");
      console.log(value);

      for (var i in json) {
        var key = i;
        var val = json[i];
        if (key == value) return val;
      }
    },
    showDetail: function(id) {
      if (!$("#fd-" + id).hasClass("hide")) {
        $(".flight_details").addClass("hide");
      } else {
        $(".flight_details").addClass("hide");
        $("#fd-" + id).removeClass("hide");
      }
    },
    open_form: function(id) {
      this.$router.push("/booknow");

      // $("#form-container").removeClass("hide");

      // console.log(id);

      localStorage.setItem("flight_data", JSON.stringify(id));
    },
    close_popup: function() {
      $("#form-container").addClass("hide");
    },
    close_popup_after: function() {
      $("#after-form").addClass("hide");
    },
    submitForm: function() {
      var bodyFormData = new FormData();

      bodyFormData.append("first_name", $("#first_name").val());
      bodyFormData.append("last_name", $("#last_name").val());
      bodyFormData.append("email", $("#email").val());
      bodyFormData.append("phone", $("#phone").val());
      bodyFormData.append("formed_data", JSON.stringify(this.formed_data));

      axios({
        method: "POST",
        data: bodyFormData,
        url: this.base_url + "/api/api.php?sendform=sendform",

        headers: {
          "Access-Control-Allow-Origin": "*"
        }
      })
        .then(res => {
          console.log("res", res);
          console.log("Info Added");

          this.transaction_id = res.data.transaction_id;

          $("#after-form").removeClass("hide");

          $("#form-container").addClass("hide");
        })
        .catch(err => {
          console.log("error in request1", err);
        });
    }
  }
};
</script>


<style scoped>
[type="radio"]:checked + label,
[type="radio"]:not(:checked) + label {
  color: white;
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
.search_button .btn {
  background-image: linear-gradient(96deg, #e91e63, #ff1100);
  border-radius: 50px;
  font-size: 15px;
  /* margin: 40px 40px; */
  line-height: 47px;
  width: 210px;
  box-shadow: 0px 5px 9px 0px #0303034a;
  height: 45px;
}

@media only screen and (max-width: 600px) {
  .contact {
    line-height: 25px;
    flex-direction: column;
  }
}

.location {
  border: 0;
  outline: 0;
  background: none;
  min-width: 140px;
  max-height: 36px;
  cursor: pointer;
  padding: 0;
  margin: 0;
  width: 100%;
  font-weight: bold;
  font-size: 30px;
  color: black;
}

.airportName {
  font-size: 14px;
  color: rgb(74, 74, 74);
}

.datepickerstyle {
  opacity: 0 !important;
  position: absolute;
  z-index: -1;
}

.font30 {
  font-size: 30px;
}

.blackText {
  color: black;
  padding-top: 10px;
}

.font20 {
  font-size: 20px;
}

.shortYear:before {
  content: "'";
}

.oneway {
  padding-bottom: 0;
}

.roundtrip {
  background-color: #dddddd !important;
  opacity: 1;
}

.roundtrip .form {
  opacity: 0.5;
}

.error-class {
  height: 30px;
  color: white;
  margin-left: -10px;
  font-size: 13px;
  line-height: 35px;
}

.makemytrip-border {
  background-color: white;
}

@media only screen and (max-width: 600px) {
  .flight_book {
    height: 40px !important;
  }

  .flight_data {
    padding-bottom: 10px;
  }

  .makemytrip-border {
    border: 1px solid #dddddd;
    border-radius: 5px;
    margin-top: 10px;
    height: 95px;
  }

  .makemytrip-border:nth-child(3) {
    border-radius: 5px 0 0 5px;
  }

  .makemytrip-border:nth-child(4) {
    border-radius: 0 5px 5px 0;
  }
}

@media only screen and (min-width: 1024px) {
  .flight_price {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 75px;
  }

  .makemytrip-border {
    border-radius: 0;
    border: 1px solid #dddddd;
    margin-top: 10px;
    height: 95px;
  }
  .makemytrip-border:first-child {
    border: 1px solid #dddddd;
    border-radius: 5px 0 0 5px;
    margin-top: 10px;
    height: 95px;
  }
  .makemytrip-border:nth-child(5) {
    border: 1px solid #dddddd;
    border-radius: 0 5px 5px 0;
    margin-top: 10px;
    height: 95px;
  }
}

@media only screen and (min-width: 600px) and (max-width: 1023px) {
  .flight_price {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 75px;
  }

  .makemytrip-border {
    border: 1px solid #dddddd;
    border-radius: 5px;
    margin-top: 10px;
    height: 95px;
  }

  .makemytrip-border:nth-child(1),
  .makemytrip-border:nth-child(3) {
    border-radius: 5px 0 0 5px;
  }

  .makemytrip-border:nth-child(2) {
    border-radius: 0 5px 5px 0;
  }
  .makemytrip-border:nth-child(4) {
    border-radius: 0;
  }
  .makemytrip-border:nth-child(5) {
    border-radius: 0 5px 5px 0;
  }
}

.card.flight_search {
  background-color: #673ab7;
  padding: 40px 24px 60px 24px;
  border-radius: 0;
  margin: 0;
  position: relative;
}

#amadeus .oneway .col,
#amadeus .return .col {
  height: 90px;
}
</style>
