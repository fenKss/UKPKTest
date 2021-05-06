import {Api} from "../../types/api";

export namespace Reducer.Editor {
    export namespace Action {
        export const ADD_QUESTION = 'ADD_QUESTION';
        export const SELECT_QUESTION = 'SELECT_QUESTION';
        export const EDIT_QUESTION = 'EDIT_QUESTION';
        export const DELETE_QUESTION = 'DELETE_QUESTION';

        export const ADD_OPTION = 'ADD_OPTION';
        export const DELETE_OPTION = 'DELETE_OPTION';
        export const EDIT_OPTION = 'EDIT_OPTION';

        export const SET_IS_PUBLISHED = 'SET_IS_PUBLISHED';

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

        export interface DeleteQuestionInterface {
            type: typeof DELETE_QUESTION,
            question: Api.Question
        }

        export interface AddOptionInterface {
            type: typeof ADD_OPTION,
            option: Api.Option,
            question: Api.Question
        }

        export interface DeleteOptionInterface {
            type: typeof DELETE_OPTION,
            option: Api.Option
        }

        export interface EditOptionInterface {
            type: typeof EDIT_OPTION,
            option: Api.Option
        }
        export interface SetIsPublishedInterface {
            type: typeof SET_IS_PUBLISHED,
            isPublished: boolean
        }

        export type Actions = AddQuestionInterface |
            SelectQuestionInterface |
            EditQuestionInterface |
            DeleteQuestionInterface |
            AddOptionInterface |
            DeleteOptionInterface |
            EditOptionInterface |
            SetIsPublishedInterface;
    }
    export namespace ActionCreator {
        import Question = Api.Question;
        import Option = Api.Option;
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
        export const deleteQuestion = (question: Question): Action.DeleteQuestionInterface => ({
            type: Action.DELETE_QUESTION,
            question
        });

        export const addOption = (option: Option, question: Question): Action.AddOptionInterface => ({
            type: Action.ADD_OPTION,
            option,
            question
        });
        export const editOption = (option: Option): Action.EditOptionInterface => ({
            type: Action.EDIT_OPTION,
            option
        });
        export const deleteOption = (option: Option): Action.DeleteOptionInterface => ({
            type: Action.DELETE_OPTION,
            option
        });

        export const setIsPublished = (isPublished: boolean): Action.SetIsPublishedInterface => ({
           type: Action.SET_IS_PUBLISHED,
           isPublished
        });
    }
}