import * as React from 'react';
import TestEditorPopup from "./TestEditorPopup";
import {connect, ConnectedProps} from "react-redux";
import {setPopupText, updateTitle} from "../../../store/popupReducer";
import {useParams} from "react-router-dom";
const mapStateToProps = (state) => {
    return {
        isVisible: state.popup.isVisible,
        text: state.popup.text,
        type: state.popup.type,
        position: state.popup.position,
        object: state.popup.object,
    }
}
const mapDispatchToProps = {
    setPopupText,
    updateTitle
}
const connector = connect(mapStateToProps, mapDispatchToProps);
type Props = ConnectedProps<typeof connector>;

const TestEditorPopupContainer = (props: Props) => {
    const {setPopupText, updateTitle} = props;
    const {isVisible, text, type, position, object} = props;//@ts-ignore
    const {variantId} = useParams();
    const onChangeText = (e: React.ChangeEvent<HTMLInputElement>) => {
        const value = e.target.value;
        setPopupText(value);
    }
    const onUpdateTitle = (e:React.MouseEvent<HTMLButtonElement, MouseEvent>) => {
        updateTitle(variantId, type,object,text);
    }

    return <TestEditorPopup
        position={position}
        isVisible={isVisible}
        text={text}
        type={type}
        onChangeText={onChangeText}
        onUpdateTitle={onUpdateTitle}
    />
}

export default connector(TestEditorPopupContainer);