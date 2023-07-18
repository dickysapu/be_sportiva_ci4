<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\JadwalModel;

class Jadwal extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    use ResponseTrait;
    public function index()
    {
        $model = new JadwalModel();
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
        $model = new JadwalModel();
        $data = $model->find(['id'=>$id]);
        if(!$data) return $this->failNotFound('no data found');
        return $this->respond($data[0]); 
    }

    public function create()
    {
        helper(['form']);
        $rules = [
            'jam' => 'required',
            'status' => 'required'
        ];
        $data = [
            'jam'=>$this->request->getVar('jam'),
            'status'=>$this->request->getVar('status'),
        ];
        if(!$this->validate($rules)) return $this->fail($this->validator->getErrors());
        $model = new JadwalModel();
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

    public function update($id = null)
    {
        helper(['form']);
        $rules = [
            'jam' => 'required',
            'status' => 'required'
        ];
        $data = [
            'jam'=>$this->request->getVar('jam'),
            'status'=>$this->request->getVar('status'),
        ];
        if(!$this->validate($rules)) return $this->fail($this->validator->getErrors());
        $model = new JadwalModel();
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
        $model = new JadwalModel();
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
