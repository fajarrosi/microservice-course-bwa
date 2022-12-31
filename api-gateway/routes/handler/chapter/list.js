const apiAdapter = require('../../apiAdapter');
const custompage = require('../customPage');

const {
  URL_SERVICE_COURSE,
  HOSTNAME
} = process.env;

const api = apiAdapter(URL_SERVICE_COURSE);
module.exports = async (req,res) => {
  try {
    const chapters = await api.get('/api/chapters',{
      params:{
        ...req.query
      }
    });
    const chapterData = custompage('chapters',chapters.data);
    return res.json(chapterData);
  } catch (error) {
    if(error.code === 'ECONNREFUSED'){
      return res.status(500).json({status:'error',message:'service unavailable'})
    }
    const { status,data } = error.response;
    return res.status(status).json(data);
  }
}