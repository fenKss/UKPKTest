import * as React from 'react';
import {RootState} from "../../../store/store";
import {connect, ConnectedProps} from "react-redux";
import TestHead from "./TestHead";

const TestHeadContainer: React.FC<TestHeadContainerProps> = (props) => {
    const {olympicName, variantIndex, tourIndex, expiredAt, resultsSavedAt} = props;
    return <TestHead
        expiredAt={expiredAt}
        variantIndex={variantIndex}
        tourIndex={tourIndex}
        olympicName={olympicName}
        resultsSavedAt={resultsSavedAt}
    />
}
const mapDispatchToProps = () => ({});
const mapStateToProps = (state: RootState) => ({
    olympicName: state.test.olympicName,
    variantIndex: state.test.variantIndex,
    tourIndex: state.test.tourIndex,
    expiredAt: state.test.expiredAt,
    resultsSavedAt: state.test.resultSavedAt
})
const connector = connect(mapStateToProps, mapDispatchToProps);
export type TestHeadContainerProps = ConnectedProps<typeof connector>
export default connector(TestHeadContainer);
