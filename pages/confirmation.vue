<template>
    <div class="container section">
              <div class="" style="padding:30px;text-align:center">
        <p
          style="position:absolute;right:10px;top:0;font-size:25px;cursor:pointer"
        >x</p>
        <div class="row">
          <div class="col s24">
            <h4 style="padding-bottom:10px">Please save the transaction ID for future reference</h4>
            <p style="padding-bottom:10px">Transaction ID: <br></p>
            <p style="    color: black;
    font-weight: bold;
    padding: 20px 0;
    border: 1px dashed grey;
    background-color: #e2e2e2;
    width: 30%;
    margin: 10px 0 20px;
    margin: auto;
    text-align: center;
    margin-bottom: 30px;
"> {{ transaction_id }} </p>
            <p style="padding-bottom:10px">Call the below Toll free Number to confirm your booking at the lowest fare</p>
            <p style="color:black;font-weight:bold"> <a href="tel:+1-888-454-1363">
                +1-888-454-1363
            </a></p>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
export default {
    data: () => ({
           transaction_id : "" 
  }),
  
  mounted() {
    
        this.transaction_id = localStorage.getItem("transaction")

  }
}
</script>