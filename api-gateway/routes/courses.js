const express = require('express');
const router = express.Router();
const { APP_NAME } = process.env;
const axios = require('./apiAdapter');
const courseHandler = require('./handler/course');
const verifyToken = require('../middlewares/verifyToken');
router.get('/', courseHandler.list);
router.get('/:id', courseHandler.detail);

router.post('/',verifyToken,courseHandler.create);
router.put('/:id',verifyToken,courseHandler.update);

router.delete('/:id',verifyToken,courseHandler.destroy);

module.exports = router;
