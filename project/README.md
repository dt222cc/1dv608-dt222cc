### A MVC project in PHP as part of the course [1DV607](https://coursepress.lnu.se/kurs/webbutveckling-med-php/laborationsmiljo/projekt/)

#### - [Vision](https://github.com/dt222cc/1dv608-dt222cc/)

#### - [Use-Cases](https://github.com/dt222cc/1dv608-dt222cc/)

#### - Installation
1. Clone repo or download rar file, then unpack.
2. Look into project/QuizGame/model/DAL/QuizDAL.php
 - You need to implement Database::HOST, Database::USER, Database::PASSWORD and Database::SCHEMA with your own mysql connection details. You can replace them with your own connection details at that file.
 - Or add a folder named "data" at the same level as the repository (1dv608-dt222cc) is located at, with a file named Database.php (a class named Database with constants containing your database details, same structure as Settings.php).
 - Or refactor the QuizDAL with your own type of storage. Keep in mind what a Question object needs (see line 24 in QuizDAL).
3. You also need a table with questions to play the game. I used MySQL which was included in MAMP and the public server which I used for this project.
 - You can try and import my table with 20 questions (quotes) to your own database, with the sql file or the queries inside it in the folder install.
 - If you want your own questions: You can replace the data in the "insert into table query" with your own theme.