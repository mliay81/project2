var express = require('express');
var bodyParser = require('body-parser');
// var exphbs = require('express-handlebars');
var mysql = require('mysql');

var app = express();
app.use(bodyParser.urlencoded({
    extended: false
}))

app.engine('handlebars', exphbs({defaultLayout: 'main'}));
app.use(express.static('public'));
app.set('view engine', 'handlebars');

var connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: 'root',
    database: 'cheers_db',
});

connection.connect(function(err){
    if(err) throw err;
    console.log('Connected as id: '+connection.threadId);
})

app.get('/', function(req, res){
   connection.query('SELECT * FROM cheers_db', function(err, data){
       res.render('index',{cheersdb:data});
   }) 
});

app.post('create', function(req, res){
    connection.query('INSERT INTO cheers_db VALUES (?)', [req.body.cheersdb], function(err,result) {
        if(err)throw err;
        res.redirect('/');
    })
})

app.put('/update', function(req, res){
    connection.query('UPDATE cheers_db SET = ? WHERE id = ?; ' [req.body.cheersdb, req.body.id], function(err, results) {
        if(err) throw err;
        res.redirect('/');
    })
})
b
app.get('/delete', function(req, res){
    connection.query('DELETE FROM cheers_db WHERE id = ?;', [req.body.id], function(err,results){
        if(err)throw err;
        res.redirect('/');
    })
})