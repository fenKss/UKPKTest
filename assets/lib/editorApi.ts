import axios from 'axios';

class editorApi{
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
        get: async(questionId: number) => {
            const response = await this.axios.post(`/question/${questionId}`)
            console.log(response);
        }
    }
}