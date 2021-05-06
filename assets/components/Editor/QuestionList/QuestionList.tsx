import * as React from 'react';
import {Api} from "../../../types/api";
import QuestionListItem from "./QuestionListItem";
import  "./questionList.scss";

export interface QuestionListProps {
    questions: Api.Question[],
    selectedQuestionId: number,
    onSelectQuestion: (id: number) => void
    onDeleteQuestion: (question: Api.Question) => void
}

const QuestionList: React.FC<QuestionListProps> = (props): JSX.Element => {
    const {questions, selectedQuestionId, onSelectQuestion,onDeleteQuestion} = props;
    const Questions = questions.map((question, i) => {
        return <QuestionListItem
            question={question}
            key={i}
            isSelected={question.id == selectedQuestionId}
            onClick={onSelectQuestion}
            onDeleteQuestion={onDeleteQuestion}
        />
    });

    return (
        <ul className={"list"}>
            {Questions}
        </ul>
    )
}
export default QuestionList;