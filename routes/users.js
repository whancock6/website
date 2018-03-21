var express = require('express');
var router = express.Router();
var mmt = require('moment');
var Utils = require('./utils');

module.exports = function(firebase) {

    router.get('/', function(req, res, next) {
        if (firebase.auth().currentUser) {
            var records = [
                firebase.database().ref('user').once('value'),
                firebase.database().ref('user/' + firebase.auth().currentUser.uid).once('value')
            ];
            Promise.all(records).then(function(snapshots) {
               if (snapshots.length === 2) {
                   var userRecords = snapshots[0];
                   var currentUser = snapshots[1];
                   res.render('view-members', {
                       title: "Members | Ramblin' Reck Club",
                       user: Utils.cleanUser(currentUser),
                       users: Utils.cleanUserList(userRecords),
                       moment: mmt
                   });
               } else {
                   res.render('error', {
                       message: "Malformed internal request. Please report to <a ref=\"mailto:technology@reckclub.org\">RRC Technology Chair</a>.",
                       error: {
                           stack: "check /members route",
                           status: "400 - bad request"
                       }
                   });
               }
            }).catch(function(err) {
                res.render('error', {
                    error: err
                });
            });
        } else {
            res.redirect('/login');
        }
    });

    router.get('/view/:id', function(req, res, next) {
        if (firebase.auth().currentUser) {
            var records = [
                firebase.database().ref('user/' + req.params.id).once('value'),
                firebase.database().ref('user/' + firebase.auth().currentUser.uid).once('value')
            ];

            Promise.all(records).then(function(snapshots) {
                if (snapshots.length == 2) {
                    var selectedUser = Utils.cleanUser(snapshots[0]);
                    var currentUser = Utils.cleanUser(snapshots[1]);
                    res.render('user', {
                        title: "User | Ramblin' Reck Club",
                        user: currentUser,
                        selectedUser: selectedUser,
                        moment: mmt
                    });
                } else if (snapshots.length == 1) {
                    var currentUser = Utils.cleanUser(snapshots[0]);
                    res.render('user', {
                        title: "User | Ramblin' Reck Club",
                        user: currentUser,
                        selectedUser: {},
                        moment: mmt
                    });
                } else {
                    res.render('error', {
                        message: "Malformed internal request. Please report to <a ref=\"mailto:technology@reckclub.org\">RRC Technology Chair</a>.",
                        error: {
                            stack: "check /members route",
                            status: "400 - bad request"
                        }
                    });
                }
            });
        } else {
            res.redirect('/login');
        }
    });

    router.get('/resetPassword/:uid', function(req, res, next) {
        if (firebase.auth().currentUser) {
            if (firebase.auth().currentUser.uid === req.params.uid) {
                firebase
                    .auth()
                    .sendPasswordResetEmail(firebase.auth().currentUser.email)
                    .then(function() {
                        res.status(200).send({
                            "status" : "ok",
                            "message": "Password reset email sent successfully!"
                        });
                    }).catch(function(error) {
                        res.status(400).send({
                            "status" : "bad",
                            "message": "error sending password reset email",
                            "detailedMessage" : error
                        });
                    });
            } else {
                res.status(401).send({
                    "status" : "bad",
                    "message": "not allowed for this account"
                });
            }
        } else {
            res.status(401).send({
                "status" : "bad",
                "message": "login required"
            });
        }
    });

    router.put('/update/:uid', function(req, res, next) {
        if (firebase.auth().currentUser) {
            var requestData = req.body;
            var uid = req.params.uid;
            firebase
                .database()
                .ref('user/' + uid)
                .set({
                    username: requestData.username,
                    email: requestData.email,
                    firstName: requestData.firstName,
                    lastName: requestData.lastName,
                    fullName: requestData.firstName + ' ' + requestData.lastName,
                    birthDate: mmt(requestData.birthDate).hour(12).minute(0).second(0).valueOf(),
                    streetAddress: requestData.streetAddress,
                    city: requestData.city,
                    state: requestData.state,
                    zipCode: requestData.zipCode,
                    phoneNumber: requestData.phoneNumber,
                    status: requestData.status,
                    gradMonth: requestData.gradMonth,
                    gradYear: requestData.gradYear,
                    isAdmin: requestData.isAdmin,
                    isEventAdmin: requestData.isEventAdmin,
                    updatedAt: Date.now(),
                    events: requestData.events,
                    points: requestData.points
                }, function(err) {
                    if (err) {
                        res.status(400).send({
                            "status" : "bad",
                            "message": "error updating user record",
                            "detailedMessage" : err
                        });
                    } else {
                        res.status(200).send({
                            status: "ok",
                            message: "User updated successfully!"
                        });
                    }
                });
        } else {
            res.status(401).send({
                "status" : "bad",
                "message": "login required",
                detailedMessage: {
                    message: "Access unauthorized. Login required."
                }
            });
        }
    });

    router.get('/update/:uid', function(req, res, next) {
        if (firebase.auth().currentUser) {
            var records = [
                firebase.database().ref('user/' + req.params.uid).once('value'),
                firebase.database().ref('user/' + firebase.auth().currentUser.uid).once('value')
            ];
            Promise.all(records).then(function(snapshots) {
                if (snapshots.length === 2) {
                    var selectedUser = snapshots[0];
                    var currentUser = snapshots[1];
                    res.render('update-member', {
                        title: "Update Member | Ramblin' Reck Club",
                        user: Utils.cleanUser(currentUser),
                        selectedUser: Utils.cleanUser(selectedUser),
                        moment: mmt
                    });
                } else {
                    console.log('ERROR loading /members/update curUser query');
                    res.render('error', {
                        message: "Malformed internal request. Please report to RRC Technology Chair (technology@reckclub.org).",
                        error: {
                            stack: "check /members route",
                            status: "400 - bad request"
                        }
                    });
                }
            }).catch(function(err) {
                console.log('ERROR loading /members/update selectedUser query'+ err);
                res.render('error', {
                    message: "Malformed internal request. Please report to RRC Technology Chair (technology@reckclub.org).",
                    error: err
                });
            });
        } else {
            res.redirect('/login');
        }
    });

    // router.get('/create', function(req, res, next) {
    //     if (firebase.auth().currentUser) {
    //         res.render('create-member', {
    //             title: "Create Member | Ramblin' Reck Club",
    //             user: firebase.auth().currentUser,
    //             moment: mmt
    //         });
    //     } else {
    //         res.redirect('/login');
    //     }
    // });
    //
    // router.put('/create', function(req, res, next) {
    //     if (firebase.auth().currentUser) {
    //         var requestData = req.body;
    //         var authData = req.headers;
    //         var email = authData['user-email'];
    //         var password = authData['user-password'];
    //         firebase
    //             .auth()
    //             .createUserWithEmailAndPassword(email, password)
    //             .catch(function(error) {
    //                 if (error) {
    //                     res.status(400).send({
    //                         "status" : "bad",
    //                         "message": "bad request",
    //                         "detailedMessage" : error
    //                     });
    //                 } else {
    //                     req.session.cookie.authdata = authData;
    //                     firebase
    //                         .database()
    //                         .ref('user/' + authData.uid)
    //                         .push({
    //                             username: requestData.username,
    //                             email: requestData.email,
    //                             firstName: requestData.firstName,
    //                             lastName: requestData.lastName,
    //                             fullName: requestData.firstName + ' ' + requestData.lastName,
    //                             birthDate: mmt(requestData.birthDate).hour(12).minute(0).second(0).valueOf(),
    //                             streetAddress: requestData.streetAddress,
    //                             city: requestData.city,
    //                             state: requestData.state,
    //                             zipCode: requestData.zipCode,
    //                             phoneNumber: requestData.phoneNumber,
    //                             status: requestData.status,
    //                             events: {},
    //                             gradMonth: requestData.gradMonth,
    //                             gradYear: requestData.gradYear,
    //                             isAdmin: requestData.isAdmin,
    //                             isEventAdmin: requestData.isEventAdmin,
    //                             createdAt: Date.now(),
    //                             updatedAt: Date.now(),
    //                             points: 0
    //                         }, function(err) {
    //                             if (err) {
    //                                 res.status(400).send({
    //                                     "status" : "bad",
    //                                     "message": "error creating user record",
    //                                     "detailedMessage" : err
    //                                 });
    //                             } else {
    //                                 res.status(200).send({
    //                                     status: "ok",
    //                                     message: "User created successfully!"
    //                                 });
    //                             }
    //                         });
    //                 }
    //             });
    //     } else {
    //         res.status(401).send({
    //             "status" : "bad",
    //             "message": "login required"
    //         });
    //     }
    // });

    return router;
};
