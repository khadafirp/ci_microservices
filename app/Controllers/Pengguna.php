<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ListToken;
use App\Models\Pengguna as PenggunaModel;
use CodeIgniter\API\ResponseTrait;
use Faker\Provider\Uuid;
use Firebase\JWT\JWT;

class Pengguna extends BaseController
{
    use ResponseTrait;
    public function daftar()
    {
        $validasi = $this->validate([
            'email' => 'required',
            'password' => 'required',
            'nama_lengkap' => 'required'
        ]);

        if(!$validasi){
            return $this->respond([
                'status-code' => 500,
                'message' => 'Data harus diisi.'
            ])->setStatusCode(500, 'Internal Server Error');
        }

        $post = $this->validator->getValidated();
        $data = new PenggunaModel;
        $data->set('email', $post['email']);
        $data->set('password', $post['password']);
        $data->set('nama_lengkap', $post['nama_lengkap']);
        $data->insert();

        return $this->respond([
            'status-code' => 200,
            'message' => 'Data berhasil ditambahkan',
            'data' => $data->orderBy('pengguna_id', 'desc')->first()
        ])->setStatusCode(200, 'OK');
    }

    public function masuk(){
        $userModel = new PenggunaModel;
  
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
          
        $user = $userModel->where(['email' => $email, 'password' => $password])->first();
  
        if(is_null($user)) {
            return $this->respond(['error' => 'Invalid username or password.'], 401);
        }
 
        $key = 'Kh@dafiR0hm@nPr1h@nda';
        $iat = time(); // current timestamp value
        $exp = $iat + (24 * 60 * 60 * 1000);
 
        $payload = array(
            "iss" => "Issuer of the JWT",
            "aud" => "Audience that the JWT",
            "sub" => "Subject of the JWT",
            "iat" => $iat, //Time the JWT issued at
            "exp" => $exp, // Expiration time of token
            "email" => $user['email'],
        );
         
        $token = JWT::encode($payload, $key, 'HS256');

        $putToken = new ListToken;
        $putToken->set('pengguna_id', $user['pengguna_id']);
        $putToken->set('token', $token);
        $putToken->set('exp_time', strval($iat));
        $putToken->insert();
 
        $response = [
            'status-code' => 200,
            'message' => 'Login Succesful',
            'token' => $token,
            'data' => $user
        ];
         
        return $this->respond($response)->setStatusCode(200, 'OK');
    }

    public function getData(){
        $dataPenguna = new PenggunaModel;
        $getDataPengguna = $dataPenguna->where(['email' => $this->request->getVar('email'), 'password' => $this->request->getVar('password')])->first();

        if(is_null($getDataPengguna)) {
            return $this->respond(['error' => 'Invalid username or password.'], 401);
        }

        $getToken = new ListToken;
        $getDataToken = $getToken->where(['pengguna_id' => $getDataPengguna['pengguna_id']])->orderBy('created_at', 'desc')->first();

        if(is_null($getDataToken)){
            return $this->respond([
                'status-code' => 404,
                'message' => 'Data tidak ditemukan'
            ], 404, 'Data is not found');
        }

        return $this->respond([
            'status-code' => 200,
            'message' => 'sukses',
            'token' => $getDataToken['token'],
            'data' => $getDataPengguna
        ])->setStatusCode(200, 'OK');
    }
}
