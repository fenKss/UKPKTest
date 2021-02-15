import * as React from 'react';
import {Question} from "../../../types/testEditor";


interface Props {
    questions: Array<Question>,
    selectedQuestion?: number,
    onSelectQuestion: (id: number) => void
}

const QuestionAside = (props: Props) => {
    const {questions, selectedQuestion, onSelectQuestion} = props;
    
    const Questions = questions.map((question, i) => {
        const className = question.id == selectedQuestion ? 'selected' : null;
        return <li
            key={i}
            className={className}
            onClick={() => {
                onSelectQuestion(question.id)
            }}>
            {question.title}
        </li>
    });
    return (
        <ul className={'questions'}>
            {Questions}
        </ul>
    )
};

export default QuestionAside;