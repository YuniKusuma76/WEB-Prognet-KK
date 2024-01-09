<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreateAnggotaController extends Controller
{
    public function formAnggotakk($kk_id)
    {
        $client = new Client();

        $urlKk = "https://api-group8-prognet.manpits.xyz/api/kk/{$kk_id}";
        $responseKk = $client->request('GET', $urlKk);
        $contentKk = $responseKk->getBody()->getContents();
        $kkData = json_decode($contentKk, true)['data'];

        $urlPenduduk = "https://api-group8-prognet.manpits.xyz/api/penduduk";
        $responsePenduduk = $client->request('GET', $urlPenduduk);
        $contentPenduduk = $responsePenduduk->getBody()->getContents();
        $pendudukOptions = json_decode($contentPenduduk, true)['data'];

        $urlHubungankk = "https://api-group8-prognet.manpits.xyz/api/hubungankk";
        $responseHubungankk = $client->request('GET', $urlHubungankk);
        $contentHubungankk = $responseHubungankk->getBody()->getContents();
        $hubungankkOptions = json_decode($contentHubungankk, true)['data'];

        return view('anggotakk.new', compact('kkData', 'pendudukOptions', 'hubungankkOptions'));
    }

    public function simpanAnggotakk(Request $request)
    {
        $kk_id = $request->kk_id;
        $penduduk_id = $request->penduduk_id;
        $hubungankk_id = $request->hubungankk_id;
        $statusaktif = $request->statusaktif;
        $user_id = $request->user_id;

        // Validasi NIK unique dalam nomor KK yang sama
        $existingAnggota = DB::table('anggotakk')
            ->where('kk_id', $kk_id)
            ->where('penduduk_id', $penduduk_id)
            ->first();

        if ($existingAnggota) {
            $error = 'NIK ini sudah terdaftar dalam nomor KK yang sama.';
            return redirect()->route('anggotakk', ['id' => $kk_id])->withErrors($error)->withInput();
        }

        $parameter = [
            'kk_id' => $kk_id,
            'penduduk_id' => $penduduk_id,
            'hubungankk_id' => $hubungankk_id,
            'statusaktif' => $statusaktif,
            'user_id' => $user_id,
        ];

        $client = new Client();
        $url = "https://api-group8-prognet.manpits.xyz/api/anggotakk";

        $response = $client->request('POST', $url, [
            'headers' => ['Content-type' => 'application/json'],
            'body' => json_encode($parameter)
        ]);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if ($contentArray['status'] != true) {
            $error = $contentArray['data'];
            return redirect()->route('anggotakk', ['id' => $kk_id])->withErrors($error)->withInput();
        } else {
            return redirect()->route('keluarga', ['id' => $kk_id])->with('success', 'Berhasil memasukkan Data, Silakan cek pada Anggota Kartu Keluarga');
        }
    }
}
