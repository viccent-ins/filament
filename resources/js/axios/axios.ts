import axios from 'axios';
import { useStores } from '../store/store';
import { storeToRefs } from 'pinia';
const stores = useStores();
const { authorisation } = storeToRefs(stores);

export const instance = axios.create({
    withCredentials: true,
    baseURL: 'http://127.0.0.1:8000/api/',
    headers: {
        'Content-Type': 'application/json',
        headers: { Authorization: `Bearer ${authorisation.value.token}`},
    }
});

