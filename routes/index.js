var express = require('express');
var router = express.Router();
var mmt = require('moment');

/* GET home page. */
router.get('/', function(req, res, next) {
    res.render('index', {
        title: "Ramblin' Reck Club | Spreading Joy since 1930",
        moment: mmt
    });
});

router.get('/about', function(req, res, next) {
    res.render('about', {
        title: "About | Ramblin' Reck Club",
        moment: mmt
    });
});

router.get('/endowments', function(req, res, next) {
    res.render('endowments', {
        title: "Endowments | Ramblin' Reck Club",
        moment: mmt
    });
});

router.get('/about/tbook', function(req, res, next) {
    res.render('t-book', {
        title: "The T-Book | Ramblin' Reck Club",
        moment: mmt
    });
});

router.get('/about/roster', function(req, res, next) {
    res.render('roster', {
        title: "Roster | Ramblin' Reck Club",
        moment: mmt
    });
});

router.get('/reckruitment', function(req, res, next) {
    res.render('recruitment-process', {
        title: "RECKruitment | Ramblin' Reck Club",
        moment: mmt
    });
});

router.get('/reckruitment/why', function(req, res, next) {
    res.render('why', {
        title: "Why you need to join Reck Club | Ramblin' Reck Club",
        moment: mmt
    });
});

router.get('/reckruitment/probateship', function(req, res, next) {
    res.render('probateship', {
        title: "Probateship | Ramblin' Reck Club",
        moment: mmt
    });
});

router.get('/reck', function(req, res, next) {
    res.render('reck', {
        title: "The Reck | Ramblin' Reck Club",
        moment: mmt
    });
});

router.get('/reck/drivers', function(req, res, next) {
    res.render('drivers-list', {
        title: "Reck Drivers | Ramblin' Reck Club",
        moment: mmt
    });
});

router.get('/t-night', function(req, res, next) {
    res.render('t-night', {
        title: "T-Night | Ramblin' Reck Club | Spreading Joy since 1930",
        moment: mmt
    });
});

module.exports = router;
