import mysql from 'mysql'

const connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'bs_notes'
})

connection.connect(err => {
  if (err) {
    console.error('Errore di connessione: ' + err.stack)
    return
  }
  console.log('Connesso come ID ' + connection.threadId)
})

function queryDatabase(sql) {
  return new Promise((resolve, reject) => {
    connection.query(sql, (error, results) => {
      if (error) {
        reject(error)
      } else {
        resolve(results)
      }
    })
  })
}

export default queryDatabase