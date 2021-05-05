import * as React from 'react';
import "./addQuestionButton.scss"
import {connect, ConnectedProps} from "react-redux";
import {useParams} from "react-router-dom";
import {ParamTypes} from "../../../types";
import {createQuestion} from "../../../store/editorReducer/editorReducer";
import AddButton from "../AddButton";

const AddQuestionButtonContainer: React.FC<AddQuestionButtonContainerProps> = (props) => {
    const {createQuestion} = props;
    const {variantId} = useParams<ParamTypes>();
    const onClick = () => {
        createQuestion(+variantId);
    }
    return (
        <AddButton onClick={onClick} id="addQuestion" class="btn-sm btn-primary"/>
    )
}
const mapDispatchToProps = {
    createQuestion
}
const connector = connect(undefined, mapDispatchToProps);
export type AddQuestionButtonContainerProps = ConnectedProps<typeof connector>
export default connector(AddQuestionButtonContainer);
