<template>
  <!--Section: Block Content-->
  <div>
    <div class="container mt-5 mb-5">
      <div class="d-flex justify-content-center row">
        <div class="col-md-8">
          <div class="p-2">
            <h4>Shopping cart</h4>
            <div class="d-flex flex-row align-items-center pull-right">
              <span class="mr-1">Sort by:</span
              ><span class="mr-1 font-weight-bold">Price</span
              ><i class="fa fa-angle-down"></i>
            </div>
          </div>
          <div
            v-for="(produit, index) in localData"
            :value="produit.id"
            :key="index"
            class="
              d-flex
              flex-row
              justify-content-between
              align-items-center
              p-2
              bg-white
              mt-4
              px-3
              rounded
            "
          >
            <div class="mr-1">
              <img
                class="rounded"
                :src="require(`@/assets/images/${produit.cover}`)"
                width="70"
              />
            </div>
            <div class="d-flex flex-column align-items-center product-details">
              <span class="font-weight-bold">{{ produit.titre }}</span>
            </div>
            <div class="d-flex flex-row align-items-center qty">
              <i class="fa fa-minus text-danger" @click="minus(produit.id)"></i>
              <h5 class="text-grey mt-1 mr-1 ml-1 p-1">
                {{ produit.quantity }}
              </h5>
              <i class="fa fa-plus text-success" @click="add(produit.id)"></i>
            </div>
            <div>
              <h5 class="text-grey">{{ produit.prix * produit.quantity }} $</h5>
            </div>
            <div class="d-flex align-items-center">
              <i
                class="fa fa-trash mb-1 text-danger"
                @click="removeProduit(produit.id)"
              ></i>
            </div>
          </div>
          <!-- <div>Total : {{ total }}</div> -->
          <div
            class="d-flex flex-row align-items-center mt-3 p-2 bg-white rounded"
          >
            <button
              class="btn btn-warning btn-block btn-lg ml-2 pay-button"
              type="button"
            >
              Proceed to Pay
            </button>
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
              ITEMS {{ localData.length }}
            </div>
            <div class="col text-right">$ {{ total }}</div>
          </div>
          <form>
            <p>SHIPPING</p>
            <select>
              <option class="text-muted">Standard-Delivery- &euro;5.00</option>
            </select>
            <p>GIVE CODE</p>
            <input id="code" placeholder="Enter your code" />
          </form>
          <div
            class="row"
            style="border-top: 1px solid rgba(0, 0, 0, 0.1); padding: 2vh 0"
          >
            <div class="col">TOTAL PRICE</div>
            <div class="col text-right">$ {{ total + 5 }}</div>
          </div>
          <button class="btn">CHECKOUT</button>
        </div>
      </div>
    </div>
  </div>

  <!--Section: Block Content-->
</template>

<script>
export default {
  name: "cart",
  mounted() {
    this.localData = JSON.parse(localStorage.getItem("produits"));
    this.getTotal();
  },
  data() {
    return {
      localData: [],
      total: null,
      // panierProduit: [],
      ProduitArr: [],
      // compt: 0,
    };
  },

  methods: {
    getTotal() {
      this.total = this.localData.reduce(
        (acc, el) => acc + el.prix * el.quantity,
        0
      );
    },
    removeProduit(id) {
      console.log(id);
      if (confirm("Are you sure remove this product ?")) {
        this.localData = this.localData.filter((element) => element.id !== id);
        localStorage.setItem("produits", JSON.stringify(this.localData));
        this.getTotal();
      }
    },
    add(idP) {
      let newData = this.localData.map((element) => {
        if (element.id == idP) {
          element.quantity++;
        }
        return element;
      });
      localStorage.setItem("produits", JSON.stringify(newData));
      this.getTotal();
    },
    minus(idPS) {
      let newData = this.localData.map((element) => {
        if (element.id == idPS) {
          if (element.quantity > 1) {
            element.quantity--;
          } else {
            this.removeProduit(idPS);
          }
        }
        return element;
      });
      this.getTotal();
      localStorage.setItem("produits", JSON.stringify(newData));
    },
  },
};
</script>

<style>
@import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css");
body {
  font-family: "Manrope", sans-serif;
  background: #eee;
}

.size span {
  font-size: 11px;
}

.color span {
  font-size: 11px;
}

.product-deta {
  margin-right: 70px;
}

.gift-card:focus {
  box-shadow: none;
}

.pay-button {
  color: #fff;
}

.pay-button:hover {
  color: #fff;
}

.pay-button:focus {
  color: #fff;
  box-shadow: none;
}

.text-grey {
  color: #a39f9f;
}

.qty i {
  font-size: 11px;
}
.summary {
  background-color: #ddd;
  border-top-right-radius: 1rem;
  border-bottom-right-radius: 1rem;
  padding: 4vh;
  color: rgb(65, 65, 65);
}

@media (max-width: 767px) {
  .summary {
    border-top-right-radius: unset;
    border-bottom-left-radius: 1rem;
  }
}

.summary .col-2 {
  padding: 0;
}

.summary .col-10 {
  padding: 0;
}
select {
  border: 1px solid rgba(0, 0, 0, 0.137);
  padding: 1.5vh 1vh;
  margin-bottom: 4vh;
  outline: none;
  width: 100%;
  background-color: rgb(247, 247, 247);
}

input {
  border: 1px solid rgba(0, 0, 0, 0.137);
  padding: 1vh;
  margin-bottom: 4vh;
  outline: none;
  width: 100%;
  background-color: rgb(247, 247, 247);
}

input:focus::-webkit-input-placeholder {
  color: transparent;
}

a {
  color: black;
}

a:hover {
  color: black;
  text-decoration: none;
}

#code {
  background-image: linear-gradient(
      to left,
      rgba(255, 255, 255, 0.253),
      rgba(255, 255, 255, 0.185)
    ),
    url("https://img.icons8.com/small/16/000000/long-arrow-right.png");
  background-repeat: no-repeat;
  background-position-x: 95%;
  background-position-y: center;
}
</style>