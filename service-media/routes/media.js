const express = require('express');
const router = express.Router();
const isBase64 = require('is-base64');
const base64Img = require('base64-img');
/* GET users listing. */
router.post('/', function(req, res, next) {
  const image = req.body.image;
  if(!isBase64(image,{mimeRequired: true})){
    return res.status(400).json(
      {status:'error',message:'invalid base64 image'}
    )
  }
});

module.exports = router;
