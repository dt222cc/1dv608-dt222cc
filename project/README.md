###A MVC project in PHP as part of the course 

##Resources
- [Use Cases](https://github.com/dt222cc/1dv608-dt222cc/blob/master/project/usecases.md)
- [Test Cases](https://github.com/dt222cc/1dv608-dt222cc/blob/master/project/testcases.md)
- [Webbdeveloping with PHP - 1DV607](https://coursepress.lnu.se/kurs/webbutveckling-med-php/laborationsmiljo/projekt/)

***

#Vision - "MVC Quiz Game"

####Background and problem description
For my MVC PHP project I intend to create a quiz game with three solutions for every question where only one solution is correct.

####Basic requirements / characteristics / Features / Unique Selling Points
1. Source code written in PHP with a focus on quality (well commented, indented, non repetitive).
2. No external code except the code given in task, no libraries are used.
3. No javascript is used.
4. Code has one single page (index.php).
5. Object Oriented
6. MVC implementation
7. Option to play with 5/10/15/20 "random" questions with 3 solutions each.
8. Solutions have a random order.
9. Total correct/incorrect answers are presented but no information regarding which questions.
10. User can add questions for the quiz.
11. User-friendly controls that are easy to understand.

####Techniques
- PHP
 - Forms
 - Database (mysqli)
 - Session variables
 - More..

***

#Class Diagram
![class-diagram](http://yuml.me/08a64843)

***

#Installation
1. Clone repo or download rar file, then unpack.
2. Look into project/QuizGame/model/DAL/QuizDAL.php
	- You need to implement Database::HOST, Database::USER, Database::PASSWORD and Database::SCHEMA with your own mysql connection details. You can replace them with your own connection details at that file.
	- Or add a folder named "data" at the same level as the repository (1dv608-dt222cc) is located at, with a file named Database.php (a class named Database with constants containing your database details, same structure as Settings.php).
	- Or refactor the QuizDAL with your own type of storage. Keep in mind what a Question object needs (see line 24 in QuizDAL).
3. You also need a table with questions to play the game. I used MySQL which was included in MAMP and the public server which I used for this project.
	- You can try and import my table with 20 questions (quotes) to your own database, with the sql file or the queries inside it in the folder install.
	- If you want your own questions: You can replace the data in the "insert into table query" with your own theme.