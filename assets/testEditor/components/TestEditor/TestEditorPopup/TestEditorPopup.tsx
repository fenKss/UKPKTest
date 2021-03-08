import * as React from 'react';
import {Position} from "../../../../types/testEditor";


export type TestEditorPopupProps = {
    type: string,
    text: string,
    isVisible: boolean,
    position: Position,
    onChangeText: (e: React.ChangeEvent<HTMLInputElement>) => void
    onUpdateTitle: (e: React.MouseEvent<HTMLButtonElement, MouseEvent>) => void
}

const TestEditorPopup = (props: TestEditorPopupProps) => {
    const {text, isVisible, onChangeText, position, onUpdateTitle} = props;
    return (
        isVisible && (
            <div className={"form test-editor-popup"} style={position}>
                <div className="test-editor-popup_wrapper">
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