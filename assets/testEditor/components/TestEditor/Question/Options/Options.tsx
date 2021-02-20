import * as React from 'react';
import {Question} from "../../../../../types/testEditor";
import Option from "./Option/Option";

type Props = {
    question: Question,
    onAddOption: (questionId: number) => void
}
const Options = (props: Props) => {
    const {question, onAddOption} = props;
    return (
        <div className="question-options">
            <div className="question-options-head">
                <span>Варианты ответа</span>
                <button className="btn btn-xs btn-success add-option" onClick={() => {
                    onAddOption(question.id)
                }}><i className="fa fa-plus"/></button>
            </div>
            <div className="options">
                {
                    question.options.map((option, i) => (
                        <Option option={option} key={i} question={question}/>
                    ))
                }
            </div>
        </div>
    )
};

export default Options;