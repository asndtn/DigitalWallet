# Digital Wallet

A backend-oriented personal finance web application developed as an academic course project, designed for managing user accounts, multi-currency wallets, categories, and transaction inputs.

## Tech Stack

* **Framework:** Symfony 4.4 LTS
* **Language:** PHP >=7.4
* **Database & ORM:** Doctrine ORM, Doctrine Migrations
* **Templating:** Twig
* **Code Quality & QA:** PHP CS Fixer, PHP_CodeSniffer, Psalm (Static Analysis)
* **Testing:** PHPUnit

## Core Features & Modules

* **User Management & Security (`UserController`, `SecurityController`):** User accounts, authentication workflows, and access control.
* **Wallets & Balances (`WalletController`, `BalanceController`):** Core financial tracking modules for managing wallet states and balances.
* **Categories, Tags & Types (`CategoryController`, `TagController`, `TypeController`):** Flexible system for classifying, organizing, and filtering financial entries (including many-to-many transaction tagging).
* **Currencies (`CurrencyController`):** Multi-currency support and code configuration.
* **Inputs & Transactions (`InputController`):** Managing specific financial entries, amounts, dates, and descriptions.

## Database Architecture

The application relies on a relational database structured via Doctrine migrations, featuring:
* **`users`:** User accounts with JSON roles and encoded passwords.
* **`wallets`:** Financial accounts linked to owners, types, and currencies.
* **`balances`:** Real-time state tracking per wallet.
* **`inputs`:** Transaction records tied to wallets and categories with dates and amounts.
* **`tags` & `inputs_tags`:** Flexible transaction tagging mechanism.
* **`currencies`, `categories`, `types`:** Dictionary lookup tables.

## Local Setup & Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/asndtn/DigitalWallet.git
2. Navigate to the application directory:
    ```bash
    cd DigitalWallet/app
3. Install PHP dependencies:
    ```bash
    composer install
4. Configure database credentials in your local environment file.

5. Run database migrations:
    ```bash
    php bin/console doctrine:migrations:migrate
6. (Optional) Load sample data fixtures:
    ```bash
    php bin/console doctrine:fixtures:load
7. Run the local development server:
    ```bash
    php -S localhost:8000 -t public