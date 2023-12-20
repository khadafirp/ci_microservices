<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Berita as ModelsBerita;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Files\File;
use Faker\Provider\Uuid;

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
            'data' => $model->orderBy('created_at', 'desc')->findAll()
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

        $statistikCont = new Statistik();
        $statistikCont->create($data['news_id'], $data['kategori_id']);

        return $this->respond([
            'status-code' => 200,
            'message' => 'sukses',
            'data' => $data
        ])->setStatusCode(200, 'OK');
    }

    public function create(){
        $model = new ModelsBerita;
        $uuid = Uuid::uuid();

        $validasi = $this->validate([
            'kategori_id' => 'required',
            'news_title' => 'required',
            'news_description' => 'required',
            'path' => [
                'label' => 'Image File',
                'rules' => [
                    'uploaded[path]',
                    'is_image[path]',
                    'mime_in[path,image/jpg,image/jpeg,image/png]',
                    'max_size[path,100]',
                    'max_dims[path,1024,768]',
                ],
            ],
        ]);

        if(!$validasi){
            return $this->respond([
                'status-code' => 500,
                'message' => 'Data tidak sesuai ketentuan.',
            ])->setStatusCode(500, 'Internal Server Error');
        }

        $post = $this->validator->getValidated();
        $img = $this->request->getFile('path');

        $filepath = WRITEPATH . 'uploads/foto';

        ['uploaded_fileinfo' => new File($filepath)];

        $img->move($filepath, $uuid . '.' . $img->getExtension());

        $model->set('kategori_id', $post['kategori_id']);
        $model->set('news_title', $post['news_title']);
        $model->set('news_description', $post['news_description'], true);
        $model->set('filename', $img->getName());
        $model->set('filesize', $img->getSize());
        $model->set('path', 'http://localhost:8080/foto/' . $img->getName());
        $model->insert();

        return $this->respond([
            'status-code' => 200,
            'message' => 'Data berhasil ditambahkan',
            'data' => $model->orderBy('news_id', 'desc')->first()
        ])->setStatusCode(200, 'OK');
    }

    public function edit(){
        $model = new ModelsBerita;
        $getData = $model->where('news_id', $this->request->getVar('news_id'))->first();
        $validasi = $this->validate([
            'kategori_id' => 'required',
            'news_title' => 'required',
            'news_description' => 'required',
            // 'path' => [
            //     'label' => 'Image File',
            //     'rules' => [
            //         'uploaded[path]',
            //         'is_image[path]',
            //         'mime_in[path,image/jpg,image/jpeg,image/png]',
            //         'max_size[path,100]',
            //         'max_dims[path,1024,768]',
            //     ],
            // ],
        ]);
        $uuid = Uuid::uuid();

        if($getData == null){
            return $this->respond([
                'status-code' => 404,
                'message' => 'Data tidak ditemukan.'
            ])->setStatusCode(404, 'Data is not found');
        }

        if(!$validasi){
            return $this->respond([
                'status-code' => 500,
                'message' => 'Data tidak sesuai ketentuan.'
            ])->setStatusCode(500, 'Internal Server Error');
        }

        $post = $this->validator->getValidated();
        $img = $this->request->getFile('path');

        $model->where('news_id', $getData['news_id'])->delete();

        if($img != null){
            $filepath = WRITEPATH . 'uploads/foto';

            ['uploaded_fileinfo' => new File($filepath)];

            $img->move($filepath, $uuid . '.' . $img->getExtension());

            $model->set('filename', $img->getName());
            $model->set('filesize', $img->getSize());
            $model->set('path', 'http://localhost:8080/foto/' . $img->getName());
        } else {
            $model->set('filename', $getData['filename']);
            $model->set('filesize', $getData['filesize']);
            $model->set('path', $getData['path']);
        }

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
        ])->setStatusCode(200, 'OK');
    }

    public function downloadFile($data){
        $download = $this->response->download(WRITEPATH . 'uploads/foto/' . $data, null);
        return $download;
    }
}
