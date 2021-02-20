import * as React from 'react';
import {Option, Question, RADIO_TYPE} from "../../../../../../types/testEditor";

type Props = {
    option:Option,
    question: Question
}
const Option = (props: Props) => {
    const {option, question} = props;
    const inputType = question.type == RADIO_TYPE ? 'radio' : 'checkbox';
    return (
        <div>
            <label htmlFor={`option_${option.id}`}>
                <input type={inputType} value={option.id} name="option" id={`option_${option.id}`}  />
                <span>{option.text}</span>
            </label>
            <button className="btn btn-xs btn-default edit-option-title" >
                <i className="fa fa-edit"/>
            </button>
        </div>
    )
}

export default Option;