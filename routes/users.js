var express = require('express');
var router = express.Router();
var mmt = require('moment');

module.exports = function(firebase) {
    /* GET users listing. */
    router.get('/list', function(req, res, next) {
        if (firebase.auth().currentUser) {
            firebase
                .database()
                .ref('user')
                .once('value')
                .then(function (snapshot) {
                    res.render('users', {
                        title: "Members | Ramblin' Reck Club",
                        user: firebase.auth().currentUser,
                        results: snapshot.val()
                    });
                }).catch(function (err) {
                    res.render('users', {
                        title: "Members | Ramblin' Reck Club",
                        user: firebase.auth().currentUser,
                        results: []
                    });
                });
        } else {
            res.redirect('/login');
        }
    });

    router.get('/:id', function(req, res, next) {
        if (firebase.auth().currentUser) {
            var records = [
                firebase.database().ref('user/' + req.params.id).once('value'),
                firebase.database().ref('user/' + firebase.auth().currentUser.uid).once('value')
            ];

            Promise.all(records).then(function(snapshots) {
                if (snapshots.length == 2) {
                    var selectedUser = snapshots[0].val();
                    selectedUser.uid = snapshots[0].key;
                    var currentUser = snapshots[1].val();
                    currentUser.uid = snapshots[1].key;
                    res.render('user', {
                        title: "User | Ramblin' Reck Club",
                        user: currentUser,
                        "selectedUser": selectedUser,
                        moment: mmt
                    });
                } else if (snapshots.length == 1) {
                    var currentUser = snapshots[0].val();
                    currentUser.uid = snapshots[0].key;
                    res.render('user', {
                        title: "User | Ramblin' Reck Club",
                        user: currentUser,
                        "selectedUser": {},
                        moment: mmt
                    });
                } else {
                    res.render('user', {
                        title: "Points | Ramblin' Reck Club",
                        user: {},
                        "selectedUser": {},
                        moment: mmt
                    });
                }
            });
        } else {
            res.redirect('/login');
        }
    });

    return router;
};
