<?php

namespace App\Http\Controllers\Api;

use App\Libraries\Responders\Contracts\ArrayResponseInterface;
use App\Libraries\Responders\Contracts\JsonApiResponseInterface;
use App\Libraries\Responders\ErrorObject;
use App\Libraries\Responders\HttpObject;
use App\Libraries\Responders\JsonApiErrorsFormatter;
use App\Repositories\Contracts\DbUsersRepositoryInterface;
use App\Repositories\Contracts\DbOrderRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Throwable;

/**
 * Class DeliveryDateController
 * @package App\Http\Controllers\Api
 */
class DeliveryDateController
{
    /**
     * @type string
     */
    private const ERROR_TITLE = 'Error';

    /**
     * @type string
     */
    private const USER_NOT_FOUND = 'USER_NOT_FOUND';
    /**
     * @type string
     */
    private const DELETE_ADDRESS_ERROR = 'DELIVERY_DATE_ERROR';

    /**
     * @type string
     */
    private const GENERAL_ERROR = 'GENERAL_ERROR';

    /**
     * @var HttpObject
     */
    private $httpObject;

    /**
     * @var ArrayResponseInterface
     */
    private $arrayResponse;

    /**
     * @var JsonApiResponseInterface
     */
    private $jsonApiResponse;

    /**
     * @var DbOrderRepositoryInterface
     */
    private $dbOrderRepository;
    
    /**
     * @var DbUsersRepositoryInterface
     */
    private $dbUserRepository;

    /**
     * @var JsonApiErrorsFormatter
     */
    private $jsonErrorFormat;

    /**
     * DeleteLocationController constructor.
     * @param ArrayResponseInterface $arrayResponse
     * @param HttpObject $httpObject
     * @param JsonApiResponseInterface $jsonApiResponse
     * @param DbOrderRepositoryInterface $dbOrderRepository
     * @param JsonApiErrorsFormatter $jsonApiErrorsFormatter
     */
    public function __construct(
        ArrayResponseInterface $arrayResponse,
        HttpObject $httpObject,
        JsonApiResponseInterface $jsonApiResponse,
        DbOrderRepositoryInterface $dbOrderRepository,
        DbUsersRepositoryInterface $dbUserRepository,
        JsonApiErrorsFormatter $jsonApiErrorsFormatter
    ) {
        $this->arrayResponse = $arrayResponse;
        $this->httpObject = $httpObject;
        $this->jsonApiResponse = $jsonApiResponse;
        $this->dbOrderRepository = $dbOrderRepository;
        $this->dbUserRepository = $dbUserRepository;
        $this->jsonErrorFormat = $jsonApiErrorsFormatter;
    }

    /**
     * @param Request $request
     * @param int $addressID
     * @return JsonResponse
     */
    public function __invoke(Request $request, int $orderID): JsonResponse
    {
        try {
            $user = $this->dbUserRepository->findByID($request['user_id']);

            if (is_null($user)) {
                $error = new ErrorObject();
                $error->setCode(self::USER_NOT_FOUND)
                    ->setTitle(self::ERROR_TITLE)
                    ->setDetail('No se encontro el usuario.')
                    ->setStatus((string) Response::HTTP_BAD_REQUEST);
                $this->jsonErrorFormat->add($error);

                return $this->jsonApiResponse->respondError($this->jsonErrorFormat, Response::HTTP_BAD_REQUEST);
            }
            
            if (! isset($request['date'])) {
                $error = new ErrorObject();
                $error->setCode(self::DELIVERY_DATE_ERROR)
                    ->setTitle('Error')
                    ->setDetail('No se envio la fecha de entrega.')
                    ->setStatus((string) Response::HTTP_BAD_REQUEST);
                $this->jsonErrorFormat->add($error);
    
                return $this->jsonApiResponse->respondError($this->jsonErrorFormat, Response::HTTP_BAD_REQUEST);
            }


            $order = $this->dbOrderRepository->findByID($orderID);
            if (! is_null($order)) {
                $order->delivery_date = $request['date'];
                $order->save();
            } else {
                $error = new ErrorObject();
                $error->setCode(self::DELIVERY_DATE_ERROR)
                    ->setTitle(self::ERROR_TITLE)
                    ->setDetail('No se pudo encontro la orden.')
                    ->setStatus((string) Response::HTTP_BAD_REQUEST);
                $this->jsonErrorFormat->add($error);

                return $this->jsonApiResponse->respondError($this->jsonErrorFormat, Response::HTTP_BAD_REQUEST);
            }

            $this->httpObject->setBody([
                'data' => null
            ]);

            return $this->arrayResponse->respond($this->httpObject);

        } catch (Throwable $exception) {
            $error = new ErrorObject();
            $error->setCode(self::GENERAL_ERROR)
                ->setTitle(self::ERROR_TITLE)
                ->setDetail('Ha ocurrido un error inesperado')
                ->setStatus((string) Response::HTTP_INTERNAL_SERVER_ERROR);
            $this->jsonErrorFormat->add($error);

            return $this->jsonApiResponse->respondError($this->jsonErrorFormat, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
