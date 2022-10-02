const { User } = require('../../../models');

module.exports = async (req,res) =>{
  const userIds = req.query.user_ids || []
  const email = req.query.email
  const name = req.query.name
  const sqlOptions = {
    attributes: ['id','name','email','role','avatar','profession']
  }
  if(userIds.length){
    sqlOptions.where = {
      id: userIds
    }
  }
  if(email){
    sqlOptions.where = {
      email
    }
  }
  if(name){
    sqlOptions.where = {
      name
    }
  }

  const user = await User.findAll(sqlOptions);

  return res.json({
    status:'success',
    data:user
  })
}