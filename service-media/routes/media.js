const express = require('express');
const router = express.Router();
const isBase64 = require('is-base64');
const base64Img = require('base64-img');
const { Media } = require('../models')
/* GET users listing. */
router.post('/', function(req, res, next) {
  const image = req.body.image;
  if(!isBase64(image,{mimeRequired: true})){
    return res.status(400).json(
      {status:'error',message:'invalid base64 image'}
    )
  }
  /*
    .img(data, destpath, name, callback) 
    {string} data required
    Image base64 data
    {string} destpath required
    Dest path, if the destpath is root, pass empty string
    {string} name required
    The image's filename 
    {function} callback(err, filepath) required
    utk filename image menggunakan date.now
  */
  base64Img.img(image,'./public/images',Date.now(), async (err,filepath) =>{
    if(err){
      return res.status(400).json({
        status: 'error',
        message: err.message
      });
    }

    /*simpan ke database
    * get filename image aja ,hasil dari filepath => ex : ./public/image/1661386825347.jpg
    * maka harus di split dlu biar menghasilkan array , kemudian 
    * untuk mendapatkan array terakhir dengan cara pop () -> return elements it removed /
    * pop untuk meremoved element terakhir array dan bisa juga mendapatkan nilai element terakhir dari array
    */
    const filename = filepath.split("\\").pop()
    const media = await Media.create({
      image : `images/${filename}`
    });

    /* 
    return response sukses dan ada link url untuk bisa akses imagenya
    */

    return res.json({
      id : media.id,
      image : `${req.get('host')}/images/${filename}`
    });
  })

});

module.exports = router;
