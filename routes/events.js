var express = require('express');
var rtr = express.Router();
var mmt = require('moment');

function onComplete(error, res, successMessage) {
    if (error) {
        res.status(400).send({
            "status" : "bad",
            "message": error
        });
    } else {
        res.status(200).send({
            status: "ok",
            message: successMessage
        });
    }
}

function getEventList(firebase, success, error) {
    firebase
        .database()
        .ref('event')
        .orderByChild('date')
        .endAt(mmt(Date.now()).hour(23).minute(59).second(59).valueOf())
        .once('value')
        .then(function (snapshot) {
            var dataArr = [];
            snapshot.forEach(function(item) {
                var itemDict = item.val();
                itemDict.id = item.key;
                dataArr.push(itemDict);
            });
            dataArr.sort(function(a, b) {
               return a.date < b.date;
            });
            success(dataArr);

        }).catch(function (err) {
        error(err);
    });
}

function getEventListCount(firebase, count, success, error) {
    firebase
        .database()
        .ref('event')
        .limitToLast(Math.min(parseInt(count), 100))
        .once('value')
        .then(function (snapshot) {
            var dataArr = [];
            snapshot.forEach(function(item) {
                var itemDict = item.val();
                itemDict.id = item.key;
                dataArr.push(itemDict);
            });
            success(dataArr);
        }).catch(function (err) {
            error(err);
        });
}

function getEventListDate(firebase, year, month, success, error) {
    var firstOfMonth = year + '-' + month + '-01';
    firebase
        .database()
        .ref('event')
        .orderByChild('date')
        .startAt(Date.parse(firstOfMonth))
        .endAt(Date.parse(mmt(firstOfMonth).endOf('month').hour(23).minute(59).second(59).format('YYYY-MM-DD')))
        .once('value')
        .then(function (snapshot) {
            var dataArr = [];
            snapshot.forEach(function(item) {
                var itemDict = item.val();
                itemDict.id = item.key;
                dataArr.push(itemDict);
            });
            success(dataArr);
        }).catch(function (err) {
            error(err);
    });
}

function getEventListRecent(firebase, year, month, count, success, error) {
    var firstOfMonth = year + '-' + month + '-01';
    var cnt = (count != null) ? parseInt(count) : 10;
    firebase
        .database()
        .ref('event')
        .orderByChild('date')
        .startAt(Date.parse(firstOfMonth))
        .endAt(mmt(Date.now()).hour(23).minute(59).second(59).valueOf())
        .limitToLast(Math.min(parseInt(cnt), 100))
        .once('value')
        .then(function (snapshot) {
            var dataArr = [];
            snapshot.forEach(function(item) {
                var itemDict = item.val();
                itemDict.id = item.key;
                dataArr.push(itemDict);
            });
            success(dataArr);
        }).catch(function (err) {
        error(err);
    });
}

