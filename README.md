# 📊 Stock Transaction Website

Stock Transaction Website is a web-based application that allows users to create virtual warehouses, manage vehicles and products, and simulate basic stock operations. 
The project was developed collaboratively by two developers: the frontend was implemented by **Atacan Cantürk**, and the backend was developed by **Ömür Efe Güçlü**.

---

## 🛠️ Technologies Used

### 🔹 Frontend (Developer: [Atacan Cantürk](https://github.com/atacancanturk))
- HTML5
- CSS3
- [Bootstrap 5](https://getbootstrap.com/)
- JavaScript (for minor interactions)

### 🔹 Backend (Developer: [Ömür Efe Güçlü](https://github.com/omurefeguclu))
- PHP (for business logic and database handling)
- XML (for data storage and structured data management)

---

## ✨ Features

- 👤 User registration and login system
- 🏢 Virtual warehouse creation
- 🚛 Virtual vehicle addition and listing
- 📦 Product stocking and shipping system
- 🗃️ XML-based data structure
- ⚙️ Database structure and logic using PHP

---

## 📦 Installation

### Requirements

- A web server (e.g., [XAMPP](https://www.apachefriends.org/index.html), [WAMP](https://www.wampserver.com/))
- PHP 7.x or higher
- Git (optional but recommended)

### Setup Instructions

1. Clone the repository:
```bash
git clone https://github.com/omurefeguclu/seng216-proje
```

```bash
git clone https://github.com/atacancanturk/StockTransactionWebsite
```

2. Move the cloned project to your web server's root directory (e.g., `htdocs` for XAMPP):
```bash
mv StockTransactionWebsite /xampp/htdocs/
```

3. Open your browser and navigate to:
```
http://localhost/StockTransactionWebsite
```

> ⚠️ **Note:** If the project contains configuration files (e.g., `config.php`), make sure to update paths, database connections, or XML file locations accordingly.

---

## 📁 Project Structure

```
StockTransactionWebsite/
├── .idea/                         # IDE configuration files (e.g., PhpStorm)
├── core/                          # Core application logic and utilities
├── db/
│   └── DbModel/                   # Database models and related classes
├── features/                      # Feature-specific modules or components
├── generated-conf/                # Auto-generated configuration files
├── generated-migrations/          # Auto-generated database migration scripts
├── generated-sql/                 # Auto-generated SQL files
├── modules/                       # Modular components of the application
├── public/                        # Publicly accessible files (e.g., index.php, assets)
├── .gitignore                     # Specifies intentionally untracked files to ignore
├── README.md                      # Project documentation and overview
├── composer.json                  # PHP dependencies and autoloading configuration
├── propel.yml                     # Propel ORM configuration file
├── propel.yml.dist                # Distribution version of Propel configuration
└── schema.xml                     # XML schema definition for the database

```

---

## 👥 Developers

| Name              | Role               | GitHub Profile                                      |
|-------------------|--------------------|-----------------------------------------------------|
| **Atacan Cantürk**| Frontend Developer | [@atacancanturk](https://github.com/atacancanturk) |
| **Ömür Efe Güçlü**| Backend Developer  | [@omurefeguclu](https://github.com/omurefeguclu)   |

---

## 🔗 Source Code Repositories

- Frontend: [https://github.com/atacancanturk/StockTransactionWebsite](https://github.com/atacancanturk/StockTransactionWebsite)
- Backend: [https://github.com/omurefeguclu/seng216-proje](https://github.com/omurefeguclu/seng216-proje)

---

## 📜 License

This project is open-source and currently does not include a specific license. You are free to explore and contribute.
