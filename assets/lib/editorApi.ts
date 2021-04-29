import axios from 'axios';
import {AxiosError, AxiosResponse} from 'axios';
import {Api} from "../types/api";

type ApiResponse<T> = AxiosResponse<Api.Response<T>>;
type ApiError = AxiosError<Api.Response<null>>;

class editorApi {
    private readonly axios;

    constructor() {
        this.axios = axios.create({
            baseURL: "/api/editor"
        });
    }

    question = {
        add: async (variantId: number) => {
            this.axios.post(`/variant/${variantId}/question`)
        },
        get: async (questionId: number) => {
            this.axios.get(`/question/${questionId}`)
                .then((response: ApiResponse<Api.Question>) => {
                    console.log(response.data);
                })
                .catch(this.catch)
        },
        all: async (variantId: number) => {
            this.axios.get(`variant/${variantId}/`)
                .then((response: ApiResponse<Api.Variant>) => {
                    console.log(response.data.data.questions[0].title.body);
                })
                .catch(this.catch)
        }
    }
    catch = (e: ApiError) => {
        //@ts-ignore
        toastr.error(e.response.data.error_msg);
    }
}

export default new editorApi();