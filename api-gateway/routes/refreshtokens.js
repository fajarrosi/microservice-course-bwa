var express = require('express');
var router = express.Router();
const { APP_NAME } = process.env;
const refreshHandler = require('./handler/refreshTokens');
//register
router.post('/',refreshHandler.refreshToken);

module.exports = router;
