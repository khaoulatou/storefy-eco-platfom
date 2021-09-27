<template>
  <div class="container">
    <form action="#" @submit.prevent="Register">
      <div class="row" style="position: relative">
        <h2 style="text-align: center">Register</h2>
        <div class="vl">
          <span class="vl-innertext">or</span>
        </div>

        <div class="col">
          <a href="#" class="fb btn">
            <i class="fa fa-facebook fa-fw"></i> Register with Facebook
          </a>

          <a href="#" class="google btn">
            <i class="fa fa-google fa-fw"></i> Register with Google+
          </a>
        </div>

        <div class="col">
          <div class="hide-md-lg">
            <p>Or sign in manually:</p>
          </div>

          <div class="input__group">
            <label class="group__label" for="first">first name : </label>
            <input
              class="group__input"
              type="text"
              id="first"
              name="firstname"
            />
          </div>
          <div class="error_message">{{ errors.firstname }}</div>
          <div class="input__group">
            <label class="group__label" for="surname">Last Name : </label>
            <input
              class="group__input"
              type="text"
              id="surname"
              name="surname"
            />
          </div>
          <div class="error_message">{{ errors.surname }}</div>

          <div class="input__group">
            <label class="group__label" for="email">email : </label>
            <input class="group__input" type="email" id="email" name="email" />
          </div>
          <div class="error_message">{{ errors.email }}</div>
          <div class="input__group">
            <label class="group__label" for="storename">storename : </label>
            <input
              class="group__input"
              type="text"
              id="storename"
              name="storename"
            />
          </div>
          <div class="error_message">{{ errors.storename }}</div>
          <div class="input__group">
            <label class="group__label" for="subdomain">subdomain : </label>
            <input
              class="group__input"
              type="text"
              id="subdomain"
              name="subdomain"
            />
          </div>
          <div class="error_message">{{ errors.subdomain }}</div>
          <div class="input__group">
            <label class="group__label" style="display: block" for="country"
              >country :
            </label>
            <select
              style="width: 100%; padding: 11px"
              id="country"
              name="country"
              @change="autoChange()"
              ref="countryRef"
            >
              <option value="0">choose your country</option>
              <option
                v-for="country in countries"
                :value="country.name"
                :key="country.name"
              >
                {{ country.name }}
              </option>
            </select>
          </div>
          <div class="error_message">{{ errors.country }}</div>
          <div class="input__group">
            <label class="group__label" for="mobile_number"
              >mobile code :
            </label>
            <input
              class="group__input"
              type="text"
              id="mobile_code"
              ref="mobileCode"
              readonly
            />
          </div>
          <div class="input__group">
            <label class="group__label" for="mobile_number">phone : </label>
            <input
              class="group__input"
              type="text"
              id="mobile_number"
              ref="mobileNumber"
            />
          </div>
          <div class="error_message">{{ errors.mobile_number }}</div>
          <div class="input__group">
            <label class="group__label" for="password">password : </label>
            <input
              class="group__input"
              type="password"
              id="password"
              name="password"
              required
            />
          </div>
          <div class="error_message">{{ errors.password }}</div>
          <div class="input__group">
            <label class="group__label" for="password_confirmation"
              >password :
            </label>
            <input
              class="group__input"
              type="password"
              id="password_confirmation"
              name="password_confirmation"
              required
            />
          </div>
          <div class="input__group input__group--submit">
            <input type="submit" value="submit" />
          </div>
        </div>
      </div>
      <div class="message">
        {{ error }}
      </div>
    </form>
    <div class="bottom-container">
      <div class="row">
        <div>
          <a href="#" style="color: white" class="btn">Sign In</a>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { ref } from "vue";
import getFormData from "../assets/helpers/formData";
import sendRequest from "../assets/helpers/fetch";

