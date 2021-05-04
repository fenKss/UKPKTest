import {Api} from "../../types/api";

export namespace Reducer.Editor {
    export namespace Action {
        export const ADD_QUESTION = 'ADD_QUESTION';
        export const SELECT_QUESTION = 'SELECT_QUESTION';
        export const EDIT_QUESTION = 'EDIT_QUESTION';

        export interface AddQuestionInterface {
            type: typeof ADD_QUESTION,
            question: Api.Question
        }

        export interface SelectQuestionInterface {
            type: typeof SELECT_QUESTION,
            id: number
        }

        export interface EditQuestionInterface {
            type: typeof EDIT_QUESTION,
            question: Api.Question
        }

        export type Actions = AddQuestionInterface | SelectQuestionInterface | EditQuestionInterface;
    }
    export namespace ActionCreator {
        import Question = Api.Question;
        export const addQuestion = (question: Question): Action.AddQuestionInterface => ({
            type: Action.ADD_QUESTION,
            question
        });
        export const selectQuestion = (id: number): Action.SelectQuestionInterface => ({
            type: Action.SELECT_QUESTION,
            id
        });
        export const editQuestion = (question: Question): Action.EditQuestionInterface => ({
            type: Action.EDIT_QUESTION,
            question
        });
    }
}