/* eslint-disable */

export default {
    isObjectEmpty (jsonObject) {
        if (jsonObject === null || jsonObject === undefined) return true
        else if(jsonObject > 0) return false
        return Object.keys(jsonObject).length === 0
    }
}