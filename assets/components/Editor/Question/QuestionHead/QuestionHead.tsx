import * as React from "react";
import {Api} from "../../../../types/api";
import QuestionType from "./QuestionType/QuestionType";
import QuestionTitle from "./QuestionTitle/QuestionTitle";
import EQuestionType = Api.EQuestionType;

interface QuestionHeadProps {
    question: Api.Question,
    onEditQuestion: (question: Api.Question) => void
    onEditQuestionTitle: (question: Api.Question) => void
    isPublished: boolean
}

const QuestionHead: React.FC<QuestionHeadProps> = (props) => {

    const {question, onEditQuestion, onEditQuestionTitle, isPublished} = props;

    const onEditTitle = (question: Api.Question) => {
        onEditQuestionTitle(question);
    }
    const onChangeType = () => {
        question.type = question.type === EQuestionType.RADIO_TYPE ?
            EQuestionType.SELECT_TYPE :
            EQuestionType.RADIO_TYPE;
        onEditQuestion(question);
    }
    return (
        <div className="question-head">
            <QuestionTitle
                question={question}
                onEditQuestionTitle={onEditTitle}
                isPublished={isPublished}
            />
            <QuestionType
                question={question}
                onChangeType={onChangeType}
                isPublished={isPublished}
            />
        </div>
    )
}

export default QuestionHead;