import {Api} from "../../../types/api";
import * as React from "react";
import TypedField = Api.TypedField;

interface TitleProps {
    field: TypedField
}

const Title: React.FC<TitleProps> = (props) => {
    const {field} = props;
    if (field.type == Api.ETypedFieldType.TEXT_TYPE) {
        return <span>{field.text}</span>;
    }
    //@ts-ignore
    return <img src={field.image.fullPath} alt={field.image.filename}/>


}

export default Title;