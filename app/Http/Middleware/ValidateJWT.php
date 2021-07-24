<?php

namespace App\Http\Middleware;

use App\Libraries\jwt;
use App\Libraries\Responders\Contracts\JsonApiResponseInterface;
use App\Libraries\Responders\ErrorObject;
use App\Libraries\Responders\JsonApiErrorsFormatter;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ValidateJWT
{
    /**
     * @type string
     */
    protected const TOKEN_NOT_VALID = 'TOKEN_NOT_VALID';

    /**
     * @type string
     */
    protected const API_TOKEN_NOT_FOUND = 'API_TOKEN_NOT_FOUND';

    /**
     * @var JsonApiResponseInterface
     */
    private $jsonApiResponse;

    /**
     * @var JsonApiErrorsFormatter
     */
    private $jsonErrorFormat;

    public function __construct(
        JsonApiResponseInterface $jsonApiResponse,
        JsonApiErrorsFormatter $jsonApiErrorsFormatter
    ) {
        $this->jsonApiResponse = $jsonApiResponse;
        $this->jsonErrorFormat = $jsonApiErrorsFormatter;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $jwt = new jwt();

        if (! isset($request['api_token'])) {
            $error = new ErrorObject();
            $error->setCode(self::API_TOKEN_NOT_FOUND)
                ->setTitle('Error')
                ->setDetail('No se envio el api token.')
                ->setStatus((string) Response::HTTP_BAD_REQUEST);
            $this->jsonErrorFormat->add($error);

            return $this->jsonApiResponse->respondError($this->jsonErrorFormat, Response::HTTP_BAD_REQUEST);
        }

        $result = $jwt->validateJWT($request['api_token']);

        if ($result === 0) {
            $error = new ErrorObject();
            $error->setCode(self::TOKEN_NOT_VALID)
                ->setTitle('Error')
                ->setDetail('Error de autenticación.')
                ->setStatus((string) Response::HTTP_BAD_REQUEST);
            $this->jsonErrorFormat->add($error);

            return $this->jsonApiResponse->respondError($this->jsonErrorFormat, Response::HTTP_BAD_REQUEST);
        }

        $request['user_id'] = $result;
        return $next($request);
    }
}
