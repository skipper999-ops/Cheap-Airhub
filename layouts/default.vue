<template>
  <div>
    <client-only>

      <div v-if="$nuxt.$route.name != 'booknow'" class="hide popup_banner">
        <div style="    z-index: 999;
    position: relative;">

            <img style="z-index:100;border-radius:10px;width:100%; max-width: 660px;" src="~static/popup_banner.png">
            <p @click="closePopup" style="width: 30px;
    height: 30px;
    cursor: pointer;
    z-index: 999;
    position: absolute;
    right: -14px;
    display: flex;
    top: -12px;
    background-color: red;
    border-radius: 20px;
    color: white;
    justify-content: center;
    align-items: center;">x</p>
        </div>
      </div>

      <Header v-if="$nuxt.$route.name != 'login'" />
      <nuxt />
      <Footer v-if="$nuxt.$route.name != 'login' && $nuxt.$route.name != 'admin'" />
    </client-only>
  </div>
</template>


<script>
import Footer from "@/components/footer";
import Header from "@/components/Header";

export default {
  components: {
    Footer,
    Header
  },
  data(){
    return{
        popupTimer: 0
    }
  },
  mounted() {
$(".popup_banner").removeClass('hide')


    var TIME_OUT = 45000;

// function that displays the popup
function displayPopup() {
    // display the popup here
     $(".popup_banner").removeClass('hide')
}

// Set the timeout to display the popup
this.popupTimer = setTimeout(displayPopup, TIME_OUT);

// attch events to the document object
// you can add more events here based on
// what events you want to track
$(document).on('click change keypress mouseover resize scroll', function() {

  // clear the timeout whenever the event is handled
  console.log("clcxkcxkcnxk")
  clearTimeout(this.popupTimer);

  // Reset the timer
  this.popupTimer = setTimeout(displayPopup, TIME_OUT);
});

// $(document).mouseleave(function () {
//      $(".popup_banner").removeClass('hide')
// });


// $(document).mouseenter(function () {
//     $(".popup_banner").addClass('hide')
// });



  },
  methods:{
    closePopup: function(){


           $(".popup_banner").addClass('hide')

            clearTimeout(this.popupTimer);

    }
  }
};
</script>


<style>
/* @import url('https://fonts.googleapis.com/css?family=Manjari:100,400,700&display=swap'); */

@font-face {
  font-family: "Manjari-bold";
  src: url("~static/Sailec-Bold.woff") format("woff");
}

@font-face {
  font-family: "Manjari";
  src: url("~static/Sailec-Regular.woff") format("woff");
}

.popup_banner{
       position: fixed;
       padding: 10px;
    z-index: 99;
    /* left: 0; */
    /* right: 0; */
    /* top: 0; */
    /* bottom: 0; */
    margin: auto;
    width: 100%;
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
}

.faremon > .col{
  height: 160px;
}

.popup_banner:after{
  content: "";
  background-color: rgba(0, 0, 0, 0.63);

       position: fixed;
    z-index: 99;
    /* left: 0; */
    /* right: 0; */
    /* top: 0; */
    /* bottom: 0; */
    margin: auto;
    width: 100%;
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
}

html {
  font-family: "Manjari", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
    "Helvetica Neue", Arial, sans-serif;
  font-size: 16px;
  word-spacing: 1px;
  -ms-text-size-adjust: 100%;
  -webkit-text-size-adjust: 100%;
  -moz-osx-font-smoothing: grayscale;
  -webkit-font-smoothing: antialiased;
  box-sizing: border-box;
}

html,
body {
  min-width: 340px;
}

*,
*:before,
*:after {
  box-sizing: border-box;
  margin: 0;
}

.travel_class{
      text-transform: capitalize;
}


.button--green {
  display: inline-block;
  border-radius: 4px;
  border: 1px solid #3b8070;
  color: #3b8070;
  text-decoration: none;
  padding: 10px 30px;
}

.button--green:hover {
  color: #fff;
  background-color: #3b8070;
}

