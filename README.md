## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Github
- Go to on the link url https://github.com/deveBrice/Budget-pro-project 
- Clone my project in the terminal


### Install

- Do composer install
- Take my sql file that content my database in the root of project and show in the header tab import on phpmyadmin 
  

### Server
Run server: php bin/console server:run

# Use crud

- I have not managed to connect as a user or as an admin but the crud works

Sur postman:

Header tab: show of the column key: content-type and value: application/json
Body: In the rolling list in side of "GraphQL" JSON(application/json)

Users

List users
GET :  http://127.0.0.1:8000/api/users

Create users: 
Change the body by putting a json object in it and adding the required fields
POST : http://127.0.0.1:8000/api/users

Update users:
Change the one or serveral fields of the json object
email_of_db: add a email of db
PUT : http://127.0.0.1:8000/api/users/email_of_db

Delete users
DELETE : http://127.0.0.1:8000/api/users/email_of_db
display a message of error but the user is still deleted

Subscription
-In url instead of users show subscription for all endpoint.
-For DELETE and PUT in url instead of the email show a name.

Card
-In url instead of users show subscription for all endpoint.
-For DELETE and PUT in url instead of the email show a name.