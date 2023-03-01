module.exports = (...roles) => {
  return (req,res,next) => {
    const role = req.user.role;
    if(!roles.includes(role)){
      return res.status(405).json({
        message: 'You dont have permission'
      })
    }
    return next();
  }
}