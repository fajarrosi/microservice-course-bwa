const { User } = require('../../../models');
const bcrypt = require('bcrypt');
const Validator = require("fastest-validator");
const v = new Validator();

module.exports = async (req,res) => {
  const schema = {
    name:'string',
    email:'email',
    password:'string|min:6',
    profession:'string|optional',
    avatar:'string|optional',
  }
  const validate = v.validate(req.body,schema);

  if(validate.length){
    return res.status(400).json({
      status:'error',
      message:validate
    })
  }

  const user = await User.findOne({
    where:{ email: req.body.email }
  })

  if(user){
    return res.status(409).json({ //status 409 itu karena user conflict /sudah ada
      status:'error',
      message:'email already exist'
    })
  }

  const password = await bcrypt.hash(req.body.password,10) ;

  const data = {
    name : req.body.name,
    email : req.body.email,
    password : password,
    role : 'student',
    avatar : req.body.avatar,
    profession : req.body.profession,
  }

  const createUser = await User.create(data);

  return res.json({
    status:'success',
    id:createUser.id
  })
  
}