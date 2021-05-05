import * as React from 'react';
import {Api} from "../../../../types/api";
import OptionList from "./OptionList/OptionList";

interface QuestionBodyProps {
    question: Api.Question,
    onEditOption: (option: Api.Option) => void,
    onAddOption: () => void,
}

const QuestionBody: React.FC<QuestionBodyProps> = (props) => {
    const {question, onEditOption, onAddOption} = props;

    return (
        <div className='question-body'>
            <div className="options">
                <OptionList type={question.type} options={question.options} onEditOption={onEditOption} onAddOption={onAddOption}/>
            </div>
        </div>
    )
};

export default QuestionBody;