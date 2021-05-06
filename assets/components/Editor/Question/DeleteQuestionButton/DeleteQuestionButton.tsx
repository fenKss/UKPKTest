import * as React from "react";
import {Api} from "../../../../types/api";
import Question = Api.Question;
import "./deleteQuestionButton.scss";

interface DeleteQuestionButtonProps{
    question: Question,
    deleteQuestion: (question: Question) => void
}
const DeleteQuestionButton: React.FC<DeleteQuestionButtonProps> = (props) => {
    const {question, deleteQuestion} = props;

    const onClick = () => {
        if (confirm(`Вы уверены что хотите удалить вопрос?`)) {
            deleteQuestion(question);
        }
    }
    return <button type="submit" onClick={onClick} className="btn btn-danger btn-xs deleteQuestion"><i className="fa fa-trash"/></button>
}
export default DeleteQuestionButton;