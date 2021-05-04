import * as React from 'react';
import "./addQuestionButton.scss"
import AddQuestionButton from "./AddQuestionButton";
import {createQuestion} from "../../../store/editorReducer/editorReducer";
import {connect, ConnectedProps} from "react-redux";
import {RouteComponentProps, useParams, withRouter} from "react-router-dom";
import {ParamTypes} from "../../../types";

const AddQuestionButtonContainer: React.FC<AddQuestionButtonContainerProps> = (props) => {
    const {createQuestion} = props;
    const {variantId} = useParams<ParamTypes>();
    const onClick = () => {
        createQuestion(+variantId);
    }
    return (
        <AddQuestionButton onClick={onClick}/>
    )
}
const mapDispatchToProps = {
    createQuestion
}
const connector = connect(undefined, mapDispatchToProps);
export type AddQuestionButtonContainerProps = ConnectedProps<typeof connector>
export default connector(AddQuestionButtonContainer);
