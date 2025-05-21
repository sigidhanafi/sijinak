<!--- Masih belum fix --->

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Register Akun | Sijinak</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/app.css" />
  <style>
    body {
      background-color: #f5f5f9;
      font-family: Arial, sans-serif;
    }
    .auth-wrapper {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }
    .auth-card {
      background-color: white;
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      max-width: 480px;
      width: 100%;
      text-align: center;
    }
    .app-brand-logo{
      -ms-flex-align: center;
      align-items: center;
      -ms-flex-pack: center;
      justify-content: center;
      display: -ms-flexbox;
      display: flex;
      width: 30px;
      height: 30px;
    }
    .sijinak-title {
      font-weight: bold;
      font-size: 1.5rem;
      margin-top: 0.5rem;
    }
    .register-subtitle {
      color: #6c757d;
      font-size: 1.1rem;
      margin-bottom: 1.5rem;
    }
    .btn-path {
      text-align: left;
      color: #
    }
  </style>
</head>
<body>
  <div class="auth-wrapper">
    <div class="auth-card">
      
      <!-- Logo Sijinak -->
      <!-- Logo Horizontal di Sebelah Kiri -->
      <div class="d-flex justify-content-center mb-4">
        <a href="/" class="d-flex align-items-center gap-2 text-decoration-none">
          <!-- Logo -->
          <span class="app-brand-logo">
            <img src="{{ asset('assets/img/favicon/favicon.ico') }}" alt="Logo" style="width: 40px; height: 40px;">
          </span>
          <!-- Teks -->
          <span class="app-brand-text h3 mb-0 fw-bold text-primary">Sijinak</span>
        </a>
      </div>

      <!-- Register -->
      <div class="register-subtitle">
      <h4 class="sijinak-title">Register</h4>


      <!-- Pilih Jalur -->
      <h5 class="text-start">Periode Jalur</h5>
      <div class="d-grid gap-2">
        <button class="btn btn-info btn-path">Profesi (Professional Degree)</button>
        <button class="btn btn-info btn-path">Pascasarjana (Graduate Degree)</button>
        <button class="btn btn-info btn-path">Sarjana (Undergraduate Degree)</button>
        <button class="btn btn-info btn-path">Tanpa Gelar (Non Degree)</button>
      </div>

      <!-- Tombol -->
      <div class="text-end mt-4">
        <a href="login.html" class="btn btn-success">Selanjutnya</a>
      </div>

    </div>
  </div>
</body>
</html>
