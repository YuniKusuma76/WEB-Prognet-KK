<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>iFamily Card - Agama</title>
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

  {{-- Start Form --}}
    <div class="main-content">
        <header>
            <h2>
                <label for="nav-toggle">
                    <span class="las la-bars"></span>
                </label> Dashboard
            </h2>
        </header>
    
        <main>
          <div class="card">
            <div class="card-header text-center">
              <h1>Form Anggota Kartu Keluarga</h1>
            </div>
            <div class="card-body">
              <form name="formAnggotakk" action="/anggotakk/simpan" method="post">
                @csrf
                <div class="form-group">
                  <label>No. KK</label>
                  <select name="kk_id" id="kk_id" class="form-control">
                      <option value="">-- Pilih --</option>
                      @foreach ($kkOptions as $kk)
                        <option value="{{ $kk['id'] }}">{{ $kk['nokk'] }}</option>
                      @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Penduduk</label>
                  <select name="penduduk_id" id="penduduk_id" class="form-control">
                      <option value="">-- Pilih --</option>
                      @foreach ($pendudukOptions as $penduduk)
                        <option value="{{ $penduduk['id'] }}">{{ $penduduk['nama'] }}</option>
                      @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Hubungan Keluarga</label>
                  <select name="hubungankk_id" id="hubungankk_id" class="form-control">
                      <option value="">-- Pilih --</option>
                      @foreach ($hubungankkOptions as $hubungankk)
                        <option value="{{ $hubungankk['id'] }}">{{ $hubungankk['hubungankk'] }}</option>
                      @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Status Aktif</label>
                  <select name="statusaktif" id="statusaktif" class="form-control">
                      <option value="">-- Pilih --</option>
                      <option value="Aktif">Aktif</option>
                      <option value="Tidak Aktif">Tidak Aktif</option>
                  </select>
                </div>
                  <div class="form-group">
                    <label>User</label>
                    <select name="user_id" id="user_id" class="form-control">
                        <option value="{{ auth()->user()->id }}">{{ auth()->user()->name }}</option>
                    </select>
                  </div>
                  <div>
                    <button type="submit" name="submit" class="btn btn-primary mb-4">Simpan</button>
                  </div>
              </form>
            </div>
          </div>
        </main>
    </div>
    {{-- End Form --}}
</body>
</html>