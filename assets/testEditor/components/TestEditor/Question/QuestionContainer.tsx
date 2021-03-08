import * as React from 'react';
import Question from "./Question";
import {connect, ConnectedProps} from "react-redux";
import {
    setPopupObject,
    setPopupText, setPopupTitle,
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
    setPopupObjectId: setPopupObject,
    setPopupType,
    setPopupText,
    addOption,
    changeQuestionType,
    setOptionIsCorrect,
    setPopupTitle
};
const connector = connect(mapStateToProps, mapDispatchToProps);

const QuestionContainer = (props: QuestionContainerProps) => {
    const {
        questions,
        selectedQuestion,
        setPopupVisibility,
        setPopupObjectId: setPopupObject,
        setPopupType,
        addOption,
        changeQuestionType,
        setPopupText,
        setOptionIsCorrect,
        setPopupTitle
    } = props;
    // @ts-ignore
    const {variantId} = useParams();
    const question = questions.find((q) => q.id == selectedQuestion);
    const onEditTitle = (e: React.MouseEvent<HTMLButtonElement, MouseEvent>) => {
        setPopupVisibility(true);
        setPopupTitle('Вариант ответа');
        setPopupObject(question);
        setPopupType(POPUP_QUESTION_TITLE_TYPE);
        setPopupText(question.title);
    }
    const onEditOptionTitle = (e: React.MouseEvent<HTMLButtonElement, MouseEvent>, option: Option) => {
        setPopupVisibility(true);
        setPopupTitle('Вопрос');
        setPopupObject(option);
        setPopupType(POPUP_OPTION_TITLE_TYPE);
        setPopupText(option.text);
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