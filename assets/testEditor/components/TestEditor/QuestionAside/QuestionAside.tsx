import * as React from 'react';
import {Question} from "../../../../types/testEditor";


interface Props {
    questions: Array<Question>,
    selectedQuestion?: number,
    onSelectQuestion: (id: number) => void
    onAddQuestion: (e:React.MouseEvent<HTMLButtonElement, MouseEvent>) => void
}

const QuestionAside = (props: Props) => {
    const {questions, selectedQuestion, onSelectQuestion, onAddQuestion} = props;
    
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
        <aside className={"asideLeft"}>
            <button className="btn btn-success" onClick={onAddQuestion}><i className="fa fa-plus"/></button>
        <ul className={'questions'}>
            {Questions}
        </ul>
        </aside>
    )
};

export default QuestionAside;