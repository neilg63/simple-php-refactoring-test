# Simple PHP Refactoring Test

This index.php incldues a controller that mimics a full-fat Laravel controller (but without any external framework dependencies). It should run in any php 8+ environment.

The controller's ```renderResults()``` method is called at the bottom of the file so it will run at the command line via ```php index.php``` with JSON output.

All data sets and variable values are hard-coded for testing purposes. In production, these would come from a ```$request``` object and database queries.

A user, Jane Blogger, identified by $userId, is answering questions in a survey identified by $surveyId. So far, she has answered 3 questions, 1 in the personal category and 2 in the career category. The current survey has 3 personal questions and 9 career questions. Each question has one answer.

This output should show status (success, invalid), the percentage completed by category key and the answers given so far. 

The API endpoint would be called by a frontend application (e.g. React, Vue or similar) with a payload containing the ```surveyId```. The ```userId``` may come from a JWT token;

Your task is only to:

1. Refactor the code within ```renderResults()```
2. Implement a percentage() method in the ```CompletionRow``` class
3. Suggest improvements to support more question categories in future.
