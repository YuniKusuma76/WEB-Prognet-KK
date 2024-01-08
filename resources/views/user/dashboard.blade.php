<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>iFamily Card - Dashboard</title>
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
                <a href="/dashboard" class="active"><span class="las la-home"></span>
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

  {{-- Start Home --}}
    <div class="main-content">
        <header>
            <h2>
                <label for="nav-toggle">
                    <span class="las la-bars"></span>
                </label> Dashboard
            </h2>
        </header>
    
        <main>
            <div class="cards">
                <div class="card-single">
                    <div>
                        <h1>Kartu Keluarga</h1>
                        <span>kartu identitas keluarga yang memuat data tentang nama, susunan dan hubungan dalam keluarga, serta identitas anggota keluarga.</span>
                    </div>
                    <div>
                        <span class="las la-film"></span>
                    </div>
                </div>
    
                <div class="card-single">
                    <div>
                        <h1>Tata Cara Pendaftaran KK</h1>
                        <span>Layanan pembuatan atau pengurusan KK saat ini dapat dilakukan secara langsung dengan mengunjungi Kantor Kelurahan Teknologi Informasi atau secara daring melalui website iFamilyCard</span>
                    </div>
                    <div>
                        <span class="las la-list"></span>
                    </div>
                </div>

            <div></div>

                <div class="card-single">
                    <div>
                        <h1>Syarat Daftar</h1>
                        <p><span>1. Kartu Tanda Penduduk/KTP</span></p>
                        <p><span>2. Akta Kelahiran</span></p>
                        <p><span>3. Surat Pengantar</span></p>
                        <p><span>4. Datang ke Kantor Kelurahan/Kunjungi website iFamilyCard</span></p>
                    </div>
                    <div>
                        <span class="las la-pen"></span>
                    </div>
                </div>
            </div>
    
            <div></div>

            <div class="card-single">
                <div>
                    <h1>iFamilyCard Service</h1>
                    <span>layanan informasi dan pendaftaran Kartu Keluarga terpadu berbasis website cerdas dan terakreditasi</span>
                </div>
                <div>
                    <span class="las la-info"></span>
                </div>
            </div>
        </main>
    </div>
    {{-- End Home --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if ($message = Session::get('success'))
    <script>
        Swal.fire({
            icon: "success",
            title: "{{ $message }}",
            showConfirmButton: false,
            timer: 1500
        });
    </script>
    @endif
</body>

</html>