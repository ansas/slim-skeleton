<?php

namespace App\Handler;


use DateTime;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Body;
use Throwable;

/**
 * Error handler
 *
 * It outputs the error message
 */
class ErrorHandler extends AbstractHandler
{
    /**
     * Invoke error handler
     *
     * @param ServerRequestInterface $request   The most recent Request object
     * @param ResponseInterface      $response  The most recent Response object
     * @param Throwable             $e The caught Exception object
     *
     * @return ResponseInterface
     */
    public function __invoke(Request $request, Response $response, Throwable $e)
    {
        $this->logError($e);

        if ($this->view && !$this->settings['displayErrorDetails']) {
            return $this->view->render(
                $response->withStatus(500),
                '_error' . $this->settings['view']['extension'],
                ['error' => $e]
            );
        }

        $handler = $this->defaultErrorHandler;
        return $handler($request, $response, $e);
    }

    /**
     * Write to the error log if displayErrorDetails is false
     *
     * @param \Throwable $throwable
     * @param boolean    $isPrevious
     *
     * @return void
     */
    protected function logError(Throwable $e, $isPrevious = false)
    {
        if ($this->settings['displayErrorDetails']) {
            return;
        }

        if (!$this->logger) {
            return;
        }

        static $errorsLogged = [];

        // get: hash of Throwable object
        $errorObjectHash = spl_object_hash($e);

        // check: only log if we haven't logged this exact error before
        if (!isset($errorsLogged[$errorObjectHash])) {
            // log: error
            $this->logger->error(
                sprintf(
                    "[%s] Slim Error: %s in %s on line %d\n%s\n",
                    date(DateTime::ATOM),
                    $e->getMessage(),
                    $e->getFile(),
                    $e->getLine(),
                    $e->getTraceAsString()
                )
            );
            while ($prev = $e->getPrevious()) {
                $this->logError($prev, $previous = true);
            }

            // save: information that we have logged this error
            $errorsLogged[$errorObjectHash] = true;
        }
    }
}
