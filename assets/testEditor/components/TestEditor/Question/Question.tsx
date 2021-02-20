import * as React from 'react';
import {Question} from "../../../../types/testEditor";

type Props = {
    question: Question,
    onEditTitle:(e:React.MouseEvent<HTMLButtonElement, MouseEvent>) => void,
}
const Question = (props: Props) => {
    const {question, onEditTitle} = props;
    if (!question) {
        return <></>
    }
    return (
        <div className="question">
            <div className="question-head">
                <div className="question-title">
                    <span>{question.title}</span>
                    <button className="btn btn-xs btn-default edit-question-title" onClick={onEditTitle}>
                        <i className="fa fa-edit"/>
                    </button>
                </div>
            </div>
        </div>
    )
}

export default Question;