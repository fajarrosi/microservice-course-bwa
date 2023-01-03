var express = require('express');
var router = express.Router();
const { APP_NAME } = process.env;
const mycourseHandler = require('./handler/mycourse');
/* GET users listing. */
router.get('/', mycourseHandler.list);
router.post('/',mycourseHandler.create);

module.exports = router;
