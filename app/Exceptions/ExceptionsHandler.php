<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionsHandler
{
    public function __invoke(Exception $e)
    {

        $error = $e->getMessage();
        $statusCode = $e->getCode() == 0 ? Response::HTTP_NOT_FOUND : $e->getCode();

        switch (true) {
            case $e instanceof NotFoundHttpException && str($e->getMessage())->contains('No query results for model'):
            case $e instanceof ModelNotFoundException:
                $error = ('No result for this record.');
                break;

            default:
                $statusCode = $e->getCode() == 0 || ! is_int($e->getCode()) ? Response::HTTP_INTERNAL_SERVER_ERROR : $e->getCode();

                break;
        }

        return response()->json(['message' => $error], status: $statusCode);
    }
}
