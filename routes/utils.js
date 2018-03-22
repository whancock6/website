function cleanUser(snapshot) {
    console.log('cleaning single user');
    var user = snapshot.val();
    if (user.events != null) {
        var eventArr = [];
        console.log(user.events);
        console.log(typeof  user.events);
        Object.keys(user.events).forEach(function(item) {
            if (item != null) {
                var eventDict = user.events[item];
                eventDict.id = item;
                eventArr.push(eventDict);
            }
        });
        user.events = eventArr;
    } else {
        user.events = [];
    }
    user.uid = snapshot.key;
    return user;
}

function cleanSnapshotArray(snapshot) {
    console.log('cleaning snapshot array');
    var dataArr = [];
    snapshot.forEach(function(item) {
        var itemDict = item.val();
        itemDict.id = item.key;
        dataArr.push(itemDict);
    });
    return dataArr;
}

function cleanUserList(snapshot) {
    console.log('cleaning set of users');
    var dataArr = [];
    snapshot.forEach(function(item) {
        dataArr.push(cleanUser(item));
    });
    return dataArr;
}

module.exports = {
    cleanUser: cleanUser,
    cleanSnapshotArray: cleanSnapshotArray,
    cleanUserList: cleanUserList
};