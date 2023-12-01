<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Statistik as ModelStatistik;
use CodeIgniter\API\ResponseTrait;

class Statistik extends BaseController
{
    use ResponseTrait;

    public function showAll(){
        $model = new ModelStatistik();
        $data = $model->orderBy('statistik_id', 'desc')->findAll();
        
        try {
            return $this->respond([
                'status-code' => 200,
                'message' => 'success',
                'data' => $data
            ])->setStatusCode(200, 'success');
        } catch (\Throwable $th) {
            return $this->respond([
                'status-code' => $th->getCode(),
                'message' => $th->getMessage()
            ])->setStatusCode($th->getCode(), $th->getMessage());
        }
    }

    public function create($news_id, $kategori_id)
    {
        try{
            $model = new ModelStatistik();

            if($news_id === null && $kategori_id === null){
                return $this->respond([
                    'status-code' => 500,
                    'message' => 'Data harus diisi.'
                ])->setStatusCode(500, 'Internal Server Error');
            }

            $model->set('news_id', $news_id);
            $model->set('kategori_id', $kategori_id);
            $model->insert();
        } catch (\Throwable $th) {
            return $this->respond([
                'status-code' => $th->getCode(),
                'message' => $th->getMessage()
            ])->setStatusCode($th->getCode(), $th->getMessage());
        }
    }
}
