<template>
  <div class="container row">
      <div class="col-md-4" ></div>
      <div class="col-md-6">
          <p style="color:blue">
              By default we set $10 for your gift thanks
          </p>
        <div class="form-group">
            <label>Gift Price : $</label>
            <input class="form-control" v-model="product.price" placeholder="Gift Price :">
        </div>
        <div class="form-group">
            <label>Payment description : $</label>
            <textarea class="form-control" v-model="product.description" ></textarea>
        </div>
        <div id="paypal-button-container"></div>
      </div>
      <div class="col-md-2"></div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
    name:"PayPalPayment",
    props:['user_id'],
    data(){
        return{
            product:{
                price:10,
                description:"Gift for your video",
            }
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
            formData.append('price',this.product.price);
            formData.append('description',this.product.description);
            formData.append('user_id',this.user_id);
            axios.post("/user-payment",formData)
            .then((response) => {
                if(response.data.status){
                    window.location.href = "/posts";
                }
            });
        }
    }
}
</script>

<style>

</style>