<?php


namespace app;

use PDO;
use PDOException;


/**
 *
 * PDO Singleton Class v 0.0.1
 *
 * @author Ademílson F. Tonato
 * @link https://twitter.com/ftonato
 * @link https://gist.github.com/ftonato/2973a55baf8eef6795a48804dcdb71dd
 *
 */
class DB
{

    protected static PDO $instance;

    public static function setCharsetEncoding(): void
    {
        if (self::$instance == null) {
            self::getInstance();
        }

        self::$instance->exec(
            "SET NAMES 'utf8';
			SET character_set_connection=utf8;
			SET character_set_client=utf8;
			SET character_set_results=utf8");
    }

    public static function getInstance(): PDO
    {
        if (empty(self::$instance)) {

            $iniFile = parse_ini_file(realpath(__DIR__ . "/../config.ini"), true);
            $credential = $iniFile['db'];

            try {
                $dsn = "mysql:host=" . $credential['host']
                    . '; port=' . $credential['port']
                    . '; dbname=' . $credential['dbname'];

                self::$instance = new PDO($dsn, $credential['user'], $credential['pass']);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->query('SET NAMES utf8');
                self::$instance->query('SET CHARACTER SET utf8');

            } catch (PDOException $error) {
                echo $error->getMessage();

                return new PDO("");
            }

        }

        return self::$instance;
    }
}
