/**
 * @type { Object.<string, import("knex").Knex.Config> }
 */
module.exports = {

  development: {
    client: 'pg',
    connection: {
      host: 'localhost',
      port: 5432,
      database: 'camuad',
      user: 'postgres',
      password: '1234'
    },
    migrations: {
      directory: './database/migrations'
    }
  }

};