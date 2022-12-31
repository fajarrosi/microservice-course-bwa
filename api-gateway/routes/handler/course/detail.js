const apiAdapter = require('../../apiAdapter');

const {
  URL_SERVICE_COURSE
} = process.env;

const api = apiAdapter(URL_SERVICE_COURSE);
module.exports = async (req,res) => {
  try {
    const media = await api.get(`/api/courses/${req.params.id}`);
    return res.json(media.data);
  } catch (error) {
    if(error.code === 'ECONNREFUSED'){
      return res.status(500).json({status:'error',message:'service unavailable'})
    }
    const { status,data } = error.response;
    return res.status(status).json(data);
  }
}