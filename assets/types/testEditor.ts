export const ADD_QUESTION = "ADD_QUESTION"
export const SELECT_QUESTION = "SELECT_QUESTION"
export const SET_QUESTIONS = "SET_QUESTIONS"

export type Option = {
    id:number,
    text:string,
    isCorrect:boolean
}

export type Question = {
    id:number,
    title:string,
    options:Array<Option>
}

export interface QuestionsState {
    questions:Array<Question>,
    selectedQuestion?:number
}
export interface AddQuestionAction  {
    type:typeof ADD_QUESTION,
    question: Question
}
export interface SelectQuestionAction  {
    type:typeof SELECT_QUESTION,
    id: number
}
export interface SetQuestionsAction  {
    type:typeof SET_QUESTIONS,
    questions: Array<Question>
}

export type QuestionActions = AddQuestionAction | SelectQuestionAction | SetQuestionsAction;

export const SET_POPUP_TEXT = "SET_TEXT";
export const SET_POPUP_TYPE = "SET_TYPE";
export const SET_POPUP_VISIBILITY = "SET_VISIBILITY"
export const POPUP_QUESTION_TITLE_TYPE = "POPUP_QUESTION_TITLE_TYPE";
export const POPUP_OPTION_TITLE_TYPE = "POPUP_OPTION_TITLE_TYPE";
export type PopupType = typeof POPUP_OPTION_TITLE_TYPE | typeof POPUP_QUESTION_TITLE_TYPE;

export interface PopupState{
    isVisible:boolean,
    text:string,
    type:PopupType
}

export interface SetPopupTextAction  {
    type: typeof SET_POPUP_TEXT,
    text:string
}
export interface SetPopupTypeAction{
    type: typeof SET_POPUP_TYPE,
    value:PopupType

}
export interface SetPopupVisibilityAction{
    type: typeof SET_POPUP_VISIBILITY,
    isVisible:boolean

}
export type PopupActions = SetPopupTextAction | SetPopupTypeAction | SetPopupVisibilityAction;