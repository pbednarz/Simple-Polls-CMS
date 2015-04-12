<?php
function getAnswers()
{
    try {
        echo json_encode(Database::getInstance()->getAnswers());
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function getAnswersForQuestion($pollId, $questionId)
{
    try {
        echo json_encode(Database::getInstance()->getAnswersForQuestion($questionId));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}
?>