import * as React from "react";
import {Api} from "../../../../types/api";
import Question from "../Question";
import QuestionType from "./QuestionType/QuestionType";
import QuestionTitle from "./QuestionTitle/QuestionTitle";
import EQuestionType = Api.EQuestionType;

interface QuestionHeadProps {
    question: Api.Question,
    onEditQuestion: (question: Api.Question) => void
    onEditQuestionTitle: (question: Api.Question) => void
}

const QuestionHead: React.FC<QuestionHeadProps> = (props) => {

    const {question, onEditQuestion, onEditQuestionTitle} = props;

    const onEditTitle = (question: Api.Question) => {
        onEditQuestionTitle(question);
    }
    const onChangeType = () => {
        question.type = question.type === EQuestionType.RADIO_TYPE ?
            EQuestionType.SELECT_TYPE
            : EQuestionType.RADIO_TYPE;
        onEditQuestion(question);
    }
    return (
        <div className="question-head">
            <QuestionTitle question={question} onEditQuestionTitle={onEditTitle}/>
            <QuestionType question={question} onChangeType={onChangeType}/>
        </div>
    )
}

export default QuestionHead;