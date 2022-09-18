var express = require('express');
var router = express.Router();
const { APP_NAME } = process.env;
const mediaHandler = require('./handler/media');
/* GET users listing. */
router.get('/', mediaHandler.list);

router.post('/',mediaHandler.create);

router.delete('/:id',mediaHandler.destroy);

module.exports = router;
