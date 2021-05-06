import editorApi from "../../lib/editorApi";
import {Api} from "../../types/api";
import Question = Api.Question;
import Option = Api.Option;
import {Reducer} from "./actions";
import editQuestion = Reducer.Editor.ActionCreator.editQuestion;
import addQuestion = Reducer.Editor.ActionCreator.addQuestion;
import selectQuestion = Reducer.Editor.ActionCreator.selectQuestion;
import addOption = Reducer.Editor.ActionCreator.addOption;
import editOption = Reducer.Editor.ActionCreator.editOption;
import deleteOption = Reducer.Editor.ActionCreator.deleteOption;
import deleteQuestion = Reducer.Editor.ActionCreator.deleteQuestion;
import setIsPublished = Reducer.Editor.ActionCreator.setIsPublished;

export const setQuestionsFromServer = (variantId: number, toggleSelected = false) => async (dispatch) => {
    const api = editorApi;
    const variant = await api.variant.get(variantId);
    const questions = variant?.questions;
    if (variant) {
        dispatch(setIsPublished(variant.isPublished));
        if (questions) {
            questions.forEach(question => dispatch(addQuestion(question)));
            if (questions[0] && toggleSelected) {
                dispatch(selectQuestion(questions[0].id));
            }
        }
    }
}

export const createQuestion = (variantId: number) => async (dispatch) => {
    const api = editorApi;
    const question = await api.question.add(variantId);
    if (question) {
        dispatch(addQuestion(question));
        dispatch(selectQuestion(question.id));
    }
}
export const getQuestion = (questionId: number) => async (dispatch) => {
    const api = editorApi;
    const question = await api.question.get(questionId);
    if (question) {
        dispatch(editQuestion(question));
    }
}
export const editQuestionOnServer = (question: Question) => async (dispatch) => {
    const api = editorApi;
    const newQuestion = await api.question.edit(question);
    if (newQuestion) {
        dispatch(editQuestion(newQuestion));
    }
}
export const editQuestionTitleOnServer = (question: Question) => async (dispatch) => {
    const api = editorApi;
    const newQuestion = await api.question.editTitle(question);
    if (newQuestion) {
        dispatch(editQuestion(newQuestion));
    }
}
export const deleteQuestionOnServer = (question: Question) => async (dispatch) => {
   const api = editorApi;
    const response = await api.question.delete(question.id);
    if (response) {
        dispatch(deleteQuestion(question));
    }
}


export const createOption = (question: Question) => async (dispatch) => {
    const api = editorApi;
    const option = await api.option.add(question.id);
        if (option) {
            dispatch(addOption(option, question));
            dispatch(selectQuestion(question.id));
        }
}
export const deleteOptionOnServer = (option: Api.Option) => async (dispatch) => {
    const api = editorApi;
    const response = await api.option.delete(option.id);
    if (response) {
        dispatch(deleteOption(option));
    }
}
export const editOptionOnServer = (option: Option, question: Question | null = null) => async (dispatch) => {

    const api = editorApi;
    const newOption = await api.option.edit(option);

    if (question) {
        dispatch(getQuestion(question.id));
    } else if (newOption) {
        dispatch(editOption(newOption));
    }
}
export const editOptionTitleOnServer = (option: Option) => async (dispatch) => {
    const api = editorApi;
    const newOption = await api.option.editTitle(option);
    if (newOption) {
        dispatch(editOption(newOption));
    }
}
