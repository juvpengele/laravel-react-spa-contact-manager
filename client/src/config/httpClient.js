import axios from "axios";
import env from "./env"


export default function httpClient(headers = {}) {
    return axios.create({
        baseURL: env.apiBaseUrl,
        headers: {
            "Content-Type": "application/json",
            ...headers
        }
    })
}