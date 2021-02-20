import {
    ADD_QUESTION,
    AddQuestionAction,
    Question,
    QuestionActions,
    QuestionsState,
    SELECT_QUESTION,
    SelectQuestionAction,
    SET_QUESTIONS,
    SetQuestionsAction
} from "../../types/testEditor";
import TestEditorApi from "../lib/testEditorApi";

const initState: QuestionsState = {
    questions: [],
    selectedQuestion: null
}
const questionsReducer = (state = initState, action: QuestionActions): QuestionsState => {
    switch (action.type) {
        case "ADD_QUESTION":
            return {
                ...state,
                questions: [...state.questions, action.question]
            }
        case "SET_QUESTIONS":
            if (state.selectedQuestion){
                return {
                    ...state,
                    questions: [...action.questions]
                }
            }
                return {
                    ...state,
                    questions: [...action.questions],
                    selectedQuestion:action.questions[0]?.id
                }

        case "SELECT_QUESTION":
            return {
                ...state,
                selectedQuestion: action.id
            }
    }
    return state;
}

export const addQuestionToState = (question: Question): AddQuestionAction => ({type: ADD_QUESTION, question});
export const selectQuestion = (id: number): SelectQuestionAction => ({type: SELECT_QUESTION, id});
export const setQuestions = (questions: Array<Question>): SetQuestionsAction => ({type: SET_QUESTIONS,questions});


export const getQuestions = (variantId: number) => async (dispatch) => {
    const api = new TestEditorApi(variantId);
    const questions = await api.getQuestions();
    dispatch(setQuestions(questions));
}
export const addQuestion = (variantId: number) => async (dispatch) => {
    const api = new TestEditorApi(variantId);
    await api.addQuestion();
    dispatch(getQuestions(variantId));
}
export default questionsReducer;