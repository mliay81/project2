
module.exports = function (app) {
  // Load index page
  app.get('/', function (req, res) {
    res.render('index', {
      msg: 'Welcome!',
      bgImage: '/images/cocktail-bg.png'

    })
  })
  // loading the search web page

  app.get('/search', function (req, res) {
    res.render('search', {
      msg: 'search!',
      bgImage: '/images/cocktail-bg.png'

    })
  })

  // loading the create web page

  app.get('/create', function (req, res) {
    res.render('create', {
      msg: 'create!',
      bgImage: '/images/cocktail-bg.png'

    })
  })

  // Render 404 page for any unmatched routes
  app.get('*', function (req, res) {
    res.render('404')
  })
}
