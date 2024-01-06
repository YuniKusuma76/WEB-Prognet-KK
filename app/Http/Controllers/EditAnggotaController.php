<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class EditAnggotaController extends Controller
{

    public function editAnggotakk(string $id)
    {
        // Dapatkan data anggotakk berdasarkan ID dari API
        $client = new Client();
        $url = "https://api-group8-prognet.manpits.xyz/api/anggotakk/$id";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $anggotakk = json_decode($content, true)['data'];

        $url = "https://api-group8-prognet.manpits.xyz/api/kk/$id";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $kk = json_decode($content, true);

        $urlPenduduk = "https://api-group8-prognet.manpits.xyz/api/penduduk";
        $responsePenduduk = $client->request('GET', $urlPenduduk);
        $contentPenduduk = $responsePenduduk->getBody()->getContents();
        $pendudukOptions = json_decode($contentPenduduk, true)['data'];

        $urlHubungankk = "https://api-group8-prognet.manpits.xyz/api/hubungankk";
        $responseHubungankk = $client->request('GET', $urlHubungankk);
        $contentHubungankk = $responseHubungankk->getBody()->getContents();
        $hubungankkOptions = json_decode($contentHubungankk, true)['data'];


        return view('anggotakk.edit', compact('anggotakk', 'kk', 'pendudukOptions', 'hubungankkOptions'));
    }

    public function updateAnggotakk(Request $request, string $id)
    {
        $kk_id = $request->kk_id;
        $penduduk_id = $request->penduduk_id;
        $hubungankk_id = $request->hubungankk_id;
        $statusaktif = $request->statusaktif;
        $user_id = $request->user_id;

        $parameter = [
            'kk_id' => $kk_id,
            'penduduk_id' => $penduduk_id,
            'hubungankk_id' => $hubungankk_id,
            'statusaktif' => $statusaktif,
            'user_id' => $user_id
        ];

        $client = new Client();
        $url = "https://api-group8-prognet.manpits.xyz/api/anggotakk/$id";
        $response = $client->request('PUT', $url, [
            'headers' => ['Content-type' => 'application/json'],
            'body' => json_encode($parameter)
        ]);

        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if ($contentArray['status'] != true) {
            $error = $contentArray['data'];
            return redirect()->to("/anggotakk/$id/edit")->withErrors($error)->withInput();
        } else {
            return redirect()->to('kk')->with('success', 'Berhasil melakukan Update Data, Silakan cek pada Anggota Kartu Keluarga');
        }
    }
}
