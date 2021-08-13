<?php
namespace App\Http\Controllers\Api;

use App\Http\Transformers\BankAccountTransformer;
use App\Libraries\Responders\Contracts\ArrayResponseInterface;
use App\Libraries\Responders\Contracts\JsonApiResponseInterface;
use App\Libraries\Responders\ErrorObject;
use App\Libraries\Responders\HttpObject;
use App\Libraries\Responders\JsonApiErrorsFormatter;
use App\Mail\SendEmail;
use App\Models\BankAccount;
use App\Models\Commerce;
use App\Models\User;
use App\Repositories\Contracts\DbBankAccountRepositoryInterface;
use App\Repositories\Contracts\DbUsersRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Exception;

/**
 * Class CreateAccountController
 * @package App\Http\Controllers\Api
 */
class CreateAccountController
{
    /**
     * @type string
     */
    protected const ERROR_TITLE = 'Error';

    /**
     * @type string
     */
    protected const USER_NOT_FOUND = 'USER_NOT_FOUND';

    /**
     * @type string
     */
    protected const GENERAL_ERROR = 'GENERAL_ERROR';

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
     * @var DbUsersRepositoryInterface
     */
    private $dbUserRepository;

    /**
     * @var DbBankAccountRepositoryInterface
     */
    private $dbBankAccountRepository;

    /**
     * @var JsonApiErrorsFormatter
     */
    private $jsonErrorFormat;

    /**
     * CreateAccountController constructor.
     * @param ArrayResponseInterface $arrayResponse
     * @param HttpObject $httpObject
     * @param JsonApiResponseInterface $jsonApiResponse
     * @param DbUsersRepositoryInterface $dbUserRepository
     * @param DbBankAccountRepositoryInterface $dbBankAccountRepository
     * @param JsonApiErrorsFormatter $jsonApiErrorsFormatter
     */
    public function __construct(
        ArrayResponseInterface $arrayResponse,
        HttpObject $httpObject,
        JsonApiResponseInterface $jsonApiResponse,
        DbUsersRepositoryInterface $dbUserRepository,
        DbBankAccountRepositoryInterface $dbBankAccountRepository,
        JsonApiErrorsFormatter $jsonApiErrorsFormatter
    ) {
        $this->arrayResponse = $arrayResponse;
        $this->httpObject = $httpObject;
        $this->jsonApiResponse = $jsonApiResponse;
        $this->dbUserRepository = $dbUserRepository;
        $this->dbBankAccountRepository = $dbBankAccountRepository;
        $this->jsonErrorFormat = $jsonApiErrorsFormatter;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'owner_name' => 'required|string',
                'owner_document' => 'required|string',
                'owner_document_type' => 'required|string',
                'account' => 'required|string',
                'account_type' => 'required|string',
                'bank' => 'required|string'
            ]);

            if ($validator->fails()) {
                return $this->jsonApiResponse->respondFormError(
                    $validator->errors(),
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            $user = $this->dbUserRepository->findByID($request['user_id']);

            if (is_null($user)) {
                $error = new ErrorObject();
                $error->setCode(self::USER_NOT_FOUND)
                    ->setTitle(self::ERROR_TITLE)
                    ->setDetail('No se encontró el usuario.')
                    ->setStatus((string) Response::HTTP_BAD_REQUEST);
                $this->jsonErrorFormat->add($error);

                return $this->jsonApiResponse->respondError($this->jsonErrorFormat, Response::HTTP_BAD_REQUEST);
            }

            $account = $this->dbBankAccountRepository->findByUserID($user->id);
            If (is_null($account)) {
                $account['user_id'] = $user->id;
                $account['user_type'] = $user->role;
                $account['owner_name'] = $request->input('owner_name');
                $account['owner_document'] = $request->input('owner_document');
                $account['owner_document_type'] = $request->input('owner_document_type');
                $account['account'] = $request->input('account');
                $account['account_type'] = $request->input('account_type');
                $account['bank'] = $request->input('bank');
                $account['status'] = BankAccount::ACCOUNT_INACTIVE;

                $account = BankAccount::create($account);
            }

            $account->owner_name = $request->input('owner_name');
            $account->owner_document = $request->input('owner_document');
            $account->owner_document_type = $request->input('owner_document_type');
            $account->account = $request->input('account');
            $account->account_type = $request->input('account_type');
            $account->bank = $request->input('bank');
            $account->status = BankAccount::ACCOUNT_INACTIVE;
            $account->save();

            $this->httpObject->setItem($account);

            //send email
            $admin = User::where('role', User::ADMIN_ROLE)->get();
            $emails = [];
            foreach ($admin as $item) {
                $emails[] = $item->email;
            }

            $commerce = Commerce::where('user_id', $user->id)->first();
            Mail::to($emails)->send(new SendEmail(
                    '',
                    sprintf('%s ha creado o actualizado su cuenta bancaria, por favor revisalo lo antes
                                posible para gestionar su aprobación. Click en el siguiente enlace para ver esta cuenta 
                                https://thenuap.com/admin/users/'.$user->id.'/view-account',
                        $commerce->business_name),
                    '¡Han creado o actualizado una cuenta bancaria!.'
                )
            );

            return $this->arrayResponse->responseWithItem(
                $this->httpObject,
                new BankAccountTransformer(),
                'data'
            );
        } catch (Exception $exception) {
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
