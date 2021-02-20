import axios from 'axios'
import {Question, QuestionType} from "../../types/testEditor";

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
    addOption = async (questionId:number) => {
        const url = this.baseUrl + `/question/${questionId}/option/add`;
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
    setQuestionTitle = async (id:number,title: string) => {
        const url = this.baseUrl + `/question/${id}/edit/title`;
        const form = new FormData();
        form.append('title', title);
        return axios({
            method:'post',
            url,
            headers: {'Content-Type': 'multipart/form-data' },
            data:form
            }
        ).then(response => {
            const {data} = response;
            return data.id
        })
    }
    setOptionTitle = async (questionId:number,optionId:number, title: string) => {
        const url = this.baseUrl + `/question/${questionId}/option/${optionId}/edit/title`;
        const form = new FormData();
        form.append('title', title);
        return axios({
            method:'post',
            url,
            headers: {'Content-Type': 'multipart/form-data' },
            data:form
            }
        ).then(response => {
            const {data} = response;
            return data.id
        })
    }

     changeQuestionType = async(questionId:number, type: QuestionType) =>{
         const url = this.baseUrl + `/question/${questionId}/edit/type`;
         const form = new FormData();
         form.append('type', type);
         return axios({
                 method:'post',
                 url,
                 headers: {'Content-Type': 'multipart/form-data' },
                 data:form
             }
         ).then(response => {
             const {data} = response;
             return data.id
         })
    }
}

export default TestEditorApi;