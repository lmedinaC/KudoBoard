# Project Kudoboard 2021

## FUNCTIONS

* Create a KudoBoard for a worker or workers
* Edit config KudoBoard (owner of the KudoBoard)
* Edit Guest list of a KudoBoard (owner of the KudoBoard)
* Post in a KudoBoard (guest of the KudoBoard)
* Edist Post in a KudoBoard (Owner of the Post)
    

## REQUIREMENTS

* Docker
* Docker-compose

## CLONE THE REPOSITORY

Create a folder in your Desktop 
Open Command Prompt

~~~
: mkdir projects
: cd project
: git clone https://github.com/lmedinaC/KudoBoard.git
: cd KudoBoard
~~~

## DOCKER-COMPOSE  BUILD/UP

In the Desktop
Open Command Prompt

~~~
: cd project/KudoBoard
: docker-compose build
: docker-compose up
~~~



## RUN PROYECT 

Open the navigator to the path:

~~~
http://127.0.0.1:8080

Like ADMIN
user: admin@gmail.com
password: adminTest1234

Like JOCA
user: jocaTest@gmail.com
password: adminTest1234
~~~

## PROBLEMS WITH NODE AND WWW DOESNT RUN

Open the file Dockerfile
Use notepad++, go to edit -> EOL conversion -> change from CRLF to LF.

Open the folder init-scripts
open the 2 fiels, apache_start and node_start.sh
Use notepad++, go to edit -> EOL conversion -> change from CRLF to LF.


* Creo que al guardar con git la configuración de estos archivos cambia.


Autor: @lmedinaC
