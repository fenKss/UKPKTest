import {
    ADD_QUESTION,
    AddQuestionAction,
    Question,
    QuestionActions,
    QuestionsState,
    SELECT_QUESTION,
    SelectQuestionAction
} from "../../types/testEditor";

const initState: QuestionsState = {
    questions: [
        {
            id: 1,
            title: "Вопрос 1",
            options: [
                {
                    id: 1,
                    text: "Вариант 1",
                    isCorrect: false
                }
            ]
        },
        {
            id: 2,
            title: "Вопрос 2",
            options: []
        },
        {
            id: 3,
            title: "Вопрос 3",
            options: []
        }
    ],
    selectedQuestion: null
}
const questionsReducer = (state = initState, action: QuestionActions): QuestionsState => {
    console.log(action);
    switch (action.type) {
        case "ADD_QUESTION":
            return {
                ...state,
                questions: [...state.questions, action.question]
            }
        case "SELECT_QUESTION":
            return {
                ...state,
                selectedQuestion: action.id
            }
    }
    return state;
}

export const addQuestion = (question: Question): AddQuestionAction => ({type: ADD_QUESTION, question})
export const selectQuestion = (id: number): SelectQuestionAction => ({type: SELECT_QUESTION, id})

export default questionsReducer;