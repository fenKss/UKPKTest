import * as React from 'react';
import {Api} from "../../../types/api";

export interface QuestionListItemProps {
    question: Api.Question,
    isSelected: boolean,
    onClick: (id: number) => void,
    index: number,
    numberOnly?: boolean,
    key: number
}

const QuestionListItem: React.FC<QuestionListItemProps> = (props): JSX.Element => {
    const {question, isSelected, onClick, numberOnly, index} = props;
    const click = () => {
        onClick(question.id);
    }
    let QuestionItem;
    if (numberOnly) {
        QuestionItem = <span>{index}</span>
    } else if (question.title.type == Api.ETypedFieldType.IMAGE_TYPE) {
        QuestionItem = <img src={question.title.image.fullPath} alt={question.title.image.filename}/>;
    } else {
        QuestionItem = <span>{question.title.text}</span>;
    }
    let className = isSelected ? "selected " : '';
    if (question.isAnswered) className += "answered";
    return (
        <li className={className} onClick={click}>
            <div>{QuestionItem}</div>
        </li>
    )
}
export default QuestionListItem;