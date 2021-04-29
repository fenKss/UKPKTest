export namespace Api {
    export interface IImage {
        filename: string
        fullPath: string
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
        body: IImage | string,
        type: ETypedFieldType,
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
    }

    export type Variant = {
        id: number
        testId: number
        userTests: []
        questions: Question[]
    }

    export type Response<T> = {
        error: boolean,
        data: T,
        error_msg: string
    }
}