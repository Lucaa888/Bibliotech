DROP TABLE IF EXISTS loans;
DROP TABLE IF EXISTS books;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  full_name VARCHAR(100) NOT NULL,
  role ENUM('student','librarian') NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE books (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(150) NOT NULL,
  author VARCHAR(100) NOT NULL,
  isbn VARCHAR(20) NULL,
  pub_year INT NULL,
  total_copies INT NOT NULL,
  available_copies INT NOT NULL,
  description TEXT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CHECK (total_copies >= 0),
  CHECK (available_copies >= 0),
  CHECK (available_copies <= total_copies)
);

CREATE TABLE loans (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  book_id INT NOT NULL,
  loan_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  return_date DATETIME NULL,
  CONSTRAINT fk_loans_user FOREIGN KEY (user_id) REFERENCES users(id),
  CONSTRAINT fk_loans_book FOREIGN KEY (book_id) REFERENCES books(id),
  INDEX idx_loans_active (return_date),
  INDEX idx_loans_user (user_id),
  INDEX idx_loans_book (book_id)
);

INSERT INTO users (username, full_name, role, password_hash) VALUES
('studente1', 'Giovanni Bianchi', 'student',   '$2b$10$KlHP3m9q0g8yBn6j8sUCsOAKSD7z4XLqJ/Yqh62jHwphYPaW/wyKW'),
('studente2', 'Laura Rossi', 'student','$2b$10$62gP9ZPCLrgi71aRX71KB.sH2MXYNCBokiPWf.DIbd9QG9tAEBQ5O'),
('studente3', 'Francesco Verdi', 'student',    '$2b$10$sTVJ7sNm3Pz3jH/lzhlSMu6BWJfZECvSskI3XyAD8XEFcMIABTcnu'),
('biblio',    'Mariella Bibliotecaria', 'librarian','$2b$10$R3csnjXSj51BvOUFZv.jdeWI3npABO4HIMDuuGbzzzpT0DnzKl8oi');

INSERT INTO books (title, author, isbn, pub_year, total_copies, available_copies, description) VALUES
('1984', 'George Orwell', '9780451524935', 1949, 10, 10, 'Distopia classica.'),
('Il signore degli anelli', 'J.R.R. Tolkien', '9780261102385', 1954, 6, 6, 'Fantasy epico.'),
('I promessi sposi', 'Alessandro Manzoni', '9788807900331', 1827, 8, 8, 'Romanzo storico.'),
('Harry Potter e la pietra filosofale', 'J.K. Rowling', '9780747532699', 1997, 12, 12, 'Fantasy per ragazzi.'),
('Il piccolo principe', 'Antoine de Saint-Exupéry', '9780156013987', 1943, 5, 5, 'Favola filosofica.');

INSERT INTO loans (user_id, book_id, loan_date, return_date)
VALUES (1, 1, NOW(), NULL);

UPDATE books
SET available_copies = available_copies - 1
WHERE id = 1;