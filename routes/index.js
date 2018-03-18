var express = require('express');
var router = express.Router();
var moment = require('moment');

/* GET home page. */
router.get('/', function(req, res, next) {
    res.render('index');
});

router.get('/points', function(req, res, next) {
    res.render('points', {
        token: "valid",
        user: {
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
            events: [1, 5]
        },
        events: [
            {
                id: 1,
                name: "test sporting event",
                date: moment("2018-03-18").format("M/D"),
                points: 10,
                bonus: false,
                family: false,
                type: "sports"
            },
            {
                id: 2,
                name: "test bonus event 2",
                date: moment("2018-03-17").format("M/D"),
                points: 20,
                bonus: true,
                family: false,
                type: "social"
            },
            {
                id: 3,
                name: "test social event 3",
                date: moment("2018-03-16").format("M/D"),
                points: 10,
                bonus: false,
                family: false,
                type: "social"
            },
            {
                id: 4,
                name: "test family event 4",
                date: moment("2018-03-15").format("M/D"),
                points: 10,
                bonus: false,
                family: true,
                type: "social"
            },
            {
                id: 5,
                name: "test mandatory event 5",
                date: moment("2018-03-14").format("M/D"),
                points: 5,
                bonus: false,
                family: false,
                type: "mandatory"
            }
        ]
    });
});

module.exports = router;
