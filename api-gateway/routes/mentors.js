var express = require('express');
var router = express.Router();
const { APP_NAME } = process.env;
const mentorHandler = require('./handler/mentor');
/* GET users listing. */
router.get('/', mentorHandler.list);
router.get('/:id', mentorHandler.detail);

router.post('/',mentorHandler.create);
router.put('/:id',mentorHandler.update);

router.delete('/:id',mentorHandler.destroy);

module.exports = router;
