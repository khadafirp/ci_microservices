<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Faker\Provider\Uuid;

class ThirdPartyController extends BaseController
{
    public function index($payload, $token)
    {
        $client = \Config\Services::curlrequest();
        $uuid = Uuid::uuid();

        $url = 'http://localhost:9200/catatan/_create/' . $uuid;

        $data = [
            'userid' => $payload['pengguna_id'],
            'nama' => $payload['nama_lengkap'],
            'token' => $token,
            'registered_at' => date("Y-m-d H:m:s"),
        ];

        $response = $client->request('POST', $url, ['json' => $data]);

        if ($response->getStatusCode() != 201) {
            echo 'Error: ' . $response->getStatusCode();
        }
    }
}
