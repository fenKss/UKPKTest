import {
    PopupActions,
    PopupState,
    PopupType,
    SET_POPUP_TEXT,
    SET_POPUP_TYPE,
    SET_POPUP_VISIBILITY,
    SetPopupTextAction,
    SetPopupTypeAction,
    SetPopupVisibilityAction
} from "../../types/testEditor";

const initState: PopupState = {
    isVisible: false,
    text: "",
    type: undefined
}
const questionReducer = (state = initState, action: PopupActions) => {
    switch (action.type){
        case "SET_TEXT":
            return {
                ...state,
                text:action.text
            }
        case "SET_TYPE":
            return {
                ...state,
                type:action.value
            }
        case "SET_VISIBILITY":
            return {
                ...state,
                isVisible:action.isVisible
            }
    }
    return state;
}

export const setPopupText = (text:string):SetPopupTextAction => ({type:SET_POPUP_TEXT, text});
export const setPopupType = (value:PopupType):SetPopupTypeAction => ({type:SET_POPUP_TYPE, value});
export const setPopupVisibility = (isVisible:boolean):SetPopupVisibilityAction => ({type:SET_POPUP_VISIBILITY, isVisible});

export default questionReducer;