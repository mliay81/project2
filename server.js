var express = require('express');
var bodyParser = require('body-parser');
var path = requeire('path');

var app = express();
var PORT = process.env.PORT || 3000;

app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());

var mysql = require('mysql');

var connection = mysql.createConnection({
  host: 'localhost',
  port: 3000,
  user: 'root',
  password: 'root',
  database: 'cheers_db',
});

connection.connect(function(err){
  if(err)throw err;
  console.log('Connected as id: '+connection.threadId);
}

app.get('/', function(req, res) {
  connection.query('SELECT * FROM cheers_db;', function(err, data) {
    res.render('/');
  })
})

// Create a new Coctail
app.post('/create', function(req, res) {
  connection.query('INSERT INTO cheers_db VALUES (?)', function(err, result) {
    if(err)throw err;
    res.redirect('/')
  });
})

// Update a Coctails
app.put('/update', function(req, res) {
  connection.query("UPDATE cheers_db SET coctail = ? WHERE id = ?", function(err, result) {
  if(err)throw err;
  res.redirect('/');

  });
})

// Delete a Coctail
app.delete('/delete', function(req, res) {
  connection.query("DELETE FROM cheers_db WHERE id = ?", function(err, result) {
   if(err)throw err;
   res.redirect('/');

  });
})


app.listen(PORT, function(){
  console.log('Server listening on: http://localhost:' + PORT)
});
