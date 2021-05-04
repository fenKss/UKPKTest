import axios from 'axios';
import {AxiosError, AxiosResponse} from 'axios';
import {Api} from "../types/api";
import Question = Api.Question;
import Option = Api.Option;

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
        add: async (variantId: number): Promise<Question> => {
            return await this.axios
                .post(`/variant/${variantId}/question`)
                .then((response: ApiResponse<Api.Question>): Question => response.data.data)
                .catch(this.catch)
        },
        get: async (questionId: number): Promise<Question> => {
            return this.axios
                .get(`/question/${questionId}`)
                .then((response: ApiResponse<Api.Question>): Question => response.data.data)
                .catch(this.catch)
        },
        all: async (variantId: number): Promise<Question[]> => {
            return this.axios
                .get(`variant/${variantId}/questions`)
                .then((response: ApiResponse<Api.Question[]>): Question[] => response.data.data)
                .catch(this.catch)
        },
        delete: async (questionId: number): Promise<null> => {
            return await this.axios.delete(`/question/${questionId}`)
                .then((response: ApiResponse<null>): null => response.data.data)
                .catch(this.catch)
        }
    }
    option = {
        add: async (questionId: number): Promise<Option> => {
            return await this.axios
                .post(`/question/${questionId}/option`)
                .then((response: ApiResponse<Api.Option>): Option => response.data.data)
                .catch(this.catch)
        },
        get: async (optionId: number): Promise<Option> => {
            return this.axios
                .get(`/option/${optionId}`)
                .then((response: ApiResponse<Api.Option>): Option => response.data.data)
                .catch(this.catch)
        },
        delete: async (optionId: number): Promise<null> => {
            return this.axios
                .delete(`option/${optionId}`)
                .then((response: ApiResponse<null>): null => response.data.data)
                .catch(this.catch)
        }
    }

    catch = (e: ApiError) => {
        //@ts-ignore
        toastr.error(e.response.data.error_msg);
    }
}

export default new editorApi();