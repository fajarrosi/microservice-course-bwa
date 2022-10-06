const apiAdapter = require('../../apiAdapter');
const jwt = require('jsonwebtoken');
const {
  URL_SERVICE_USER,
  JWT_SECRET,
  JWT_SECRET_REFRESH_TOKEN,
  JWT_ACCESS_TOKEN_EXPIRED
} = process.env;

const api = apiAdapter(URL_SERVICE_USER);
module.exports = async (req,res) => {
  try {
    const refreshtoken = req.body.refresh_token;
    const email = req.body.email;

    // check terlebih dahulu apakah ada email dan refresh token , jika tidak ada invalid token
    if(!refreshtoken || !email){
      return res.status(400).json({
        status:'error',
        message:'invalid token'
      })
    }

    // cek apakah refresh token tersebut ada di database atau tidak 
    await api.get('refresh_token',{ params : { refresh_token : refreshtoken } });

    // jika ada maka kita verify jwt tokennya 
    jwt.verify(refreshtoken,JWT_SECRET_REFRESH_TOKEN,(err,decoded)=>{
      if(err){
        return res.status(403).json({
          status:'error',
          message:err.message
        });
      }
      //check apakah email yang dimasukkan itu sama dengan email 
      if(email !== decoded.data.email) {
        return res.status(400).json({
          status:'error',
          message:'email is not valid'
        });
      }
      const token = jwt.sign({ data : refreshtoken},JWT_SECRET,{ expiresIn: JWT_ACCESS_TOKEN_EXPIRED });
      return res.json({
        status:'success',
        data:{
          token
        }
      })
    }) 

  } catch (error) {
    if(error.code === 'ECONNREFUSED'){
      return res.status(500).json({status:'error',message:'service unavailable'});
    }
    const { status,data } = error.response;
    return res.status(status).json(data);
  }
}