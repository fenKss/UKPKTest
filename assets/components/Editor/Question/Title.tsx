import {Api} from "../../../types/api";
import * as React from "react";
import TypedField = Api.TypedField;

interface TitleProps {
    field: TypedField
}

const Title: React.FC<TitleProps> = (props) => {
    const {field} = props;
    if (field.type == Api.ETypedFieldType.TEXT_TYPE && typeof field.body == 'string') {
        return <span>{field.body}</span>;
    }
    //@ts-ignore
    return <img src={field.body?.fullPath} alt={field.body?.filename}/>


}

export default Title;