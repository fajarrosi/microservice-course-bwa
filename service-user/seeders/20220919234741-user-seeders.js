'use strict';
const bcrypt = require('bcrypt');

module.exports = {
  async up (queryInterface, Sequelize) {
    let user = [];
    for (let index = 0; index < 10; index++) {
      user.push(
        {
          name: `John Doe ke- ${index}`,
          profession: 'Admin ',
          email: `adminke${index}@gmail.com`,
          role: 'admin',
          password: await bcrypt.hash('password',10),
          created_at: new Date(),
          updated_at: new Date(),
        }
      )
    }
    await queryInterface.bulkInsert('Users', user, {});
  },

  async down (queryInterface, Sequelize) {
    await queryInterface.bulkDelete('users', null, {});
  }
};
