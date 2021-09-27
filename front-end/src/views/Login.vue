<template>
  <div class="container">
    <form action="#" @submit.prevent="login">
      <div class="row" style="position: relative">
        <h2 style="text-align: center">Login</h2>
        <div class="vl">
          <span class="vl-innertext">or</span>
        </div>

        <div class="col">
          <a @click="loginGoogle('facebook')" class="fb btn">
            <i class="fa fa-facebook fa-fw"></i> Login with Facebook
          </a>

          <a @click="loginGoogle('google')" class="google btn">
            <i class="fa fa-google fa-fw"></i> Login with Google+
          </a>
        </div>

        <div class="col">
          <div class="hide-md-lg">
            <p>Or sign in manually:</p>
          </div>

          <input
            type="email"
            id="email"
            name="email"
            required
            placeholder="email"
            v-model="email"
          />
          <input
            type="password"
            name="password"
            placeholder="Password"
            required
          />
          <input type="submit" value="Login"/>
        </div>
      </div>
      <div class="message">
        {{ error }}
      </div>
    </form>
    <div class="bottom-container">
      <div class="row">
        <div class="col">
          <a href="#" style="color: white" class="btn">Sign up</a>
        </div>
        <div class="col">
          <a href="#" style="color: white" class="btn">Forgot password?</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {ref} from "vue";
import sendRequest from "../assets/helpers/fetch";
import getFormData from "../assets/helpers/formData";
import { useRouter, useRoute } from 'vue-router'


const apiEndpoint = "http://localhost:8000";

function openWindow(url, title, options = {}) {
  if (typeof url === "object") {
    options = url;
    url = "";
  }
  options = {url, title, width: 600, height: 720, ...options};
  const dualScreenLeft =
    window.screenLeft !== undefined ? window.screenLeft : window.screen.left;
  const dualScreenTop =
    window.screenTop !== undefined ? window.screenTop : window.screen.top;
  const width =
    window.innerWidth ||
    document.documentElement.clientWidth ||
    window.screen.width;
  const height =
    window.innerHeight ||
    document.documentElement.clientHeight ||
    window.screen.height;
  options.left = width / 2 - options.width / 2 + dualScreenLeft;
  options.top = height / 2 - options.height / 2 + dualScreenTop;
  const optionsStr = Object.keys(options)
    .reduce((acc, key) => {
      acc.push(`${key}=${options[key]}`);
      return acc;
    }, [])
    .join(",");
  const newWindow = window.open(url, title, optionsStr);
  if (window.focus) {
    newWindow.focus();
  }
  return newWindow;
}

export default {
  mounted() {
    window.addEventListener("message", this.onMessage, false);
  },

  beforeDestroy() {
    window.removeEventListener("message", this.onMessage);
  },
  methods: {
    loginGoogle(provider) {
      const newWindow = openWindow(
        `${apiEndpoint}/api/v1/authorize/${provider}/redirect`,
        "message"
      );
    },

    // This method save the new token and username
    onMessage(e) {
      if (e.origin !== apiEndpoint || e.data.token === undefined) {
        // error
        return;
      }
      console.log("error", e.data.error);
      console.log("test333");
      console.log("token", e.data.token);
      console.log("user", e.data.user);
      console.log("new-user", e.data.new);
      localStorage.setItem("user", e.data.user);
      localStorage.setItem("token", e.data.token);
    },
  },
  name: "Login",
  setup() {
    const error = ref();
    const email = ref();
    const route = useRouter();
    const login = async (e) => {
      const data = getFormData(Object.fromEntries(new FormData(e.target)));
      let myHeaders = new Headers();
      myHeaders.append("Accept", "application/json");

      let requestOptions = {
        method: "POST",
        headers: myHeaders,
        body: data,
        redirect: "follow",
      };

      const request = await fetch(
        "http://localhost:8000/api/v1/login",
        requestOptions
      );
      const response = await request.json();
      if (request.status === 403) {
        console.log("test")
        console.log(email.value)
        route.push({name: 'verifiedAccount', query: {email: email.value}});
      }
      if (request.status !== 201) {
        alert(response.message);
        error.value = response.message;
      } else {
        await (async () => {
          let response = await sendRequest("pixel", null, "GET", true);
          console.log(response);
          let pixels = response[0].data;
          pixels.forEach((pixel) => {
            document.head.insertAdjacentHTML("beforeend", pixel.pixel);
          });
        })();
      }
      console.log(response);
    };
    return {
      login,
      error,
      email
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
  /* width: ; */
  width: 50%;
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
  top: 30%;
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
