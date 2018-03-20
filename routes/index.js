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

module.exports = router;
