import * as React from 'react';
import "./addQuestionButton.scss"

export interface AddQuestionButtonProps{
    onClick: () => void
}
const AddQuestionButton: React.FC<AddQuestionButtonProps> = (props) => {
    const {onClick} = props;
    return (
        <button id={"addQuestion"} className={"btn btn-sm btn-primary"} onClick={onClick}>
            <i className="fa fa-plus"/>
        </button>
    )
}

export default AddQuestionButton;