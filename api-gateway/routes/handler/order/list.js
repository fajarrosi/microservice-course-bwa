const apiAdapter = require('../../apiAdapter');
const custompage = require('../customPage');

const {
  URL_SERVICE_ORDER_PAYMENT
} = process.env;

const api = apiAdapter(URL_SERVICE_ORDER_PAYMENT);
module.exports = async (req,res) => {
  try {
    const userId = req.user.id
    const orders = await api.get('/api/orders',{
      params:{
        user_id:userId
      }
    });
    const orderData = custompage('orders',orders.data);
    return res.json(orderData);
  } catch (error) {
    if(error.code === 'ECONNREFUSED'){
      return res.status(500).json({status:'error',message:'service unavailable'})
    }
    const { status,data } = error.response;
    return res.status(status).json(data);
  }
}