export const ADD_QUESTION = "ADD_QUESTION"
export const SELECT_QUESTION = "SELECT_QUESTION"
export const SET_QUESTIONS = "SET_QUESTIONS"
export const RADIO_TYPE = 'radio';
export const SELECT_TYPE = 'select';
export type QuestionType = typeof RADIO_TYPE | typeof SELECT_TYPE;
export type Option = {
    id:number,
    text:string,
    isCorrect:boolean,

}

export type Question = {
    id:number,
    title:string,
    options:Array<Option>,
    type: QuestionType
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
export const SET_POPUP_POSITION = "SET_POPUP_POSITION"
export const SET_POPUP_OBJECT_ID = "SET_POPUP_OBJECT_ID"
export const POPUP_QUESTION_TITLE_TYPE = "POPUP_QUESTION_TITLE_TYPE";
export const POPUP_OPTION_TITLE_TYPE = "POPUP_OPTION_TITLE_TYPE";
export type PopupType = typeof POPUP_OPTION_TITLE_TYPE | typeof POPUP_QUESTION_TITLE_TYPE;

export interface PopupState{
    isVisible:boolean,
    text:string,
    type:PopupType,
    position:Position,
    objectId?:number
}
export type Position = {
    top:number,
    left:number
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
export interface SetPopupPositionAction{
    type: typeof SET_POPUP_POSITION,
    position:Position
}
export interface SetPopupObjectIdAction{
    type: typeof SET_POPUP_OBJECT_ID,
    id:Array<number>
}
export type PopupActions = SetPopupTextAction | SetPopupTypeAction | SetPopupVisibilityAction | SetPopupPositionAction | SetPopupObjectIdAction;