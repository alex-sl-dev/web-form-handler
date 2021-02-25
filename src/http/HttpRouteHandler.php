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
    protected function renderHTML(string $file, array $args)
    {
        $filePath = __DIR__ . '/../tmpl/' . $file . '.phtml';
        if (!file_exists($filePath)) { return; }
        if (is_array($args)) { extract($args); }
        ob_start();
        include $filePath;
        print ob_get_clean();
    }

    protected function renderJSON($data): void
    {
        header('Content-Type: application/json');
        print json_encode($data);
    }

    protected function generateCSRFToken(): string
    {
        if (!isset($_SESSION['csrf_token'])) {
            /** https://gist.github.com/ziadoz/3454607 */
            $_SESSION['csrf_token'] = base64_encode(openssl_random_pseudo_bytes(32));
        }

        return $_SESSION["csrf_token"];
    }

    protected function isValidCSRF(): bool
    {
        return (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']);
    }
}
