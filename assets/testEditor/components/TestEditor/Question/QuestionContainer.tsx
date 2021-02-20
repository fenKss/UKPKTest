import * as React from 'react';
import Question from "./Question";
import {connect, ConnectedProps} from "react-redux";
import {setPopupObjectId, setPopupPosition, setPopupType, setPopupVisibility} from "../../../store/popupReducer";
import {POPUP_QUESTION_TITLE_TYPE} from "../../../../types/testEditor";
import {addOption} from "../../../store/questionsReducer";
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
};
const connector = connect(mapStateToProps, mapDispatchToProps);

const QuestionContainer = (props: QuestionContainerProps) => {
    const {questions, selectedQuestion, setPopupVisibility, setPopupPosition, setPopupObjectId, setPopupType, addOption} = props;
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
        addOption(variantId, questionId);
    }
    return (
        <Question question={question} onEditTitle={onEditTitle} onAddOption={onAddOption}/>
    )
}

type QuestionContainerProps = ConnectedProps<typeof connector>;

export default connector(QuestionContainer);