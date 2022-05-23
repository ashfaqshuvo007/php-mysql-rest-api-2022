## PARim Home Task

A simple api task for PARim Solutions using PHP 7+, MySQL 8


## :triangular_flag_on_post: Table of Contents

- [Installation](#installation)
- [Usage](#usage)
- [Testing](#testing)
- [Note](#note)
- [Author](#author)
- [License](#license)

## Installation :computer:
Follow these steps:

### 1. Clone the project 

```bash
git clone git@github.com:ashfaqshuvo007/php-mysql-rest-api-2022.git
```
### 2. DB Setup (MySQL) 
- login to MySQL
Open your terminal and type the following command
```bash
mysql -u root -p
```
Enter your **password** when prompted.

- Create a new Database. Replace **dbname** with your database name.
```bash
CREATE DATABASE dbname;
```
- Create a new User
```bash
CREATE USER 'username' IDENTIFIED BY 'password';
```
- Grant all privileges to the user for the new database
```bash
GRANT ALL PRIVILEGES on DATABASE dbname to username;
```
- Create tables with following schema. The schema is given in **schema.sql** file. 

```bash
CREATE TABLE IF NOT EXISTS `Users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NULL,
  `email` varchar(50) UNIQUE NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8;
```

```bash
CREATE TABLE IF NOT EXISTS `Events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8;
```

```bash
CREATE TABLE IF NOT EXISTS `Departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8;
```
```bash
CREATE TABLE IF NOT EXISTS `Locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8;
```


```bash
CREATE TABLE IF NOT EXISTS `Areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8;
```

```bash
CREATE TABLE IF NOT EXISTS `shifts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(256) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `location_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NULL,
  `rate` float(4,2) NULL,
  `charge` float(4,2) NULL,
  `area_id` int(11) NOT NULL,
  `department_ids` text NOT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8;

```
### 2.Run server

- Run this command inside the prject root
```bash
php -S 127.0.0.1:8000 
```
This will run server on **http://127.0.0.1:8000**
## Folder Structure

```
📦api
 ┣ 📜create.php
 ┣ 📜delete.php
 ┣ 📜PostHeader.php
 ┗ 📜read.php
```



### For Person package

You can look at [Person Folder](src/main/java/com/moderan/hometask/person/)


## API routes 
I have used thunder client of Vscode but you use your browser or POSTMAN to test the endpoints.


**Authentication**

For authentication, we have used a Basic Auth (username & password): ```localhost:8888/auth``` return a user json object with details. You are authenticated.

- Auth route setup

![Auth Setup](/DemoImages/authRoute.PNG)

- Response

![Response](DemoImages/authResponse.PNG) 


**We have two main routes**:

1. To save a Person ```"/person"``` **POST METHOD** permitted only to users with role **ADMIN**

- POST url and input body. It takes a json in the following format

![Route url and input](DemoImages/postRoute.PNG)

- Response: returns a new created Person Object with timestamp and id.

![response](DemoImages/postResponse.PNG)


2. To retrieve list of records matching a search string a Person ```"/person?search=John"``` GET METHOD permitted to ALL
Let's say we want to retrieve all rows of data with 'John' in any column. We put a query parameter 'search' and its value as 'John'

- GET url and input body. It takes a json in the following format

![Search url and input](DemoImages/searchRoute.PNG)

- Response: returns a json list of all the records with 'John' 

![Response](DemoImages/searchResponse.PNG)

## Testing 

I implemented a simple test which you can find [here](src/test/java/com/moderan/hometask/HometaskApplicationTests.java)

## Improvements:
- I would have loved to have more tests(Unit and integration test with Mockito)
- Error Handling can be much better with custom Error handlers 
- Implementing CORS for the endpoints

## Author

**Ashfaq Hussain Ahmed**
- [LinkedIn](https://www.linkedin.com/in/ashfaqhahmed/)

## License
[MIT](https://choosealicense.com/licenses/mit/)