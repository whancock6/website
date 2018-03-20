var express = require('express');
var rtr = express.Router();
var mmt = require('moment');

function onComplete(error, res, successMessage) {
    if (error) {
        res.status(500).send({
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

function getEventList(database, success, error) {
    database.ref('event')
        .orderByChild('date')
        .endAt(Date.now())
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

function getEventListCount(database, count, success, error) {
    database.ref('event')
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

function getEventListDate(database, year, month, success, error) {
    var firstOfMonth = year + '-' + month + '-01';
    database.ref('event')
        .orderByChild('date')
        .startAt(Date.parse(firstOfMonth))
        .endAt(Date.parse(mmt(firstOfMonth).endOf('month').format('YYYY-MM-DD')))
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

function getEventListRecent(database, year, month, count, success, error) {
    var firstOfMonth = year + '-' + month + '-01';
    var cnt = (count != null) ? parseInt(count) : 10;
    database.ref('event')
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

module.exports = function(firebase, database) {
    /* GET events listing. */
    rtr.get('/', function(req, res, next) {
        if (firebase.auth().currentUser) {
            getEventList(database, function (results) {
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
        getEventList(database, function(results) {
            res.status(200).send({
                "status" : "ok",
                "events" : results
            });
        }, function (err) {
            res.status(500).send({
                "status" : "bad",
                "message": err,
                "events" : []
            });
        });
    });

    rtr.get('/list/:count', function(req, res, next) {
        getEventListCount(database, req.params.count, function (results) {
            res.status(200).send({
                "status" : "ok",
                "events" : results
            });
        }, function (err) {
            res.status(500).send({
                "status" : "bad",
                "message": err,
                "events" : []
            });
        });
    });

    rtr.get('/list/year/:year/month/:month', function(req, res, next) {
        var year = req.params.year;
        var month = req.params.month;
        getEventListDate(database, year, month, function (results) {
            res.status(200).send({
                "status" : "ok",
                "events" : results
            });
        }, function (err) {
            res.status(500).send({
                "status" : "bad",
                "message": err,
                "events" : []
            });
        })
    });

    rtr.get('/list/recent/:count', function(req, res, next) {
        var year = mmt(Date.now()).year();
        var month = mmt(Date.now()).month();
        getEventListRecent(database, year, month, req.params.count, function (results) {
            res.status(200).send({
                "status" : "ok",
                "events" : results
            });
        }, function(err) {
            res.status(500).send({
                "status" : "bad",
                "message": err,
                "events" : []
            });
        })
    });

    rtr.put('/create', function(req, res, next) {
        var requestData = req.body;
        database.ref('event').push({
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
    });

    rtr.put('/update/:id', function(req, res, next) {
        var requestData = req.body;
        database.ref('event/' + req.params.id).set({
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
    });

    rtr.delete('/delete/:id', function(req, res, next) {
        database.ref('event/' + req.params.id).remove()
            .then(function () {
                onComplete(null, res, "Event removed successfully!")
            })
            .catch(function (error) {
                onComplete(error, res, "Remove failed: " + error.message);
            });
    });

    return {
        router: rtr,
        getEventList: getEventList,
        getEventListRecent: getEventListRecent,
        getEventListCount: getEventListCount,
        getEventListData: getEventListDate
    }
};
