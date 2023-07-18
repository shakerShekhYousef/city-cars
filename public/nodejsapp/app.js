// creating express instance
var express = require("express");
var app = express();
var request_lib = require('request');
//geoip
var geoip = require('geoip-lite');
// creating http instance
var http = require("http").createServer(app);

// creating socket io instance
var io = require("socket.io")(http);
//===================================
// create body parser instance
var bodyParser = require("body-parser");

//
const cron = require('node-cron');

// enable URL encoded for POST requests
app.use(bodyParser.urlencoded({extended: true}));

//===========================================================
// Create instance of mysql
var mysql = require("mysql");

// make a connection

// var connection = mysql.createConnection({
//     "host": "127.0.0.1",
//     "user": "",
//     "password": "",
//     "database": "city-cars",
//     "charset": "utf8mb4"
// });


var connection = mysql.createConnection({
    "host": "localhost",
    "user": "citycars_citycars",
    "password": "8EF1H,9,f%g3",
    "database": "citycars_citycars"
});

// connect
connection.connect(function (error) {
    if (error) throw error;
    console.log("Connected!");
});
//===================================
// enable headers required for POST request
app.use(function (request, result, next) {
    result.setHeader("Access-Control-Allow-Origin", "*");
    next();
});

io.on("connection", function (socket) {
    socket.on('live_location', (data) => {
        var userId = data.user_id;
        var lat = data.lat;
        var long = data.long;
        var sql = "UPDATE users SET users.lat = ?, users.long =?  WHERE uuid=?";
        function updateCorelecation() {
            connection.query(sql,[data.lat,data.long,data.user_id],function (insert_err, insert_result) {
                if (insert_err) throw insert_err;
                io.emit(`live_location_${userId}`, data);
                console.log(`live_location_${userId}`);

            });
        }
        setInterval(updateCorelecation, 5000);

    });


});

io.on("connection", function (socket) {
    socket.on(`update_request`, (data) => {
        console.log('f');
        var requestId = data.request_id;
        var status = data.status;
        var sql = "UPDATE ride_requests SET ride_requests.status = ? WHERE uuid=?";
        connection.query(sql,[status,requestId],function (insert_err, insert_result) {
            if (insert_err) throw insert_err;
            io.emit(`update_request_${requestId}`, data);
            console.log(`update_request_${requestId}`);
        });
        function updateStatus() {
            connection.query(sql,[status,requestId],function (insert_err, insert_result) {
                if (insert_err) throw insert_err;
                io.emit(`update_request_${requestId}`, data);
                console.log(`update_request_${requestId}`);
            });
        }
    });
});

io.on("connection", function (socket) {
    socket.on('get_request_status', (data) => {
        var requestId = data.request_id;
        var sql = "Select * From ride_requests WHERE id = ?";
        function updateStatus() {
            connection.query(sql,[requestId],function (insert_err, insert_result) {
                if (insert_err) throw insert_err;
                io.emit(`get_request_status${requestId}`, data);
            });
        }
    });
});
//===================================
// start the server
http.listen(3000, function () {
    console.log("Server started");
});
//===================================
