module.exports = (sequelize,DataTypes) => {
  const User = sequelize.define('User', {
    // Model attributes are defined here
    // allowNull defaults to true
    id: {
      type: DataTypes.INTEGER,
      primaryKey: true,
      autoIncrement : true,
      allowNull : false
    },
    name: {
      type: DataTypes.STRING,
      allowNull: false
    },
    email: {
      type: DataTypes.STRING,
      allowNull: false,
      unique:true
    },
    password: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    role: {
      type: DataTypes.ENUM,
      values:['admin','student'],
      allowNull: false,
      defaultValue : 'admin'
    },
    avatar: {
      type: DataTypes.STRING,
    },
    profession: {
      type: DataTypes.STRING,
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
    tableName: 'users',
    timestamps:true
  });

  return User
}