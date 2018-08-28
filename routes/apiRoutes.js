var db = require("../models");

module.exports = function(app){
  
  app.get('/api/', function(req, res) {
  connection.query('SELECT * FROM cheers_db;', function(err, data) {
    res.render('/');
  })
})

// Create a new Coctail
app.post('/api/', function(req, res) {
  connection.query('INSERT INTO cheers_db VALUES (?)', function(err, result) {
    if(err)throw err;
    res.redirect('/')
  });
})

// Delete a Coctail
app.delete('/api/', function(req, res) {
  connection.query("DELETE FROM cheers_db WHERE id = ?", function(err, result) {
   if(err)throw err;
   res.redirect('/');

  });
})
};

