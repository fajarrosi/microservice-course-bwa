var express = require('express');
var router = express.Router();
const { APP_NAME } = process.env;
const webhookHandler = require('./handler/webhook');
/* GET users listing. */
router.post('/',webhookHandler.create);

module.exports = router;
