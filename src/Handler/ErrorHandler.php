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

        $output = $this->renderHtmlErrorMessage($e);

        if ($this->view) {
            return $this->view->render(
                $response->withStatus(500),
                '_error' . $this->settings['view']['extension'],
                ['html' => $output]
            );
        }
        
        $body = new Body(fopen('php://temp', 'r+'));
        $body->write($output);
        return $response->withStatus(500)->withBody($body);
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

    /**
     * Render HTML error page
     *
     * @param  Throwable $e
     *
     * @return string
     */
    protected function renderHtmlErrorMessage(Throwable $e)
    {
        $title = 'Slim Application Error';

        if ($this->settings['displayErrorDetails']) {
            $html = '<p>The application could not run because of the following error:</p>';
            $html .= '<h2>Details</h2>';
            $html .= $this->renderHtmlException($e);

            while ($e = $e->getPrevious()) {
                $html .= '<h2>Previous exception</h2>';
                $html .= $this->renderHtmlException($e);
            }
        } else {
            $html = '<p>A website error has occurred. Sorry for the temporary inconvenience.</p>';
        }

        $output = sprintf(
            "<html><head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>" .
            "<title>%s</title><style>body{margin:0;padding:30px;font:12px/1.5 Helvetica,Arial,Verdana," .
            "sans-serif;}h1{margin:0;font-size:48px;font-weight:normal;line-height:48px;}strong{" .
            "display:inline-block;width:65px;}</style></head><body><h1>%s</h1>%s</body></html>",
            $title,
            $title,
            $html
        );

        return $output;
    }

    /**
     * Render exception as HTML.
     *
     * @param Throwable $e
     *
     * @return string
     */
    protected function renderHtmlException(Throwable $e)
    {
        $html = sprintf('<div><strong>Type:</strong> %s</div>', get_class($e));

        if (($code = $e->getCode())) {
            $html .= sprintf('<div><strong>Code:</strong> %s</div>', $code);
        }

        if (($message = $e->getMessage())) {
            $html .= sprintf('<div><strong>Message:</strong> %s</div>', htmlentities($message));
        }

        if (($file = $e->getFile())) {
            $html .= sprintf('<div><strong>File:</strong> %s</div>', $file);
        }

        if (($line = $e->getLine())) {
            $html .= sprintf('<div><strong>Line:</strong> %s</div>', $line);
        }

        if (($trace = $e->getTraceAsString())) {
            $html .= '<h2>Trace</h2>';
            $html .= sprintf('<pre>%s</pre>', htmlentities($trace));
        }

        return $html;
    }
}
