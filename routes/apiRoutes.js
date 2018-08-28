var db = require('../models/cocktail.js')

module.exports = function (app) {
  // Get all examples
  app.get('/api/cocktail', function (req, res) {
    db.findAll(function (resObj) {
      console.log(resObj)
      res.json(resObj)
    })
  })

  // Create a new example
  app.post('/api/cocktail', function (req, res) {
    db.create(req.body, function (response) {
      console.log(response)
      res.redirect('/index')
    })
  })
}

module.exports = function(app) {

app.get('/api', function(req, res) {
  connection.query('SELECT * FROM cheers_db;', function(err, data) {
    res.render('/');
  })
})

// Create a new Coctail
app.post('/api/create', function(req, res) {
  connection.query('INSERT INTO cheers_db VALUES (?)', function(err, result) {
    if(err)throw err;
    res.redirect('/')
  });
})

// Delete a Coctail
app.delete('/delete', function(req, res) {
  connection.query("DELETE FROM cheers_db WHERE id = ?", function(err, result) {
   if(err)throw err;
   res.redirect('/');

  });
})
  
};

