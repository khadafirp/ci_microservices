<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Berita as ModelsBerita;
use CodeIgniter\API\ResponseTrait;

use function PHPUnit\Framework\isEmpty;

class Berita extends BaseController
{
    use ResponseTrait;

    public function show()
    {
        $model = new ModelsBerita;
        
        return $this->respond([
            'status-code' => 200,
            'message' => 'success',
            'data' => $model->findAll()
        ])->setStatusCode(200, 'OK');
        
    }

    public function filter(){
        $model = new ModelsBerita;

        $data = $model->where('news_id', $this->request->getVar('news_id'))->first();
        if (empty($data)) {
            return $this->respond([
                'status-code' => 404,
                'message' => 'Data tidak ditemukan'
            ])->setStatusCode(404, 'Data is not found');
        }

        return $this->respond([
            'status-code' => 200,
            'message' => 'sukses',
            'data' => $data
        ])->setStatusCode(200, 'OK');
    }

    public function create(){
        $model = new ModelsBerita;

        $validasi = $this->validate([
            'kategori_id' => 'required',
            'news_title' => 'required',
            'news_description' => 'required'
        ]);

        if(!$validasi){
            return $this->respond([
                'status-code' => 500,
                'message' => 'Data harus diisi.',
            ])->setStatusCode(500, 'Internal Server Error');
        }

        $post = $this->validator->getValidated();

        $model->set('kategori_id', $post['kategori_id']);
        $model->set('news_title', $post['news_title']);
        $model->set('news_description', $post['news_description'], true);
        $model->insert();

        return $this->respondCreated([
            'statusCode' => 200,
            'message' => 'Data berhasil ditambahkan',
            'data' => $model->orderBy('news_id', 'desc')->first()
        ]);
    }

    public function edit(){
        $model = new ModelsBerita;
        $getData = $model->where('news_id', $this->request->getVar('news_id'))->first();
        $validasi = $this->validate([
            'kategori_id' => 'required',
            'news_title' => 'required',
            'news_description' => 'required',
        ]);

        if($getData == null){
            return $this->respond([
                'status-code' => 404,
                'message' => 'Data tidak ditemukan.'
            ])->setStatusCode(404, 'Data is not found');
        }

        if(!$validasi){
            return $this->respond([
                'status-code' => 500,
                'message' => 'Data harus diisi.'
            ])->setStatusCode(500, 'Internal Server Error');
        }

        $post = $this->validator->getValidated();

        $model->where('news_id', $getData['news_id'])->delete();

        $model->set('news_id', $getData['news_id']);
        $model->set('kategori_id', $post['kategori_id']);
        $model->set('news_title', $post['news_title']);
        $model->set('news_description', $post['news_description']);
        $model->set('created_at', $getData['created_at']);
        $model->set('updated_at', date("Y-m-d H:i:s"));
        $model->insert();

        return $this->respond([
            'status-code' => 200,
            'message' => 'Data berhasil diperbaharui.',
            'data' => $model->where('news_id', $getData['news_id'])->first()
        ]);
    }

    public function delete(){
        $model = new ModelsBerita;
        $data = $model->where('news_id', $this->request->getVar('news_id')); 
        
        if($data->first() == null){
            return $this->respond([
                'status-code' => 404,
                'message' => 'Data tidak ditemukan'
            ])->setStatusCode(404, 'Data is not found');
        }

        $dataa = $model->where('news_id', $this->request->getVar('news_id')); 
        $dataa->delete();

        return $this->respond([
            'status-code' => 200,
            'message' => 'Data berhasil dihapus',
        ]);
    }
}
