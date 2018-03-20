var express = require('express');
var router = express.Router();
var mmt = require('moment');

module.exports = function(firebase) {
    router.get('/', function(req, res, next) {
        if (firebase.auth().currentUser) {
            console.log('AUTHDATA: ' + JSON.stringify(req.session));

            var year = mmt(Date.now()).year();
            var month = mmt(Date.now()).format('MM');

            var firstOfMonth = year + '-' + month + '-01';
            firebase.database().ref('event')
                .orderByChild('date')
                .startAt(Date.parse(firstOfMonth))
                .endAt(mmt(Date.now()).hour(23).minute(59).second(59).valueOf())
                //.limitToLast(Math.min(parseInt(count), 100))
                .once('value')
                .then(function (snapshot) {
                    var dataArr = [];
                    snapshot.forEach(function (item) {
                        var itemDict = item.val();
                        itemDict.id = item.key;
                        dataArr.push(itemDict);
                    });

                    firebase
                        .database()
                        .ref('user/' + firebase.auth().currentUser.uid)
                        .once('value')
                        .then(function(snapshot) {
                            var user = snapshot.val();
                            user.events = user.events.filter(function(item) {
                                return (item != null && item.length !== 0);
                            });
                            user.uid = snapshot.key;

                            res.render('points', {
                                title: "Points | Ramblin' Reck Club",
                                token: "valid",
                                user: user,
                                events: dataArr,
                                moment: mmt
                            });
                        }).catch(function(err) {
                            console.log('ERROR: ' + err);
                            res.render('points', {
                                title: "Points | Ramblin' Reck Club",
                                token: "valid",
                                user: firebase.auth().currentUser,
                                events: dataArr,
                                moment: mmt
                            });
                        });
                }).catch(function (err) {
                    console.log('ERROR loading /points: ' + err);
                    firebase
                        .database()
                        .ref('user/' + firebase.auth().currentUser.uid)
                        .once('value')
                        .then(function(snapshot) {
                            var user = snapshot.val();
                            user.events = user.events.filter(function(item) {
                                return (item != null && item.length !== 0);
                            });
                            user.uid = snapshot.key;
                            res.render('points', {
                                title: "Points | Ramblin' Reck Club",
                                token: "valid",
                                user: user,
                                events: [],
                                moment: mmt
                            });
                        }).catch(function(err) {
                        console.log('ERROR: ' + err);
                        res.render('points', {
                            title: "Points | Ramblin' Reck Club",
                            token: "valid",
                            user: firebase.auth().currentUser,
                            events: [],
                            moment: mmt
                        });
                    });
                });
        } else {
            res.redirect('/login');
        }
    });

    return router;
};