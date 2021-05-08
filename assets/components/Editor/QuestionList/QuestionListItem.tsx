import * as React from 'react';
import {Api} from "../../../types/api";

export interface QuestionListItemProps {
    question: Api.Question,
    isSelected: boolean,
    onClick: (id: number) => void
}

const QuestionListItem: React.FC<QuestionListItemProps> = (props): JSX.Element => {
    const {question, isSelected, onClick} = props;
    const click = () => {
        onClick(question.id);
    }
    let QuestionItem;
    if (question.title.type == Api.ETypedFieldType.IMAGE_TYPE) {
        QuestionItem = <img src={question.title.image.fullPath} alt={question.title.image.filename}/>;
    } else {
        QuestionItem = <span>{question.title.text}</span>;
    }
    const className = isSelected ? "selected" : '';
    return (
        <li className={className} onClick={click}>
            <div>{QuestionItem}</div>
        </li>
    )
}
export default QuestionListItem;