var express = require('express');
var router = express.Router();
var mmt = require('moment');

module.exports = function(firebase) {
    router.get('/', function(req, res, next) {
        if (firebase.auth().currentUser) {
            firebase
                .database()
                .ref('user/' + firebase.auth().currentUser.uid)
                .once('value')
                .then(function(snapshot) {
                    var user = snapshot.val();
                    if (user.events != null) {
                        user.events = user.events.filter(function(item) {
                            return (item != null && item.length !== 0);
                        });
                    }
                    user.uid = snapshot.key;
                    return res.render('families', {
                        title: "Families | Ramblin' Reck Club",
                        user: user,
                        families: [],
                        moment: mmt
                    });
                }).catch(function(err) {
                    console.log('ERROR: ' + err);
                    return res.render('error', {
                        message: err
                    });
                });
        } else {
            return res.redirect('/login');
        }
    });
    // router.get('/edit', function(req, res, next) {
    //     if (firebase.auth().currentUser) {
    //         
    //     } else {
    //         return res.redirect('/login');
    //     }
    // });
    // router.put('/edit', function(req, res, next) {
    //     if (firebase.auth().currentUser) {
    //
    //     } else {
    //         return res.redirect('/login');
    //     }
    // });
    return router;
};