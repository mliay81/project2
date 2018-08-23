var express = require("express");

var exphbs = require("express-handlebars");



var app = express();
var PORT = process.env.PORT || 3000;

// Middleware

app.use(express.static("public"));

// Handlebars
app.engine(
  "handlebars",
  exphbs({
    defaultLayout: "main"
  })
);
app.set("view engine", "handlebars");

// // Routes
require("./routes/htmlRoutes")(app);

app.listen(PORT, function() {
    // Log (server-side) when our server has started
    console.log("Server listening on: http://localhost:" + PORT);



});
module.exports = app;
