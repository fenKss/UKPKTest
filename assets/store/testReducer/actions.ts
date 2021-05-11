import {Api} from "../../types/api";

export namespace Reducer.Test {
    export namespace Action {
        export const ANSWER = "TEST_ANSWER";
        export const ADD_QUESTION = 'TEST_ADD_QUESTION';
        export const SELECT_QUESTION = 'TEST_SELECT_QUESTION';
        export const SET_OLYMPIC_NAME = 'TEST_SET_OLYMPIC_NAME';
        export const SET_TOUR_INDEX = 'TEST_SET_TOUR_INDEX';
        export const SET_VARIANT_INDEX = 'TEST_SET_VARIANT_INDEX';
        export const SET_EXPIRED_AT = 'TEST_SET_EXPIRED_AT';
        export const SET_RESULT_SAVED_AT = 'TEST_SET_RESULT_SAVED_AT';

        export interface AnswerInterface {
            type: typeof ANSWER,
            option: Api.Option,

        }

        export interface AddQuestionInterface {
            type: typeof ADD_QUESTION,
            question: Api.Question
        }

        export interface SelectQuestionInterface {
            type: typeof SELECT_QUESTION,
            id: number
        }

        export interface SetOlympicNameInterface {
            type: typeof SET_OLYMPIC_NAME,
            name: string
        }

        export interface SetTourIndexInterface {
            type: typeof SET_TOUR_INDEX,
            index: number
        }

        export interface SetVariantIndexInterface {
            type: typeof SET_VARIANT_INDEX,
            index: number
        }

        export interface SetExpiredAtInterface {
            type: typeof SET_EXPIRED_AT,
            expiredAt: Date
        }

        export interface SetResultSavedAtInterface {
            type: typeof SET_RESULT_SAVED_AT,
            savedAt: Date
        }

        export type Actions = AnswerInterface |
            AddQuestionInterface |
            SelectQuestionInterface |
            SetTourIndexInterface |
            SetVariantIndexInterface |
            SetOlympicNameInterface |
            SetExpiredAtInterface |
            SetResultSavedAtInterface;

    }
    export namespace ActionCreator {
        export const answer = (option: Api.Option): Action.AnswerInterface => ({
            type: Action.ANSWER,
            option
        });
        export const addQuestion = (question: Api.Question): Action.AddQuestionInterface => ({
            type: Action.ADD_QUESTION,
            question
        });
        export const selectQuestion = (id: number): Action.SelectQuestionInterface => ({
            type: Action.SELECT_QUESTION,
            id
        });
        export const setTourIndex = (index: number): Action.SetTourIndexInterface => ({
            type: Action.SET_TOUR_INDEX,
            index
        });
        export const setVariantIndex = (index: number): Action.SetVariantIndexInterface => ({
            type: Action.SET_VARIANT_INDEX,
            index
        });
        export const setExpiredAt = (expiredAt: Date): Action.SetExpiredAtInterface => ({
            type: Action.SET_EXPIRED_AT,
            expiredAt
        });
        export const setResultSavedAt = (savedAt: Date): Action.SetResultSavedAtInterface => ({
            type: Action.SET_RESULT_SAVED_AT,
            savedAt
        });
        export const setOlympicName = (name: string): Action.SetOlympicNameInterface => ({
            type: Action.SET_OLYMPIC_NAME,
            name
        });
    }
}