<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\DbOrderRepositoryInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use App\Models\Order;

/**
 * Class PaymentGatewayController
 * @package App\Http\Controllers\Admin
 */
class PaymentGatewayController extends Controller
{
    /**
     * @var DbOrderRepositoryInterface
     */
    private $dbOrderRepository;

    /**
     * PaymentGatewayController constructor.
     * @param DbOrderRepositoryInterface $dbOrderRepository
     */
    public function __construct(
        DbOrderRepositoryInterface $dbOrderRepository
    )
    {
        $this->dbOrderRepository = $dbOrderRepository;
    }

    /**
     * @param Request $request
     * @return array|Factory|Application|RedirectResponse|Redirector|View
     */
    public function index(Request $request)
    {
        $name = 'NUAP PAGO PEDIDOS (';
        $description = '';
        $total = 0;
        $error = false;
        $orders = $request->orders;
        $userID = $request->user;

        $ordersIDs = '';
        $orders = array_unique($orders);
        foreach ($orders as $item) {
            $ordersIDs = sprintf('%s-', $item);
            $order = $this->dbOrderRepository->findByUserIDAndOrderUD($item, $userID);
            if (! count($order)) {
                $error = true;
                return view('admin.payments.payment-gateway', [
                    'error' => $error,
                ]);
            }

            $products = $this->dbOrderRepository->findProductsByOrderID($item);

            foreach ($products as $product) {
                $data = sprintf('%s x %d = %d - ', $product->name, $product->quantity, $product->quantity * $product->price);
                $description .= $data;
            }

            $name .= sprintf('%d - ', $order->first()->id);
            $total += $order->first()->total;
        }

        $description = substr($description, 0, -3);
        $name = substr($name, 0, -3). ')';
        return view('admin.payments.payment-gateway', [
            'key' => '***REMOVED***',
            'amount' => $total,
            'name' => $name,
            'description' => $description,
            'currency' => 'cop',
            'country' => 'co',
            'test' => 'false',
            'external' => 'true',
            'response' => 'https://thenuap.com/payment-response?orders='.$ordersIDs,
            'confirmation' => 'https://thenuap.com/confirm-payment',
            'error' => $error,
            'acepted' => 'https://thenuap.com/payment-acepted?orders='.$ordersIDs
        ]);
    }

    /**
     * @param Request $request
     * @return Factory|Application|View
     */
    public function response(Request $request): View
    {
        $reference = $request->input('ref_payco');
        $response = $request->input('x_cod_response');
        $validSignature = false;
        
        $orders = explode('-', $request->input('orders'));
        
        $p_cust_id_client = env('P_CUST_ID_CLIENTE');
        $p_key = env('P_KEY');
        $x_ref_payco = $request['x_ref_payco'];
        $x_transaction_id = $request['x_transaction_id'];
        $x_amount = $request['x_amount'];
        $x_currency_code = $request['x_currency_code'];
        $x_signature = $request['x_signature'];
        $x_cod_response = $request['x_cod_response'];

        $signature = hash(
            'sha256',
            $p_cust_id_client . '^' . $p_key . '^' . $x_ref_payco . '^' . $x_transaction_id . '^' . $x_amount . '^' . $x_currency_code
        );

        if ($signature === $x_signature) {
            $validSignature = true;
        }

        foreach ($orders as $item) {
            if ($item !== null){
                $order = $this->dbOrderRepository->findByID((int) $item);
                $order->reference = $reference;
                if ($response === 1 && $validSignature) {
                    $order->status = Order::STATUS_ACCEPTED;
                }
                
                $order->save();
            }
            return view('admin.payments.payment-response');
        }

        return view('admin.payments.payment-response');
    }
    
        /**
     * @param Request $request
     * @return Factory|Application|View
     */
    public function responseAcepted(Request $request): View
    {
        $reference = $request->input('x_ref_payco');

        $response = $request->input('x_cod_response');
        $validSignature = false;
        
        $orders = explode('-', $request->input('orders'));
      
        $p_cust_id_client = env('P_CUST_ID_CLIENTE');
        $p_key = env('P_KEY');
        $x_ref_payco = $request['x_ref_payco'];
        $x_transaction_id = $request['x_transaction_id'];
        $x_amount = $request['x_amount'];
        $x_currency_code = $request['x_currency_code'];
        $x_signature = $request['x_signature'];
        $x_cod_response = $request['x_cod_response'];

        $signature = hash(
            'sha256',
            $p_cust_id_client . '^' . $p_key . '^' . $x_ref_payco . '^' . $x_transaction_id . '^' . $x_amount . '^' . $x_currency_code
        );

        if ($signature === $x_signature) {
            $validSignature = true;
        }

        foreach ($orders as $item) {
            if ($item !== null){
                $order = $this->dbOrderRepository->findByID((int) $item);
                $order->reference = $reference;
                if ($response == 1 && $validSignature) {
                    $order->status = Order::STATUS_ACCEPTED;
                }

                $order->save();
            }
            return view('admin.payments.payment-response');
        }

        return view('admin.payments.payment-response');
    }
}
