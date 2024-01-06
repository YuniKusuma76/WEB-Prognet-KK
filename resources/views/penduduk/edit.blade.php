<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>iFamily Card - Mengedit Data Penduduk</title>
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
                <a href="/kk" onclick="return confirm('Apakah Anda Ingin Mengabaikan Perubahan ini?')"><span class="las la-film"></span>
                <span>Kartu Keluarga</span></a>
            </li>
            <li>
                <a href="/penduduk" onclick="return confirm('Apakah Anda Ingin Mengabaikan Perubahan ini?')" class="active"><span class="las la-users"></span>
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
              <h1>Form Agama</h1>
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
              <form name="formAgama" action="/penduduk/{{ $penduduk['id'] }}/update" method="post">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>NIK</label>
                    <input type="text" name="nik" id="nik" placeholder="NIK" class="form-control" 
                           value="{{ isset($penduduk['nik'])?$penduduk['nik']:old['nik'] }}" readonly>
                  </div>
                  <div class="form-group">
                    <label>Nama Penduduk</label>
                    <input type="text" name="nama" id="nama" placeholder="Nama Penduduk" class="form-control"
                           value="{{ isset($penduduk['nama'])?$penduduk['nama']:old['nama'] }}">
                  </div>
                  <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" name="alamat" id="alamat" placeholder="Alamat Penduduk" class="form-control" 
                           value="{{ isset($penduduk['alamat'])?$penduduk['alamat']:old['alamat'] }}">
                  </div>
                  <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="lahir" id="lahir" placeholder="Tanggal Lahir" class="form-control" lahir 
                           value="{{ isset($penduduk['lahir'])?$penduduk['lahir']:old['lahir'] }}">
                  </div>
                  <div class="form-group">
                    <label>Agama</label>
                    <select name="agama_id" required>
                        @foreach ($agamaOptions as $agama)
                            <option value="{{ $agama['id'] }}" {{ $penduduk['agama_id'] == $agama['id'] ? 'selected' : '' }}>
                                {{ $agama['agama'] }}
                            </option>
                        @endforeach
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