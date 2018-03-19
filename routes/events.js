var express = require('express');
var router = express.Router();
var mmt = require('moment');

/* GET events listing. */
router.get('/', function(req, res, next) {
    var userDict = {
        isAdmin: true,
        username: "akeaswaran",
        password: "test",
        fullName: "Akshay Easwaran",
        email: "akeaswaran@me.com",
        streetAddress: "1990 Willshire Glen",
        city: "Alpharetta",
        state: "GA",
        //bigReckerPair: "",
        gradYear: "2019",
        gradMonth: "May",
        status: "member",
        events: []
    };
    res.render('events', {
        title: "Events | Ramblin' Reck Club",
        user: userDict,
        moment: mmt,
        events: []
    });
});

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

module.exports = function(database) {
    router.get('/list', function(req, res, next) {
        database.ref('event').orderByChild('date').endAt(Date.now()).once('value').then(function (snapshot) {
            var dataArr = [];
            snapshot.forEach(function(item) {
                var itemDict = item.val();
                itemDict.id = item.key;
                dataArr.push(itemDict);
            });
            res.status(200).send({
                "status" : "ok",
                "events" : dataArr
            });
        }).catch(function (error) {
            res.status(500).send({
                "status" : "bad",
                "message": error,
                "events" : []
            });
        });
    });

    router.get('/list/:count', function(req, res, next) {
        database.ref('event').limitToFirst(parseInt(req.params.count)).orderByChild('date').startAt(Date.parse('2018-01-01')).endAt(Date.now()).once('value', function(snapshot) {
            res.status(200).send(snapshot);
        });
    });

    // router.get('/list/:year/:month', function(req, res, next) {
    //     database.ref('event').limitToFirst(parseInt(req.params.count)).orderByChild('date').startAt(Date.parse('2018-01-01')).endAt(Date.now()).once('value', function(snapshot) {
    //         res.status(200).send(snapshot);
    //     });
    // });

    router.put('/create', function(req, res, next) {
        var requestData = req.body;
        database.ref('event').push({
            name: requestData.name,
            date: Date.parse(requestData.date),
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

    router.put('/update/:id', function(req, res, next) {
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

    router.delete('/delete/:id', function(req, res, next) {
        database.ref('event/' + req.params.id).remove()
            .then(function () {
                onComplete(null, res, "Event removed successfully!")
            })
            .catch(function (error) {
                onComplete(error, res, "Remove failed: " + error.message);
            });
    });
    return router;
};
