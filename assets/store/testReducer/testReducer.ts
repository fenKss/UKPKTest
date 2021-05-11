import {Api} from "../../types/api";
import {Reducer} from "./actions";
import Action = Reducer.Test.Action;

type TestState = {
    questions: Api.Question[],
    answers: [],
    expiredAt: Date,
    selectedQuestionId: number | null,
    resultSavedAt: Date
} & Api.Test

const initState: TestState = {
    olympicName: null,
    tourIndex: null,
    variantIndex: null,
    questions: [],
    answers: [],
    expiredAt: null,
    selectedQuestionId: null,
    resultSavedAt: null
}

const testReducer = (state = initState, action: Action.Actions) => {
    switch (action.type) {
        case Action.ANSWER:

            break;
        case Action.ADD_QUESTION:
            return {
                ...state,
                questions: [
                    ...state.questions, action.question
                ]
            }
        case Action.SELECT_QUESTION:
            return {
                ...state,
                selectedQuestionId: action.id
            }
        case Action.SET_OLYMPIC_NAME:
            return {
                ...state,
                olympicName: action.name
            }
        case Action.SET_EXPIRED_AT:
            return {
                ...state,
                expiredAt: action.expiredAt
            }
        case Action.SET_VARIANT_INDEX:
            return {
                ...state,
                variantIndex: action.index
            }
        case Action.SET_TOUR_INDEX:
            return {
                ...state,
                tourIndex: action.index
            }
        case Action.SET_RESULT_SAVED_AT:
            return {
                ...state,
                resultSavedAt: action.savedAt
            }


    }
    return state;
}

export default testReducer;