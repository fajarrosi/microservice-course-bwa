const express = require('express');
const router = express.Router();
const { APP_NAME } = process.env;
const axios = require('./apiAdapter');


/* GET users listing. */
router.get('/', function(req, res, next) {
  res.send(`respons with app name => ${APP_NAME}`);
});

module.exports = router;
