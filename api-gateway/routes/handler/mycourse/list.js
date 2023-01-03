const apiAdapter = require('../../apiAdapter');
const custompage = require('../customPage');

const {
  URL_SERVICE_COURSE,
  HOSTNAME
} = process.env;

const api = apiAdapter(URL_SERVICE_COURSE);
module.exports = async (req,res) => {
  try {
    const userId = req.user.id
    const lessons = await api.get('/api/my-course',{
      params:{
        user_id:userId
      }
    });
    const lessonData = custompage('my-course',lessons.data);
    return res.json(lessonData);
  } catch (error) {
    if(error.code === 'ECONNREFUSED'){
      return res.status(500).json({status:'error',message:'service unavailable'})
    }
    const { status,data } = error.response;
    return res.status(status).json(data);
  }
}