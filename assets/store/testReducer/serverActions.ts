import testApi from "../../lib/testApi";
import {Reducer} from "./actions";
import selectQuestion = Reducer.Test.ActionCreator.selectQuestion;
import addQuestion = Reducer.Test.ActionCreator.addQuestion;
import setTourIndex = Reducer.Test.ActionCreator.setTourIndex;
import setVariantIndex = Reducer.Test.ActionCreator.setVariantIndex;
import setExpiredAt = Reducer.Test.ActionCreator.setExpiredAt;
import setOlympicName = Reducer.Test.ActionCreator.setOlympicName;

export const setTestFromServer = (testId: number, toggleSelected = false) => async (dispatch) => {
    const api = testApi;
    const test = await api.test.get(testId);
    const questions = test?.questions;
    if (test) {
        if (questions) {
            questions.forEach(question => dispatch(addQuestion(question)));
            if (questions[0] && toggleSelected) {
                dispatch(selectQuestion(questions[0].id));
            }
        }
        dispatch(setTourIndex(test.tourIndex));
        dispatch(setVariantIndex(test.variantIndex));
        dispatch(setExpiredAt(new Date(test.expiredAt)));
        dispatch(setOlympicName(test.olympicName));
    }
}