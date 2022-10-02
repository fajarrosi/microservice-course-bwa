var express = require('express');
var router = express.Router();
const refreshHandler = require('./handler/refreshtoken');

router.post('/',refreshHandler.create);
router.get('/',refreshHandler.getToken);


module.exports = router;
