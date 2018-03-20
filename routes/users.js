var express = require('express');
var router = express.Router();

module.exports = function(database) {
    /* GET users listing. */
    router.get('/', function(req, res, next) {
        res.send('respond with a user resource');
    });

    router.get('/:id', function(req, res, next) {
        database.ref('user/' + req.params.id).once('value')
            .then(function (snapshot) {
                res.status(200).send({
                    status: "ok",
                    user: snapshot.val(),
                    message: "viewing user " + req.params.id
                });
                // res.render('points', {
                //     title: "Points | Ramblin' Reck Club",
                //     token: "valid",
                //     user: firebase.auth().currentUser,
                //     events: dataArr,
                //     moment: mmt
                // });
            }).catch(function (err) {
                res.status(200).send({
                    status: "bad",
                    user: {},
                    message: "error retrieving user " + req.params.id,
                    detailedMessage: err
                });
            });
    });

    return router;
};
