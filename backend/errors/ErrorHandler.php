<?php


namespace errors;


class ErrorHandler
{

    public function __construct()
    {
        if (DEBUG) {
            error_reporting(E_ALL);
        } else {
            error_reporting(0);
        }
        set_exception_handler([$this, 'exceptionHandler']);
        set_error_handler([$this, 'errorHandler']);
        ob_start();
        register_shutdown_function([$this, 'fatalErrorHandler']);
    }

    public function errorHandler($errno, $errstr, $errfile, $errline)
    {
        $this->logError($errstr, $errfile, $errline);
        $this->displayError($errno, $errstr, $errfile, $errline);
    }

    public function fatalErrorHandler()
    {
        $error = error_get_last();

        if (!empty($error) && $error['type'] &
            (E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR)
        ) {
            $this->logError(
                $error['message'],
                $error['file'],
                $error['line']
            );
            ob_end_clean();

            $this->displayError(
                $error['type'],
                $error['message'],
                $error['file'],
                $error['line']
            );
        } else {
            ob_end_flush();
        }
    }

    public function exceptionHandler(\Throwable $e)
    {
        $this->logError(
            $e->getMessage(),
            $e->getFile(),
            $e->getLine()
        );
        $this->displayError(
            'Исключение',
            $e->getMessage(),
            $e->getFile(),
            $e->getLine(),
            $e->getCode()
        );
    }

    protected function logError($message = '', $file = '', $line = '')
    {
        $data = date('Y-m-d H:i:s');

        file_put_contents(
             ROOT.'/tmp/logs/errors.log',
            "[{$data}] Текст ошибки: {$message} | Файл: {$file} | Строка: {$line}\n=================\n",
            FILE_APPEND);
    }

    protected function displayError($errorNo, $errorMsg, $errorFile, $errorLine, $responce = 500)
    {
        if ($responce == 0) {
            $responce = 500;
        }
        http_response_code($responce);

        require ROOT.'/public/errors/error.php';

        die;
    }

}