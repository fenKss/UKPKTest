import {
    Option,
    PopupActions,
    PopupState,
    PopupType,
    Question,
    SET_POPUP_OBJECT,
    SET_POPUP_TEXT,
    SET_POPUP_TITLE,
    SET_POPUP_TYPE,
    SET_POPUP_VISIBILITY,
    SetPopupObjectAction,
    SetPopupTextAction,
    SetPopupTitleAction,
    SetPopupTypeAction,
    SetPopupVisibilityAction
} from "../../types/testEditor";
import TestEditorApi from "../lib/testEditorApi";
import {getQuestions} from "./questionsReducer";

const initState: PopupState = {
    isVisible: false,
    text: "",
    type: undefined,
    object: undefined
}
const questionReducer = (state = initState, action: PopupActions) => {
    switch (action.type) {
        case "SET_TEXT":
            return {
                ...state,
                text: action.text
            }
        case "SET_TYPE":
            return {
                ...state,
                type: action.value
            }
        case "SET_VISIBILITY":
            return {
                ...state,
                isVisible: action.isVisible
            }
        case "SET_POPUP_OBJECT_ID":
            return {
                ...state,
                object: action.object
            }
        case "SET_TITLE":
            return {
                ...state,
                title: action.title
            }
    }
    return state;
}

export const setPopupText = (text: string): SetPopupTextAction => ({type: SET_POPUP_TEXT, text});
export const setPopupTitle = (title: string): SetPopupTitleAction => ({type: SET_POPUP_TITLE, title});
export const setPopupType = (value: PopupType): SetPopupTypeAction => ({type: SET_POPUP_TYPE, value});
export const setPopupVisibility = (isVisible: boolean): SetPopupVisibilityAction => ({
    type: SET_POPUP_VISIBILITY,
    isVisible
});
export const setPopupObject = (object: Option | Question): SetPopupObjectAction => ({
    type: SET_POPUP_OBJECT,
    object
});
export const updateTitle = (variantId: number, type: PopupType, object: Option | Question, title: string) => async (dispatch) => {
    const api = new TestEditorApi(variantId);
    switch (type) {
        case "POPUP_QUESTION_TITLE_TYPE":
            await api.setQuestionTitle(object.id, title);
            break;
        case "POPUP_OPTION_TITLE_TYPE":
            //@ts-ignore
            await api.setOptionTitle(object.questionId, object.id, title);
            break;
    }
    dispatch(getQuestions(variantId));
    dispatch(setPopupVisibility(false));
}

export default questionReducer;