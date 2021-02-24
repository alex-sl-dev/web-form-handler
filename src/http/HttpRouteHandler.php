<?php


namespace app\http;


/**
 * Class HttpRouteHandler
 * @package app
 */
abstract class HttpRouteHandler
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
    protected function renderHTML($file, $args)
    {
        $filePath = __DIR__ . '/../tmpl/' . $file . '.phtml';

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

    /**
     * @param $json
     */
    protected function renderJSON($json): void
    {
        header('Content-Type: application/json');

        print json_encode($json);
    }

    /**
     * https://gist.github.com/ziadoz/3454607
     * @param bool $force
     * @return mixed|string
     */
    protected function generateCSRFToken($force = false): string
    {
        if (!isset($_SESSION['csrf_token']) || $force) {
            $_SESSION['csrf_token'] = base64_encode(openssl_random_pseudo_bytes(32));
        }

        return $_SESSION["csrf_token"];
    }

    /**
     * @return bool
     */
    protected function isValidCSRF(): bool
    {
        return (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']);
    }
}
