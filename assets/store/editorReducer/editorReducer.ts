import {Api} from "../../types/api";
import {Reducer} from "./actions";
import Question = Api.Question;
import Action = Reducer.Editor.Action;
import addQuestion = Reducer.Editor.ActionCreator.addQuestion;
import selectQuestion = Reducer.Editor.ActionCreator.selectQuestion;
import editQuestion = Reducer.Editor.ActionCreator.editQuestion;
import editorApi from "../../lib/editorApi";
import addOption = Reducer.Editor.ActionCreator.addOption;
import Option = Api.Option;
import editOption = Reducer.Editor.ActionCreator.editOption;

interface EditorState {
    questions: Question[],
    selectedQuestionId: number | null
}

const initState: EditorState = {
    questions: [],
    selectedQuestionId: null
}
const updateQuestion = (questions: Question[], questionNew: Question): Question[] => {
    return questions.map(question => {
        if (question.id == questionNew.id) {
            return {...questionNew}
        }
        return question;
    });

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
            return {
                ...state,
                questions: updateQuestion(state.questions, action.question)
            }
        case Action.ADD_OPTION: {
            const question = state.questions.find(element => {
                if (element.id == action.question.id) {
                    return element
                }
                return false;
            });
            question.options = [...question.options, action.option];
            return {
                ...state,
                questions: updateQuestion(state.questions, {...question})
            }
        }
        case Action.EDIT_OPTION: {
            let question;
            state.questions.forEach(q => {
                q.options.forEach((option, i) => {
                    if (option.id == action.option.id) {
                        question = {...q}
                        question.options[i] = {...action.option};
                        // question.options = [...question.options];
                    }
                })
            })
            if (question) {
                return {
                    ...state,
                    questions: updateQuestion(state.questions, {...question})
                }
            }
            return state;
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

export const getQuestion = (questionId: number) => async (dispatch) => {
    const api = editorApi;
    const question = await api.question.get(questionId);

    dispatch(editQuestion(question));
}
export const createOption = (question: Question) => async (dispatch) => {
    const api = editorApi;
    const option = await api.option.add(question.id);

    dispatch(addOption(option, question));
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

export const editOptionOnServer = (option: Option, question: Question | null = null) => async (dispatch) => {

    const api = editorApi;
    const newOption = await api.option.edit(option);

    if (question){
         dispatch(getQuestion(question.id));
    }else{
        dispatch(editOption(newOption));
    }
}
export const editOptionTitleOnServer = (option: Option) => async (dispatch) => {
    const api = editorApi;
    const newOption = await api.option.editTitle(option);
    dispatch(editOption(newOption));
}


export const getQuestionFromEditorState = (editorState) => {
    return editorState.questions.find(element => {
        if (element.id == editorState.selectedQuestionId) {
            return element
        }
        return false;
    })
}

export default editorReducer;