var express = require('express');
var router = express.Router();
var mmt = require('moment');
var Event = require('events');

/* GET home page. */
router.get('/', function(req, res, next) {
    res.render('index');
});

module.exports = function(database) {
    router.get('/points', function(req, res, next) {
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

        var year = mmt(Date.now()).year();
        var month = mmt(Date.now()).format('MM');
        var count = 5;
        var firstOfMonth = year + '-' + month + '-01';
        database.ref('event')
            .orderByChild('date')
            .startAt(Date.parse(firstOfMonth))
            .endAt(mmt(Date.now()).hour(12).minute(0).second(1).valueOf())
            .limitToLast(Math.min(parseInt(count), 100))
            .once('value')
            .then(function (snapshot) {
                var dataArr = [];
                snapshot.forEach(function (item) {
                    var itemDict = item.val();
                    itemDict.id = item.key;
                    dataArr.push(itemDict);
                });
                res.render('points', {
                    title: "Points | Ramblin' Reck Club",
                    token: "valid",
                    user: userDict,
                    events: dataArr,
                    moment: mmt
                });
            }).catch(function (err) {
            console.log('ERROR loading /points: ' + err);
            res.render('points', {
                title: "Points | Ramblin' Reck Club",
                token: "valid",
                user: userDict,
                events: [],
                moment: mmt
            });
        });
    });
    return router;
};
