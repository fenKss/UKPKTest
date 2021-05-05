import * as React from "react";
import {Api} from "../../../types/api";
import Question = Api.Question;
import QuestionHead from "./QuestionHead/QuestionHead";
import QuestionBody from "./QuestionBody/QuestionBody";
import "./question.scss";

interface QuestionProps {
    question: Question
    onEditQuestion: (question: Question) => void
    onEditQuestionTitle: (question: Question) => void

    onAddOption: () => void
    onEditOption: (option: Api.Option) => void
    onEditOptionTitle: (option: Api.Option) => void
}


const Question: React.FC<QuestionProps> = (props): JSX.Element => {
    const {question, onEditQuestion, onEditQuestionTitle, onEditOption, onAddOption, onEditOptionTitle} = props;

    return (
        <div className='question'>
            <QuestionHead onEditQuestion={onEditQuestion} onEditQuestionTitle={onEditQuestionTitle} question={question}/>
            <QuestionBody question={question} onAddOption={onAddOption} onEditOption={onEditOption} onEditOptionTitle={onEditOptionTitle}/>
        </div>
    )
}
export default Question;