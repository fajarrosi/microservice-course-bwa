const axios = require('axios');
const { TIMEOUT } = process.env;
module.exports = (baseURL) => {
  return axios.create({
    baseURL: baseURL,
    timeout: parseInt(TIMEOUT) //karena hasil dari env berupa string jadi harus di parse dulu ke int
  })
}