.button--grey {
  display: inline-block;
  border-radius: 4px;
  border: 1px solid #35495e;
  color: #35495e;
  text-decoration: none;
  padding: 10px 30px;
  margin-left: 15px;
}

.button--grey:hover {
  color: #fff;
  background-color: #35495e;
}

* {
  margin: 0;
  padding: 0;
}

.drop-down_ui {
}

.btn:focus {
  outline: none;
}

.drop-down_ui .selected p {
  background: #fff no-repeat scroll right center;
  display: block;
  padding-right: 20px;
  border: 1px solid #d7d7d7;
  border-radius: 2px;
  text-decoration: none;
  color: #000;
  height: 37px;
  line-height: 30px;
  font-size: 13px;
}

.drop-down_ui .selected p span {
  cursor: pointer;
  display: block;
  padding: 5px 10px;
}

.drop-down .option {
  position: relative;
}

.drop-down_ui .options ul {
  background: #fff none repeat scroll 0 0;
  display: none;
  list-style: none;
  padding: 0px 0px;
  position: absolute;
  left: 0px;
  top: 62px;
  width: auto;
  width: 100%;
  border: 1px solid #d7d7d7;
  z-index: 99;
}

.drop-down_ui .selected span.value,
.drop-down_ui .options span.value {
  display: none;
}

.drop-down_ui .options ul li p {
  padding: 5px;
  display: block;
  text-decoration: none;
  color: #000;
  font-size: 13px;
  padding: 15px 10px;
}

.drop-down_ui .options ul li p:hover {
  background: #000;
  color: #fff;
  transition: 0.2s ease;
}

html,
body {
  /* background-color: #f5f5f5; */
}

.navbar {
  background-color: #1f1f1f;
  height: 60px;
  color: white;
  display: flex;
  align-items: center;
}

.search_button {
  padding-top: 10px;
  position: absolute;
  bottom: -30px;
  left: 0 !important;
  right: 0;
  /* margin: auto; */
  /* width: 100%; */
  text-align: center;
}

/*	.container{
		width: 90%;
		max-width: 1200px;
		margin: auto;

	}

	.section{
		padding-bottom: 10px;
		padding-top: 10px
	}
	*/
.card {
  background-color: white;
  box-shadow: 0px 9px 12px 1px #31313114;
  padding: 25px;
  border-radius: 5px;
  margin: 15px 5px;
  position: relative;
}

.card.main_section {
  background-color: white;
  box-shadow: 0px 9px 12px 1px #31313114;
  padding: 40px 24px 60px 24px;
  border-radius: 5px;
  margin: 15px 5px;
  position: relative;
}

[type="radio"]:checked,
[type="radio"]:not(:checked) {
  position: absolute;
  left: -9999px;
}
[type="radio"]:checked + label {
  position: relative;
  padding: 0px 28px;
  /*padding: 3px 7px 3px 22px;*/
  cursor: pointer;
  font-size: 12px;
  line-height: 23px;
  display: inline-block;
  color: #000;
  font-weight: bold;
  letter-spacing: 0.2px;
}

[type="radio"]:not(:checked) + label {
  position: relative;
  padding: 0px 28px;
  cursor: pointer;
  font-size: 12px;
  line-height: 23px;
  display: inline-block;
  color: #000;
  font-weight: bold;
  letter-spacing: 0.2px;
}
[type="radio"]:checked + label:before,
[type="radio"]:not(:checked) + label:before {
  content: "";
  position: absolute;
  left: 0;
  top: 0;
  width: 18px;
  height: 18px;
  border: 1px solid #ddd;
  border-radius: 100%;
  background: #fff;
}
[type="radio"]:checked + label:after,
[type="radio"]:not(:checked) + label:after {
  content: "";
  width: 12px;
  height: 12px;
  background: #1f1f1f;
  position: absolute;
  top: 3px;
  left: 3px;
  border-radius: 100%;
  -webkit-transition: all 0.2s ease;
  transition: all 0.2s ease;
}
[type="radio"]:not(:checked) + label:after {
  opacity: 0;
  -webkit-transform: scale(0);
  transform: scale(0);
}
[type="radio"]:checked + label:after {
  opacity: 1;
  -webkit-transform: scale(1);
  transform: scale(1);
}

