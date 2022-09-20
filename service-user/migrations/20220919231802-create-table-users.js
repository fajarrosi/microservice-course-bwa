'use strict';

module.exports = {
  async up (queryInterface, Sequelize) {
    await queryInterface.createTable('users', { 
      id: {
        type: Sequelize.INTEGER,
        allowNull : false,
        autoIncrement : true,
        primaryKey : true
      },
      name: {
        type: Sequelize.STRING,
        allowNull : false
      },
      profession: {
        type: Sequelize.STRING,
        allowNull : true
      },
      avatar: {
        type: Sequelize.STRING,
        allowNull : true
      },
      email: {
        type: Sequelize.STRING,
        allowNull : false
      },
      password: {
        type: Sequelize.STRING,
        allowNull : false
      },
      role: {
        type: Sequelize.ENUM,
        allowNull : false,
        values:['admin','student'],
      },
      created_at : {
        type: Sequelize.DATE,
        allowNull : false
      },
      updated_at : {
        type: Sequelize.DATE,
        allowNull : false
      }
    });

    await queryInterface.addConstraint('users',{
      type:'unique',
      name:'UNIQUE_USERS_EMAIL',
      fields:['email']
    });
  },

  async down (queryInterface, Sequelize) {
    await queryInterface.dropTable('users');
  }
};
