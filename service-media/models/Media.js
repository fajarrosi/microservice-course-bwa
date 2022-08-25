module.exports = (sequelize,DataTypes) => {
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

  return Media
}