# Banking CLI App 

# Objectives
Create a banking app initially run on CLI. Trying to follow OOP in this whole project and also design principals. Implement storage for persisting data.

# Core Parts
- Feature
- Storage
- View

# Implementation

- **Feature**
    - New Feature can be added by extending the `Feature` abstract class and implementing the abstract method.
    - Register the new feature to the app.
    - No need any backtracking for new features.
- **Storage**
    - Easily Migrate to another persistent storage by implementing the `Storage` Interface
- **View**
    - Easily change the view layer by implementing the `View` interface.

# Features
- For Admin
  - View Customers
  - View Transactions By User Email
  - View All Transactions
- For Customer
  - Deposit Money
  - Withdraw Money
  - Transfer Money
  - View Transactions


Every input will go through a validation process.

# Usage
```bash
git clone https://github.com/OmarFaruk-0x01/banking-cli-app

cd banking-cli-app

chmod +x main.php AdminCreator.php

./main.php # Run App

./AdminCreator.php # Admin Register
  
```