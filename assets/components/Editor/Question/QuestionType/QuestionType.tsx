import * as React from 'react'
import {Api} from "../../../../types/api";
import EQuestionType = Api.EQuestionType;

interface QuestionTypeProps {
    question: Api.Question,
    onChangeType: () => void
}



const QuestionType: React.FC<QuestionTypeProps> = (props) => {
    const {question, onChangeType} = props;
    return (
        <div className="question-type">
            <span>CheckBox</span>
            <div className="material-switch">
                <input className="edit-question-type"
                       id={`questionType_${question.id}`}
                       name={`questionType_${question.id}`}
                       type="checkbox"
                       checked={question.type === EQuestionType.RADIO_TYPE}
                       onChange={onChangeType}
                />
                <label htmlFor={`questionType_${question.id}`} className="label-default"/>
            </div>
            <span>Radio</span>
        </div>
    )
};

export default QuestionType;