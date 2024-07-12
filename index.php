<?php

/*
* This controller mimics a Laravel controller (without any external dependencies)
* Its renderResults function is called below.
* All data-sets and variables are hard-coded for testing purposes.
* Your task is only to:
* 1) Refactor the code within renderResults() ,
* 2) implement a percentage() method in the CompletionRow class
* 3) Suggest improvements to support more question categories in future.
* The current code base assumes two categories with "personal" first and "career" second. 
* However, these categories may change in future.
*/
class SurveyController extends Controller {

  /*
  * Output the survey results as JSON
  * with percentage of answers by category. There are only 2 categories "personal" and "career".
  * However, in future there may be more categories.
  * The current surveyId and userId are hard coded for testing purposes
  * The static methods above have hard coded static methods. In production this would come from a database
  */
  public function renderResults() {

    // These would normally come from a $request object
    // current ids are hard-coded here
    $surveyid = 4;
    $userId = 209;

    $answers =  SurveyResult::getAnswers($surveyid, $userId);
  
    $completions = SurveyResult::getCompletionResults($surveyid, $userId);

    // A successful response requires two completion reuslt rows
    // the first for personal questions and the second for career questions
    $statusKey = count($completions) === 2 ? 'success' : 'invalid';
    $statusCode = count($completions) === 2 ? 400 : 406;

    // Can you refactor this code block to return early if we have insufficient data
    // and reduce copy-and-paste procedures
  
    $personalPercentage = ($completions[0]->count / $completions[0]->total) * 100;
  
    $careerPercentage = ($completions[1]->count / $completions[1]->total) * 100;

    // Suggest implementation
    // $careerPercentage = $completions[1]->percentage();
    
    // Suggest other improvements

    $details = [
      'status' => $statusKey,
      'surveyId' => $surveyid,
      'personal' => $personalPercentage,
      'career' => $careerPercentage,
      'answers' => $answers
    ];
  
    return response()->json($details, $statusCode);
  }
}

// Should be a base Laravel Controller
abstract class Controller {
  
}

// Mock Laravel Reponse class. Only for testing purposes
class Responder {
  public function json($data, $statusCode = 403) {
    header("Content-Type", "application/json");
    print json_encode($data);
    exit;
  }
}

function response() {
  return new Responder();
}

// Dummy entity class with default constructors only setting the values
// of $this->id, $this->text and $this->type, 
class AnswerRow {

  function __construct(public int $id, public string $text, public string $type)
  {

  }
  
}

// Dummy entity class with default constructors only setting the values
// of $this->type, $this->count and $this->total, 
class CompletionRow {

  function __construct(public string $type, public int $count, public int $total)
  {
  
  }

  // Consider adding percentage method here. To be implemented
  /* function percentage(): float {
    return 0.0 ;
  } */
  
}

// Mock SurveyResult class

class SurveyResult {
  public static function getCompletionResults($surveyId = 0, $userId = 0)
  {
    // Normally the count and total would be dynamically calculated
    return [
      new CompletionRow('personal', 1, 3),
      new CompletionRow('career', 2, 9),
    ];
  }

  public static function getAnswers($surveyId = 0, $userId = 0)
  {
    return [
      new AnswerRow(1, 'Jane Blogger', 'personal'),
      new AnswerRow(4, 'Lead API Developer', 'career'),
      new AnswerRow(7, 'Python', 'career'),
    ];
  }
}



/**
 * Run code in test mode
 */
 $controller = new SurveyController();

 $controller->renderResults();