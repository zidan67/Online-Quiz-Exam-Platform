<?php

require_once "../Model/QuizModel.php";

class QuizController
{
    private $model;

    public function __construct($db)
    {
        $this->model = new QuizModel($db);
    }

    public function quizList()
    {
        return $this->model->getPublishedQuizzes();
    }
}
?>