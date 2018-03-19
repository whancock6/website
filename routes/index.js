var express = require('express');
var router = express.Router();
var mmt = require('moment');

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

        database.ref('event').orderByChild('date').endAt(Date.now()).once('value').then(function (snapshot) {
            var dataArr = [];
            snapshot.forEach(function(item) {
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
        }).catch(function (error) {
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
