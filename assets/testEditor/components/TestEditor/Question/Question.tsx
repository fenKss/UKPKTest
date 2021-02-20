import * as React from 'react';
import {Question} from "../../../../types/testEditor";
import Options from "./Options/Options";

type Props = {
    question: Question,
    onEditTitle:(e:React.MouseEvent<HTMLButtonElement, MouseEvent>) => void,
    onAddOption:(questionId:number) => void,
}
const Question = (props: Props) => {
    const {question, onEditTitle,onAddOption} = props;
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
            <Options question={question} onAddOption={onAddOption} />
        </div>
    )
}

export default Question;