const { Sequelize, DataTypes } = require('sequelize');
require('dotenv').config();
const {
  DB_NAME,
DB_USERNAME,
DB_PASSWORD,
} = process.env;
const sequelize = new Sequelize(DB_NAME, DB_USERNAME, DB_PASSWORD, {
  dialect: 'mysql'
})

const Media = sequelize.define('Media', {
  // Model attributes are defined here
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement : true
  },
  image: {
    type: DataTypes.STRING,
    // allowNull defaults to true
  },
  createdAt : {
    field: 'created_at',
    type : DataTypes.DATE
  },
  updatedAt : {
    field: 'updated_at',
    type : DataTypes.DATE
  },
}, {
  tableName: 'media'
});

module.exports = Media;