const express = require('express');
const app = express();
const http = require('http');
const server = http.createServer(app);
const {Server} = require("socket.io");
const io = new Server(server);
const mysql = require('mysql2');
const moment = require('moment');
//
//
// let con = mysql.createConnection({
//     host: "localhost",
//     user: "laravel",
//     password: "adgjmp96"
// });
// con.connect(function (err) {
//     if (err) throw err;
//     console.log("mysql Connected!");
// });
let connection = mysql.createConnection({
    host: 'localhost',
    user: 'laravel',
    password: 'adgjmp96',
    database: 'boszhan'
});
connection.connect(function (err) {
    if (err) {
        return console.error('error: ' + err.message);
    }
    console.log('Connected to the MySQL server.');
});


io.on('connection', (socket) => {
    console.log('socket user connected');
    socket.on('position', function (json) {
        let data = JSON.parse(json)
        console.log(data)
        connection.query(`UPDATE users
                          SET lat = ${data.lat},
                              lng = ${data.lng}
                          where id = ${data.id}`,
            function (err, results, fields) {
                if (err) {
                    console.error(err.message)
                }
            })
        var mysqlTimestamp = moment(Date.now()).add(6, 'hours').format('YYYY-MM-DD HH:mm:ss');


        connection.query(`INSERT INTO user_positions (user_id, lat, lng, created_at)
                          VALUES (${data.id}, ${data.lat}, ${data.lng}, '${mysqlTimestamp}');`,
            function (err, results, fields) {
                if (err) {
                    console.log(err.message)
                }
            })
    })

    socket.on('disconnect', function () {
        console.log('A user disconnected');
    });

    setInterval(function () {
        console.log('emit')
        socket.emit('position', 1)
    }, 10000)

});


server.listen(3000, () => {
    console.log('listening on *:3000');
});
