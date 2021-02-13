<template>
  <div class="container row">
      <div class="col-md-7">
          <p style="color:blue">
            Please choose how much to buy
          </p>
        <div class="form-group">
            <label>Price : $</label>
            <input type="number" class="form-control" v-model="product.price" placeholder="Gift Price :">
        </div>
        
        <div id="paypal-button-container"></div>
      </div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
    name:"ByeCoin",
    props:['user_id'],
    data(){
        return{
            product:{
                price:1,
                description:"Bye",
            },
        }
    },
    mounted:function(){
        const script = document.createElement("script");
            script.src="https://www.paypal.com/sdk/js?client-id=ASyBLrCpsjB4fKGdtshk9gYl2LukxGtom0EKNX_AQ2ONJZ9utCJx78047JX9I5pDZjYoTE6PUKda0Y6v";
            script.addEventListener("load",this.setLoaded);
            document.body.appendChild(script);
    },
    methods:{
        setLoaded:function(){
            window.paypal.Buttons({
                createOrder:(data, actions) => {
                // This function sets up the details of the transaction, including the amount and line item details.
                return actions.order.create({
                    purchase_units: [{
                    amount: {
                        value: this.product.price,
                    }
                    }]
                });
                },
                onApprove: async(data, actions) => {
                // This function captures the funds from the transaction.
                const order = await actions.order.capture();
                this.submitPayment();
                }
            }).render('#paypal-button-container');
        },

        submitPayment(){
            const formData = new FormData();
            formData.append('amount',this.product.price);
            formData.append('user_id',this.user_id);
            axios.post("/bye-coin",formData)
            .then((response) => {
                console.log(response);
                if(response.data.status){
                    window.location.href = "/";
                }
            })
            .catch((err)=>{
                console.log("error "+err);
            });
        }
    }
}
</script>

<style>

</style>