var express = require('express');
var bodyParser = require('body-parser');
var mysql = require('mysql');
var path = require('path');

var app = express();
var PORT = process.env.PORT || 3000;

var connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: 'root',
  database: 'cheers_db',
});

connection.connect(function(err){
  if(err)throw err;
  console.log('Connected as id: '+connection.threadId);
});

// Middleware
app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());
app.use(express.static("public"));

// Routes
// require("./routes/api.routes")(app);
// require("./routes/htmlRoutes")(app);


app.listen(PORT, function(){
  console.log('App listening on PORT: ' + PORT);
});

module.exports = app;
module.exports = connection
