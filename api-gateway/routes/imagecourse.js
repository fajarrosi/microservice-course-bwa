var express = require('express');
var router = express.Router();
const { APP_NAME } = process.env;
const imagecourseHandler = require('./handler/imagecourse');
/* GET users listing. */
router.post('/',imagecourseHandler.create);
router.delete('/:id',imagecourseHandler.destroy);

module.exports = router;
