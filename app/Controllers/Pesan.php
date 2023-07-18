<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PesanModel;

class Pesan extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    use ResponseTrait;
    public function index()
    {
        $model = new PesanModel();
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
        $model = new PesanModel();
        $data = $model->find(['id'=>$id]);
        if(!$data) return $this->failNotFound('no data found');
        return $this->respond($data[0]); 
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        helper(['form']);
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'noTelp' => 'required|numeric',
            'isiPesan' => 'required'
        ];
        $data = [
            'name'=>$this->request->getVar('name'),
            'email'=>$this->request->getVar('email'),
            'noTelp'=>$this->request->getVar('noTelp'),
            'isiPesan'=>$this->request->getVar('isiPesan'),
        ];
        if(!$this->validate($rules)) return $this->fail($this->validator->getErrors());
        $model = new PesanModel();
        $model->save($data);
        $response = [
            'status'=>201,
            'error'=>null,
            'messages'=>[
                'success' => 'Data Inserted'
            ]
        ];
        return $this->respondCreated($response);
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
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
        $model = new PesanModel();
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