label {
  padding: 5px 0;
  font-size: 12px;
  font-weight: bold;
}

input[type="text"],
input[type="email"] {
  outline: 0;
  border: 1px solid #e8e8e8;
  padding: 10px;
  border-radius: 2px;
}
/* input[type="text"]:focus,
input[type="email"]:focus {
  outline: 0;
  border: 1px solid black;
} */

.form {
  margin-top: 5px;
  display: flex;
  flex-direction: column;
  position: relative;
}

.bold {
  font-weight: bold;
}

.flight_name {
  font-size: 12px;
  display: flex;
  align-items: center;
  letter-spacing: 0.2px;
  color: #666;
  display: flex;
}

.flex-between {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.flex-center {
  display: flex;
  align-items: center;
  justify-content: center;
}

.flight_data {
  line-height: 19px;
  padding-top: 0;
  padding-bottom: 0;
}

.extra_flight_data {
  line-height: 25px;
  padding-top: 10px;
}

.pl-5 {
  padding-left: 15px;
}

.flight_origin {
  font-family: "Manjari";
}

.flight_origin p {
  font-family: "Manjari";
  font-size: 13px;
}

.flight_departure,
.flight_arrival {
  font-size: 20px;
}

.dropdown {
  background-color: white;
  position: absolute;
  top: 70px;
  left: 0;
  right: 0;
  border: 1px solid black;
  z-index: 9;
}
ul,
li {
  list-style-type: none;
}

.dropdown li {
  line-height: 20px;
}

.dropdown ul > li {
  padding: 10px;
}

.hide {
  display: none !important;
}

.airport_select:hover {
  background-color: #f1f1f1;
  cursor: pointer;
}

.dashed-line {
  border: 0;
  border-top: 1px dashed #bdbdbd !important;
  margin: 20px 0;
  width: 70%
}

.flight_change h5 {
  font-weight: 300;
  color: #949494;
}

.flight_change {
  white-space: pre-wrap;
}

.flight_duration {
  font-size: 15px;
  font-weight: bold;
}

.carrier_icon {
  width: 55px;
  height: 100%;
  object-fit: contain;
  margin-right: 15px;
}

.extra_carrier_icon {
  width: 35px;
  height: 100%;
  object-fit: contain;
  margin-right: 15px;
}

.extra_flight_name p {
  font-size: 11px;
  color: #656565;
  line-height: 18px;
}

.extra_destination {
  font-size: 11px;
  color: #b3b3b3;
}

.show_flight {
  text-decoration: none;
  font-size: 13px;
  color: #2196f3;
  cursor: pointer;
}

.flight_details_border {
  border: 1px solid #e8e8e8;
  padding: 10px 30px;
  margin: 15px 0;
  border-radius: 5px;
}

.popup_form {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  z-index: 10;
  display: flex;
  margin: auto;
  justify-content: center;
  align-items: center;
}

.popup_form:after {
  content: "";
  background-color: rgba(0, 0, 0, 0.6);
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
}

.form_body {
  background-color: white;
  position: absolute;
  min-width: 324px;
  width: auto;
  z-index: 11;
  border-radius: 5px;
}

.bg-image {
  background-image: linear-gradient(
      rgba(0, 0, 0, 0.5),
      rgba(255, 255, 255, 0.05)
    ),
    url(https://gos3.ibcdn.com/flight-1550057390.jpg);
  background-size: cover;
  padding: 0 0 85px;
}

#loading-holder {
  height: 100%;
}
.spinner {
  -webkit-animation: rotator 1.4s linear infinite;
  animation: rotator 1.4s linear infinite;
}

@-webkit-keyframes rotator {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(270deg);
    transform: rotate(270deg);
  }
}

@keyframes rotator {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(270deg);
    transform: rotate(270deg);
  }
}
.path {
  stroke-dasharray: 187;
  stroke-dashoffset: 0;
  -webkit-transform-origin: center;
  transform-origin: center;
  -webkit-animation: dash 1.4s ease-in-out infinite,
    colors 5.6s ease-in-out infinite;
  animation: dash 1.4s ease-in-out infinite, colors 5.6s ease-in-out infinite;
}

