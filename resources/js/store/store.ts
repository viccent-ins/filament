import { defineStore } from 'pinia';
export const useStores = defineStore('store', {
    state: () => {
        return {
            user: {
                id: 0,
                name: '',
                email: '',
                account_type: '',
                email_verified_at: '',
                profile: '',
                phone: '',
            },
            authorisation: {
                token: '',
                type: '',
                expires_in: 0,
            },
            auth: false,
        }
    },
    actions: {
        updateAuthorisation(authorisation: IAuthorisation) {
            this.authorisation = authorisation;
        },
        removeAuthorisation(authorisation: string) {
            this.authorisation.token = authorisation;
            this.auth = false;
        },
        updateAuth(auth: boolean) {
            this.auth = auth;
        },
    },
    getters: {
        userInfo: (state) => state.user,
        isAuth: (state) => {
            let auth = state.auth;
            if (state.authorisation.token) {
                auth = true;
            }
            return auth;
        },
    },
    persist: true,
})
