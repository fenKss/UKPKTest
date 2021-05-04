import {Api} from "../../types/api";

export namespace Reducer.Editor{
    export namespace Action{
        export const ADD_QUESTION = 'ADD_QUESTION';
        export const SELECT_QUESTION = 'SELECT_QUESTION';
        export interface AddQuestionInterface  {
            type: typeof ADD_QUESTION,
            question: Api.Question
        }
        export interface SelectQuestionInterface  {
            type: typeof SELECT_QUESTION,
            id: number
        }
        export type Actions = AddQuestionInterface | SelectQuestionInterface;
    }
    export namespace ActionCreator{
        import Question = Api.Question;
        export const addQuestion = (question : Question): Action.AddQuestionInterface => ({type: Action.ADD_QUESTION, question}) ;
        export const selectQuestion = (id : number): Action.SelectQuestionInterface => ({type: Action.SELECT_QUESTION, id}) ;
    }
}