@-webkit-keyframes colors {
  0% {
    stroke: #4285f4;
  }
  25% {
    stroke: #de3e35;
  }
  50% {
    stroke: #f7c223;
  }
  75% {
    stroke: #1b9a59;
  }
  100% {
    stroke: #4285f4;
  }
}

@keyframes colors {
  0% {
    stroke: #4285f4;
  }
  25% {
    stroke: #de3e35;
  }
  50% {
    stroke: #f7c223;
  }
  75% {
    stroke: #1b9a59;
  }
  100% {
    stroke: #4285f4;
  }
}
@-webkit-keyframes dash {
  0% {
    stroke-dashoffset: 187;
  }
  50% {
    stroke-dashoffset: 46.75;
    -webkit-transform: rotate(135deg);
    transform: rotate(135deg);
  }
  100% {
    stroke-dashoffset: 187;
    -webkit-transform: rotate(450deg);
    transform: rotate(450deg);
  }
}
@keyframes dash {
  0% {
    stroke-dashoffset: 187;
  }
  50% {
    stroke-dashoffset: 46.75;
    -webkit-transform: rotate(135deg);
    transform: rotate(135deg);
  }
  100% {
    stroke-dashoffset: 187;
    -webkit-transform: rotate(450deg);
    transform: rotate(450deg);
  }
}

/* Animation keyframes - you need to add prefixes */
@-webkit-keyframes spin {
  from {
    -webkit-transform: rotate(0deg);
  }
  to {
    -webkit-transform: rotate(360deg);
  }
}

@-moz-keyframes spin {
  from {
    -moz-transform: rotate(0deg);
  }
  to {
    -moz-transform: rotate(360deg);
  }
}

@-ms-keyframes spin {
  from {
    -ms-transform: rotate(0deg);
  }
  to {
    -ms-transform: rotate(360deg);
  }
}

p {
  color: rgb(3, 27, 78);
}

.relative {
  position: relative;
}

.hot-des h4 {
  color: #333;
  margin-top: 155px;
  text-align: center;
}

.hot-des::before {
  background: none repeat scroll 0 0 #eee;
  border-radius: 100%;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.2);
  content: "";
  display: block;
  height: 100px;
  left: 50%;
  margin-left: -51px;
  position: absolute;
  top: 41px;
  width: 100px;
}

.hot-des::after {
  background: rgba(0, 0, 0, 0) url(/_nuxt/static/sprt.png) no-repeat scroll -322px -530px;
  content: "";
  display: block;
  height: 88px;
  left: 50%;
  margin-left: -36px;
  position: absolute;
  top: 52px;
  width: 66px;
}

.air-code h4 {
  color: #333;
  margin-top: 155px;
  text-align: center;
}

.air-code::before {
  background: none repeat scroll 0 0 #eee;
  border-radius: 100%;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.2);
  content: "";
  display: block;
  height: 100px;
  left: 50%;
  margin-left: -51px;
  position: absolute;
  top: 41px;
  width: 100px;
}

.air-code::after {
  background: rgba(0, 0, 0, 0) url(~static/sprt.png) no-repeat scroll -397px -553px;
  content: "";
  display: block;
  height: 41px;
  left: 50%;
  margin-left: -36px;
  position: absolute;
  top: 72px;
  width: 69px;
}

.air-cont h4 {
  color: #333;
  margin-top: 155px;
  text-align: center;
}

.air-cont::before {
  background: none repeat scroll 0 0 #eee;
  border-radius: 100%;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.2);
  content: "";
  display: block;
  height: 100px;
  left: 50%;
  margin-left: -51px;
  position: absolute;
  top: 41px;
  width: 100px;
}

.air-cont::after {
  background: rgba(0, 0, 0, 0) url(~static/sprt.png) no-repeat scroll -266px -543px;
  content: "";
  display: block;
  height: 59px;
  left: 50%;
  margin-left: -24px;
  position: absolute;
  top: 60px;
  width: 59px;
}
</style>
