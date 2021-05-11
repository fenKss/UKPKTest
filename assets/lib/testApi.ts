import axios, {AxiosInstance} from 'axios';
import * as qs from 'qs'
import {Api, ApiError, ApiResponse} from "../types/api";


class testApi {
    private readonly axios: AxiosInstance;

    constructor() {
        this.axios = axios.create({
            baseURL: "/api/test"
        });
    }

    test = {
        get: async (testId: number): Promise<Api.Test> => {
            return this
                .axios
                .get(`/${testId}`)
                .then((response: ApiResponse<Api.Test>) => response.data.data)
                .catch(this.catch);
        }
    }
    catch = (e: ApiError): null => {
        //@ts-ignore
        toastr.error(e.response.data.error_msg);
        return null;
    }
    put = (url: string, data, field: string): Promise<any> => {
        const a = [];
        a[field] = data;
        return this.axios.put(url, qs.stringify(a), {
            headers: {
                'content-type': 'application/x-www-form-urlencoded;charset=utf-8'
            }
        })
    }
}

export default new testApi();