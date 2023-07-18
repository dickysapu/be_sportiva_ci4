<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\AkunModel;
class Akun extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $model = new AkunModel();
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
        $model = new AkunModel();
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
            'username' => 'required',
            'password' => 'required'
        ];
        $data = [
            'jam'=>$this->request->getVar('username'),
            'status'=>$this->request->getVar('password'),
        ];
        if(!$this->validate($rules)) return $this->fail($this->validator->getErrors());
        $model = new AkunModel();
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
        //
    }
}
