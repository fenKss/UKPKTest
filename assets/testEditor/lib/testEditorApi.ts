import axios from 'axios'
import {Question} from "../../types/testEditor";

class TestEditorApi {
    private readonly baseUrl: string;

    constructor(variantId: number) {
        this.baseUrl = `/api/variant/${variantId}`;
    }

    addQuestion = async () => {
        const url = this.baseUrl + '/question/add';
        return axios.post(url).then(response => {
            const {data} = response;
            if (data.error) {
                throw data.error_msg;
            }
            return data.data.id;
        })
    }
    getQuestions = async () => {
        const url = this.baseUrl + '/question';
        return axios.get(url).then(response => {
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
}

export default TestEditorApi;