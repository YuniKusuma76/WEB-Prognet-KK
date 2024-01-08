<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class DetailsController extends Controller
{
    public function indexAnggotakk(string $id)
    {
        // Dapatkan data penduduk berdasarkan ID dari API
        $client = new Client();
        $urlKkId = "https://api-group8-prognet.manpits.xyz/api/kk/$id";
        $responseKkId = $client->request('GET', $urlKkId);
        $contentKkId = $responseKkId->getBody()->getContents();
        $kkId = json_decode($contentKkId, true)['data'];

        // Mendapatkan data Anggotakk
        $urlAnggotakk = "https://api-group8-prognet.manpits.xyz/api/anggotakk";
        $responseAnggotakk = $client->request('GET', $urlAnggotakk);
        $contentAnggotakk = $responseAnggotakk->getBody()->getContents();
        $contentArrayAnggotakk = json_decode($contentAnggotakk, true);
        $dataAnggotakk = $contentArrayAnggotakk['data'];

        // Mendapatkan data Kk
        $urlKk = "https://api-group8-prognet.manpits.xyz/api/kk";
        $responseKk = $client->request('GET', $urlKk);
        $contentKk = $responseKk->getBody()->getContents();
        $contentArrayKk = json_decode($contentKk, true);
        $dataKk = $contentArrayKk['data'];

        // Mendapatkan data penduduk
        $urlPenduduk = "https://api-group8-prognet.manpits.xyz/api/penduduk";
        $responsePenduduk = $client->request('GET', $urlPenduduk);
        $contentPenduduk = $responsePenduduk->getBody()->getContents();
        $contentArrayPenduduk = json_decode($contentPenduduk, true);
        $dataPenduduk = $contentArrayPenduduk['data'];

        // Mendapatkan data Hubungankk
        $urlHubungankk = "https://api-group8-prognet.manpits.xyz/api/hubungankk";
        $responseHubungankk = $client->request('GET', $urlHubungankk);
        $contentHubungank = $responseHubungankk->getBody()->getContents();
        $contentArrayHubungankk = json_decode($contentHubungank, true);
        $dataHubungankk = $contentArrayHubungankk['data'];

        // Mendapatkan data All User
        $urlAllUser = "https://api-group8-prognet.manpits.xyz/api/all-user";
        $responseAllUser = $client->request('GET', $urlAllUser);
        $contentAllUser = $responseAllUser->getBody()->getContents();
        $contentArrayAllUser = json_decode($contentAllUser, true);
        $dataAllUser = $contentArrayAllUser['data'];

        return view('anggotakk.list', [
            'kkId' => $kkId,
            'dataAnggotakk' => $dataAnggotakk,
            'dataKk' => $dataKk,
            'dataPenduduk' => $dataPenduduk,
            'dataHubungankk' => $dataHubungankk,
            'dataAllUser' => $dataAllUser,
        ]);
    }

    public function getNoKk($kkId, $dataKk)
    {
        // Cari agama berdasarkan agama_id
        $Kk = collect($dataKk)->where('id', $kkId)->first();

        // Return nama agama jika ditemukan, atau pesan kesalahan jika tidak
        return $Kk ? $Kk['nokk'] : 'no kk tidak ditemukan';
    }

    public function statusAktif($kkId, $dataKk)
    {
        // Cari agama berdasarkan agama_id
        $Kk = collect($dataKk)->where('id', $kkId)->first();

        // Return nama agama jika ditemukan, atau pesan kesalahan jika tidak
        return $Kk ? $Kk['statusaktif'] : 'statusaktif tidak ditemukan';
    }

    public function getNamaPenduduk($pendudukId, $dataPenduduk)
    {
        // Cari agama berdasarkan agama_id
        $penduduk = collect($dataPenduduk)->where('id', $pendudukId)->first();

        // Return nama agama jika ditemukan, atau pesan kesalahan jika tidak
        return $penduduk ? $penduduk['nama'] : 'nama penduduk tidak ditemukan';
    }

    public function getNamaKepalaKeluarga($kkId, $dataKk, $dataHubungankk, $dataPenduduk, $dataAnggotakk)
    {
        // Cari KK berdasarkan ID
        $kk = collect($dataKk)->where('id', $kkId)->first();

        // Jika KK ditemukan, cari kepala keluarga berdasarkan hubungan dan KK ID
        if ($kk) {
            $hubungankkIdKepalaKeluarga = collect($dataHubungankk)->where('hubungankk', 'Kepala Keluarga')->first()['id'];

            $kepalaKeluargaId = collect($dataAnggotakk)
                ->where('kk_id', $kkId)
                ->where('hubungankk_id', $hubungankkIdKepalaKeluarga)
                ->first()['penduduk_id'];

            // Cari nama penduduk berdasarkan ID
            $namaKepalaKeluarga = $this->getNamaPenduduk($kepalaKeluargaId, $dataPenduduk);

            return $namaKepalaKeluarga;
        } else {
            return 'KK tidak ditemukan';
        }
    }

    public function getAlamatKepalaKeluarga($kkId, $dataKk, $dataHubungankk, $dataPenduduk, $dataAnggotakk)
    {
        // Cari KK berdasarkan ID
        $kk = collect($dataKk)->where('id', $kkId)->first();

        // Jika KK ditemukan, cari kepala keluarga berdasarkan hubungan dan KK ID
        if ($kk) {
            $hubungankkIdKepalaKeluarga = collect($dataHubungankk)->where('hubungankk', 'Kepala Keluarga')->first()['id'];

            $kepalaKeluargaId = collect($dataAnggotakk)
                ->where('kk_id', $kkId)
                ->where('hubungankk_id', $hubungankkIdKepalaKeluarga)
                ->first()['penduduk_id'];

            // Cari alamat penduduk berdasarkan ID
            $alamatKepalaKeluarga = $this->getAlamatPenduduk($kepalaKeluargaId, $dataPenduduk);

            return $alamatKepalaKeluarga;
        } else {
            return 'KK tidak ditemukan';
        }
    }

    public function getAlamatPenduduk($pendudukId, $dataPenduduk)
    {
        // Cari alamat penduduk berdasarkan ID
        $penduduk = collect($dataPenduduk)->where('id', $pendudukId)->first();

        // Return alamat penduduk jika ditemukan, atau pesan kesalahan jika tidak
        return $penduduk ? $penduduk['alamat'] : 'alamat penduduk tidak ditemukan';
    }

    public function getNamaHubungankk($hubungankkId, $dataHubungankk)
    {
        // Cari agama berdasarkan agama_id
        $hubungankk = collect($dataHubungankk)->where('id', $hubungankkId)->first();

        // Return nama agama jika ditemukan, atau pesan kesalahan jika tidak
        return $hubungankk ? $hubungankk['hubungankk'] : 'hubungan tidak ditemukan';
    }

    public function getNamaUser($userId, $dataAllUser)
    {
        // Cari agama berdasarkan agama_id
        $allUser = collect($dataAllUser)->where('id', $userId)->first();

        // Return nama agama jika ditemukan, atau pesan kesalahan jika tidak
        return $allUser ? $allUser['name'] : 'user tidak ditemukan';
    }

    public function destroy(string $id)
    {
        $client = new Client();
        $url = "https://api-group8-prognet.manpits.xyz/api/anggotakk/$id";
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
