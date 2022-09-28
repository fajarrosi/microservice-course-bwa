var express = require('express');
var router = express.Router();
const usersHandler = require('./handler/users');
/* GET users listing. */
router.get('/', function(req, res, next) {
  res.send('respond with a resource');
});
router.post('/register',usersHandler.register);

module.exports = router;
