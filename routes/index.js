var express = require('express');
var router = express.Router();
var mmt = require('moment');
var nodemailer = require('nodemailer');
var transporter = nodemailer.createTransport({
    host: 'smtp.ethereal.email',
    port: 587,
    auth: {
        user: process.env.MAILER_USERNAME,
        pass: process.env.MAILER_PASSWORD
    }
});

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
        title: "T-Night " + mmt().format('YYYY') + " | Ramblin' Reck Club",
        moment: mmt
    });
});

router.get('/big-buzz', function(req, res, next) {
    res.render('big-buzz-form', {
        title: "Big Buzz Appearance Request | Ramblin' Reck Club",
        moment: mmt
    });
});

router.put('/big-buzz/request', function(req, res, next) {
    var requestData = req.body;
    // setup email data with unicode symbols
    var mailOptions = {
        from: '"Ramblin \' Reck Club 👻" <no-reply@reckclub.org>', // sender address
        to: 'Big Buzz Chair <' + process.env.BIG_BUZZ_REQUEST_RECIPIENT + '>', // list of receivers
        subject: '[Big Buzz] New Appearance Request from ' + requestData.renterName, // Subject line
        text: 'A new Big Buzz request has been submitted via https://reckclub.org/big-buzz.\n' +
        '\n' +
        'Requestor: ' + requestData.renterName + ' \<' + requestData.renterEmail + '\>\n' +
        'Event Name: ' + requestData.eventName + '\n' +
        'Event Location: ' + requestData.eventLocation + '\n' +
        'Event Date: ' + mmt(requestData.eventDate).format('dddd, MMMM D, YYYY') + '\n' +
        'Event Details: ' + ((requestData.eventDetails.length > 0) ? requestData.eventDetails : 'No additional information provided.') + '\n' +
        '\n' +
        'Please email ' + requestData.renterName + ' \<' + requestData.renterEmail + '\> at your earliest convenience to confirm or reject this request.\n\n--\nThis email was sent automatically from reckclub.org. Please do not reply to this email -- the sender is a not real inbox. If you received this email in error, please contact technology@reckclub.org.'
    };

    // send mail with defined transport object
    transporter.sendMail(mailOptions, function (error, info) {
        if (error) {
            console.log(error);
            res.status(400).send({
                "status" : "bad",
                "message": error
            });
        } else {
            res.status(200).send({
                'status' : 'ok',
                'message' : 'Big Buzz email sent successfully!'
            });
        }
        // Preview only available when sending through an Ethereal account

        console.log('Message sent: %s', info.messageId);
        console.log('Preview URL: %s', nodemailer.getTestMessageUrl(info));
        // Message sent: <b658f8ca-6296-ccf4-8306-87d57a0b4321@example.com>
        // Preview URL: https://ethereal.email/message/WaQKMgKddxQDoou...
    });
});

module.exports = router;
