const express = require('express');
const router = express.Router();
const { APP_NAME } = process.env;
const axios = require('./apiAdapter');
const courseHandler = require('./handler/course');
const verifyToken = require('../middlewares/verifyToken');
const can = require('../middlewares/permission');
router.get('/', courseHandler.list);
router.get('/:id', courseHandler.detail);

router.post('/',verifyToken,can('admin'),courseHandler.create);
router.put('/:id',verifyToken,can('admin'),courseHandler.update);

router.delete('/:id',verifyToken,can('admin'),courseHandler.destroy);

module.exports = router;
