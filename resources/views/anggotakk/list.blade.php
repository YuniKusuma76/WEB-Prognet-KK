<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>iFamily Card - Anggota Kartu Keluarga</title>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="/css/style-header.css">
</head>

<body>
  {{-- Start Title Sidebar --}}
  <input type="checkbox" id="nav-toggle">
    <div class="sidebar">
      <div class="sidebar-brand">
        <h2>
          <span class="las la-smile"></span>
          <span>iFamilyCard</span>
        </h2>
      </div>
  {{-- End Title Sidebar --}}

  {{-- Start Sidebar --}}
    <div class="sidebar-menu">
        <ul>
            <li>
                <a href="/dashboard"><span class="las la-home"></span>
                <span>Home</span></a>
            </li>
            <li>
              <a href="/agama"><span class="las la-book"></span>
              <span>Agama</span></a>
          </li>
          <li>
              <a href="/hubungankk"><span class="las la-heart"></span>
              <span>Hubungan Keluarga</span></a>
          </li>
          <li>
              <a href="/kk" class="active"><span class="las la-film"></span>
              <span>Kartu Keluarga</span></a>
          </li>
          <li>
              <a href="/penduduk"><span class="las la-users"></span>
              <span>Penduduk</span></a>
          </li>
            <li>
                <a href="/logout"><span class="las la-sign-out-alt"></span>
                <span>Logout</span></a>
            </li>
        </ul>
    </div>
  </div>
  {{-- End Sidebar --}}

  {{-- Start List --}}
    <div class="main-content">
        <header>
            <h2>
                <label for="nav-toggle">
                    <span class="las la-bars"></span>
                </label> Dashboard
            </h2>
        </header>
    
        <main>
          <div class="container">
            <h1>Data Kartu Keluarga</h1>
            <div class="card-body mb-5">
              <table width=100%>
              @php
                $infoDisplayed = false;
              @endphp

              @foreach ($dataAnggotakk as $listAnggotakk)
                @if ($listAnggotakk['kk_id'] == $kkId['id'] && !$infoDisplayed)
                    <thead>
                        {{-- Kolom No KK --}}
                        <tr>
                            <td>No. Kartu Keluarga</td>
                            <td>: {{ app('App\Http\Controllers\DetailsController')->getNoKk($listAnggotakk['kk_id'], $dataKk) }}</td>
                        </tr>
                        {{-- Kolom Nama Kepala Keluarga --}}
                        <tr>
                            <td>Kepala Keluarga</td>
                            <td>: {{ app('App\Http\Controllers\DetailsController')->getNamaKepalaKeluarga($listAnggotakk['kk_id'], $dataKk, $dataHubungankk, $dataPenduduk, $dataAnggotakk) }}</td>
                        </tr>
                        {{-- Kolom Status Aktif KK --}}
                        <tr>
                            <td>Status Aktif</td>
                            <td>: {{ app('App\Http\Controllers\DetailsController')->statusAktif($listAnggotakk['kk_id'], $dataKk) }}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>: {{ app('App\Http\Controllers\DetailsController')->getAlamatKepalaKeluarga($listAnggotakk['kk_id'], $dataKk, $dataHubungankk, $dataPenduduk, $dataAnggotakk) }}</td>
                        </tr>
                    </thead>
                    @php
                    $infoDisplayed = true;
              @endphp
                @endif
              @endforeach
              </table>
            </div>

            <br>
            <hr><hr>
            <br>

            <h1>Daftar Anggota Kartu Keluarga</h1>
            <table width=100% border=1>
              <tr class="thead">
                  <th>No</th>
                  <th>No. KK</th>
                  <th>Nama Penduduk</th>
                  <th>Hubungan KK</th>
                  <th>Status Aktif</th>
                  <th>User ID</th>
                  <th>Action</th>
              </tr>
            
              <tr class="tbody">
                <form action="/anggotakk/create/{{ $kkId['id'] }}" method="get">
                  <button type="submit" class="btn btn-success">Tambah Anggotakk</button>
              </form>
                <form action="/kk">
                    <button type="submit" class="btn btn-primary">Kembali</button>
                  </form>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                    
                @if (session()->has('success'))
                  <div class="alert alert-success">
                      {{ session('success') }}
                  </div>
                @endif
                <?php $i = 1; ?>
                @foreach ($dataAnggotakk as $listAnggotakk)
                  @if ($listAnggotakk['kk_id'] == $kkId['id'])
                  <tr>
                    <td><?= $i++; ?></td>
                    <td>{{ app('App\Http\Controllers\DetailsController')->getNoKk($listAnggotakk['kk_id'], $dataKk) }}</td>
                    <td>{{ app('App\Http\Controllers\DetailsController')->getNamaPenduduk($listAnggotakk['penduduk_id'], $dataPenduduk) }}</td>
                    <td>{{ app('App\Http\Controllers\DetailsController')->getNamaHubungankk($listAnggotakk['hubungankk_id'], $dataHubungankk) }}</td>
                    <td>{{ $listAnggotakk['statusaktif'] }}</td>
                    <td>{{ app('App\Http\Controllers\DetailsController')->getNamaUser($listAnggotakk['user_id'], $dataAllUser) }}</td>
                    <td>
                        <form action="{{ url('/anggotakk/'.$listAnggotakk['id'].'/edit') }}">
                            <button class="btn btn-warning">Edit</button>
                        </form>
                        <form action="{{ url('/anggotakk/'.$listAnggotakk['id']) }}" method="POST" class="d-inline">
                            @method('delete')
                            @csrf
                            <button class="btn btn-danger" onclick="return confirm('Apa Anda yakin menghapus data ini?')">Delete</button>
                        </form>
                    </td>
                  </tr>
                  @endif
                @endforeach
            </table>
          </div>
        </main>
    </div>
    {{-- End List --}}
</body>
</html>