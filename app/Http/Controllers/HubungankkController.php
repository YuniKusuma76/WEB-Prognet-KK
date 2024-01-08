<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HubungankkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $client = new Client();
        $url = "https://api-group8-prognet.manpits.xyz/api/hubungankk";

        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        $data = $contentArray['data'];
        return view('hubungankk.list', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hubungankk.new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'hubungankk' => [
                'required',
                'unique:hubungankk,hubungankk',
            ],
        ];

        $messages = [
            'hubungankk.unique' => 'Hubungan Kartu Keluarga yang di-Inputkan sudah terdaftar',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect('hubungankk/create')
                ->withErrors($validator)
                ->withInput();
        }

        $hubungankk = $request->hubungankk;

        $parameter = [
            'hubungankk' => $hubungankk
        ];

        $client = new Client();
        $url = "https://api-group8-prognet.manpits.xyz/api/hubungankk";

        $response = $client->request('POST', $url, [
            'headers' => ['Content-type' => 'application/json'],
            'body' => json_encode($parameter)
        ]);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if ($contentArray['status'] != true) {
            $error = $contentArray['data'];
            return redirect()->to('/hubungankk/create')->withErrors($error)->withInput();
        } else {
            return redirect()->to('hubungankk')->with('success', 'Berhasil memasukkan Data');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $client = new Client();
        $url = "https://api-group8-prognet.manpits.xyz/api/hubungankk/$id";

        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if ($contentArray['status'] != true) {
            $error = $contentArray['message'];
            return redirect()->to('hubungankk')->withErrors($error);
        } else {
            $data = $contentArray['data'];
            return view('hubungankk.edit', ['data' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $hubungankk = $request->hubungankk;

        $parameter = [
            'hubungankk' => $hubungankk
        ];

        $client = new Client();
        $url = "https://api-group8-prognet.manpits.xyz/api/hubungankk/$id";
        $response = $client->request('PUT', $url, [
            'headers' => ['Content-type' => 'application/json'],
            'body' => json_encode($parameter)
        ]);

        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if ($contentArray['status'] != true) {
            $error = $contentArray['data'];
            return redirect()->to('/hubungankk/{id}/edit')->withErrors($error)->withInput();
        } else {
            return redirect()->to('hubungankk')->with('success', 'Berhasil melakukan Update Data');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = new Client();
        $url = "https://api-group8-prognet.manpits.xyz/api/hubungankk/$id";

        // Lakukan query langsung ke database untuk mendapatkan data Hubungankk
        $hubungankkData = DB::table('hubungankk')->find($id);

        // Misalnya, jika ada tabel lain yang merujuk pada Hubungankk, lakukan pemeriksaan
        $relatedRecordCount = DB::table('anggotakk')->where('hubungankk_id', $id)->count();

        // Periksa apakah ada catatan terkait
        if ($relatedRecordCount > 0) {
            $error = "Data ini tidak dapat dihapus karena direferensikan di tabel lain";
            return redirect()->to('hubungankk')->withErrors($error)->withInput();
        }

        $response = $client->request('DELETE', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if ($contentArray['status'] != true) {
            $error = $contentArray['data'];
            return redirect()->to('hubungankk')->withErrors($error)->withInput();
        } else {
            return redirect()->to('hubungankk')->with('success', 'Berhasil melakukan hapus Data');
        }
    }
}