module.exports = function(firebase) {
    /* GET events listing. */
    rtr.get('/', function(req, res, next) {
        if (firebase.auth().currentUser) {
            var year = mmt().format('YYYY');
            var month = mmt().format('MM');
            getEventListDate(firebase, year, month, function (results) {
                firebase
                    .database()
                    .ref('user/' + firebase.auth().currentUser.uid)
                    .once('value')
                    .then(function(snapshot) {
                        var user = snapshot.val();
                        user.events = user.events.filter(function(item) {
                            return (item != null && item.length !== 0);
                        });
                        res.render('events', {
                            title: "Events | Ramblin' Reck Club",
                            user: user,
                            moment: mmt,
                            events: results
                        });
                    }).catch(function(err) {
                        console.log('ERROR: ' + err);
                        res.render('events', {
                            title: "Events | Ramblin' Reck Club",
                            user: firebase.auth().currentUser,
                            moment: mmt,
                            events: results
                        });
                    });
            }, function(err) {
                console.log('ERROR loading /events: ' + err);
                firebase
                    .database()
                    .ref('user/' + firebase.auth().currentUser.uid)
                    .once('value')
                    .then(function(snapshot) {
                        var user = snapshot.val();
                        user.events = user.events.filter(function(item) {
                            return (item != null && item.length !== 0);
                        });
                        res.render('events', {
                            title: "Events | Ramblin' Reck Club",
                            user: user,
                            moment: mmt,
                            events: []
                        });
                    }).catch(function(err) {
                        console.log('ERROR: ' + err);
                        res.render('events', {
                            title: "Events | Ramblin' Reck Club",
                            user: firebase.auth().currentUser,
                            moment: mmt,
                            events: []
                        });
                    });
            });
        } else {
            res.redirect('/login');
        }
    });

    rtr.get('/list', function(req, res, next) {
        if (firebase.auth().currentUser) {
            getEventList(firebase, function(results) {
                res.status(200).send({
                    "status" : "ok",
                    "events" : results
                });
            }, function (err) {
                res.status(400).send({
                    "status" : "bad",
                    "message": err,
                    "events" : []
                });
            });
        } else {
            res.status(401).send({
                "status" : "bad",
                "message": "login required",
                "events" : []
            });
        }
    });

    rtr.get('/list/:count', function(req, res, next) {
        if (firebase.auth().currentUser) {
            getEventListCount(firebase, req.params.count, function (results) {
                res.status(200).send({
                    "status" : "ok",
                    "events" : results
                });
            }, function (err) {
                res.status(400).send({
                    "status" : "bad",
                    "message": err,
                    "events" : []
                });
            });
        } else {
            res.status(401).send({
                "status" : "bad",
                "message": "login required",
                "events" : []
            });
        }
    });

    rtr.get('/list/year/:year/month/:month', function(req, res, next) {
        if (firebase.auth().currentUser) {
            var year = req.params.year;
            var month = req.params.month;
            getEventListDate(firebase, year, month, function (results) {
                res.status(200).send({
                    "status" : "ok",
                    "events" : results
                });
            }, function (err) {
                res.status(400).send({
                    "status" : "bad",
                    "message": err,
                    "events" : []
                });
            });
        } else {
            res.status(401).send({
                "status" : "bad",
                "message": "login required",
                "events" : []
            });
        }
    });

    rtr.get('/list/recent/:count', function(req, res, next) {
        if (firebase.auth().currentUser) {
            var year = mmt(Date.now()).year();
            var month = mmt(Date.now()).month();
            getEventListRecent(firebase, year, month, req.params.count, function (results) {
                res.status(200).send({
                    "status" : "ok",
                    "events" : results
                });
            }, function(err) {
                res.status(400).send({
                    "status" : "bad",
                    "message": err,
                    "events" : []
                });
            })
        } else {
            res.status(401).send({
                "status" : "bad",
                "message": "login required",
                "events" : []
            });
        }
    });

    rtr.get('/create', function(req, res) {
        if (firebase.auth().currentUser) {
            res.render('add-event', {
                title: "Create Event | Ramblin' Reck Club",
                user: firebase.auth().currentUser,
                moment: mmt
            });
        } else {
            res.redirect('/login');
        }
    });

    rtr.put('/create', function(req, res, next) {
        if (firebase.auth().currentUser) {
            var requestData = req.body;
            firebase
                .database()
                .ref('event')
                .push({
                    name: requestData.name,
                    date: mmt(requestData.date).hour(12).minute(0).second(0).valueOf(),
                    points: requestData.points,
                    bonus: (requestData.bonus === "true"),
                    family: (requestData.family === "true"),
                    type: requestData.type,
                    createdAt: Date.now(),
                    updatedAt: Date.now()
                }, function(error) {
                    onComplete(error, res, "Event created successfully!")
                });
        } else {
            res.status(401).send({
                "status" : "bad",
                "message": "login required"
            });
        }
    });

    rtr.get('/update/:id', function(req, res) {
        if (firebase.auth().currentUser) {
            firebase
                .database()
                .ref('event/' + req.params.id)
                .once('value')
                .then(function(snapshot) {
                    var event = snapshot.val();
                    event.id = snapshot.key;
                    res.render('update-event', {
                        title: "Create Event | Ramblin' Reck Club",
                        user: firebase.auth().currentUser,
                        event: event,
                        moment: mmt
                    });
                })
                .catch(function(err) {
                    res.render('error', {
                        message: "Event " + req.params.id + " not found",
                        error: err
                    });
                });
        } else {
            res.redirect('/login');
        }
    });

    rtr.get('/:id', function(req, res) {
        if (firebase.auth().currentUser) {
            firebase
                .database()
                .ref('event/' + req.params.id)
                .once('value')
                .then(function(snapshot) {
                    var event = snapshot.val();
                    event.id = snapshot.key;
                    firebase
                        .database()
                        .ref('user/' + firebase.auth().currentUser.uid)
                        .once('value')
                        .then(function(snap) {
                            var curUser = snap.val();
                            curUser.uid = snap.key;
                            res.render('view-event', {
                                title: "Event | Ramblin' Reck Club",
                                user: curUser,
                                event: event
                            });
                        })
                        .catch(function (usrErr) {
                            res.render('error', {
                                message: "User " + firebase.auth().currentUser.uid + " not found",
                                error: usrErr
                            });
                        });
                })
                .catch(function(err) {
                    res.render('error', {
                        message: "Event " + req.params.id + " not found",
                        error: err
                    });
                });
        } else {
            res.redirect('/login');
        }
    });

    rtr.put('/update/:id', function(req, res, next) {
        if (firebase.auth().currentUser) {
            var requestData = req.body;
            firebase.database().ref('event/' + req.params.id).set({
                name: requestData.name,
                date: requestData.date,
                points: requestData.points,
                bonus: requestData.bonus,
                family: requestData.family,
                type: requestData.type,
                updatedAt: new Date()
            }, function(error) {
                onComplete(error, res, "Event updated successfully!")
            });
        } else {
            res.status(401).send({
                "status" : "bad",
                "message": "login required"
            });
        }
    });

    rtr.delete('/delete/:id', function(req, res, next) {
        if (firebase.auth().currentUser) {
            firebase.database().ref('event/' + req.params.id).remove()
                .then(function () {
                    onComplete(null, res, "Event removed successfully!")
                })
                .catch(function (error) {
                    onComplete(error, res, "Remove failed: " + error.message);
                });
        } else {
            res.status(401).send({
                "status" : "bad",
                "message": "login required"
            });
        }
    });

    return {
        router: rtr,
        getEventList: getEventList,
        getEventListRecent: getEventListRecent,
        getEventListCount: getEventListCount,
        getEventListData: getEventListDate
    }
};
