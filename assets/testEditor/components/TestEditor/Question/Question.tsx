import * as React from 'react';
import {Option, Question, RADIO_TYPE} from "../../../../types/testEditor";
import Options from "./Options/Options";

type Props = {
    question: Question,
    onEditTitle:(e:React.MouseEvent<HTMLButtonElement, MouseEvent>) => void,
    onEditOptionTitle:(e:React.MouseEvent<HTMLButtonElement, MouseEvent>, option: Option) => void,
    onAddOption:(questionId:number) => void,
    onChangeType:()=>void
}
const Question = (props: Props) => {
    const {question, onEditTitle,onAddOption, onChangeType,onEditOptionTitle} = props;
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
                <div className="question-type">
                    <span>CheckBox</span>
                    <div className="material-switch pull-right">
                        <input id={`questionType_${question.id}`} className="edit-question-type" type="checkbox" checked={question.type == RADIO_TYPE} onChange={onChangeType}   />
                        <label htmlFor={`questionType_${question.id}`} className="label-default"/>
                    </div>
                    <span>Radio</span>
                </div>
            </div>

            <Options question={question} onAddOption={onAddOption} onEditOptionTitle={onEditOptionTitle} />
        </div>
    )
}

export default Question;