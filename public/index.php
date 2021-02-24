<?php

use app\http\StarEventRoutes;

require __DIR__ . '/../vendor/autoload.php';

session_start();


$starEventRoutes = new StarEventRoutes();

ob_start();

switch ($_SERVER['REQUEST_URI']) {
    case '/event-sessions':
        $starEventRoutes->eventSessionsHandler();
        break;
    case '/submit-form':
        $starEventRoutes->submittedFormHandler();
        break;
    case '/done':
        $starEventRoutes->donePageHandler();
        break;
    default;
        $starEventRoutes->show();
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
