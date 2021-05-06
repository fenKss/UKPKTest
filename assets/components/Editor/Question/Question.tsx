import * as React from "react";
import {Api} from "../../../types/api";
import Question = Api.Question;
import QuestionHead from "./QuestionHead/QuestionHead";
import QuestionBody from "./QuestionBody/QuestionBody";
import "./question.scss";
import DeleteQuestionButton from "./DeleteQuestionButton/DeleteQuestionButton";

interface QuestionProps {
    question: Question,
    isPublished: boolean
    onEditQuestion: (question: Question) => void
    onEditQuestionTitle: (question: Question) => void
    onDeleteQuestion: (question: Question) => void

    onAddOption: () => void
    onDeleteOption: (option: Api.Option) => void
    onEditOption: (option: Api.Option) => void
    onEditOptionTitle: (option: Api.Option) => void
}


const Question: React.FC<QuestionProps> = (props): JSX.Element => {
    const {
        question,
        onEditQuestion,
        onEditQuestionTitle,
        onEditOption,
        onAddOption,
        onEditOptionTitle,
        onDeleteOption,
        onDeleteQuestion,
        isPublished
    } = props;

    return (
        <div className='question'>
            {!isPublished && <DeleteQuestionButton question={question} deleteQuestion={onDeleteQuestion}/>}
            <QuestionHead
                onEditQuestion={onEditQuestion}
                onEditQuestionTitle={onEditQuestionTitle}
                question={question}
                isPublished={isPublished}
            />
            <QuestionBody
                question={question}
                onAddOption={onAddOption}
                onEditOption={onEditOption}
                onEditOptionTitle={onEditOptionTitle}
                onDeleteOption={onDeleteOption}
                isPublished={isPublished}
            />
        </div>
    )
}
export default Question;