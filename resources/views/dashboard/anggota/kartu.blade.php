<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kartu Anggota</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      padding: 20px;
    }
    .card-header {
      display: flex;
      align-items: center;
      justify-content: flex-start; /* This line changes justification to flex-start */
    }
    .logo {
      max-width: 80px;
      max-height: 80px;
    }
    .member-image {
      max-width: 50px;
      max-height: 50px;
      border-radius: 50%;
      margin-left: auto; /* Add margin-left to move image to the right */
    }
    .card-title {
      flex-grow: 1;
      text-align: center;
      margin-bottom: 0;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div class="card">
          <div class="card-header">
            <img src="{{ asset('assets/img/smkn3palu.png') }}" class="logo" alt="Logo">
            <div class="title-container">
              <h5 class="card-title">Kartu Anggota Siperpus</h5>
            </div>
            <img src="{{ asset('storage/' . $anggota->gambar) }}" class="member-image" alt="{{ $anggota->nama_lengkap }}">
          </div>
          <div class="card-body">
            <p class="card-text"><strong>Nama:</strong> {{ $anggota->nama_lengkap }}</p>
            <p class="card-text"><strong>Kelas:</strong> {{ $anggota->kelas }}</p>
            <p class="card-text"><strong>Jurusan:</strong> {{ $anggota->jurusan }}</p>
            <p class="card-text"><strong>Alamat:</strong> {{ $anggota->alamat }}</p>
            <p class="card-text"><strong>Telepon:</strong> {{ $anggota->telepon }}</p>
            <p class="card-text"><strong>Email:</strong> {{ $anggota->email }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
