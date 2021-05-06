import * as React from 'react';
import "./addQuestionButton.scss"
import {connect, ConnectedProps} from "react-redux";
import {useParams} from "react-router-dom";
import {ParamTypes} from "../../../types";
import {createQuestion} from "../../../store/editorReducer/serverActions";
import AddButton from "../AddButton";
import {RootState} from "../../../store/store";

const AddQuestionButtonContainer: React.FC<AddQuestionButtonContainerProps> = (props) => {
    const {createQuestion,isPublished} = props;
    const {variantId} = useParams<ParamTypes>();
    const onClick = () => {
        createQuestion(+variantId);
    }
    return (
        !isPublished && <AddButton onClick={onClick} id="addQuestion" class="btn-sm btn-primary"/>
    )
}
const mapDispatchToProps = {
    createQuestion
}
const mapStateToProps = (state: RootState) =>({
    isPublished: state.editor.isPublished
})
const connector = connect(mapStateToProps, mapDispatchToProps);
export type AddQuestionButtonContainerProps = ConnectedProps<typeof connector>
export default connector(AddQuestionButtonContainer);
