import * as React from 'react';


export type TestEditorPopupProps = {
    type:string,
    text:string,
    isVisible:boolean,
    onChangeText:(e:React.ChangeEvent<HTMLInputElement>)=>void
}

const TestEditorPopup = (props: TestEditorPopupProps) => {
    const {text, isVisible, onChangeText} = props;
    return (
        <div id={"testEditorForm"} className={"form"}>
            <input type="text" value={text} onChange={onChangeText}/>
            <button>Изменить</button>
        </div>
    )
}

export default TestEditorPopup;