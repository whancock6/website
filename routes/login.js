var express = require('express');
var router = express.Router();
var mmt = require('moment');

function authUser(firebase, email, password, failCallback, successCallback) {
    firebase
        .auth()
        .signInWithEmailAndPassword(email, password)
        .then(function(authData) {
            successCallback(authData);
        })
        .catch(function(err) {
            failCallback(err);
        });
}

/* GET login page. */
router.get('/', function (req, res, next) {
    res.render('login', {
        title: "Member Login | Ramblin' Reck Club",
        moment: mmt
    });
});

module.exports = function(firebase) {
    router.put('/', function (req, res, next) {
        var userEmail = req.headers['user-email'];
        var userPassword = req.headers['user-password'];
        authUser(firebase, userEmail, userPassword, function(err) {
            res.status(401).send({
                status: "bad",
                message: "Unauthorized. Please use a valid account and try again.",
                detailedMessage: err
            });
            return res.end();
        }, function(authData) {
            req.session.cookie.authdata = authData;
            res.status(200).send({
                status: "ok",
                message: "Signed in successfully"
            });
            return res.end();
        });
    });

    router.get('/signOut', function(req, res, next) {
        if (firebase.auth().currentUser) {
            firebase.auth().signOut();
            res.status(200).send({
                status: "ok",
                message: "Signed out successfully"
            });
        } else {
            res.status(401).send({
                status: "bad",
                message: "No user signed in",
                detailedMessage: "No user signed in"
            });
        }
    });
    return router;
};

