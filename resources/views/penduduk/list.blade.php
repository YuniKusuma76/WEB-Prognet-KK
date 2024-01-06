<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Family Card - Penduduk</title>
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
                <a href="/kk"><span class="las la-film"></span>
                <span>Kartu Keluarga</span></a>
            </li>
            <li>
                <a href="/penduduk" class="active"><span class="las la-users"></span>
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
            <h1>Data Penduduk</h1>
            <table width=100% border=1>
              <tr class="thead">
                  <th>No</th>
                  <th>NIK</th>
                  <th>Nama Penduduk</th>
                  <th>Alamat</th>
                  <th>Tanggal Lahir</th>
                  <th>Agama</th>
                  <th>Action</th>
              </tr>

              <tr class="tbody">
                <form action="/penduduk/create" method="get">
                  <button type="submit" class="btn btn-success">Tambah Penduduk</button>
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
                @foreach ($dataPenduduk as $penduduk)
                  <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $penduduk['nik'] }}</td>
                    <td>{{ $penduduk['nama'] }}</td>
                    <td>{{ $penduduk['alamat'] }}</td>
                    <td>{{ $penduduk['lahir'] }}</td>
                    <td>{{ app('App\Http\Controllers\PendudukController')->getAgamaName($penduduk['agama_id'], $dataAgama) }}</td>
                    <td>
                      <form action="{{ url('/penduduk/'.$penduduk['id'].'/edit') }}">
                        <button class="btn btn-warning">Edit</button>
                      </form>
                      <form action="{{ url('/penduduk/'.$penduduk['id']) }}" method="POST" class="d-inline">
                        @method('delete')
                        @csrf
                        <button class="btn btn-danger" onclick="return confirm('Apa Anda yakin menghapus data ini?')">Delete</button>
                      </form>
                    </td>
                  </tr>
                  <?php $i++ ?>
                @endforeach
            </table>
          </div>
        </main>
    </div>
    {{-- End List --}}
</body>
</html>