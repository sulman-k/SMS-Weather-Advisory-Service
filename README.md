# Bulk Unsub Portal

## Introduction
This README file will guide you on how to set up and run your PHP project on a local WAMP/XAMPP server with MySQL. 

## Prerequisites

Before you can run this project on your local machine, you'll need to install the following:

```
WAMP/XAMPP server
MySQL
PHP
```

## Installation

1. Clone or download the project files onto your computer.
2. Copy the project folder into the www folder in your WAMP/XAMPP installation directory. If you're using WAMP, the directory is usually located at C:\wamp64\www\. For XAMPP, it's usually located at C:\xampp\htdocs\.
3. Open your web browser and type localhost in the address bar. If your WAMP/XAMPP server is running properly, you should see the WAMP/XAMPP homepage.
4. Navigate to phpmyadmin by clicking on the corresponding link on the WAMP/XAMPP homepage. This will open up the  MySQL database management interface in your web browser.
5. Click on the New button in the left sidebar to create a new database.
6. Give your database a name and click on the Create button to create it.
7. Click on the new database name in the left sidebar to open it.
8. Click on the Import tab in the top navigation bar.
9. Click on the Choose File button and select the .sql file that came with your project. This file should contain the database schema and any necessary data.
10. Click on the Go button to import the database.

## Configuration

1. Open the project folder and look for a file called **in_dbConnection.php**. This file should contain database connection information, such as the database name, username, and password.
2. Edit the database connection information in the **in_dbConnection.php** file to match your local MySQL server configuration.
3. Save the **in_dbConnection.php** file.

## Running the Project

1. Open your web browser and type localhost/your_project_folder_name in the address bar. Replace your_project_folder_name with the name of the project folder you copied into the **www** folder earlier.
2. The project should now be running in your web browser.

