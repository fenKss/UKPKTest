import Question = Api.Question;
import {Api} from "../../types/api";
import editorApi from "../../lib/editorApi";
import {Reducer} from "./actions";
import Action = Reducer.Editor.Action;
import addQuestion = Reducer.Editor.ActionCreator.addQuestion;
import selectQuestion = Reducer.Editor.ActionCreator.selectQuestion;
import editQuestion = Reducer.Editor.ActionCreator.editQuestion;

interface EditorState {
    questions: Question[],
    selectedQuestionId: number | null
}

const initState: EditorState = {
    questions: [],
    selectedQuestionId: null
}

const editorReducer = (state = initState, action: Action.Actions) => {

    switch (action.type) {
        case Action.ADD_QUESTION:
            return {
                ...state,
                questions: [
                    ...state.questions,
                    action.question
                ]
            }
        case Action.SELECT_QUESTION:
            return {
                ...state,
                selectedQuestionId: action.id
            }
        case Action.EDIT_QUESTION:
            const questions = state.questions.map(question => {
                if (question.id == action.question.id) {
                    return {...action.question}
                }
                return question;
            });
            return {
                ...state,
                questions: questions
            }
        default:
            return state;
    }

};

export const setQuestionsFromServer = (variantId: number, toggleSelected = false) => async (dispatch) => {
    const api = editorApi;
    const questions = await api.question.all(variantId);
    questions.forEach(question => dispatch(addQuestion(question)));
    if (questions[0] && toggleSelected) {
        dispatch(selectQuestion(questions[0].id));
    }
}
export const createQuestion = (variantId: number) => async (dispatch) => {
    const api = editorApi;
    const question = await api.question.add(variantId);

    dispatch(addQuestion(question));
    dispatch(selectQuestion(question.id));
}

export const editQuestionOnServer = (question: Question) => async (dispatch) => {
    const api = editorApi;
    const newQuestion = await api.question.edit(question);
    dispatch(editQuestion(newQuestion));
}
export const editQuestionTitleOnServer = (question: Question) => async (dispatch) => {
    const api = editorApi;
    const newQuestion = await api.question.editTitle(question);
    dispatch(editQuestion(newQuestion));
}

export default editorReducer;