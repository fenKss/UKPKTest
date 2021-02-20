import * as React from 'react';
import TestEditorPopup from "./TestEditorPopup";
import {connect, ConnectedProps} from "react-redux";

const mapStateToProps = (state) => {
    return {
        isVisible:state.popup.isVisible,
        text:state.popup.text,
        type:state.popup.type,
    }
}
const mapDispatchToProps = (dispatch) => {
    return {

    }
}
const connector = connect(mapStateToProps, mapDispatchToProps);
type Props = ConnectedProps<typeof connector>;
const TestEditorPopupContainer = (props: Props) => {
    const onChangeText = (e: React.ChangeEvent<HTMLInputElement>) => {
        const value = e.target.value;
    }
    const {isVisible ,text ,type} = props;
    return <TestEditorPopup isVisible={isVisible} text={text} type={type} onChangeText={onChangeText} />
}

export default TestEditorPopupContainer;