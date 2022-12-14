const apiAdapter = require('../../apiAdapter');
const custompage = require('../customPage');

const {
  URL_SERVICE_COURSE
} = process.env;

const api = apiAdapter(URL_SERVICE_COURSE);
module.exports = async (req,res) => {
  try {
    const mentors = await api.get('/api/mentors');
    const mentorData = custompage('mentors',mentors.data);
    return res.json(mentorData);
  } catch (error) {
    if(error.code === 'ECONNREFUSED'){
      return res.status(500).json({status:'error',message:'service unavailable'})
    }
    const { status,data } = error.response;
    return res.status(status).json(data);
  }
}