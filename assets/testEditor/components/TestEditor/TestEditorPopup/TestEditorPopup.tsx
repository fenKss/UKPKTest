import * as React from 'react';
import {Position} from "../../../../types/testEditor";
import {setPopupVisibility} from "../../../store/popupReducer";


export type TestEditorPopupProps = {
    type: string,
    text: string,
    title: string,
    isVisible: boolean,
    position: Position,
    setPopupVisibility,
    onChangeText: (e: React.ChangeEvent<HTMLInputElement>) => void
    onUpdateTitle: (e: React.MouseEvent<HTMLButtonElement, MouseEvent>) => void
}

const TestEditorPopup = (props: TestEditorPopupProps) => {
    const {text, isVisible, onChangeText, position, onUpdateTitle, title,setPopupVisibility} = props;
    const closePopup = () => {
        setPopupVisibility(false);
    }
    return (
        isVisible && (
            <div className={"form test-editor-popup"} style={position}>
                <div className="test-editor-popup_wrapper">
                    <div className="test-editor-popup_header">
                        <div className="popup-close" onClick={closePopup}>X</div>
                        <div className="popup-title">
                            {title}
                        </div>
                    </div>
                    <div className="form-group">
                        <input type="text" className={'form-control'} value={text} onChange={onChangeText}/>
                    </div>
                    <button className={`btn btn-success`} onClick={onUpdateTitle}>Изменить</button>
                </div>
            </div>
        )
    )
}

export default TestEditorPopup;