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