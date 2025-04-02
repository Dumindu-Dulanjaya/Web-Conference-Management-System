#Conference Management System

How to Set Up and Run the Application

  1.Requirements: Install WampServer. Ensure MySQL and PHP are configured correctly. Place the project folder (conference) in the www directory of WampServer.

  2.Database Setup: Open phpMyAdmin (usually accessible via http://localhost/phpmyadmin). Log in with the username: root (no password by default). Create a database named conf. Import the provided SQL file (conf.sql) to set up the necessary tables (participants, tracks, sessions, attendance).

  3.Running the Application: Start WampServer and ensure all services ( MySQL) are running. Access the application via your browser at http://localhost/conference/home.php.

##Features Implemented

##Home Page:

Displays conference details, including date, location, and guest speakers.
![Image](https://github.com/user-attachments/assets/28412880-bd81-49a6-a3a0-d979cb957999)

##Schedule Page:

Lists conference topics and tracks with detailed information. Includes a filter to find specific tracks.
![Image](https://github.com/user-attachments/assets/b69f6eb2-02db-4763-b56c-58f1c2478c49)

##RegistrationPage:

Allows participants to register by submitting their details. Data is stored in the participants table in the database.
![Image](https://github.com/user-attachments/assets/09dfa06a-3b8f-47f6-bfe1-562b609d27ea)

#Login Page:

Authenticates users based on email and password. Admin users can access the admin dashboard.



