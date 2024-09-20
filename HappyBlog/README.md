# Instructions

1) Requirements : 
 1.1) Install the latest PHP version(https://windows.php.net/download/) and Composer(https://getcomposer.org/download/).
 1.2) Install MySQL (https://dev.mysql.com/downloads/mysql/) and optionaly WorkBench(https://dev.mysql.com/downloads/workbench/). 
 1.3) Install Postman(https://www.postman.com/downloads/).

2) Setup : 
 2.1) Setup the database connection in the .env(HappyBlog\.env) file.
 2.2) Start Mysql Service
 2.3) On a terminal of your choise go to the \HappyBlog path
 2.4) Run the command : php artisan migrate --db:seed
 2.5) Import the postman collection (HappyBlog\HappyBlog.postman_collection.json)

3) Run: 
 3.1) Use on a terminal of your choise in \HappyBlog the command:  php artisan serve.
 3.2) Use the collection to test the endpoints.

 # Notes  
1) Did not use SMTP for the email functionality.Email can be found at the log file(HappyBlog\storage\logs\laravel.log) 