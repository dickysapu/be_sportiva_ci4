<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ProductModel;

class Product extends ResourceController
{
    
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    use ResponseTrait;
    public function index()
    {
        $model = new ProductModel();
        $data = $model->findAll();
        return $this->respond($data); 
        
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    // public function show($id = null)
    // {
    //     $model = new ProductModel();
    //     $data = $model->find(['id'=>$id]);
    //     if(!$data) return $this->failNotFound('no data found');
    //     return $this->respond($data[0]); 
    // }

    public function show($id = null)
{
    $model = new ProductModel();
    $data = $model->find(['id'=>$id]);
    if (!$data) {
        return $this->failNotFound('No data found');
    }
    
    $data[0]['gambar'] = $this->getFullImageUrl($data[0]['gambar']); // Memperoleh URL gambar yang valid

    return $this->respond($data[0]); 
}

private function getFullImageUrl($gambar)
{
    $baseUrl = 'http://localhost:8080'; // Ganti dengan URL server Anda
    $imageUrl = $baseUrl . 'public/uploads' . $gambar; // Ganti dengan path atau logika yang sesuai untuk membentuk URL gambar

    return $imageUrl;
}


    public function create()
{
    helper(['form']);
    $rules = [
        'name' => 'required',
        'harga' => 'required',
        'gambar' => 'uploaded[gambar]|max_size[gambar,1024]|is_image[gambar]',
    ];

    if (!$this->validate($rules)) {
        $errors = $this->validator->getErrors();
        return $this->fail($errors);
    }

    $gambar = $this->request->getFile('gambar');
    if ($gambar->isValid() && !$gambar->hasMoved()) {
        $newName = $gambar->getRandomName();
        $gambar->move(ROOTPATH . 'public/uploads', $newName);
    } else {
        return $this->fail('Gagal mengunggah gambar.');
    }

    $data = [
        'name' => $this->request->getVar('name'),
        'gambar' => $newName,
        'harga' => $this->request->getVar('harga'),
        'keterangan' => $this->request->getVar('keterangan'),
    ];

    $model = new ProductModel();
    $model->save($data);

    $response = [
        'status' => 201,
        'error' => null,
        'messages' => [
            'success' => 'Data Inserted'
        ]
    ];

    return $this->respondCreated($response);
}

public function update($id = null)
{
    helper(['form']);
    $rules = [
        'name' => 'required',
        'harga' => 'required'
    ];
    $data = [
        'name'=>$this->request->getVar('name'),
        'harga'=>$this->request->getVar('harga'),
        'keterangan'=>$this->request->getVar('keterangan'),
    ];
    if(!$this->validate($rules)) return $this->fail($this->validator->getErrors());
    $model = new ProductModel();
    $findById = $model->find(['id'=>$id]);
    if(!$findById) return $this->failNotFound('no data found');
    $model->update($id, $data);
    $response = [
        'status'=>200,
        'error'=>null,
        'messages'=>[
            'success' => 'Data Updated'
        ]
    ];
    return $this->respond($response);
}

/**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $model = new ProductModel();
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
}
