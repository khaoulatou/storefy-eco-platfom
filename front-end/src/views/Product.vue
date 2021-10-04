<template>
  <!--Section: Block Content-->
  <div class="container-fluid mt-4 mb-4">
    <div class="row g-2 justify-content-between">
      <div
        class="col-md-4"
        v-for="(produit, index) in listProduits"
        :value="produit.id"
        :key="index"
      >
        <div class="card h-auto m-4">
          <div class="img-container h-auto">
            <div
              class="
                h-auto
                d-flex
                justify-content-between
                align-items-center
                p-2
                first
              "
            >
              <span class="percent">-25%</span>
              <span class="wishlist"><i class="fa fa-heart"></i></span>
            </div>
            <img
              :src="require(`@/assets/images/${produit.cover}`)"
              class="img-card"
            />
          </div>
          <div class="product-detail-container">
            <div class="d-flex justify-content-between align-items-center">
              <h6 class="mb-0">{{ produit.titre }}</h6>
              <span class="text-danger font-weight-bold"
                >{{ produit.prix }}$</span
              >
            </div>
            <div class="d-flex justify-content-between align-items-center mt-2">
              <div class="ratings">
                <i class="fa fa-star"></i> <span>4.5</span>
              </div>
            </div>
            <div class="d-flex justify-content-around align-items-center mt-3">
              <div>
                <button
                  class="btn btn-success btn-block"
                  @click="addToArry(produit)"
                >
                  Add To cart
                </button>
              </div>
              <div>
                <button class="btn btn-danger btn-block">Buy Now</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--Section: Block Content-->
</template>

<script>
import axios from "axios";
export default {
  name: "ProductComponnent",
  inject: ["message"],
  mounted() {
    this.getProduit();
    if (localStorage.getItem("produits")) {
      try {
        this.panierProduit = JSON.parse(localStorage.getItem("produits"));
      } catch (e) {
        localStorage.removeItem("produits");
      }
    }
  },
  data() {
    return {
      listProduits: [],
      panierProduit: [],
      ProduitArr: [],
      compt: 0,
    };
  },

  methods: {
    async getProduit() {
      const res = await axios.get("http://localhost:8000/api/v1/produit");
      console.log(res.data);
      this.listProduits = res.data;
    },
    addToArry(produit) {
      this.message.message = "added successfully!";
            console.log(this.message.message);
            setTimeout(function() {
              this.message.message = "";
            }.bind(this), 3000);
      let proObj = { ...produit, quantity: 1 };
      let localData = JSON.parse(localStorage.getItem("produits"));
      if (!localData?.some((ele) => ele.id == produit.id)) {
        this.ProduitArr.push(proObj);
        localStorage.setItem("produits", JSON.stringify(this.ProduitArr));
      } else {
        console.log("localStorage is note empty");
        this.ProduitArr = JSON.parse(localStorage.getItem("produits"));
        let newData = this.ProduitArr.map(function (el) {
          console.log(el);
          if (el.id == produit.id) {
            // console.log(el.id);
            // el.quantity++;
            // console.log(Number(el.quantity));
            this.message.message = "already added!";
            this.message.error = true;
            console.log(this.message.message);
            setTimeout(function() {
              this.message.message = "";
            this.message.error = false;
            }.bind(this), 3000);
            // alert("the product is already added");
          }
          return el;
        }.bind(this));
        console.log(newData);
        localStorage.setItem("produits", JSON.stringify(newData));
      }

      // let existProduit = this.ProduitArr.map(function (el) {
      //   if (el.id == produit.id) {
      //     el.quantity++;
      //     console.log(Number(el.quantity));
      //   }
      //   return el
      // });
    },
    // async create() {
    //   // this.resultat = await this.getTimes();
    //   // console.log(this.resultat);

    //   const res = axios.post(
    //     "http://localhost/gRendezVous/ApiAppointement/createAnAppointement",
    //     {
    //       userId_fk: sessionStorage.getItem("userId"),
    //       timeslot_id_fk: this.id,
    //       user_subject: this.description,
    //       c_date: this.dateOfAppointement,
    //     }
    //   );
    //   console.log(res);
    //   swal(
    //     "Good job!",
    //     "Congratulations ! Your information has been registered ! ",
    //     "success"
    //   );
    //   (this.dateOfAppointement = ""),
    //     (this.description = ""),
    //     (this.times = "");
    //   if (res) {
    //     this.$router.push("/Dashbord");
    //   }
    // },
  },
};
</script>

<style>
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap");

.card {
  border: none;
  border-radius: 10px;
}

.percent {
  padding: 5px;
  background-color: red;
  border-radius: 5px;
  color: #fff;
  font-size: 14px;
  height: 35px;
  width: 70px;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
}

.wishlist {
  height: 40px;
  width: 40px;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 50%;
  background-color: #eee;
  padding: 10px;
  cursor: pointer;
}

.img-container {
  position: relative;
}
.img-card {
  height: 20rem;
  width: 100%;
}

.img-container .first {
  position: absolute;
  width: 100%;
}

.img-container img {
  border-top-left-radius: 5px;
  border-top-right-radius: 5px;
}

.product-detail-container {
  padding: 10px;
}

.ratings i {
  color: #a9a6a6;
}

.ratings span {
  color: #a9a6a6;
}

label.radio {
  cursor: pointer;
}

label.radio input {
  position: absolute;
  top: 0;
  left: 0;
  visibility: hidden;
  pointer-events: none;
}

label.radio span {
  height: 25px;
  width: 25px;
  display: flex;
  justify-content: center;
  align-items: center;
  border: 2px solid #dc3545;
  color: #dc3545;
  font-size: 10px;
  border-radius: 50%;
  text-transform: uppercase;
}

label.radio input:checked + span {
  border-color: #dc3545;
  background-color: #dc3545;
  color: #fff;
}
</style>