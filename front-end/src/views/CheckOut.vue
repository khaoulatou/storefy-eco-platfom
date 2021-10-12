<template>
  <div class="container">
    <!-- Content here -->
    <form class="row g-3" @submit.prevent="addCommande">
      <div class="col-8">
        <div class="row">
          <div class="col-md-6">
            <label for="destinataire" class="form-label">Destinataire</label>
            <input
              type="text"
              class="form-control"
              id="destinataire"
              placeholder="Enter recipient data"
              v-model="form.destinataire"
            />
          </div>
          <div class="col-md-6">
            <label for="ville" class="form-label">Ville Customer</label>
            <input
              type="text"
              class="form-control"
              id="ville"
              placeholder="Enter the city"
              v-model="form.ville_customer"
            />
          </div>
          <div class="col-md-6">
            <label for="phone1" class="form-label">phone 1</label>
            <input
              type="phone"
              class="form-control"
              id="phone1"
              placeholder="Enter the first number"
              v-model="form.phone1"
            />
          </div>
          <div class="col-md-6">
            <label for="phone2" class="form-label">phone 2</label>
            <input
              type="phone"
              class="form-control"
              id="phone2"
              placeholder="Enter the second number"
              v-model="form.phone2"
            />
          </div>
          <div class="col-12">
            <label for="inputAddress" class="form-label">Address</label>
            <input
              type="text"
              class="form-control"
              id="inputAddress"
              placeholder="Enter the address"
              v-model="form.address"
            />
          </div>
          <div class="col-12">
            <button type="submit" class="btn btn-primary">CHECKOUT</button>
          </div>
        </div>
      </div>

      <!-- Summary -->

      <div class="col-md-4 summary">
        <div>
          <h5><b>Summary</b></h5>
        </div>
        <hr />
        <div class="row">
          <div class="col" style="padding-left: 0">
            ITEMS {{ productData.length }}
          </div>
          <div class="col text-right">$ {{ total }}</div>
        </div>
        <form>
          <p>SHIPPING</p>
          <select>
            <option class="text-muted">Standard-Delivery- &euro;5.00</option>
          </select>
          <p>GIVE CODE</p>
          <input
            id="code"
            placeholder="Enter your code"
            @change="getCoupon"
            v-model="form.coupon"
          />
        </form>
        <div
          class="row"
          style="border-top: 1px solid rgba(0, 0, 0, 0.1); padding: 2vh 0"
        >
          <div class="col">TOTAL PRICE</div>
          <div class="col text-right">
            {{ `$ ${coupooon}` }}
          </div>
        </div>
      </div>
      <!-- End Summary -->
    </form>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "checkout",
  mounted() {
    this.productData = JSON.parse(localStorage.getItem("produits"));
    this.getTotal();
  },
  data() {
    return {
      productData: [],
      statusCoupon: null,
      totaleRemise: null,
      form: {
        destinataire: "",
        ville_customer: "",
        phone1: "",
        phone2: "",
        address: "",
        coupon: null,
        couponData: "",
      },
      total: null,
    };
  },

  methods: {
    getTotal() {
      this.total = this.productData.reduce(
        (acc, el) => acc + el.prix * el.quantity,
        0
      );
    },
    async getCoupon() {
      if (this.form.coupon) {
        const response = await axios.post(
          `http://localhost:8000/api/v1/getCoupon/${this.form.coupon}`,
          null
        );
        this.statusCoupon = response.data.success;
        if (response.data.success) {
          alert(response.data.message);
          this.couponData = response.data.data;
          let totaleRemise = "";
          if (this.couponData.type_prix == "percentage") {
            totaleRemise = this.total * (1 - this.couponData.remise / 100);
            this.totaleRemise = totaleRemise.toFixed(2);
          } else {
            totaleRemise = this.total - this.couponData.remise;
            this.totaleRemise = totaleRemise.toFixed(2);
          }
        } else {
          alert(response.data.message);
        }
      } else {
        this.statusCoupon = false;
      }
    },
    async addCommande() {
      // POST request using axios with async/await
      const commande = {
        products: this.productData,
        commande: this.form,
      };
      console.log(this.form);
      const response = await axios.post(
        "http://localhost:8000/api/v1/createCommande",
        commande
      );
      console.log(response.data);
    },
  },
  computed: {
    coupooon() {
      return this.statusCoupon ? this.totaleRemise : this.total;
    },
  },
};
</script>

<style>
</style>