export default {
  name: "Register",
  setup() {
    const errors = ref({});
    let countries = ref(null);
    let mobileCode = ref();
    let countryRef = ref();
    let mobileNumber = ref();
    let message = ref();
    (async () => {
      let response = await sendRequest("country", null, "GET", false);
      countries.value = response[0].country;
    })();
    const Register = async (e) => {
      const data = getFormData(Object.fromEntries(new FormData(e.target)));
      data.append(
        "mobile_number",
        `${mobileCode.value.value}${mobileNumber.value.value}`
      );
      const [response, statuscode] = await sendRequest(
        "register",
        data,
        "POST",
        false
      );
      errors.value = {};
      console.log(response);

      if (statuscode === 400) {
        for (const key of Object.keys(response.error)) {
          console.log(response.error[key]);
          [errors.value[key]] = response.error[key];
        }
      }
      if (statuscode === 201) {
        console.log(response);
        localStorage.setItem("token", response.token);
        alert(response.message);
        let myHeaders = new Headers();
        myHeaders.append(
          "Authorization",
          `Bearer ${localStorage.getItem("token")}`
        );

        let requestOptions = {
          method: "POST",
          headers: myHeaders,
          redirect: "follow",
        };

        fetch(
          "http://localhost:8000/api/v1/email/verification-notification",
          requestOptions
        )
          .then((response) => response.json())
          .then((result) => alert(result.message));
      }
    };

    const autoChange = () => {
      let country = countryRef.value.value;
      mobileCode.value.value = countries.value.filter(
        (element) => element.name === country
      )[0].callingCode;
    };
    return {
      Register,
      errors,
      countries,
      mobileCode,
      countryRef,
      autoChange,
      mobileNumber,
      message,
    };
  },
};
</script>
<style scoped>
* {
  box-sizing: border-box;
}

/* style the container */
.container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px 25px 30px 25px;
  width: 80%;
  display: flex;
  justify-content: center;
  flex-direction: column;
  margin: auto;
}
.input__group {
  /* display: block; */
  width: 100%;
}
/* style inputs and link buttons */
input,
.btn {
  width: 100%;
  padding: 12px;
  border: none;
  border-radius: 4px;
  margin: 5px 0;
  opacity: 0.85;
  display: inline-block;
  font-size: 17px;
  line-height: 20px;
  text-decoration: none; /* remove underline from anchors */
}

input:hover,
.btn:hover {
  opacity: 1;
}

/* add appropriate colors to fb, twitter and google buttons */
.fb {
  background-color: #3b5998;
  color: white;
}

.twitter {
  background-color: #55acee;
  color: white;
}

.google {
  background-color: #dd4b39;
  color: white;
}

/* style the submit button */
input[type="submit"] {
  background-color: #04aa6d;
  color: white;
  cursor: pointer;
}

input[type="submit"]:hover {
  background-color: #45a049;
}

/* Two-column layout */
.col {
  float: left;
  width: 50%;
  margin: auto;
  padding: 0 50px;
  margin-top: 6px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* vertical line */
.vl {
  position: absolute;
  left: 50%;
  transform: translate(-50%);
  height: 90px;
  background-color: white;
  width: 0px;
  display: flex;
  justify-content: center;
  flex-direction: column;
  align-items: center;
  top: 7%;
}

/* text inside the vertical line */
.inner {
  position: absolute;
  top: 50%;
  transform: translate(-50%, -50%);
  background-color: #f1f1f1;
  border: 1px solid #ccc;
  border-radius: 50%;
  padding: 8px 10px;
}

/* hide some text on medium and large screens */
.hide-md-lg {
  display: none;
}

/* bottom container */
.bottom-container {
  text-align: center;
  background-color: #666;
  border-radius: 0px 0px 4px 4px;
}

/* Responsive layout - when the screen is less than 650px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 650px) {
  .col {
    width: 100%;
    margin-top: 0;
  }
  /* hide the vertical line */
  .vl {
    display: none;
  }
  /* show the hidden text on small screens */
  .hide-md-lg {
    display: block;
    text-align: center;
  }
}
</style>
