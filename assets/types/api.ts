import {AxiosError, AxiosResponse} from "axios";

export type ApiResponse<T> = AxiosResponse<Api.Response<T>>;
export type ApiError = AxiosError<Api.Response<null>>;

export namespace Api {

    export interface IImage {
        filename: string
        fullPath: string,
    }

    export enum ETypedFieldType {
        TEXT_TYPE = 0,
        IMAGE_TYPE = 1
    }

    export enum EQuestionType {
        RADIO_TYPE = 0,
        SELECT_TYPE = 1
    }

    export type TypedField = {
        text: string | null,
        image: IImage | null,
        type: ETypedFieldType,
        file?: File
    }

    export type Option = {
        id: number
        questionId: number
        isCorrect: boolean
        body: TypedField
    }
    export type Question = {
        id: number
        title: TypedField
        type: EQuestionType
        variantId: number
        options: Option[]
        isAnswered?: boolean
    }

    export type Variant = {
        id: number
        testId: number
        userTests: []
        questions: Question[]
        isPublished: boolean
    }

    export type Response<T> = {
        error: boolean,
        data: T,
        error_msg: string
    }

    export type Test = {
        questions: Question[],
        expiredAt: Date
        tourIndex: number
        variantIndex: number
        olympicName: string
    }
}