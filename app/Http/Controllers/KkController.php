<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $client = new Client();
        $url = "https://api-group8-prognet.manpits.xyz/api/kk";

        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        $data = $contentArray['data'];
        return view('kk.list', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kk.new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'nokk' => [
                'required',
                'unique:kk,nokk',
            ],
            'statusaktif' => 'required',
        ];

        $messages = [
            'nokk.unique' => 'No KK yang di-Inputkan sudah terdaftar',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect('kk/create')
                ->withErrors($validator)
                ->withInput();
        }

        $nokk = $request->nokk;
        $statusaktif = $request->statusaktif;

        $parameter = [
            'nokk' => $nokk,
            'statusaktif' => $statusaktif
        ];

        $client = new Client();
        $url = "https://api-group8-prognet.manpits.xyz/api/kk";

        $response = $client->request('POST', $url, [
            'headers' => ['Content-type' => 'application/json'],
            'body' => json_encode($parameter)
        ]);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if ($contentArray['status'] != true) {
            $error = $contentArray['data'];
            return redirect()->to('/kk/create')->withErrors($error)->withInput();
        } else {
            return redirect()->to('kk')->with('success', 'Berhasil memasukkan Data');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $client = new Client();
        $url = "https://api-group8-prognet.manpits.xyz/api/kk/$id";

        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if ($contentArray['status'] != true) {
            $error = $contentArray['message'];
            return redirect()->to('kk')->withErrors($error);
        } else {
            $data = $contentArray['data'];
            return view('kk.edit', ['data' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $nokk = $request->nokk;
        $statusaktif = $request->statusaktif;

        $parameter = [
            'nokk' => $nokk,
            'statusaktif' => $statusaktif
        ];

        $client = new Client();
        $url = "https://api-group8-prognet.manpits.xyz/api/kk/$id";
        $response = $client->request('PUT', $url, [
            'headers' => ['Content-type' => 'application/json'],
            'body' => json_encode($parameter)
        ]);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if ($contentArray['status'] != true) {
            $error = $contentArray['data'];
            return redirect()->to('/kk/{id}/edit')->withErrors($error)->withInput();
        } else {
            return redirect()->to('kk')->with('success', 'Berhasil melakukan Update Data');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $client = new Client();
        $url = "https://api-group8-prognet.manpits.xyz/api/kk/$id";

        $response = $client->request('DELETE', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if ($contentArray['status'] != true) {
            $error = $contentArray['data'];
            return redirect()->to('kk')->withErrors($error)->withInput();
        } else {
            return redirect()->to('kk')->with('success', 'Berhasil melakukan hapus Data');
        }
    }
}
