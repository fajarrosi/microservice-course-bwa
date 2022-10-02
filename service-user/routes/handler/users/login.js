const { User } = require('../../../models');
const bcrypt = require('bcrypt');
const Validator = require("fastest-validator");
const v = new Validator();

module.exports = async (req,res) =>  {
  const schema = {
    email:'email',
    password:'string|min:6',
  }

  const validate = v.validate(req.body,schema);

  if(validate.length){
    return res.status(400).json({
      status:'error',
      message:validate
    })
  }

  const dataUser = await User.findOne({
    where: { email :req.body.email }
  });

  if(!dataUser){
    return res.status(404).json({
      status:'error',
      message:'User not found'
    })
  }

  const isValidPassword = await bcrypt.compare(req.body.password,dataUser.password);
  if(!isValidPassword){
    return res.status(404).json({
      status:'error',
      message:'User not found'
    })
  }
  const object = (({ password, ...o }) => o)(dataUser.dataValues); //menghilangkan password di object
  const {
    id,
    name,
    email,
    role,
    avatar,
    profession
  } = dataUser.dataValues; //cara lain untuk mendapatkan data tanpa property password
  return res.json({
    status:'success',
    data : {
      ...object
    }
  })
}