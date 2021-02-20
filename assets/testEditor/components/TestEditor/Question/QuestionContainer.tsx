import * as React from 'react';
import Question from "./Question";
import {connect, ConnectedProps} from "react-redux";
import {setPopupObjectId, setPopupPosition, setPopupType, setPopupVisibility} from "../../../store/popupReducer";
import {POPUP_QUESTION_TITLE_TYPE} from "../../../../types/testEditor";

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
    setPopupType
};
const connector = connect(mapStateToProps, mapDispatchToProps);

const QuestionContainer = (props: QuestionContainerProps) => {
    const {questions, selectedQuestion, setPopupVisibility, setPopupPosition, setPopupObjectId, setPopupType} = props;

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
    return (
        <Question question={question} onEditTitle={onEditTitle}/>
    )
}

type QuestionContainerProps = ConnectedProps<typeof connector>;

export default connector(QuestionContainer);