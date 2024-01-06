<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

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
