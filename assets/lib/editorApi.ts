import axios, {AxiosError, AxiosInstance, AxiosResponse} from 'axios';
import * as qs from 'qs'
import {Api} from "../types/api";
import Question = Api.Question;
import Option = Api.Option;
import ETypedFieldType = Api.ETypedFieldType;

type ApiResponse<T> = AxiosResponse<Api.Response<T>>;
type ApiError = AxiosError<Api.Response<null>>;

class editorApi {
    private readonly axios: AxiosInstance;

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
        delete: async (questionId: number): Promise<true> => {
            return await this.axios
                .delete(`/question/${questionId}`)
                .then((response: ApiResponse<true>): true => true)
                .catch(this.catch)
        },
        edit: async (question: Question): Promise<Question> => {
            return await this
                .put(`/question/${question.id}`, question, 'question')
                .then((response: ApiResponse<Question>): Question => response.data.data)
                .catch(this.catch)
        },
        editTitle: async (question: Question): Promise<Question> => {
            if (question.title.type == ETypedFieldType.TEXT_TYPE) {
                return this.question.__editTitleString(question);
            }
            return this.question.__editTitleFile(question);
        },
        __editTitleString: async (question: Question): Promise<Question> => {
            return await this
                .put(`/question/${question.id}/title`, question, 'question')
                .then((response: ApiResponse<Question>): Question => response.data.data)
                .catch(this.catch)
        },
        __editTitleFile: async (question: Question): Promise<Question> => {
            const formData = new FormData();
            formData.append("title", question.title.file, question.title.file.name);
            return await this.axios
                .post(`/question/${question.id}/title`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then((response: ApiResponse<Question>): Question => response.data.data)
                .catch(this.catch)
        }
    }
    variant = {
        get: async (variantId: number): Promise<Api.Variant> => {
            return this.axios
                .get(`/variant/${variantId}`)
                .then((response: ApiResponse<Api.Variant>): Api.Variant => response.data.data)
                .catch(this.catch)
        },
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
        delete: async (optionId: number): Promise<true> => {
            return this.axios
                .delete(`option/${optionId}`)
                .then((response: ApiResponse<true>): true => true)
                .catch(this.catch)
        },
        edit: async (option: Option): Promise<Option> => {
            return await this
                .put(`/option/${option.id}`, option, 'option')
                .then((response: ApiResponse<Option>): Option => response.data.data)
                .catch(this.catch)
        },
        editTitle: async (option: Option): Promise<Option> => {
            if (option.body.type == ETypedFieldType.TEXT_TYPE) {
                return this.option.__editTitleString(option);
            }
            return this.option.__editTitleFile(option);
        },
        __editTitleString: async (option: Option): Promise<Option> => {
            return await this
                .put(`/option/${option.id}/title`, option, 'option')
                .then((response: ApiResponse<Option>): Option => response.data.data)
                .catch(this.catch)
        },
        __editTitleFile: async (option: Option): Promise<Option> => {
            const formData = new FormData();
            formData.append("title", option.body.file, option.body.file.name);
            return await this.axios
                .post(`/option/${option.id}/title`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then((response: ApiResponse<Option>): Option => response.data.data)
                .catch(this.catch)
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

export default new editorApi();