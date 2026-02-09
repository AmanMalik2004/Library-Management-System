# 📚 Library Management System

## 📌 Overview
This project is a database-driven Library Management System designed to manage core library operations digitally.  
It provides structured storage and management of books, members, borrowing records, and overdue fines using a normalized relational database.

The system ensures data consistency, reduces redundancy, and supports efficient library administration.

---

## ⚙️ Technologies
- PHP (server-side logic)
- MySQL (database management)
- SQL (queries, constraints, transactions)

---

## 🧩 Features

### Book Management
- Add new books
- Update book details
- Remove lost or outdated books
- Track book availability

### Member Management
- Register members
- Update member information
- Remove expired memberships

### Borrow & Return System
- Issue books with due dates
- Record returns
- Restrict issuing for members with pending fines

### Fine Management
- Automatic overdue fine calculation
- Fine tracking per member

### Search & Reporting
- Search books by title, author, or category
- View issued and overdue books
- Generate summary reports

---

## 🗄️ Database Design

### Core Entities
- Book
- Member
- Librarian
- Borrow_Record
- Fine
- Category

### Relationships
- Members can borrow multiple books
- Books can be issued multiple times
- Borrow records connect members and books
- Fines are associated with borrow records

### Normalization
Database schema follows:
- First Normal Form (1NF)
- Second Normal Form (2NF)
- Third Normal Form (3NF)
- BCNF where applicable

---

## 🛠️ Implementation
- Tables created with primary and foreign keys
- Constraints enforce data integrity
- SQL operations implemented:
  - INSERT, UPDATE, DELETE
  - JOIN queries
  - Nested queries
  - Aggregate functions
  - Views
- Transactions used for issuing and returning books
- PHP handles database interaction

---

## ▶️ Setup Instructions

### 1. Install Server Environment
Install XAMPP or WAMP.

### 2. Start Services
Start:
- Apache
- MySQL

### 3. Import Database
Import:
into MySQL.

### 4. Run Application
Place project folder in:
Open browser:

---

## http://localhost/DB%20Project/
