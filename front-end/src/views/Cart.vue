<template>
  <!--Section: Block Content-->

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
            <h5 class="text-grey mt-1 mr-1 ml-1 p-1">{{ produit.quantity }}</h5>
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
    </div>
  </div>
  <!--Section: Block Content-->
</template>

<script>
export default {
  name: "cart",
   data() {
    return {
      localData:[],
      // panierProduit: [],
      ProduitArr: [],
      // compt: 0,
    };
  },
  mounted() {
    this.localData=JSON.parse(localStorage.getItem('produits'))
  },


  methods: {
    removeProduit(id) {
      console.log(id);
      this.localData = this.localData.filter((element) => element.id !== id);
      localStorage.setItem("produits", JSON.stringify(this.localData));
    },
    add(id){
      console.log('add');
      this.localData  = this.localData.map(element=>{
        if(element.id==id){
          element.qauntity++
        }
        return element
      });
      localStorage.setItem("produits", JSON.stringify(this.localData));
    },
        minus(id){
      this.localData  = this.localData.map(element,i,arr=>{
        if(element.id==id){
          if(element.qauntity==0){
            return arr.filter(ele=>ele.id!=id);
          }else {
            element.qauntity--;
          }
        }
      });
      localStorage.setItem("produits", JSON.stringify(this.localData));
    }
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
</style>