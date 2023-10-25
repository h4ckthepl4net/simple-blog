import {ApiService} from "../api-service/ApiService";
import ApiEndpoints from "../../helpers/constants/api-endpoints";
import {AuthServiceException} from "./AuthServiceException";
import {constructUser} from "../../helpers/functions/constructUser";


const TOKEN_KEY = process.env.REACT_APP_TOKEN_KEY;

export class AuthService {

    static async signIn(username, password) {
        try {
            const response = await ApiService.post(ApiEndpoints.signIn, {
                username,
                password,
            });
            const {token, user} = response.data;
            await this.storeToken(token);
            return constructUser(user);
        } catch (e) {
            throw new AuthServiceException(e, "Failed to sign in");
        }
    }

    static async signOut() {
        try {
            ApiService.removeAuthenticationHeader();
            localStorage.removeItem(TOKEN_KEY);
        } catch (e) {
            throw new AuthServiceException(e, "Failed to sign out");
        }
    }

    static async fetchUser(token = null) {
        if (!token) {
            token = localStorage.getItem(TOKEN_KEY);
        }
        if (!token) {
            throw new AuthServiceException(new Error("No auth token found"), "Can't fetch user");
        }
        try {
            await this.storeToken(token);
            const response = await ApiService.get(ApiEndpoints.user);
            const {user} = response.data;
            return constructUser(user);
        } catch (e) {
            if(e instanceof AuthServiceException) {
                throw e;
            }
            throw new AuthServiceException(e, "Failed to fetch user");
        }
    }

    static async storeToken(token) {
        try {
            ApiService.setAuthenticationHeader(token);
            localStorage.setItem(TOKEN_KEY, token);
            return token;
        } catch (e) {
            throw new AuthServiceException(e, "Failed to set token");
        }
    }


}