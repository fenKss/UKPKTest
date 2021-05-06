import {Api} from "../../types/api";
import {Reducer} from "./actions";
import Question = Api.Question;
import Action = Reducer.Editor.Action;

interface EditorState {
    questions: Question[],
    selectedQuestionId: number | null
    isPublished: boolean
}

const initState: EditorState = {
    questions: [],
    selectedQuestionId: null,
    isPublished: true
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
        case Action.DELETE_QUESTION:
            let isChanged = false;
            const questions = state.questions;
            for (let i = 0; i < questions.length; i++) {
                const question = questions[i];
                if (question.id == action.question.id) {
                    isChanged = true;
                    questions.splice(i, 1);
                    break;
                }
            }
            let selectedQuestionId = null;
            if (questions.length) {
                selectedQuestionId = questions[0].id;
            }
            if (isChanged) {
                return {
                    ...state,
                    questions: [...questions],
                    selectedQuestionId
                }
            }
            return state;

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
        case Action.DELETE_OPTION:
            let question;
            state.questions.forEach(q => {
                q.options.forEach((option, i) => {
                    if (option.id == action.option.id) {
                        question = {...q};
                        question.options.splice(i, 1);
                    }
                })
            });
            if (question) {
                return {
                    ...state,
                    questions: updateQuestion(state.questions, {...question})
                }
            }
            return state;
        case Action.SET_IS_PUBLISHED:
            return {
                ...state,
                isPublished: action.isPublished
            }
        default:
            return state;

    }
};


export const getQuestionFromEditorState = (editorState) => {
    return editorState.questions.find(element => {
        if (element.id == editorState.selectedQuestionId) {
            return element
        }
        return false;
    })
}

export default editorReducer;