News Portal
Overview
This is a web-based News Portal designed to deliver the latest news articles to users. The portal provides an intuitive and user-friendly interface for reading and managing news content.
Project URL
http://localhost/newsportal/index.php
Features
•	Dynamic news categories
•	User authentication (Login & Registration)
•	Search functionality
•	Admin panel for content management
•	Responsive design for mobile and desktop
Installation
1.	Clone the repository: 
2.	git clone https://github.com/your-repo/newsportal.git
3.	Navigate to the project folder: 
4.	cd newsportal
5.	Import the database (if applicable): 
o	Open phpMyAdmin
o	Create a database named newsportal
o	Import newsportal.sql
6.	Configure database settings: 
o	Open config.php
o	Update database credentials:
7.	define('DB_SERVER', 'localhost');
8.	define('DB_USERNAME', 'root');
9.	define('DB_PASSWORD', '');
10.	define('DB_DATABASE', 'newsportal');
11.	Start the server: 
12.	php -S localhost:8000
13.	Open the browser and navigate to: 
14.	http://localhost/newsportal/index.php
Screenshots
Homepage

 ![Screenshot (96)](https://github.com/user-attachments/assets/5edd0280-7fd1-4c9d-84cd-8f8e9ad37e31)
 

Admin Dashboard 

 
 ![Screenshot (97)](https://github.com/user-attachments/assets/936585f3-6cfd-4ef3-99c7-8bab95ed7925)
 

Technologies Used
•	PHP
•	MySQL
•	HTML, CSS, JavaScript
•	Bootstrap
License
This project is licensed under the MIT License.
________________________________________
