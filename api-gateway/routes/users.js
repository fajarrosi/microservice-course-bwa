var express = require('express');
var router = express.Router();
const { APP_NAME } = process.env;
const userHandler = require('./handler/user');
const verifyToken = require('../middlewares/verifyToken');
//register
router.get('/',verifyToken,userHandler.list);
router.get('/detail',verifyToken,userHandler.detail);
router.post('/register',userHandler.register);
router.post('/login',userHandler.login);

router.put('/update',verifyToken,userHandler.update);



module.exports = router;
