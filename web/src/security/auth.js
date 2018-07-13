export default {
    request: function (req, token) {
        let isRefresh = req.url.indexOf('refresh') > -1;

        token = token.split(';');
        token = isRefresh ? token[1] : token[0];

        if (!isRefresh) {
            this.options.http._setHeaders.call(this, req, {
                'Content-Type': 'application/json',
                Authorization: 'Bearer ' + token
            });
        } else {
            this.options.http._setData.call(this, req, {refresh_token: token});
        }
    },

    response: function (res) {
        if (res.data.hasOwnProperty('token') && res.data.hasOwnProperty('refresh_token'))
            return Object.values(res.data).join(';');
    }
};