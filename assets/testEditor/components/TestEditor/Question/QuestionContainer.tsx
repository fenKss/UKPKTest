import * as React from 'react';
import Question from "./Question";
import {connect, ConnectedProps} from "react-redux";
import {
    setPopupObjectId,
    setPopupPosition,
    setPopupText,
    setPopupType,
    setPopupVisibility
} from "../../../store/popupReducer";
import {
    Option,
    POPUP_OPTION_TITLE_TYPE,
    POPUP_QUESTION_TITLE_TYPE,
    RADIO_TYPE,
    SELECT_TYPE
} from "../../../../types/testEditor";
import {addOption, changeQuestionType, setOptionIsCorrect} from "../../../store/questionsReducer";
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
    setPopupText,
    addOption,
    changeQuestionType,
    setOptionIsCorrect
};
const connector = connect(mapStateToProps, mapDispatchToProps);

const QuestionContainer = (props: QuestionContainerProps) => {
    const {
        questions,
        selectedQuestion,
        setPopupVisibility,
        setPopupPosition,
        setPopupObjectId,
        setPopupType,
        addOption,
        changeQuestionType,
        setPopupText,
        setOptionIsCorrect
    } = props;
    // @ts-ignore
    const {variantId} = useParams();
    const question = questions.find((q) => q.id == selectedQuestion);
    const onEditTitle = (e: React.MouseEvent<HTMLButtonElement, MouseEvent>) => {
        setPopupVisibility(true);
        setPopupObjectId([question.id]);
        setPopupType(POPUP_QUESTION_TITLE_TYPE);
        setPopupText(question.title);
        setPopupPosition({
            top: e.currentTarget.offsetTop - 2,
            left: e.currentTarget.offsetLeft + 15
        });
    }
    const onEditOptionTitle = (e: React.MouseEvent<HTMLButtonElement, MouseEvent>, option: Option) => {
        setPopupVisibility(true);
        setPopupObjectId([question.id,option.id]);
        setPopupType(POPUP_OPTION_TITLE_TYPE);
        setPopupText(option.text);
        setPopupPosition({
            top: e.currentTarget.offsetTop - 2,
            left: e.currentTarget.offsetLeft + 15
        });
    }
    const onAddOption = (questionId: number) => {
        addOption(variantId, question.id);
    }
    const onChangeType = () => {
        const type = question.type == RADIO_TYPE ? SELECT_TYPE : RADIO_TYPE;
        changeQuestionType(variantId, question.id, type);
    }
    const onEditOptionIsCorrect = (option: Option) => {
        setOptionIsCorrect(variantId, question, option)
    }
    return <Question question={question}
                     onEditTitle={onEditTitle}
                     onEditOptionTitle={onEditOptionTitle}
                     onAddOption={onAddOption}
                     onChangeType={onChangeType}
                     onEditIsOptionCorrect={onEditOptionIsCorrect}
    />

}

type QuestionContainerProps = ConnectedProps<typeof connector>;

export default connector(QuestionContainer);