import * as React from 'react';
import {Api} from "../../../types/api";

export interface QuestionListItemProps {
    question: Api.Question,
    isSelected: boolean,
    onClick: (id:number) => void
}

const QuestionListItem: React.FC<QuestionListItemProps> = (props): JSX.Element => {
    const {question, isSelected, onClick} = props;
    const body = question.title.body;
    const click = () => {
        onClick(question.id);
    }
    let QuestionItem;
    if (question.title.type == Api.ETypedFieldType.IMAGE_TYPE) {
        //@ts-ignore
        QuestionItem = <img src={body.fullPath} alt={body.filename}/>;
    } else {
        QuestionItem = <span >{body}</span>;
    }
    const className = isSelected ? "selected" : '';
    return (
        <li className={className} onClick={click}>
            {QuestionItem}
        </li>
    )
}
export default QuestionListItem;