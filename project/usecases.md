#Use Cases

##UC1 Play a game
####Main scenario
1. Starts when a user visit the game site (index.php)
2. System presents the quiz setup and asks for a limit for the amount of questions
3. User press a radio button and then press the submit button
4. System presents the solve question form and asks for a solution for the question
5. User press a radio button and then press the submit button
6. System presents the results when the total questions limit have been reached
7. User press the Play again link or revisit the game site (index.php)
5. System presents the quiz setup again

##UC2 Test the randomness
####Main scenario
1. Starts when a user has pressed the Submit button from the quiz setup
2. System presents the solve question form and asks for a solution for the question
3. User plays the game and see if there is a new set of questions for each game
3. User plays the game and look if a same question has a different solution order

##UC3 Add a new question
####Main scenario
1. Starts when a user has pressed the "Register a new question for the quiz." link
2. System presents the form for adding a question to the quiz
3. System asks for the question and the three solutions for the game
4. User provides the question and the solutions for the question
5. System validates the given data and presents that the registration succeeded

####Alternate Scenarios
- 4a. Question did not pass the validation
 1. System presents an error message
 2. Step 2 in main scenario

##UC4 User resends page
####Main scenario
1. Starts when a user has pressed the Submit button
2. User press the F5 key to resend page
3. System resubmits the last action
4. A new quiz game with aa different question is shown after every resend

####Alternate Scenarios
- 4a. The result page is shown after a specific threshold has been met
- 4b. The add new question page is shown with an error message