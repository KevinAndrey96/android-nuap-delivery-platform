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
use GuzzleHttp\Client;

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
        
        //dd('https://thenuap.com/payment-response?orders='.$ordersIDs);
        return view('admin.payments.payment-gateway', [
            'key' => config('services.epayco.public_key'),
            'amount' => $total,
            'name' => $name,
            'description' => $description,
            'currency' => 'cop',
            'country' => 'co',
            'test' => 'false',
            'external' => 'true',
            'response' => 'https://thenuap.com/payment-response?orders='.$ordersIDs,
            'confirmation' => 'https://thenuap.com/confirm-payment', // no existe esta vista
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
        $validSignature = false;

        $client = new Client([
            'base_uri' => 'https://secure.epayco.co/validation/v1/reference/'.$reference,
            'timeout'  => 5.0,
        ]);

        $response = $client->request('GET', null, []);
        
        if ($response->getStatusCode() == '200')
        {
            $data = json_decode($response->getBody(), true)['data'];

            $orders = explode('-', $request->input('orders'));
            
            $p_cust_id_client = $data['x_cust_id_cliente'];
            $p_key = config('services.epayco.p_key');
            $x_ref_payco = $data['x_ref_payco'];
            $x_transaction_id = $data['x_transaction_id'];
            $x_amount = $data['x_amount'];
            $x_currency_code = $data['x_currency_code'];
            $x_signature = $data['x_signature'];
            $x_cod_response = $data['x_cod_response'];

            $signature = hash(
                'sha256',
                $p_cust_id_client . '^' . $p_key . '^' . $x_ref_payco . '^' . $x_transaction_id . '^' . $x_amount . '^' . $x_currency_code
            );
            
            
            if ($signature == $x_signature) {
                $validSignature = true;
            }

            foreach ($orders as $item) {
                if ($item !== null){
                    $order = $this->dbOrderRepository->findByID((int) $item);
                    $order->reference = $reference;
                    if ($x_cod_response == 1 && $validSignature) {
                        $order->status = Order::STATUS_ACCEPTED;
                    }
                    
                    $order->save();
                }
                return view('admin.payments.payment-response');
            }
        }

        return view('admin.payments.payment-response');
    }
    
        /**
     * @param Request $request
     * @return Factory|Application|View
     */
    public function responseAcepted(Request $request): View
    {
        $reference = $request->input('ref_payco');
        $validSignature = false;

        $client = new Client([
            'base_uri' => 'https://secure.epayco.co/validation/v1/reference/'.$reference,
            'timeout'  => 5.0,
        ]);

        $response = $client->request('GET', null, []);
        
        if ($response->getStatusCode() == '200')
        {
            $data = json_decode($response->getBody(), true)['data'];

            $orders = explode('-', $request->input('orders'));
            
            $p_cust_id_client = $data['x_cust_id_cliente'];
            $p_key = config('services.epayco.p_key');
            $x_ref_payco = $data['x_ref_payco'];
            $x_transaction_id = $data['x_transaction_id'];
            $x_amount = $data['x_amount'];
            $x_currency_code = $data['x_currency_code'];
            $x_signature = $data['x_signature'];
            $x_cod_response = $data['x_cod_response'];

            $signature = hash(
                'sha256',
                $p_cust_id_client . '^' . $p_key . '^' . $x_ref_payco . '^' . $x_transaction_id . '^' . $x_amount . '^' . $x_currency_code
            );
            
            
            if ($signature == $x_signature) {
                $validSignature = true;
            }

            foreach ($orders as $item) {
                if ($item !== null){
                    $order = $this->dbOrderRepository->findByID((int) $item);
                    $order->reference = $reference;
                    if ($x_cod_response == 1 && $validSignature) {
                        $order->status = Order::STATUS_ACCEPTED;
                    }
                    
                    $order->save();
                }
                return view('admin.payments.payment-response');
            }
        }

        return view('admin.payments.payment-response');
    }
}
