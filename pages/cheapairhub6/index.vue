<template>
  <div>
    <div class="popup_form hide" id="form-container">
      <div class="form_body" style="padding-top:25px">
        <p
          @click="close_popup"
          style="position:absolute;right:10px;top:0;font-size:25px;cursor:pointer"
        >x</p>
        <div class="row">
          <div class="col s24">
            <h4>Fill up this form for the best offers</h4>
          </div>
          <div class="col s24">
            <div class="form">
              <label>Full Name</label>
              <input id="full_name" type="text" placeholder="Full Name" autocomplete="off" />
            </div>
          </div>
          <div class="col s24">
            <div class="form">
              <label>Email</label>
              <input id="email" type="email" autocomplete="off" placeholder="Email Address" />
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
      <div class="form_body" style="padding-top:25px">
        <p
          @click="close_popup_after"
          style="position:absolute;right:10px;top:0;font-size:25px;cursor:pointer"
        >x</p>
        <div class="row">
          <div class="col s24">
            <h4>Please save the transaction ID for future reference</h4>
            <p>Transaction ID: {{ transaction_id }}</p>
            <p>Call the below number to confirm your booking at the lowest fare</p>
            <p>+91 700505019198</p>
          </div>
        </div>
      </div>
    </div>

    <div class="bg-image">
      <div
        class="container section"
        style="display: flex;align-items: center;justify-content: center;height: 100%;"
      >
        <div>
          <div style="text-align: center">
            <h4 style="color:white">ALL THE BEST FARES IN ONE SEARCH</h4>
            <h4 style="color:white">TRAVEL WITH DEALS OVER 500 AIRLINES' CHEAP FLIGHTS</h4>
          </div>
          <div class="card main_section">
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

            <div class="row">
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
                  <p class="from_airport hide clamp1 airportName">DEL, Delhi Airport India</p>
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
                    @keydown="clearCountdown"
                    @keyup="startCountdownArr"
                    type="text"
                    class="location"
                    autocomplete="off"
                    placeholder="Destination"
                  />
                  <p class="to_airport hide airportName clamp1">DEL, Delhi Airport India</p>
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

                    <p class="travel_class">{{travelClass}}</p>
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
                                <span class="value">Economy</span>
                              </p>
                            </div>
                            <div class="options">
                              <ul>
                                <li>
                                  <p>
                                    Economy
                                    <span class="value">Economy</span>
                                  </p>
                                </li>
                                <li>
                                  <p>
                                    Business
                                    <span class="value">Business</span>
                                  </p>
                                </li>
                                <li>
                                  <p>
                                    First
                                    <span class="value">First</span>
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
                <button type="button" @click="submit" class="btn bold">Search</button>
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

    <div class="hide" style="background-color:#f5f5f5" id="result_section">
      <div class="container section">
        <h3>Search Results</h3>

        <div class="loader hide" style="text-align:center">
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

        <div class="row">
          <div class="col s24">
            <div id="amadeus">
              <div class="card oneseg" v-for="(p, index) in amadeus" :key="p.id">
                <div class="oneway">
                  <div class="flight_name">
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
                  <div class="flight_data flex-between">
                    <div class="flight_departure_time">
                      <div class="flex-center flight_origin">
                        <h5>{{ p.origin }}</h5>
                        <p class="pl-5 clamp1" style="width: 130px;">{{ p.origin_fullname }}</p>
                      </div>
                      <p class="flight_departure">{{ p.dep_time }}</p>
                    </div>
                    <div class="extra_duration extar_flight_origin center">
                      <p style="font-size:11px;color:#b5b5b5">Flight Duration</p>
                      <h5>{{ p.duration }}</h5>
                    </div>
                    <div class="flight_arrival_time">
                      <div class="flex-center flight_origin">
                        <h5>{{ p.destination }}</h5>
                        <p class="pl-5 clamp1" style="width: 130px;">{{ p.destination_fullname }}</p>
                      </div>
                      <p class="flight_arrival">{{ p.arr_time }}</p>
                    </div>
                    <div class="flight_price">
                      <h3>$ {{ p.price }}</h3>
                    </div>
                    <div class="flight_book">
                      <button type="button" @click="open_form(p)" class="btn">Book Now</button>
                    </div>
                  </div>
                </div>

                <hr v-if="p.isRound == 1" class="dashed-line" />

                <div class="return" v-if="p.isRound == 1">
                  <div class="flight_name">
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
                  <div class="flight_data flex-between">
                    <div class="flight_departure_time">
                      <div class="flex-center flight_origin">
                        <h5>{{ p.round_origin }}</h5>
                        <p class="pl-5 clamp1" style="width: 130px;">{{ p.round_origin_fullname }}</p>
                      </div>
                      <p class="flight_departure">{{ p.round_dep_time }}</p>
                    </div>
                    <div class="extra_duration extar_flight_origin center">
                      <p style="font-size:11px;color:#b5b5b5">Flight Duration</p>
                      <h5>{{ p.round_duration }}</h5>
                    </div>
                    <div class="flight_arrival_time">
                      <div class="flex-center flight_origin">
                        <h5>{{ p.round_destination }}</h5>
                        <p
                          class="pl-5 clamp1"
                          style="width: 130px;"
                        >{{ p.round_destination_fullname }}</p>
                      </div>
                      <p class="flight_arrival">{{ p.round_arr_time }}</p>
                    </div>
                    <div class="flight_price">
                      <h3>$ {{ p.round_price }}</h3>
                    </div>
                    <div class="flight_book">
                      <button type="button" style="opacity:0" class="btn">Book Now</button>
                    </div>
                  </div>
                </div>

                <div style="display:flex;justify-content: space-between">
                  <p
                    style="font-size:12px;font-style:italic;color:#949494;font-family:'Manjari'"
                  >No Baggage info available</p>
                  <p class="show_flight" @click="showDetail(index)">Flight Details</p>
                </div>

                <div class="flight_details hide" :id="'fd-' + index">
                  <div class="flight_details_border">
                    <div v-for="(q, qIndex) in amadeus[index].seg" :key="q.id">
                      <hr v-if="qIndex != 0" class="dashed-line" />
                      <div class="extra_flight_data flex-between">
                        <div class="extra_flight_name">
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
                        <div class="flight_departure_time">
                          <div class="flex-center extar_flight_origin">
                            <h5>{{ q.origin }}</h5>
                            <p
                              class="extra_flight_departure"
                              style="padding-left:10px"
                            >{{ q.dep_time }}</p>
                          </div>
                          <p class="pl-5 extra_destination">{{ q.origin_fullname }}</p>
                        </div>
                        <div class="extra_duration extar_flight_origin center">
                          <p style="font-size:11px;color:#b5b5b5">Flight Duration</p>
                          <h5>{{ q.duration }}</h5>
                        </div>
                        <div class="flight_arrival_time">
                          <div class="flex-center extar_flight_origin">
                            <h5>{{ q.destination }}</h5>
                            <p
                              class="extra_flight_arrival"
                              style="padding-left:10px"
                            >{{ q.arr_time }}</p>
                          </div>

                          <p class="pl-5 extra_destination">{{ q.destination_fullname }}</p>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div v-if="p.isRound == 1" class="flight_details_border">
                    <div v-for="(q, qIndex) in amadeus[index].round_seg" :key="q.id">
                      <hr v-if="qIndex != 0" class="dashed-line" />
                      <div class="extra_flight_data flex-between">
                        <div class="extra_flight_name">
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
                        <div class="flight_departure_time">
                          <div class="flex-center extar_flight_origin">
                            <h5>{{ q.round_origin }}</h5>
                            <p
                              class="extra_flight_departure"
                              style="padding-left:10px"
                            >{{ q.round_dep_time }}</p>
                          </div>
                          <p class="pl-5 extra_destination">{{ q.round_origin_fullname }}</p>
                        </div>
                        <div class="extra_duration extar_flight_origin center">
                          <p style="font-size:11px;color:#b5b5b5">Flight Duration</p>
                          <h5>{{ q.round_duration }}</h5>
                        </div>
                        <div class="flight_arrival_time">
                          <div class="flex-center extar_flight_origin">
                            <h5>{{ q.round_destination }}</h5>
                            <p
                              class="extra_flight_arrival"
                              style="padding-left:10px"
                            >{{ q.round_arr_time }}</p>
                          </div>
                          <p class="pl-5 extra_destination">{{ q.round_destination_fullname }}</p>
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
      </div>
    </div>

        <div style="background-color:#673ab7">
      <div
        class="container section"
        style="height: 170px;display: flex;align-items: center;justify-content: center;">
        <div
          class="contact"
          style="width:100%"
        >
          <div class="row">
            <div class="hide-on-med-and-down col s24 m24 l12 pic-call">
            <a href="tel:1877-593-2194">
                <h1><i class="fa fa-phone-square"></i>&nbsp;CALL NOW</h1>
            </a>
        </div>
        <div class="col s24 m24 l12" style="    height: 190px;
    display: flex;
    align-items: center;
    justify-content: center;">
    <div style="text-align:center">
      <p style="color:white;font-size:45px">1877-593-2194</p>
      <p style="color:white">Call For Unpublished Cheap Flight Deals</p>
    </div>
          
          </div>
      </div>
    </div>
    </div>
    </div>


    <div style="background-color:#fff">
      <div
        class="container section"
        style="min-height: 300px;
    display: flex;
    align-items: center;
    justify-content: center; text-align:center"
      >
        <div class="row faremon">
          <div class="col s12 m12 l5">
            <img src="~static/trustpilot_logo.png" alt />
            <p>Get the Best Deal with our Price Indicator &amp; Deal Analyzer Tool</p>
          </div>
          <div class="col s12  m12 l5">
            <img src="~static/flight.png" width="40" height="50" alt />
            <p>Special Bargain Fares From 500+ Airlines</p>
          </div>
          <div class="col s12 m12 l4">
            <img src="~static/Secure.png" width="50" height="50" alt />
            <p>Purchase with Confidence: Safe &amp; Secure Bookings</p>
          </div>
          <div class="col s12  m12 l5">
            <img src="~static/customer.png" width="50" height="50" alt />
            <p>24/7 Round the Clock Customer Service</p>
          </div>
          <div class="col s24  m24 l5">
            <img src="~static/asta_logo.png" alt />
            <p>Purchase with Confidence Join other happy customers</p>
          </div>
        </div>
      </div>
    </div>


    <div style="border-top: 1px solid #dedede;">
      <div
        class="container section"
        style="height: 250px;
    align-items: center;
    justify-content: center;"
      >
        <div class="icon-text row">
          <div class="hidden-xs col s12 relative">
            <nuxt-link to="/airportcodes">
              <div class="air-code">
                <h4>Airport Code</h4>
              </div>
            </nuxt-link>
          </div>
          <div class="hidden-xs col s12 relative">
            <nuxt-link to="/airportcontact">
              <div class="air-cont">
                <h4>Airline Contact</h4>
              </div>
            </nuxt-link>
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
    picked: "roundtrip",
    source: "amadeus",
    isInternationDep: 0,
    isInternationArr: 0,
    // base_url: "http://localhost",
    base_url: "https://www.cheapairhub.com",
    amadeus: [],
    amadeusReturn: [],
    carrier_list: [],
    transaction_id: 0,
    formed_data: [],
    traveller: 1,
    airportArrListError: true,
    airportDepListError: true,
    travelClass: "Economy"
  }),

  mounted() {
    this.$nextTick(function() {
      this.onResize();
    });


    
            $(".telephone").attr("href" , 'tel:1877-593-2194')

    $(".telephone").html('1877-593-2194')

    window.addEventListener("resize", this.onResize);

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

          this.arr_date_ui = fd;

          localStorage.setItem("return_day", $(".return_day").html());
          localStorage.setItem("return_date", fd);

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

          self.dep_date_ui = "sssss";

          console.log("this.dep_date_ui");

          localStorage.setItem("departure_day", $(".departure_day").html());
          localStorage.setItem("departure_date", fd);

          console.log(this.dep_date_ui);

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

    dp.selectDate(new Date());

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
  },

  methods: {
    onResize: function() {
      // $(".bg-image").height("100%");
    },
    getToken: function() {
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
        })
        .catch(err => {
          console.log("error in request1", err.response.data.message);
          this.$vs.loading.close();
          this.$vs.notify({
            title: "Login Failed",
            text: err.response.data.message,
            color: "danger",
            time: 5000
          });
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
    },

    //     radioClicked: function(){

    //  $('.datepicker-here').datepicker()

    //     },
    submit: function() {
      // if ($("#from_iata").val() == "") {

      //   $(".error-class").html("Please select a valid origin airport");
      // } else if ($("#to_iata").val() == "") {

      //   $(".error-class").html("Please select a valid destination airport");
      // }
      // else{

      $(".error-class").html("");

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

        // localStorage.setItem("from", this.origin);
        // localStorage.setItem("to", this.destination);
        // localStorage.setItem("departure", this.departureDate);
        // localStorage.setItem("return", this.returnDate);
        // localStorage.setItem("travel_class", this.travelClass);
        // localStorage.setItem("adult", this.adults);
        // localStorage.setItem("children", this.children);
        // localStorage.setItem("infants", this.infants);
        // localStorage.setItem("currency", this.currency);
        // localStorage.setItem("nonStop", this.nonStop);
        // localStorage.setItem("way", this.picked);

        //all data

        localStorage.setItem("from_des", $("#from_des").val());
        localStorage.setItem("from_airport", $(".from_airport").html());

        localStorage.setItem("to_arr", $("#to_arr").val());
        localStorage.setItem("to_airport", $(".to_airport").html());

        // this.$router.push("/cheapairhub/cheapflightresults");



        var newstring1 = $("#dep_date_hidden").val().split("-").reverse().join("/")
        var newstring2 = $("#ret_date_hidden").val().split("-").reverse().join("/")

      var rtn = "Oneway"
        if(this.picked == 'roundtrip'){
            rtn = "Return"
        }

        // https://booking.domain.com/en-us/selectflights?SearchType=Oneway&OriginStation=HKG&DestinationStation=NGO&DepartureDate=03/03/2017&Adults=1

        this.$router.push("/cheapairhub6/en-us/?SearchType="+ rtn + "&OriginStation="+ $("#from_iata").val().toUpperCase()  +"&DestinationStation="+ $("#to_iata").val().toUpperCase() +"&DepartureDate="+ newstring1 +"&ReturnDate="+ newstring2 +"&Adults="+ $(".drop-down1 .selected .value").html() +"&Children="+ $(".drop-down2 .selected .value").html() +"&Infants="+ $(".drop-down3 .selected .value").html() +"&cabinclass=" + $(".drop-down .selected .value").html())

        // this.$router.push("/cheapairhub/flights/" + $("#from_iata").val().toLowerCase()  + "/" + $("#to_iata").val().toLowerCase() + "/" + newstring1 + "/" + newstring2 + "/?adults=" + $(".drop-down1 .selected .value").html() + "&children=" + $(".drop-down2 .selected .value").html() + "&infants=" + $(".drop-down3 .selected .value").html() + "&cabinclass=" + $(".drop-down .selected .value").html() + "&rtn=" + rtn + "&utm_campaign=skyscanner" );
      }

      // }
    },
    getSortedData: function(data, isAsc) {
      return data.sort((a, b) => {
        return (
          (a.offerItems[0].price.total < b.offerItems[0].price.total &&
          a.offerItems[0].services[0].segments[0].flightSegment.departure ==
            $("#from_iata").val()
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
      console.log(
        string.charAt(0).toUpperCase() + string.toLowerCase().slice(1)
      );
      return string
        .toLowerCase()
        .split(" ")
        .map(s => s.charAt(0).toUpperCase() + s.substring(1))
        .join(" ");
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
      clearTimeout(this.typingTimer);
      this.typingTimer = setTimeout(this.getAirportArr, 500);
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
      clearTimeout(this.typingTimer);
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
          localStorage.setItem("isInternationDep" , this.isInternationDep)
        } else {
          this.isInternationDep = 0;
          localStorage.setItem("isInternationDep" , this.isInternationDep)
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
          localStorage.setItem("isInternationDep" , this.isInternationDep)
        } else {
          if (this.isInternationDep == 0) {
            this.isInternationDep = 0;
            localStorage.setItem("isInternationDep" , this.isInternationDep)
          }
        }
      }
    },
    getJSONKeyValue: function(json, value) {
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
      $("#form-container").removeClass("hide");

      console.log(id);

      this.formed_data = id;
    },
    close_popup: function() {
      $("#form-container").addClass("hide");
    },
    close_popup_after: function() {
      $("#after-form").addClass("hide");
    },
    submitForm: function() {
      var bodyFormData = new FormData();

      bodyFormData.append("full_name", $("#full_name").val());
      bodyFormData.append("email", $("#email").val());
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
  background-image: linear-gradient(96deg, #673ab7, #2196f3);
  border-radius: 50px;
  font-size: 15px;
  /* margin: 40px 40px; */
  line-height: 47px;
  width: 210px;
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

.roundtrip {
  background-color: #dddddd;
  opacity: 0.5;
}

.error-class {
  height: 30px;
  color: #ff5722;
  margin-left: -10px;
  font-size: 13px;
  line-height: 35px;
}

@media only screen and (max-width: 600px) {
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

.faremon p {
  font-size: 13px;
  padding-top: 10px;
}

.faremon img {
  width: 144px;
  height: 60px;
  object-fit: contain;
}

.pic-call {
    background: url(~static/call-center.png) no-repeat left center rgba(0, 0, 0, 0);
    height: 190px;
    background-size: 152px
}

.pic-call > a {
background-color: #ffffff;
    border-radius: 7px;
    color: #666;
    cursor: pointer;
    float: left;
    font-weight: bold;
    margin-bottom: 0;
    margin-left: 125px;
    margin-top: 75px;
    padding: 10px;
    text-decoration: none;
    font-size: 10px;
}
</style>
