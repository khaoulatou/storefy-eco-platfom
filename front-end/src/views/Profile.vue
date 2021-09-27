<template>
  <div class="container">
    <form>
      <div class="form-group">
        <label for="fName">First Name</label>
        <input
          type="text"
          class="form-control"
          id="fName"
          placeholder="Enter Your First Name"
        />
      </div>
      <div class="form-group">
        <label for="lName">Last Name</label>
        <input
          type="text"
          class="form-control"
          id="lName"
          placeholder="Enter Your Last Name"
        />
      </div>
      <div class="form-group">
        <label for="storeName">Store Name :</label>
        <input
          type="text"
          class="form-control"
          id="storeName"
          placeholder="Enter Store Name"
        />
      </div>
      <div class="form-group">
        <label for="subdomain">Sub Domain :</label>
        <input
          type="text"
          class="form-control"
          id="subdomain"
          placeholder="Enter Sub Domain"
        />
      </div>
      <div class="form-group">
        <label for="country">Country :</label>
        <select
          id="country"
          class="form-select"
          aria-label="Default select example"
        >
          <option selected>Choose your country</option>
          <option value="1">Morocco</option>
          <option value="2">Casablanca</option>
          <option value="3">Fes</option>
        </select>
      </div>
      <div class="row">
        <div class="col-2">
          <label for="mobileCode">Mobile code :</label>
          <input type="text" class="form-control" readonly />
        </div>
        <div class="col-10">
          <label for="mobileCode">Phone Number :</label>
          <input
            type="text"
            class="form-control"
            id="phoneNumber"
            placeholder="Enter Your Phone Number"
          />
        </div>
      </div>
      <div class="form-group">
        <label for="companyName">Company Name :</label>
        <input
          type="text"
          class="form-control"
          id="subdomain"
          placeholder="Enter Your Company Name"
        />
      </div>

      <div class="row g-3">
        <div class="col-sm-3">
          <label class="visually-hidden" for="specificSizeInputName"
            >Name</label
          >
          <input
            type="text"
            class="form-control"
            id="specificSizeInputName"
            placeholder="Jane Doe"
          />
        </div>
        <div class="col-sm-3">
          <label class="visually-hidden" for="specificSizeInputName"
            >Name</label
          >
          <input
            type="text"
            class="form-control"
            id="specificSizeInputName"
            placeholder="Jane Doe"
          />
        </div>
      </div>

      <div class="mb-3">
        <label for="formFileMultiple" class="form-label"
          >Multiple files input example</label
        >
        <input
          class="form-control"
          type="file"
          id="formFileMultiple"
          multiple
        />
      </div>
      <button type="submit" class="btn btn-primary">
        Update your information
      </button>
    </form>
  </div>
</template>

<script>
export default {
  name: "Profile",
  data() {
    return {
      name: "",
    };
  },
  methods: {},
};
</script>
