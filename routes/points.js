var express = require('express');
var router = express.Router();
var mmt = require('moment');
var Utils = require('./utils');

module.exports = function(firebase) {
    router.get('/', function(req, res, next) {
        if (firebase.auth().currentUser) {
            var year = mmt(Date.now()).year();
            var month = mmt(Date.now()).format('MM');

            var firstOfMonth = year + '-' + month + '-01';
            firebase.database().ref('event')
                .orderByChild('date')
                .startAt(Date.parse(firstOfMonth))
                .endAt(mmt(Date.now()).hour(23).minute(59).second(59).valueOf())
                .once('value')
                .then(function (snapshot) {
                    var dataArr = Utils.cleanEvents(snapshot);
                    firebase
                        .database()
                        .ref('user/' + firebase.auth().currentUser.uid)
                        .once('value')
                        .then(function(snap) {
                            return res.render('points', {
                                title: "Points | Ramblin' Reck Club",
                                user: Utils.cleanUser(snap),
                                events: dataArr,
                                moment: mmt,
                                FIREBASE_PROJECT_ID: process.env.FIREBASE_PROJECT_ID
                            });
                        }).catch(function(err) {
                            console.log('ERROR: ' + err);
                            return res.render('error', {
                                message: err
                            });
                        });
                }).catch(function (err) {
                    console.log('ERROR loading /points: ' + err);
                    firebase
                        .database()
                        .ref('user/' + firebase.auth().currentUser.uid)
                        .once('value')
                        .then(function(snap) {
                            return res.render('points', {
                                title: "Points | Ramblin' Reck Club",
                                user: Utils.cleanUser(snap),
                                events: [],
                                moment: mmt,
                                FIREBASE_PROJECT_ID: process.env.FIREBASE_PROJECT_ID
                            });
                        }).catch(function(err) {
                        console.log('ERROR: ' + err);
                        return res.render('error', {
                            message: err
                        });
                    });
                });
        } else {
            return res.redirect('/login');
        }
    });

    return router;
};