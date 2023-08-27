const mysql = require('mysql');
const express = require('express');
const bodyParser = require('body-parser');
const app = express();
const port = 3000; // Change this to your desired port

app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());

// Database connection parameters
const dbConfig = {
  host: 'localhost',
  user: 'root',
  password: 'Harihk@1106',
  database: 'mydb'
};

// Create a database connection pool
const pool = mysql.createPool(dbConfig);

// Route for handling login
app.post('/login', (req, res) => {
  const { username, password } = req.body;

  // Query the database to retrieve user data
  pool.getConnection((err, connection) => {
    if (err) {
      res.status(500).json({ error: 'Database connection failed' });
      return;
    }

    connection.query('SELECT id, username, password FROM users WHERE username = ?', [username], (queryError, results) => {
      connection.release(); // Release the connection back to the pool

      if (queryError) {
        res.status(500).json({ error: 'Database query error' });
        return;
      }

      if (results.length === 1) {
        const hashedPassword = results[0].password;

        // Verify the password
        if (password === hashedPassword) {
          // Redirect to the index page on successful login (replace with your logic)
          res.redirect('/DataHorizon/index.html');
        } else {
          res.redirect(`/DataHorizon/login.html?message=wrong`);
        }
      } else {
        res.redirect(`/DataHorizon/login.html?message=no`);
      }
    });
  });
});

app.listen(port, () => {
  console.log(`Server is running on port ${port}`);
});
