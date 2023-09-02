import axios from 'axios';
import { useStores } from '../store/store';

export const useApiBridge = () => {
    const stores = useStores();
    const { authorisation, apiServer } = storeToRefs(stores);
    const instance = axios.create({
        withCredentials: true,
        baseURL: `${apiServer.value}api/`,
        headers: { Authorization: `Bearer ${authorisation.value.token}`},
    });
    instance.interceptors.response.use(
        (response: any) => response,
        (error: { response: { status: number; data: { message: string; }; statusText: string; }; }) => {
            if (error.response?.status === 422) {
                // @ts-ignore
                ElNotification({
                    title: 'Error',
                    message: error.response.data?.errors.Message[0],
                    type: 'error',
                })
            }
            if (error.response?.status === 401) {
                let keysToRemove = ['store'];
                keysToRemove.forEach((key) => {
                    localStorage.removeItem(key);
                });
                navigateTo('/auth/login');
                // window.location.href = '/auth/login';
            }
            if (error.response?.status === 500) {
                ElNotification({
                    title: 'Error',
                    message: error.response?.statusText,
                    type: 'error',
                })
            }
            Promise.reject(error);
        },
    );
    return {
        instance,
    }
}
