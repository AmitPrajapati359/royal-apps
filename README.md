# Royal App Project

## Requirements

### Backend:
- **Laravel**: 8.75
- **PHP**: 7.3 (minimum) - 8.1 (maximum)

### Frontend:
- **Laravel Mix**: 6
- **Node.js**: 14.x or 16.x
- **npm**: 6.14

---

## Installation Guide

### 1. Clone the Repository
```sh
git clone https://github.com/AmitPrajapati359/royal-apps.git
cd royal-apps
```

### 2. Install Dependencies
```sh
composer install
```

### 3. Setup Environment File
Copy the example environment file and configure necessary settings:
```sh
cp .env.example .env
```

Make sure to update the **API Base URL** in the `.env` file:
```
CANDIDATE_API_BASE_URL="https://candidate-testing.com/api/v2"
```

### 4. Generate Application Key
```sh
php artisan key:generate
```

### 5. Install Node Modules
```sh
npm install
```

### 6. Compile Assets
```sh
npm run dev
```

### 7. Run the Project
```sh
php artisan serve
```

The project will now be available at `http://127.0.0.1:8000`.

---

## Authentication
Pre-configured login credentials are already set up. Use them to access the system.

---

## Author Creation Command
To create an author, run the following command:
```sh
php artisan author:create
```
This command will prompt you to enter the following details:

1. **First Name** (e.g., John)
2. **Last Name** (e.g., Doe)
3. **Gender** (Options: Male, Female, Other)
4. **Biography** (Short description)
5. **Place of Birth** (e.g., "New York, USA")
6. **User Access Token** (Required for API authentication)

> **Note:** The User Access Token must be generated from the Swagger API tool and entered manually.

---

## Additional Notes
- Ensure that your system meets the PHP and Node.js version requirements.
---
