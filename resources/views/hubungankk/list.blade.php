<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>iFamily Card - Hubungan Kartu Keluarga</title>
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
                    <a href="/hubungankk" class="active"><span class="las la-heart"></span>
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
                <h1>Data Hubungan Kartu Keluarga</h1>
                <table width=100% border=1>
                    <tr class="thead">
                        <th>No</th>
                        <th>Hubungan Kartu Keluarga</th>
                        <th>Action</th>
                    </tr>

                    <tr class="tbody">
                        <form action="/hubungankk/create" method="get">
                            <button type="submit" class="btn btn-success">Tambah Hubungan KK</button>
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
                      @foreach ($data as $item)
                      <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $item['hubungankk'] }}</td>
                        <td>
                            <form action="{{ url('/hubungankk/'.$item['id'].'/edit') }}">
                              <button class="btn btn-warning">Edit</button>
                            </form>
                            <form action="{{ url('/hubungankk/'.$item['id']) }}" method="POST" class="d-inline">
                              @csrf
                              @method('delete')
                              <button class="btn btn-danger" onclick="return confirm('Apa Anda yakin menghapus data ini?')">Delete</button>
                            </form>
                        </td>
                      </tr>
                      <?php $i++ ?>
                      @endforeach
                    </tr>
                </table>
            </div>
        </main>
    </div>
    {{-- End List --}}
</body>
</html>