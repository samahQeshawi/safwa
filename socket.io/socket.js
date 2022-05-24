var clients = [];
var mysql = require('mysql');
const dotenv = require('dotenv');
dotenv.config();
//console.log(`${process.env.DB_HOST}`);
var db_config = {
    host: `${process.env.DB_HOST}`,
    user: `${process.env.DB_USERNAME}`,
    password: `${process.env.DB_PASSWORD}`,
    database: `${process.env.DB_DATABASE}`
};
var connection;

function handleDisconnect() {
    connection = mysql.createConnection(db_config);


    connection.connect(function (err) {
        if (err) {
            console.log('error when connecting to db:', err);
            setTimeout(handleDisconnect, 2000);
        }
    });

    connection.on('error', function (err) {
        console.log('db error', err);
        if (err.code === 'PROTOCOL_CONNECTION_LOST') {
            handleDisconnect();
        } else {
            throw err;
        }
    });
}

handleDisconnect();

var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http, {
    cors: {
        origin: '*',
    }
});

http.listen(`${process.env.CHAT_SOCKET_PORT}`, function () {
    console.log('listen to port ' + `${process.env.CHAT_SOCKET_PORT}`);
});

io.on("connection", (socket) => {


    socket.on('join', function (socket_token) {

        connection.query("SELECT count(id) as no,id,user_type_id FROM users where socket_token=?", [socket_token], function (err, result, fields) {
            if (err) throw err;
            var row = result[0];
            if (row.no > 0) {
                var username = row.id;
                console.log('join userid:' + username);
                console.log('join socket.id:' + socket.id);

                //console.log('clients:'+clients.length );
                if (!check_client_array(username)) {
                    //console.log('join ----:');
                    socket.username = username;
                    socket.token = socket_token;
                    socket.auth = "yes";
                    clients.push({
                        id: socket.id,
                        username: username,
                        token: socket_token
                    });
                    if (row.user_type_id == 1) socket.join('admin');
                    connection.query("update users set is_online='1' where socket_token=? ", [socket.token], function (err, result, fields) {
                        if (err) throw err;
                    });
                    var response = {
                        status: true,
                        code: 0,
                        text: "The Socket Joined successfuly"
                    }
                    io.to(socket.id).emit('join', response);


                }
            } else {
                var response = {
                    status: false,
                    code: 1,
                    text: "The Socket Not Joined Due to Wrong Token"
                }
                io.to(socket.id).emit('join', response);
            }

        });
    });

    socket.on('chat', function (object) { // {to,msg}

        if (socket.auth == "yes") {
            console.log('chat:' + object.to);
            var socket_id_to = get_socketId(object.to);
            var from = get_userId(socket.id);
            object.from = from;
            console.log('chat from:' + object.from);
            io.to(socket_id_to).emit('chat', object); //{from,to,msg}

            var response = {
                status: true,
                code: 0,
                text: "The Message sent Successfuly"
            }
            io.to(socket.id).emit('chat_response', response);
        } else {
            var response = {
                status: false,
                code: 2,
                text: "The Socket Not Authenticated"
            }
            io.to(socket.id).emit('chat_response', response);
        }

    });
    /////////////////////////////////////////////////////
    socket.on('join_trip', function (object) { //{trip_id,socket_token}
        console.log('join_trip ' + object.trip_id);

        if (socket.auth == "yes") {
            connection.query("SELECT count(trips.id) as no,users.user_type_id,customers.user_id FROM trips inner join drivers on trips.driver_id=drivers.id inner JOIN users ON drivers.user_id=users.id inner join customers on trips.customer_id=customers.id where users.user_type_id=3 and trips.status in(4,5,6,7,8) and users.socket_token=? and trips.id=?", [object.socket_token, object.trip_id], function (err, result, fields) {
                if (err) throw err;
                var row = result[0];
                console.log('join_trip row.no' + row.no);

                if (row.no == 1) {
                    socket.auth_tracking = "send";
                    socket.trip_id = object.trip_id
                    socket.trip_customer_id = row.user_id;
                    var customer_socket_id = get_socketId(row.user_id);
                    io.to(customer_socket_id).emit('start_trip', {
                        trip_id: object.trip_id
                    });
                    var response = {
                        status: true,
                        code: 0,
                        text: "The Socket Joined to Tracking"
                    }
                    io.to(socket.id).emit('join_trip', response);
                } else {
                    var response = {
                        status: false,
                        code: 3,
                        text: "The Socket has not authorized to this trip Id"
                    }
                    io.to(socket.id).emit('join_trip', response);
                }
            });


        } else {
            var response = {
                status: false,
                code: 2,
                text: "The Socket Not Authenticated"
            }
            io.to(socket.id).emit('join_trip', response);

        }

    });

    socket.on('leave_trip', function (trip_id) {
        if (socket.auth == "yes") {
            socket.auth_tracking = "";
            socket.trip_id = 0
            socket.trip_customer_id = 0;
            var response = {
                status: true,
                code: 0,
                text: "The Socket Leaved Tracking"
            }
            io.to(socket.id).emit('leave_trip', response);
        } else {
            var response = {
                status: false,
                code: 2,
                text: "The Socket Not Authenticated"
            }
            io.to(socket.id).emit('leave_trip', response);
        }
    });

    socket.on('trip_track', function (object) { //{trip_no,lat,lng}
        if (socket.auth == "yes") {
            if ((socket.auth_tracking == "send") && (socket.trip_id == object.trip_id)) {
                var updated_at = new Date().toISOString().slice(0, 19).replace('T', ' ');

                connection.query("update trip_trackings set lat=? , lng=? , updated_at=? where trip_id=? ", [object.lat, object.lng, updated_at, object.trip_id], function (err, result, fields) {
                    if (err) throw err;
                });
                var customer_socket_id = get_socketId(socket.trip_customer_id);
                io.to(customer_socket_id).emit('trip_track', object);
                socket.to('admin').emit('trip_track', object);
            } else {
                var response = {
                    status: false,
                    code: 4,
                    text: "The Socket has not authenticate for tracking this trip"
                }
                io.to(socket.id).emit('trip_track', response);
            }
        } else {
            var response = {
                status: false,
                code: 2,
                text: "The Socket Not Authenticated"
            }
            io.to(socket.id).emit('trip_track', response);
        }
    });

    socket.on('trip_route', function (object) { //{trip_id,lat,lng}
        if (socket.auth == "yes") {
            if ((socket.auth_tracking == "send") && (socket.trip_id == object.trip_id)) {
                var update_at = new Date().toISOString().slice(0, 19).replace('T', ' ');
                connection.query("insert into trip_routes(trip_id,lat,lng) values(?,?,?) ", [object.trip_id, object.lat, object.lng], function (err, result, fields) {
                    if (err) throw err;
                });
                var customer_socket_id = get_socketId(socket.trip_customer_id);
                io.to(customer_socket_id).emit('trip_route', object);
                socket.to('admin').emit('trip_route', object);
            } else {
                var response = {
                    status: false,
                    code: 4,
                    text: "The Socket has not authenticate for tracking this trip"
                }
                io.to(socket.id).emit('trip_route', response);
            }
        } else {
            var response = {
                status: false,
                code: 2,
                text: "The Socket Not Authenticated"
            }
            io.to(socket.id).emit('trip_route', response);
        }
    });
    /////////////////////////////////////////////////////////
    socket.on("disconnect", (reason) => {
        console.log("disconnect ");
        try {
            clients.remove(socket.id);
            connection.query("update users set is_online='0' where socket_token=? ", [socket.token], function (err, result, fields) {
                if (err) throw err;
            });
        } catch (e) {
            console.log("error ")
            clients.remove(socket.id);
        }

    });


});

Object.defineProperty(Array.prototype, "remove", {
    value: function (value) {
        for (let key in this) {
            if (this[key].id === value) {
                this.splice(key, 1);
            }
        }
        return this;
    }
});

function check_client_array(user_name) {
    var check = false;
    for (var i = 0; i < clients.length; ++i) {
        if (clients[i].username == user_name) {
            check = true;
            break;
        }
    }
    return check;
}

function get_socketId(user_name) {
    var socketId = '';
    for (var i = 0; i < clients.length; ++i) {
        if (clients[i].username == user_name) {
            socketId = clients[i].id;
            break;
        }
    }
    return socketId;
}

function get_userId(socket_id) {
    var userId = '';
    for (var i = 0; i < clients.length; ++i) {
        if (clients[i].id == socket_id) {
            userId = clients[i].username;
            break;
        }
    }
    return userId;
}
