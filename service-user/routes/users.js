var express = require('express');
var router = express.Router();
const usersHandler = require('./handler/users');
/* GET users listing. */
router.get('/', usersHandler.list);
router.post('/register',usersHandler.register);
router.post('/login',usersHandler.login);
router.put('/:id',usersHandler.update);
router.get('/:id',usersHandler.detail);

module.exports = router;
