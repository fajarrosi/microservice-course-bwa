var express = require('express');
var router = express.Router();
const { APP_NAME } = process.env;
const orderHandler = require('./handler/order');
//register
router.get('/',orderHandler.list);

module.exports = router;
