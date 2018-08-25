var Sequelize = require("sequelize");

var sequelize = require("../config/connection.js");

var Drink = sequelize.define("drink", {
    name: Sequelize.STRING,
    ingredients: Sequelize.STRING,
    recipe: Sequelize.INTEGER
});

Drink.sync();

module.exports = Drink;