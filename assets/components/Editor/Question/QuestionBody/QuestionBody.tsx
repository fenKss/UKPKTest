import * as React from 'react';
import {Api} from "../../../../types/api";
import OptionList from "./OptionList/OptionList";

interface QuestionBodyProps {
    question: Api.Question
    onEditOption: (option: Api.Option) => void
    onDeleteOption: (option: Api.Option) => void
    onAddOption: () => void
    onEditOptionTitle: (option: Api.Option) => void
    isPublished: boolean
}

const QuestionBody: React.FC<QuestionBodyProps> = (props) => {
    const {question, onEditOption, onAddOption, onEditOptionTitle,onDeleteOption, isPublished} = props;

    return (
        <div className='question-body'>
            <div className="options">
                <OptionList type={question.type}
                            options={question.options}
                            onEditOption={onEditOption}
                            onEditOptionTitle={onEditOptionTitle}
                            onAddOption={onAddOption}
                            onDeleteOption={onDeleteOption}
                            isPublished={isPublished}
                />
            </div>
        </div>
    )
};

export default QuestionBody;