<template>
    <div class="success-page">
        <h1>Checkout Successful!</h1>
        <p>Your payment was successful, and your order is now complete.</p>
        <router-link to="/" class="btn">Go to Homepage</router-link>
    </div>
</template>

<script>
export default {
    name: "SuccessPage",
};
</script>

<style scoped>
.success-page {
    text-align: center;
    padding: 50px;
}

.success-message {
    background-color: #4caf50;
    color: white;
    padding: 20px;
    border-radius: 10px;
    display: inline-block;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    margin-top: 20px;
}
</style>
