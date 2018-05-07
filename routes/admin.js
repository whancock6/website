var express = require('express');
var router = express.Router();
var mmt = require('moment');
var Utils = require('./utils');

module.exports = function(admin, firebase) { // firebase-admin instance + firebase instance
    router.get('/site/manage', function(req, res, next) {
        firebase
            .database()
            .ref('user/' + firebase.auth().currentUser.uid)
            .once('value')
            .then(function(snapshot) {
                res.render('site-management', {
                    moment: mmt,
                    title: 'Manage Site | Ramblin\' Reck Club',
                    user: Utils.cleanUser(snapshot),
                    FIREBASE_PROJECT_ID: process.env.FIREBASE_PROJECT_ID
                });
            }).catch(function(err) {
                console.log('ERROR: ' + err);
                res.render('error', {
                    error: err
                });
        });
    });

    router.get('/user/create', function(req, res, next) {
        if (firebase.auth().currentUser) {
            res.render('create-member', {
                title: "Create Member | Ramblin' Reck Club",
                user: firebase.auth().currentUser,
                moment: mmt
            });
        } else {
            res.redirect('/login');
        }
    });

    // router.put('/user/update-privileges', function(req, res, next) {
    //     if (firebase.auth().currentUser) {
    //         admin.auth().setCustomUserClaims(req.body.id, {admin: true}).then(function() {
    //             // The new custom claims will propagate to the user's ID token the
    //             // next time a new one is issued.
    //         });
    //     }
    // });

    router.put('/user/create', function(req, res, next) {
        if (firebase.auth().currentUser) {
            var requestData = req.body;
            var authData = req.headers;
            var email = authData['user-email'];
            var password = authData['user-password'];
            admin.auth().createUser({
                email: email,
                password: password,
                disabled: false
            })
                .then(function(userRecord) {
                    // See the UserRecord reference doc for the contents of userRecord.
                    console.log("Successfully created new user:", userRecord.uid);
                    firebase
                        .database()
                        .ref('user/' + userRecord.uid)
                        .push({
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
                            events: {},
                            gradMonth: requestData.gradMonth,
                            gradYear: requestData.gradYear,
                            isAdmin: requestData.isAdmin,
                            isEventAdmin: requestData.isEventAdmin,
                            createdAt: Date.now(),
                            updatedAt: Date.now(),
                            points: 0
                        }, function(err) {
                            if (err) {
                                res.status(400).send({
                                    "status" : "bad",
                                    "message": "error creating user record",
                                    "detailedMessage" : err
                                });
                            } else {
                                res.status(200).send({
                                    status: "ok",
                                    message: "User created successfully!"
                                });
                            }
                        });
                })
                .catch(function(error) {
                    console.log("Error creating new user:", error);
                    res.status(400).send({
                        status: "bad",
                        "message": "error creating user record",
                        "detailedMessage" : error
                    });
                });
        } else {
            res.status(401).send({
                "status" : "bad",
                "message": "login required"
            });
        }
    });
    return router;
};