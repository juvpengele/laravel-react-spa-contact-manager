import axios from "axios";
import config from "./env"


export default function httpClient(headers = {}) {
    return axios.create({
        baseURL: config.apiBaseUrl,
        headers: {
            "Content-Type": "application/json",
            ...headers
        }
    })
}