<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class AgamaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $client = new Client();
        $url = "https://api-group8-prognet.manpits.xyz/api/agama";

        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        $data = $contentArray['data'];
        return view('agama.list', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('agama.new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $agama = $request->agama;

        $parameter = [
            'agama' => $agama
        ];

        $client = new Client();
        $url = "https://api-group8-prognet.manpits.xyz/api/agama";

        $response = $client->request('POST', $url, [
            'headers' => ['Content-type' => 'application/json'],
            'body' => json_encode($parameter)
        ]);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if ($contentArray['status'] != true) {
            $error = $contentArray['data'];
            return redirect()->to('/agama/create')->withErrors($error)->withInput();
        } else {
            return redirect()->to('agama')->with('success', 'Berhasil memasukkan Data');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $client = new Client();
        $url = "https://api-group8-prognet.manpits.xyz/api/agama/$id";

        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if ($contentArray['status'] != true) {
            $error = $contentArray['message'];
            return redirect()->to('agama')->withErrors($error);
        } else {
            $data = $contentArray['data'];
            return view('agama.edit', ['data' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $agama = $request->agama;

        $parameter = [
            'agama' => $agama
        ];

        $client = new Client();
        $url = "https://api-group8-prognet.manpits.xyz/api/agama/$id";
        $response = $client->request('PUT', $url, [
            'headers' => ['Content-type' => 'application/json'],
            'body' => json_encode($parameter)
        ]);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if ($contentArray['status'] != true) {
            $error = $contentArray['data'];
            return redirect()->to('/agama/{id}/edit')->withErrors($error)->withInput();
        } else {
            return redirect()->to('agama')->with('success', 'Berhasil melakukan Update Data');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = new Client();
        $url = "https://api-group8-prognet.manpits.xyz/api/agama/$id";
        $response = $client->request('DELETE', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if ($contentArray['status'] != true) {
            $error = $contentArray['data'];
            return redirect()->to('agama')->withErrors($error)->withInput();
        } else {
            return redirect()->to('agama')->with('success', 'Berhasil melakukan hapus Data');
        }
    }
}
