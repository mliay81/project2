var orm = require('../config/orm.js')

var cocktail = {
  findAll: function (cb) {
    orm.all('cheers', function (res) {
      console.log('In All ORM : ' + res)
      cb(res)
    })
  },
  create: function (dbObj, cb) {
    console.log(dbObj.name)
    console.log('In Create ORM : ' + JSON.stringify(dbObj))
    var vals = [
      dbObj.name, dbObj.ingredients, dbObj.recipe
    ]
    var cols = [
      'name', 'ingredients', 'recipe'
    ]
    orm.create('cheers', cols, vals, function (res) {
      cb(res)
    })
  }
}
module.exports = cocktail
