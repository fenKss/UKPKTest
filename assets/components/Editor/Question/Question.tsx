import * as React from "react";
import {Api} from "../../../types/api";
import "./question.scss";
import Question = Api.Question;
import EQuestionType = Api.EQuestionType;

interface QuestionProps {
    question: Question,
    onEditQuestion: (question: Question) => void
}


const Question: React.FC<QuestionProps> = (props): JSX.Element => {
    const {question, onEditQuestion} = props;
    const body = question.title.body;

    const onChangeType = () => {
        question.type = question.type === EQuestionType.RADIO_TYPE ?
            EQuestionType.SELECT_TYPE
            : EQuestionType.RADIO_TYPE;
        onEditQuestion(question);
    }
    let title;
    if (typeof body !== "string" && question.title.type == Api.ETypedFieldType.IMAGE_TYPE) {
        title = <img src={body.fullPath} alt={body.filename}/>;
    } else {
        title = <span>{body}</span>;
    }
    return (
        <div className='question'>
            <div className="question-head">
                <div className="question-title">{title}</div>
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
            </div>
        </div>
    )
}
export default Question;