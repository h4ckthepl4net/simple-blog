import axios from "axios";
import {ApiServiceException} from "./ApiServiceException";

const APP_API_URL = process.env.REACT_APP_API_URL;

export class ApiService {

    static axiosInstance = axios.create({
        baseURL: APP_API_URL,
    });

    static interceptFailedRequests() {
        this.axiosInstance.interceptors.response.use(
            response => response,
            error => {
                throw new ApiServiceException(error, "Failed to make request");
            }
        );
    }

    static setAuthenticationHeader(token) {
        this.axiosInstance.defaults.headers.common["Authentication"] = token;
    }

    static removeAuthenticationHeader() {
        delete this.axiosInstance.defaults.headers.common["Authentication"];
    }

    static async post(path, data, config) {
        return this.axiosInstance.post(path, data, config);
    }

    static async get(path, config) {
        return this.axiosInstance.get(path, config);
    }

    static async delete(path, config) {
        return this.axiosInstance.delete(path, config);
    }

}