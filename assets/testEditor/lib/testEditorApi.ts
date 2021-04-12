import axios from 'axios'
import {AxiosInstance} from 'axios'
import {Question, QuestionType} from "../../types/testEditor";

class TestEditorApi {
    private readonly axios: AxiosInstance;

    constructor(variantId: number) {
        this.axios = axios.create({
            baseURL: `/api/variant/${variantId}`
        })
    }

    addQuestion = async () => {
        const url = '/question/add';
        return this.axios.post(url).then(response => {
            const {data} = response;
            if (data.error) {
                throw data.error_msg;
            }
            return data.data.id;
        })
    }
    addOption = async (questionId: number) => {
        const url =  `/question/${questionId}/option/add`;
        return this.axios.post(url).then(response => {
            const {data} = response;
            if (data.error) {
                throw data.error_msg;
            }
            return data.data.id;
        })
    }
    getQuestions = async () => {
        const url =  '/question';
        return this.axios.get(url).then(response => {
            const {data} = response;
            let questions: Array<Question> = [];
            if (data.error) {
                throw data.error_msg;
            }
            const rawQuestions = data.data;
            for (const i in rawQuestions) {
                const rawQuestion = rawQuestions[i];
                rawQuestion.options = Object.values(rawQuestion.options);
                questions.push(rawQuestion);
            }
            return questions;
        })
    }
    setQuestionTitle = async (id: number, title: string) => {
        const url  =  `/question/${id}/edit/title`,
              form = new FormData();
        form.append('title', title);
        return axios({
                method: 'post',
                url,
                headers: {'Content-Type': 'multipart/form-data'},
                data: form
            }
        ).then(response => {
            const {data} = response;
            return data.id
        })
    }
    setOptionTitle = async (questionId: number, optionId: number, title: string) => {
        const url  = `/question/${questionId}/option/${optionId}/edit/title`,
              form = new FormData();
        form.append('title', title);
        return this.axios({
                method: 'post',
                url,
                headers: {'Content-Type': 'multipart/form-data'},
                data: form
            }
        ).then(response => {
            const {data} = response;
            return data.id
        })
    }

    changeQuestionType = async (questionId: number, type: QuestionType) => {
        const url = `/question/${questionId}/edit/type`;
        const form = new FormData();
        form.append('type', type);
        return this.axios({
                method: 'post',
                url,
                headers: {'Content-Type': 'multipart/form-data'},
                data: form
            }
        ).then(response => {
            const {data} = response;
            return data.id
        })
    }
    changeOptionIsCorrect = async (questionId: number, optionId: number) => {
        const url = `/question/${questionId}/option/${optionId}/correct`;
        return this.axios({
                method: 'post',
                url,
                headers: {'Content-Type': 'multipart/form-data'},
            }
        ).then(response => {
            const {data} = response;
            return data.id
        })
    }
}

export default TestEditorApi;