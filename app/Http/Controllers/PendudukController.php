<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PendudukController extends Controller
{
    public function indexPenduduk()
    {
        $client = new Client();

        // Mendapatkan data penduduk
        $urlPenduduk = "https://api-group8-prognet.manpits.xyz/api/penduduk";
        $responsePenduduk = $client->request('GET', $urlPenduduk);
        $contentPenduduk = $responsePenduduk->getBody()->getContents();
        $contentArrayPenduduk = json_decode($contentPenduduk, true);
        $dataPenduduk = $contentArrayPenduduk['data'];

        // Mendapatkan data agama
        $urlAgama = "https://api-group8-prognet.manpits.xyz/api/agama";
        $responseAgama = $client->request('GET', $urlAgama);
        $contentAgama = $responseAgama->getBody()->getContents();
        $contentArrayAgama = json_decode($contentAgama, true);
        $dataAgama = $contentArrayAgama['data'];

        // Mengirimkan data ke tampilan Blade
        return view('penduduk.list', ['dataPenduduk' => $dataPenduduk, 'dataAgama' => $dataAgama]);
    }

    public function getAgamaName($agamaId, $dataAgama)
    {
        // Cari agama berdasarkan agama_id
        $agama = collect($dataAgama)->where('id', $agamaId)->first();

        // Return nama agama jika ditemukan, atau pesan kesalahan jika tidak
        return $agama ? $agama['agama'] : 'Agama tidak ditemukan';
    }

    public function formPenduduk()
    {
        $client = new Client();
        $urlAgama = "https://api-group8-prognet.manpits.xyz/api/agama";
        $responseAgama = $client->request('GET', $urlAgama);
        $contentAgama = $responseAgama->getBody()->getContents();
        $agamaOptions = json_decode($contentAgama, true)['data'];

        return view('penduduk.new', compact('agamaOptions'));
    }

    public function simpanPenduduk(Request $request)
    {
        $rules = [
            'nik' => [
                'required',
                'unique:penduduk,nik',
            ],
            'nama' => 'required',
            'alamat' => 'required',
            'lahir' => 'required',
            'agama_id' => 'required',
        ];

        $messages = [
            'nik.unique' => 'Nik ini yang di-Inputkan sudah terdaftar',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect('penduduk/create')
                ->withErrors($validator)
                ->withInput();
        }

        $nik = $request->nik;
        $nama = $request->nama;
        $alamat = $request->alamat;
        $lahir = $request->lahir;
        $agama_id = $request->agama_id;

        $parameter = [
            'nik' => $nik,
            'nama' => $nama,
            'alamat' => $alamat,
            'lahir' => $lahir,
            'agama_id' => $agama_id,
        ];

        $client = new Client();
        $url = "https://api-group8-prognet.manpits.xyz/api/penduduk";

        $response = $client->request('POST', $url, [
            'headers' => ['Content-type' => 'application/json'],
            'body' => json_encode($parameter)
        ]);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if ($contentArray['status'] != true) {
            $error = $contentArray['data'];
            return redirect()->to('/penduduk/create')->withErrors($error)->withInput();
        } else {
            return redirect()->to('penduduk')->with('success', 'Berhasil memasukkan Data');
        }
    }

    public function editPenduduk(string $id)
    {
        // Dapatkan data penduduk berdasarkan ID dari API
        $client = new Client();
        $url = "https://api-group8-prognet.manpits.xyz/api/penduduk/$id";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $penduduk = json_decode($content, true)['data'];

        // Dapatkan juga opsi Agama dari API
        $urlAgama = "https://api-group8-prognet.manpits.xyz/api/agama";
        $responseAgama = $client->request('GET', $urlAgama);
        $contentAgama = $responseAgama->getBody()->getContents();
        $agamaOptions = json_decode($contentAgama, true)['data'];

        return view('penduduk.edit', compact('penduduk', 'agamaOptions'));
    }

    public function updatePenduduk(Request $request, string $id)
    {
        $nik = $request->nik;
        $nama = $request->nama;
        $alamat = $request->alamat;
        $lahir = $request->lahir;
        $agama_id = $request->agama_id;

        $parameter = [
            'nik' => $nik,
            'nama' => $nama,
            'alamat' => $alamat,
            'lahir' => $lahir,
            'agama_id' => $agama_id
        ];

        $client = new Client();
        $url = "https://api-group8-prognet.manpits.xyz/api/penduduk/$id";
        $response = $client->request('PUT', $url, [
            'headers' => ['Content-type' => 'application/json'],
            'body' => json_encode($parameter)
        ]);

        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if ($contentArray['status'] != true) {
            $error = $contentArray['data'];
            return redirect()->to("/penduduk/$id/edit")->withErrors($error)->withInput();
        } else {
            return redirect()->to('penduduk')->with('success', 'Berhasil melakukan Update Data');
        }
    }

    public function destroy(string $id)
    {
        $client = new Client();
        $url = "https://api-group8-prognet.manpits.xyz/api/penduduk/$id";
        $response = $client->request('DELETE', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if ($contentArray['status'] != true) {
            $error = $contentArray['data'];
            return redirect()->to('penduduk')->withErrors($error)->withInput();
        } else {
            return redirect()->to('penduduk')->with('success', 'Berhasil melakukan hapus Data');
        }
    }
}
