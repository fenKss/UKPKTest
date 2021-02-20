import * as React from 'react';
import {Position} from "../../../../types/testEditor";


export type TestEditorPopupProps = {
    type:string,
    text:string,
    isVisible:boolean,
    position: Position,
    onChangeText:(e:React.ChangeEvent<HTMLInputElement>)=>void
    onUpdateTitle:(e:React.MouseEvent<HTMLButtonElement, MouseEvent>)=>void
}

const TestEditorPopup = (props: TestEditorPopupProps) => {
    const {text, isVisible, onChangeText, position, onUpdateTitle} = props;
    return (
        isVisible && (
            <div id={"testEditorForm"} className={"form"} style={position}>
                <input type="text" value={text} onChange={onChangeText}/>
                <button onClick={onUpdateTitle}>Изменить</button>
            </div>
        )
    )
}

export default TestEditorPopup;