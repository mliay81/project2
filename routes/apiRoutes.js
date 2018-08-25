var Drink = require("..models/drink.js");

module.exports = function(app) {
  app.get("/api/all", function(req, res) {
    Drink.findAll({}).then(function(results) {
      res.json(results);
    });
  });

  app.get("/api/:drink", function(req, res) {
    Drink.findAll({
      where: {
       name: req.params.drink 
      }
    }).then(function(results) {
      res.json(results);
    });
  });

  app.get("/api/ingredients/:ingredients", function(req, res) {
    Drink.findAll({
      where: {
        ingredients: req.params.ingredients
      }
    }).then(function(results) {
      res.json(results);
    });
  });

  // app.get("/api/recipe/:recipe", function(req, res) {
  //   Drink.findAll({
  //     where: {
  //       recipe: req.params.recipe
  //     }
  //   }).then(function(results) {
  //     res.json(results);
  //   });
  // });
};