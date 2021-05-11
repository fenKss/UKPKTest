import * as React from 'react';
import {Api} from "../../../types/api";
import QuestionListItem from "./QuestionListItem";


export interface QuestionListProps {
    questions: Api.Question[],
    selectedQuestionId: number,
    onSelectQuestion: (id: number) => void
    numbersOnly ?: boolean
}

const QuestionList: React.FC<QuestionListProps> = (props): JSX.Element => {
    const {questions, selectedQuestionId, onSelectQuestion, numbersOnly} = props;
    const Questions = questions.map((question, i) => {
        return <QuestionListItem
            question={question}
            key={i}
            isSelected={question.id == selectedQuestionId}
            onClick={onSelectQuestion}
            numberOnly={numbersOnly}
            index={++i}
        />
    });

    return (
        <ul className={"list"}>
            {Questions}
        </ul>
    )
}
export default QuestionList;