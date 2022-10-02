const { User } = require('../../../models');
const bcrypt = require('bcrypt');
const Validator = require("fastest-validator");
const v = new Validator();

module.exports = async (req,res) => {
  const schema = {
    name:'string',
    email:'email',
    password:'string|min:6|optional',
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

  const id = req.params.id;
  const user = await User.findByPk(id);
  if(!user){
    return res.status(404).json({
      status:'error',
      message:'User not found'
    })
  }

  const email = req.body.email;
  if(email){
    const checkEmail = await User.findOne({
      where : { email }
    })

    if(checkEmail && email !== user.email) {
      return res.status(409).json({
        status:'error',
        message:'email already exist'
      })
    }
  }

  if(req.body.password){
    const password = await bcrypt.hash(req.body.password,10);
    const dataUpdate = (({ password, ...o }) => o)(req.body); //menghilangkan password  dari req.body
    await user.update({
      password,
      ...dataUpdate
    })
  }else {
    await user.update({
      ...req.body
    })
  }
  const object = (({ password, ...o }) => o)(user.dataValues);
  return res.json({
    status:'success',
    data:{
      ...object
    }
  })
}