<?php

use app\http\EventFormController;

require __DIR__ . '/../vendor/autoload.php';

session_start();


$ctrl = new EventFormController();

ob_start();

switch ($_SERVER['REQUEST_URI']) {
    case '/event-sessions':
        $ctrl->eventSessionsHandler();
        break;
    case '/submit-form':
        $ctrl->submittedFormHandler();
        break;
    case '/done':
        $ctrl->donePageHandler();
        break;
    default;
        $ctrl->show();
        break;
}

$output = ob_get_contents();
ob_end_clean();


if (strlen($output)) {
    http_response_code(200);
    file_put_contents("php://output", $output);
} else {
    http_response_code(500);
    file_put_contents("php://output", "Internal Server Error");
}
