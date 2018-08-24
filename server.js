var express = require('express');
var bodyParser = require('body-parser');
var mysql = require('mysql');
var path = requeire('path');

var app = express();
var PORT = process.env.PORT || 3000;

// Middleware
app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());
app.use(express.static("public"));

// Routes
require("./routes/api.routes")(app);
require("./routes/htmlRoutes")(app);


app.listen(PORT, function(){
  console.log('App listening on PORT: ' + PORT);
});

module.exports = app;
