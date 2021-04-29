import * as React from "react";
import editorApi from "../../lib/editorApi";
import {
    useParams
} from "react-router-dom";
import {ParamTypes} from "../../types";
import {useEffect} from "react";

const Editor: () => JSX.Element = () => {
    const api = editorApi;
    const {variantId} = useParams<ParamTypes>();
    useEffect(() => {
        api.question.all(+variantId).then(e => e);
    }, [])

    return <div>123</div>
}
export default Editor;