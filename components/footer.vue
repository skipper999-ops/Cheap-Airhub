<template>
  <div class="footer">
    <div class="container section space-footer">
      <div class="row footer hidden-xs">
        <div class="col s24 m12 l6">
          <div class="help-cen">
            <ul>
              <li style="margin: 30px 0 10px">Help Center</li>
              <li>
                <div class="faq">
                  <nuxt-link to="/faq">FAQ</nuxt-link>
                </div>
              </li>
              <li>
                <nuxt-link to="/contact" class="btn btn-default b-footer btn-xs">Contact Us</nuxt-link>
              </li>
            </ul>
          </div>
        </div>

        <div class="hidden-xs col s24 m12 l6">
          <div class="about">
            <ul>
              <li style="margin: 30px 0 10px">About Us</li>

              <li>
                <div class="pri-pol">
                  <nuxt-link
                    to="/aboutus/privacypolicy"
                    class="btn btn-default b-footer btn-xs"
                  >Privacy Policy</nuxt-link>
                </div>
              </li>

              <li>
                <div class="term-of">
                  <nuxt-link
                    to="/aboutus/termsofuse"
                    class="btn btn-default b-footer btn-xs"
                  >Terms of Use</nuxt-link>
                </div>
              </li>

              <li>
                <div class="com-prac">
                  <nuxt-link
                    to="/aboutus/commonpractices"
                    class="btn btn-default b-footer btn-xs"
                  >Common Practice</nuxt-link>
                </div>
              </li>

              <li>
                <div class="diff">
                  <nuxt-link
                    to="/aboutus/differentiation"
                    class="btn btn-default b-footer btn-xs"
                  >Differentiation</nuxt-link>
                </div>
              </li>

              <li>
                <div class="pricing-pol">
                  <nuxt-link
                    to="/aboutus/pricingpolicy"
                    class="btn btn-default b-footer btn-xs"
                  >Pricing policy</nuxt-link>
                </div>
              </li>
              <li>
                <div class="pricing-pol">
                  <nuxt-link
                    to="/aboutus/cookiepolicy"
                    class="btn btn-default b-footer btn-xs"
                  >Cookie policy</nuxt-link>
                </div>
              </li>
            </ul>
          </div>
        </div>
        <div class="col s24 m24 l6">
          <div class="suppliers" style="margin: 30px 0 10px">
            <strong></strong>
          </div>
        </div>
        <div class="col s24 m24 l6">
          <div class="news-letter" style="margin: 30px 0 10px">
            <strong>Newsletter</strong>
            <p style="font-size:13px;padding: 9px 0;">Subscribe to our GREAT DEALS for you</p>
            <div class="form-group">
              <form id="subscribe-validate" novalidate="novalidate">
                <input
                  type="email"
                  @keydown="checkemail"
                  class="form-control required email _ar_hide_ valid"
                  id="emailSubscribe"
                  placeholder="Enter Your email Here"
                  _ar_hide_="width:350px;height:34px;margin:0px;position:static;display:block;"
                  style="z-index: 1;"
                  aria-required="true"
                  aria-invalid="false"
                />
                <label
                  id="emailSubscribe-error"
                  class="error"
                  for="emailSubscribe"
                  style="display: none;"
                ></label>
                <label id="subscribe-msg" class="subscribe-msg success"></label>
                <p
                  v-if="showingSub == true"
                  style="font-size:13px;padding: 9px 0 0; color: green"
                >Your subscription has been confirmed.</p>
              </form>
              <button
                :disabled="isDisabled == false"
                @click="subscribe"
                type="button"
                class="btn-sub btn-warning"
              >SUBSCRIBE</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<style scoped>
a {
  text-decoration: none;
  color: black;
}

.space-footer {
  padding-top: 20px;
}

ul,
.news-letter {
  color: black;
}

.footer {
  background-color: #f1f1f1;
}

.suppliers:after {
  background: url(~static/sprt.png) no-repeat scroll -524px -291px
    rgba(0, 0, 0, 0);
  content: "";
  display: block;
  height: 68px;
  margin-bottom: 15px;
  margin-top: 15px;
  width: 240px;
}

ul li:first-child {
  font-weight: bold;
}
ul li:not(:first-child) {
  line-height: 25px;
  font-size: 13px;
}

.btn-sub[disabled] {
  cursor: not-allowed;
  background-color: #ababab;
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
</style>


<script>
export default {
  data() {
    return {
      showingSub: false,
      isDisabled: false
    };
  },
  methods: {
    validateEmail: function(email) {
      var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email);
    },
    checkemail: function() {
      if (this.validateEmail($("#emailSubscribe").val()) == false) {
        this.isDisabled = false;
      } else {
        this.isDisabled = true;
      }
    },
    subscribe: function() {
      if (this.validateEmail($("#emailSubscribe").val()) == false) {
        this.showingSub = false;
      } else {
        this.showingSub = true;
      }
    }
  }
};
</script>