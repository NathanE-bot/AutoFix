/* eslint-disable */

export default {
    user: {
        authenticated: false
    },
    checkAuth () {
        let tempAccessToken = {}
        tempAccessToken = localStorage.getItem('access_token')
        if (tempAccessToken.data.token === null) {
            this.user.authenticated = false
        }
        else {
            this.user.authenticated = true
        }
            return this.user.authenticated
    }
}