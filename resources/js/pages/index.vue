<template>
    <div>
        <div class="flex justify-center py-10 gap-5">
            <el-statistic :value="account[0] ? `Login time: ${date_time}` : 'Unauthorize'">
                <template #title>
                    <div style="display: inline-flex; align-items: center">
                        <p class="text-xl">Monthly Active Users</p>
                        <el-tooltip
                            effect="dark"
                            content="User login activity"
                            placement="top"
                        >
                            <el-icon style="margin-left: 4px" :size="12">
                                <Warning />
                            </el-icon>
                        </el-tooltip>
                    </div>
                </template>
            </el-statistic>
        </div>
    </div>
</template>

<script setup>
import Web3Modal from "web3modal";
import Web3 from "web3";
import { ref, reactive, onUnmounted, onMounted } from 'vue';
import { Warning } from '@element-plus/icons-vue'
import { instance } from "../axios/axios";
import { ElNotification } from "element-plus";
let provider = null;
const account = ref([]);
const today = new Date();
const date = today.getFullYear() + '-' + (today.getMonth()+1) + '-' + today.getDate();
const time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
const date_time = date + ' ' + time;
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
        user_address: account.value[0],
    };
    await instance.post('w3Login', params)
        .then((res) => {
          if (res.data) {
              ElNotification({
                  title: 'Success',
                  message: 'Login successfully!',
                  type: 'success',
              });
          }

        }).catch((err) => {
            ElNotification({
                title: 'Error',
                message: 'Unauthorize!',
                type: 'error',
            });
            console.log(err);
        });
};

</script>

<style scoped>

</style>
