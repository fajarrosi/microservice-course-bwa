const create = require('./create');
const list = require('./list');
const detail = require('./detail');
const update = require('./update');
const destroy = require('./delete');
module.exports = {
  list,
  create,
  destroy,
  detail,
  update
};