import * as React from 'react';
import Question from "./Question";
import {connect, ConnectedProps} from "react-redux";
import {setPopupObjectId, setPopupPosition, setPopupType, setPopupVisibility} from "../../../store/popupReducer";
import {POPUP_QUESTION_TITLE_TYPE, RADIO_TYPE, SELECT_TYPE} from "../../../../types/testEditor";
import {addOption, changeQuestionType} from "../../../store/questionsReducer";
import validate = WebAssembly.validate;
import {useParams} from "react-router-dom";

const mapStateToProps = (state) => {
    return {
        questions: state.questions.questions,
        selectedQuestion: state.questions.selectedQuestion
    }
};
const mapDispatchToProps = {
    setPopupVisibility,
    setPopupPosition,
    setPopupObjectId,
    setPopupType,
    addOption,
    changeQuestionType
};
const connector = connect(mapStateToProps, mapDispatchToProps);

const QuestionContainer = (props: QuestionContainerProps) => {
    const {questions, selectedQuestion, setPopupVisibility, setPopupPosition, setPopupObjectId, setPopupType, addOption,changeQuestionType} = props;
    // @ts-ignore
    const {variantId} = useParams();
    const question = questions.find((q) => q.id == selectedQuestion);
    const onEditTitle = (e: React.MouseEvent<HTMLButtonElement, MouseEvent>) => {
        setPopupVisibility(true);
        setPopupObjectId(question.id);
        setPopupType(POPUP_QUESTION_TITLE_TYPE);
        setPopupPosition({
            top: e.currentTarget.offsetTop - 2,
            left: e.currentTarget.offsetLeft + 15
        })
    }
    const onAddOption = (questionId:number) => {
        addOption(variantId, question.id);
    }
    const onChangeType = () => {
        const type = question.type == RADIO_TYPE ? SELECT_TYPE : RADIO_TYPE;
        changeQuestionType(variantId, question.id,type);
    }
    return (
        <Question question={question} onEditTitle={onEditTitle} onAddOption={onAddOption} onChangeType={onChangeType}/>
    )
}

type QuestionContainerProps = ConnectedProps<typeof connector>;

export default connector(QuestionContainer);