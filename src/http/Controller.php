<?php


namespace app\http;


/**
 * Class Controller
 * @package app
 */
class Controller
{

    /**
     * Simple Templating function
     *
     * https://www.daggerhartlab.com/create-simple-php-templating-function/
     *
     * @param $file - Path to the PHP file that acts as a template.
     * @param $args - Associative array of variables to pass to the template file.
     * @return void - Output of the template file. Likely HTML.
     */
    protected function render($file, $args)
    {
        $filePath = __DIR__ . '/../tmpl/' . $file. '.phtml';

        // ensure the file exists
        if (!file_exists($filePath)) {
            return;
        }

        // Make values in the associative array easier to access by extracting them
        if (is_array($args)) {
            extract($args);
        }

        // buffer the output (including the file is "output")
        ob_start();
        include $filePath;

        print ob_get_clean();
    }

    protected function renderJSON($json): void
    {
        header('Content-Type: application/json');

        print json_encode($json);
    }

}
