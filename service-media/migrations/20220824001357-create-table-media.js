'use strict';

module.exports = {
  async up (queryInterface, Sequelize) {
    /**
     * Add altering commands here.
     *
     * Example:
     * await queryInterface.createTable('users', { id: Sequelize.INTEGER });
     */
    await queryInterface.createTable('media', { 
      id: {
        type: Sequelize.DataTypes.INTEGER,
        allowNull : false,
        autoIncrement : true,
        primaryKey : true
      },
      image: {
        type: Sequelize.DataTypes.STRING,
        allowNull : false
      },
      created_at : {
        type: Sequelize.DataTypes.DATE,
        allowNull : false
      },
      updated_at : {
        type: Sequelize.DataTypes.DATE,
        allowNull : false
      }
    });
  },

  async down (queryInterface, Sequelize) {
    /**
     * Add reverting commands here.
     *
     * Example:
     * await queryInterface.dropTable('users');
     */
    await queryInterface.dropTable('media');
  }
};
