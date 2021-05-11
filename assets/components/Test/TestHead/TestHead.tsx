import * as React from "react";
import About from "./About/About";
import Times from "./Times/Times";

interface TestHeadProps {
    olympicName: string
    variantIndex: number
    tourIndex: number,
    expiredAt: Date,
    resultsSavedAt: Date
}

const TestHead: React.FC<TestHeadProps> = (props) => {
    const {olympicName, variantIndex, tourIndex, expiredAt,resultsSavedAt} = props;
    return (
        <div className='test-head'>
            <About olympicName={olympicName} variantIndex={variantIndex} tourIndex={tourIndex}/>
            <Times expiredAt={expiredAt} resultsSavedAt={resultsSavedAt} />
        </div>
    )
};

export default TestHead;