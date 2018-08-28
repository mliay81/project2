var db = require("../models/cocktail.js");

module.exports = function(app) {
  // Get all examples
  app.get("/api/cocktail", function(req, res) {
    db.findAll(function(resObj){
      console.log(resObj);
      res.json(resObj);

    });
  });

  // Create a new example
  app.post("/api/cocktail", function(req, res) {

    db.create(req.body, function(response){
      console.log(response);
        res.redirect("/index");
    });
  });

};
