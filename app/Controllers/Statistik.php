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

        $arr1 = array();
        $arr2 = array();
        $arr3 = array();
        $arr4 = array();

        for($i = 1; $i <= 12; $i++){
            $data1 = $model->where(['tahun' => date('Y'), 'bulan' => strval($i), 'kategori_id' => 1])->countAllResults();
            $data2 = $model->where(['tahun' => date('Y'), 'bulan' => strval($i), 'kategori_id' => 2])->countAllResults();
            $data3 = $model->where(['tahun' => date('Y'), 'bulan' => strval($i), 'kategori_id' => 3])->countAllResults();
            $data4 = $model->where(['tahun' => date('Y'), 'bulan' => strval($i), 'kategori_id' => 4])->countAllResults();
            array_push($arr1, $data1);
            array_push($arr2, $data2);
            array_push($arr3, $data3);
            array_push($arr4, $data4);
        }
        
        try {
            return $this->respond([
                'status-code' => 200,
                'message' => 'success',
                'data' => [
                    '1' => $arr1,
                    '2' => $arr2,
                    '3' => $arr3,
                    '4' => $arr4
                ]
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
            $model->set('tahun', date('Y'));
            $model->set('bulan', date('m'));
            $model->set('tanggal', date('d'));
            $model->insert();
        } catch (\Throwable $th) {
            return $this->respond([
                'status-code' => $th->getCode(),
                'message' => $th->getMessage()
            ])->setStatusCode($th->getCode(), $th->getMessage());
        }
    }
}
