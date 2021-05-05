import {Api} from "../../types/api";
import {Reducer} from "./actions";
import Question = Api.Question;
import Action = Reducer.Editor.Action;
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


export const getQuestionFromEditorState = (editorState) => {
    return editorState.questions.find(element => {
        if (element.id == editorState.selectedQuestionId) {
            return element
        }
        return false;
    })
}

export default editorReducer;