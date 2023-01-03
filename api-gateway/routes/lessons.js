var express = require('express');
var router = express.Router();
const { APP_NAME } = process.env;
const lessonHandler = require('./handler/lesson');
/* GET users listing. */
router.get('/', lessonHandler.list);
router.get('/:id', lessonHandler.detail);

router.post('/',lessonHandler.create);
router.put('/:id',lessonHandler.update);

router.delete('/:id',lessonHandler.destroy);

module.exports = router;
