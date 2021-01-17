<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\ErrorHandler\ErrorRenderer\HtmlErrorRenderer;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        if ($this->shouldReport($exception)) {
            $this->sendEmail($exception); // sends an email
        }
    }

    /**
     * Sends an email to the developer about the exception.
     *
     * @param Throwable $exception
     * @return void
     */
    private function sendEmail(Throwable $exception)
    {
        if(\env('APP_ENV') !== 'local')
        {
            try {
                $e = FlattenException::createFromThrowable($exception);
                $handler = new HtmlErrorRenderer(true); // boolean, true raises debug flag...
                $css = $handler->getStylesheet();
                $content = $handler->getBody($e);

                Mail::send('emails.exception', compact('css','content'), function ($message) {
                    $message
                        ->to(['auto@hakkertmedia.nl','brianloman@hotmail.com']) //1 = e-mail van Pim. Hier komen de e-mails altijd aan
                        ->subject('KSEC website exception: ' . \Request::fullUrl())
                    ;
                });
            } catch (Throwable $ex) {
                Log::error($ex);
            }
        }
    }
}
