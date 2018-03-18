var express = require('express');
var router = express.Router();

module.exports = function(database) {
    /* GET events listing. */
    router.get('/', function(req, res, next) {
        res.send('respond with a event resource');
    });

    router.post('/', function(req, res, next) {
        var requestData = req.body;
        // firebase.database().ref('/users').set({
        //     username: requestData.username,
        //     email: "test@mail.com"
        // });
    });
    return router;
};
