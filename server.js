var express = require('express');
var bodyParser = require('body-parser');
var mysql = require('mysql');
var path = require('path');
var exphbs = require("express-handlebars");

var app = express();
var PORT = process.env.PORT || 3000;

var connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: 'root',
  database: 'cheers_db',
});

// Handlebars
app.engine(
  "handlebars",
  exphbs({
    defaultLayout: "main"
  })
);
app.set("view engine", "handlebars");


connection.connect(function(err){
  if(err)throw err;
  console.log('Connected as id: '+connection.threadId);
});

// Middleware
app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());
app.use(express.static("public"));

// Routes
require("./routes/apiRoutes")(app);
require("./routes/htmlRoutes")(app);


app.listen(PORT, function(){
  console.log('App listening on PORT: ' + PORT);
});

module.exports = app;