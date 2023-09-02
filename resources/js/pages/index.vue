<template>
    <div>
        <div class="flex justify-center py-10 gap-5">
             wallet address : {{ account }}
            <el-button @click="login">Login</el-button>
        </div>
    </div>
</template>

<script setup>
import Web3Modal from "web3modal";
import Web3 from "web3";
import { ref, reactive, onUnmounted, onMounted } from 'vue';
import { useApiBridge } from "../axios/axios";
let provider = null;
const account = ref();

onMounted(() => {
    if (window.ethereum){
        init();
    }else {
        alert('Please use wallet to enter')
    }
});
// Define the function to be executed on disconnection
const onDisconnect = (code, reason) => {
    console.log('User disconnected')
    alert('User disconnected')
}
onUnmounted(() => {
    // Unregister the function from the provider
    provider.off('disconnect', onDisconnect)
});
const init = async () => {
    let web3Modal = new Web3Modal({
        cacheProvider: false, // optional
        disableInjectedProvider: false, // optional. For MetaMask / Brave / Opera.
    });
    try {
        provider = await web3Modal.connect()
        await web3Modal.toggleModal()
    } catch (e) {
        // User unlinks wallet
        console.log("User unlinks wallet");
        alert("User unlinks wallet");
        return;
    }
    const web3 = new Web3(provider);
    account.value= await web3.eth.getAccounts();
    await login();//After successfully obtaining the user, execute the login method
};
const login = async () => {
    const params = {
        address: account.value[0],
    }
    // const response = await useApiBridge.post('w3Login', params);
    // console.log(response);
};

</script>

<style scoped>

</style>
