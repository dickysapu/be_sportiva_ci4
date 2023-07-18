<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\OrderModel;
use Config\Midtrans;
use Midtrans\Snap;
use Midtrans\Notification;
use Midtrans\Config;

class Order extends ResourceController
{
    
    public function __construct()
    {
        // Atur konfigurasi Midtrans
        Config::$serverKey = config('Midtrans')->serverKey;
        Config::$isProduction = config('Midtrans')->isProduction;
        Config::$isSanitized = config('Midtrans')->isSanitized;
        Config::$is3ds = config('Midtrans')->is3ds;
    }

    
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    use ResponseTrait;
    public function index()
    {
        $model = new OrderModel();
        $data = $model->findAll();
        return $this->respond($data); 
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $model = new OrderModel();
        $data = $model->find(['id'=>$id]);
        if(!$data) return $this->failNotFound('no data found');
        return $this->respond($data[0]); 
    }

    public function create()
    {
        
        
        helper(['form']);
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'noTelp' => 'required',
            'lapangan' => 'required',
            'tanggal' => 'required',
            'totalHarga' => 'required',
        ];

        $orderId = rand();
        $params = [
            'transaction_details' => [
                "order_id" => $orderId,
                "gross_amount" => (int) $this->request->getVar('totalHarga'),
            ],
            'item_details' => [
                [
                    'id' => 'lapangan',
                    'price' => (int) $this->request->getVar('totalHarga'),
                    'quantity' => 1,
                    'name' => 'Lapangan ' . $this->request->getVar('lapangan'),
                    'brand' => 'Sportiva',
                    'category' => 'Futsal',
                ],
            ],
            'customer_details' => [
                'first_name' => $this->request->getVar('name'),
                'email' => $this->request->getVar('email'),
                'phone' => $this->request->getVar('noTelp'),
            ],
        ];
        
        $data = [
            'name'=>$this->request->getVar('name'),
            'email'=>$this->request->getVar('email'),
            'noTelp'=>$this->request->getVar('noTelp'),
            'lapangan'=>$this->request->getVar('lapangan'),
            'tanggal'=>$this->request->getVar('tanggal'),
            'totalHarga'=>$this->request->getVar('totalHarga'),
            'tanggal_pesanan_dibuat'=> date('Y-m-d H:i:s'),
            'orderId'=>  $orderId,
            'metodePembayaran'=>$this->request->getVar('metodePembayaran'),
            'status'=>$this->request->getVar('status'),
        ];
        if(!$this->validate($rules)) return $this->fail($this->validator->getErrors());
        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $token ['token'] = $snapToken;
        $model = new OrderModel();
        $model->save($data);
        // $response = [
        //     'status'=>201,
        //     'error'=>null,
        //     'messages'=>[
        //         'success' => 'Data Inserted'
        //     ]
        // ];
        return $this->respond(['token'=> $snapToken]);
    }

    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $model = new OrderModel();
        $findById = $model->find(['id'=>$id]);
        if(!$findById) return $this->failNotFound('no data found');
        $model->delete($id);
        $response = [
            'status'=>200,
            'error'=>null,
            'messages'=>[
                'success' => 'Data Deleted'
            ]
        ];
        return $this->respond($response);
    }

    public function midtransNotif()
{
    $notif = new Notification();
    $model = new OrderModel();

    $transaction = $notif->transaction_status;
    $orderId = $notif->order_id;
    $paymentType = $notif->payment_type;
    $status = "";

    switch ($transaction) {
        case 'capture':
            $status = "paid";
            break;
        case 'settlement':
            $status = "paid";
            break;
        case 'pending':
            $status = "unpaid";
            break;
        case 'deny':
            $status = "unpaid";
            break;
        case 'expire':
            $status = "unpaid";
            break;
        case 'cancel':
            $status = "unpaid";
            break;
    }

    // Update status in BookingsModel
    if ($model->where('orderId', $orderId)->set(['metodePembayaran' => $paymentType, 'status' => $status])->update()) {
        return $this->respond(['message' => "Transaction status updated."]);
    } else {
        return $this->respond(['message' => "Failed to update transaction status."]);
    }
}

}
