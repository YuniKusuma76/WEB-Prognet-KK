<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>iFamily Card - Mengedit Data Anggota Kartu Keluarga</title>
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
                <a href="/dashboard" onclick="return confirm('Apakah Anda Ingin Mengabaikan Perubahan ini?')"><span class="las la-home"></span>
                <span>Home</span></a>
            </li>
            <li>
                <a href="/agama" onclick="return confirm('Apakah Anda Ingin Mengabaikan Perubahan ini?')"><span class="las la-book"></span>
                <span>Agama</span></a>
            </li>
            <li>
                <a href="/hubungankk" onclick="return confirm('Apakah Anda Ingin Mengabaikan Perubahan ini?')"><span class="las la-heart"></span>
                <span>Hubungan Keluarga</span></a>
            </li>
            <li>
                <a href="/kk" onclick="return confirm('Apakah Anda Ingin Mengabaikan Perubahan ini?')" class="active"><span class="las la-film"></span>
                <span>Kartu Keluarga</span></a>
            </li>
            <li>
                <a href="/penduduk" onclick="return confirm('Apakah Anda Ingin Mengabaikan Perubahan ini?')"><span class="las la-users"></span>
                <span>Penduduk</span></a>
            </li>
            <li>
                <a href="/logout" onclick="return confirm('Apakah Anda Ingin Mengabaikan Perubahan ini?')"><span class="las la-sign-out-alt"></span>
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
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
              <form name="formAgama" action="/anggotakk/{{ $anggotakk['id'] }}/update" method="post">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Kk ID</label>
                    <input type="text" name="kk_id" id="kk_id" class="form-control"
                           value="{{ isset($anggotakk['kk_id'])?$anggotakk['kk_id']:old['kk_id'] }}" readonly>
                </div>                                
                  <div class="form-group">
                      <label>Penduduk ID</label>
                        <select name="penduduk_id" id="penduduk_id" class="form-control">
                            <option value="">-- Pilih --</option>
                            @foreach ($pendudukOptions as $penduduk)
                            <option value="{{ $penduduk['id'] }}" {{ $anggotakk['penduduk_id'] == $penduduk['id'] ? 'selected' : '' }}>
                                {{ $penduduk['nama'] }}
                            </option>
                            @endforeach
                        </select>
                  </div>
                  <div class="form-group">
                      <label>Hubungan Kartu Keluarga ID</label>
                        <select name="hubungankk_id" id="hubungankk_id" class="form-control">
                            <option value="">-- Pilih --</option>
                            @foreach ($hubungankkOptions as $hubungankk)
                            <option value="{{ $hubungankk['id'] }}" {{ $anggotakk['hubungankk_id'] == $hubungankk['id'] ? 'selected' : '' }}>
                                {{ $hubungankk['hubungankk'] }}
                            </option>
                            @endforeach
                        </select>
                  </div>
                  <div class="form-group">
                      <label>Status Aktif</label>
                        <select name="statusaktif" id="statusaktif" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="Aktif" @if ($anggotakk['statusaktif'] == 'Aktif') selected @endif>Aktif</option>
                            <option value="Tidak Aktif" @if ($anggotakk['statusaktif'] == 'Tidak Aktif') selected @endif>Tidak Aktif</option>
                        </select>
                  </div>
                  <div class="form-group">
                      <label>User ID</label>
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