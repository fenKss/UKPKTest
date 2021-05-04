import * as React from "react";
import {Api} from "../../../types/api";
import "./question.scss";
import Question = Api.Question;
import EQuestionType = Api.EQuestionType;
import QuestionTitle from "./QuestionTitle/QuestionTitle";
import QuestionType from "./QuestionType/QuestionType";

interface QuestionProps {
    question: Question,
    onEditQuestion: (question: Question) => void
}


const Question: React.FC<QuestionProps> = (props): JSX.Element => {
    const {question, onEditQuestion} = props;


    const onChangeType = () => {
        question.type = question.type === EQuestionType.RADIO_TYPE ?
            EQuestionType.SELECT_TYPE
            : EQuestionType.RADIO_TYPE;
        onEditQuestion(question);
    }

    return (
        <div className='question'>
            <div className="question-head">
                <QuestionTitle question={question}/>
                <QuestionType question={question} onChangeType={onChangeType}/>

            </div>
        </div>
    )
}
export default Question;