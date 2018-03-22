var express = require('express');
var router = express.Router();
var mmt = require('moment');
var Utils = require('./utils');

module.exports = function(firebase) {
    router.get('/', function(req, res, next) {
        if (firebase.auth().currentUser) {
            var promises = [
                firebase.database().ref('families').once('value'),
                firebase.database().ref('user/' + firebase.auth().currentUser.uid).once('value')
            ];
            Promise
                .all(promises)
                .catch(function(err) {
                    console.log('ERROR: ' + err);
                    return res.render('error', {
                        message: "bad request",
                        error: err
                    });
                }).then(function(snapshots) {
                    if (snapshots.length < 1) {
                        res.render('error', {
                            message: "bad request",
                            error: {
                                message: "unable to load /families data"
                            }
                        });
                    } else if (snapshots.length === 1) {
                        var currentUserDict = snapshots[0];
                        var curUser = Utils.cleanUser(currentUserDict);
                        var families = [];
                        res.render('families', {
                            title: 'Families | Ramblin\' Reck Club',
                            families: families,
                            user: curUser,
                            FIREBASE_PROJECT_ID: process.env.FIREBASE_PROJECT_ID,
                            moment: mmt
                        });
                    } else {
                        var familiesSnap = snapshots[0];
                        var families = Utils.cleanSnapshotArray(familiesSnap);
                        var currentUserSnap = snapshots[1];
                        var curUser = Utils.cleanUser(currentUserSnap);
                        res.render('families', {
                            title: 'Families | Ramblin\' Reck Club',
                            families: families,
                            user: curUser,
                            FIREBASE_PROJECT_ID: process.env.FIREBASE_PROJECT_ID,
                            moment: mmt
                        });
                    }
                });
        } else {
            return res.redirect('/login');
        }
    });

    router.get('/view/:id', function(req, res, next) {
        if (firebase.auth().currentUser) {
            var promises = [
                firebase.database().ref('families/' + req.params.id).once('value'),
                firebase.database().ref('user/' + firebase.auth().currentUser.uid).once('value')
            ];
            Promise
                .all(promises)
                .catch(function(err) {
                    console.log('ERROR: ' + err);
                    return res.render('error', {
                        message: "bad request",
                        error: err
                    });
                }).then(function(snapshots) {
                if (snapshots.length < 1) {
                    res.render('error', {
                        message: "bad request",
                        error: {
                            message: "unable to load /families data"
                        }
                    });
                } else if (snapshots.length === 1) {
                    var currentUserDict = snapshots[0];
                    var curUser = Utils.cleanUser(currentUserDict);
                    var family = {};
                    res.render('view-family', {
                        title: 'Families | Ramblin\' Reck Club',
                        family: family,
                        user: curUser,
                        FIREBASE_PROJECT_ID: process.env.FIREBASE_PROJECT_ID,
                        moment: mmt
                    });
                } else {
                    var familySnap = snapshots[0];
                    var family = familySnap.val();
                    family.id = familySnap.key;
                    var currentUserSnap = snapshots[1];
                    var curUser = Utils.cleanUser(currentUserSnap);
                    res.render('view-family', {
                        title: 'Families | Ramblin\' Reck Club',
                        family: family,
                        user: curUser,
                        FIREBASE_PROJECT_ID: process.env.FIREBASE_PROJECT_ID,
                        moment: mmt
                    });
                }
            });
        } else {
            return res.redirect('/login');
        }
    });

    router.get('/create', function(req, res, next) {
        if (firebase.auth().currentUser) {
            res.render('create-family', {
                title: "Create Family | Ramblin' Reck Club",
                user: firebase.auth().currentUser,
                moment: mmt
            });
        } else {
            return res.redirect('/login');
        }
    });

    router.put('/create', function(req, res, next) {
        if (firebase.auth().currentUser) {
            var requestData = req.body;
            var members = JSON.parse(req.body.members);
            var membersStruct = {};
            members.forEach(function(item) {
                membersStruct[item.id] = true;
            });
            firebase
                .database()
                .ref('families')
                .push({
                    name: requestData.name,
                    points: requestData.points,
                    createdAt: Date.now(),
                    updatedAt: Date.now(),
                    members: membersStruct
                }, function(err) {
                    if (err) {
                        return res.status(500).send({
                            message: "Internal server error",
                            error: {
                                message: "Error sending /families/create request"
                            }
                        });
                    } else {
                        return res.status(200).send({
                            status: "ok",
                            message: "Family created successfully"
                        })
                    }
                });
        } else {
            return res.status(401).send({
                "status" : "bad",
                "message": "login required"
            });
        }
    });

    router.get('/update/:id', function(req, res, next) {
        if (firebase.auth().currentUser) {
            firebase
                .database()
                .ref('families/' + req.params.id)
                .once('value')
                .then(function(snapshot) {
                    var event = snapshot.val();
                    event.id = snapshot.key;
                    res.render('update-family', {
                        title: "Update Family | Ramblin' Reck Club",
                        user: firebase.auth().currentUser,
                        event: event,
                        moment: mmt
                    });
                })
                .catch(function(err) {
                    res.render('error', {
                        message: "Family " + req.params.id + " not found",
                        error: err
                    });
                });
        } else {
            return res.redirect('/login');
        }
    });

    router.put('/update/:id', function(req, res, next) {
        if (firebase.auth().currentUser) {
            var requestData = req.body;
            var members = JSON.parse(req.body.members);
            var membersStruct = {};
            members.forEach(function(item) {
                membersStruct[item.id] = true;
            });
            firebase
                .database()
                .ref('families/' + req.params.id)
                .set({
                    name: requestData.name,
                    points: requestData.points,
                    updatedAt: Date.now(),
                    members: membersStruct
                }, function(err) {
                    if (err) {
                        return res.status(500).send({
                            message: "Internal server error",
                            error: {
                                message: "Error sending /families/update request"
                            }
                        });
                    } else {
                        return res.status(200).send({
                            status: "ok",
                            message: "Family updated successfully"
                        })
                    }
                });
        } else {
            return res.status(401).send({
                "status" : "bad",
                "message": "login required"
            });
        }
    });


    return router;
};