# Automotive Company Project and its dealers, customer module.



## REQUIREMENTS

* Composer
* Laravel
* Node
* XAMPP 


## CLONE THE REPOSITORY

In the folder C: \ xampp \ htdocs
Open Command Prompt

~~~
: mkdir project
: cd project
: git clone https://github.com/lmedinaC/automotive
~~~

## COMPOSER AND NODE INSTALLATION 

In the folder C: \ xampp \ htdocs \ proyect 
Open Command Prompt

~~~
:composer install
:npm install 
~~~


## CONNECTION TO DB

In the folder C: \ xampp \ htdocs \ proyect 
Create a copy of the .env.example file, with the name .env and modify the following variable 

~~~
DB_DATABASE=automotriz_db
~~~
And run in Command Prompt 

~~~
: php artisan key:generate
: php artisan db:create automotriz_db
: php artisan migrate
: php artisan db:seed
~~~



## RUN PROYECT 
In the folder C: \ xampp \ htdocs \ proyect 
Open Command Prompt run

~~~
:php artisan serve --port=8080
~~~

And open the navigator to the path:

~~~
http://127.0.0.1:8080
user: adminTest@gmail.com
password: adminTest1234
~~~

Autor: @lmedinaC
