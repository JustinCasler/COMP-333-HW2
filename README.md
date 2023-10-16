# COMP-333-HW2
## **Setting up the development environment:**

XXAMP local MySQL database:
<img width="1406" alt="Screenshot 2023-10-07 at 6 52 43 PM" src="https://github.com/JustinCasler/COMP-333-HW2/assets/97986810/784461db-fdb4-4d54-b164-731defc87659">

We created a database called music_db, with two tables: "users" and "ratings"

**users**:

<img width="801" alt="Screenshot 2023-10-16 at 5 53 53 PM" src="https://github.com/JustinCasler/COMP-333-HW2/assets/97986810/6f381dd4-1f4a-4fb0-93f9-a824bd52aaa3">

*primary key: username*

**ratings**:

<img width="892" alt="Screenshot 2023-10-16 at 5 53 42 PM" src="https://github.com/JustinCasler/COMP-333-HW2/assets/97986810/09565758-f270-4286-9548-c245ae069a9b">

*primary key: id, foreign key: username, id auto-increment*

To set up this project locally. Clone this repo and download xxamp and set up your database according to our specifications. Start the MySql Database and Apache web server from manager-osx which comes with xxamp. Go into the htdocs folder within xxamp directory and drag this projects folder into htdocs. Navigate to localhost/COMP-333-hw2/login.php or whatever the pathname is to the php files withing htdocs. 
## Code breakdown

- login.php: Code responsible for the login page and checking if users exist in the users table
- registration.php: Code responsible for the registration page and creating new users in the users table
- overview.php: Code responsible for showing all the songs and ratings. Displays all entries in the ratings table.
- newrating.php: Code responsible for the page that creates a new rating in the ratings table that gets displayed on overview.php.
- update.php: Code responsible for the page that updates ratings in the ratings table.
- viewrating.php: Code responsible for the page that displays details about any rating shown in overview.php.
- delete.php: Code responsible for the page that deletes ratings from the ratings table.
- includes/dbh.php: Code that establishes a connection with our database that can be called in any php code.

## Deployment
