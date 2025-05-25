<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-wide customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../../assets/"
  data-template="vertical-menu-template">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Registrasi | Sijinak</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/typeahead-js/typeahead.css" />
    <!-- Vendor -->
    <link rel="stylesheet" href="../../assets/vendor/libs/bs-stepper/bs-stepper.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/bootstrap-select/bootstrap-select.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/@form-validation/umd/styles/index.min.css" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="../../assets/vendor/css/pages/page-auth.css" />

    <!-- Helpers -->
    <script src="../../assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="../../assets/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../../assets/js/config.js"></script>
    <style>
      .custom-option-content-simple {
        padding: 1rem;
        border: 1px solid #d9dee3;
        border-radius: 0.375rem;
        text-align: center;
        transition: all 0.2s ease-in-out;
        background-color: #03c3ec;
        color: #fff;
      }
      .custom-option-content-simple:hover {
        border-color: #03a9f4;
        background-color: #03a9f4;
      }
      .form-check-input:checked + .custom-option-content-simple {
        border-color: #5a8dee !important;
        background-color: #5a8dee !important;
        box-shadow: 0 0 0 0.2rem rgba(90, 141, 238, 0.25);
      }
      .custom-option-title {
        font-weight: 500;
      }
      /* Ensure validation messages are visible */
      .fv-plugins-message-container {
        font-size: 0.875em;
        margin-top: 0.25rem;
      }
    </style>
  </head>

  <body>
    <!-- Content -->
    <div class="authentication-wrapper authentication-cover">
      <div class="authentication-inner row m-0">
        <!-- Left Text -->
        <div class="d-none d-lg-flex col-lg-4 align-items-center justify-content-end p-5 pe-0">
          <div class="w-px-400">
            <img
              src="../../assets/img/illustrations/create-account-light.png"
              class="img-fluid scaleX-n1-rtl"
              alt="multi-steps"
              width="600"
              data-app-light-img="illustrations/create-account-light.png"
              data-app-dark-img="illustrations/create-account-dark.png" />
          </div>
        </div>
        <!-- /Left Text -->

        <!--  Multi Steps Registration -->
        <div class="d-flex col-lg-8 authentication-bg p-sm-5 p-3 justify-content-center">
          <div class="d-flex flex-column w-px-700">
            <!-- Logo -->
            <div class="app-brand border-bottom mx-3 mb-4">
              <a href="index.html" class="app-brand-link gap-2 mb-3">
                <span class="app-brand-logo demo">
                  <svg
                    width="26px"
                    height="26px"
                    viewBox="0 0 26 26"
                    version="1.1"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink">
                    <title>icon</title>
                    <defs>
                      <linearGradient x1="50%" y1="0%" x2="50%" y2="100%" id="linearGradient-1">
                        <stop stop-color="#5A8DEE" offset="0%"></stop>
                        <stop stop-color="#699AF9" offset="100%"></stop>
                      </linearGradient>
                      <linearGradient x1="0%" y1="0%" x2="100%" y2="100%" id="linearGradient-2">
                        <stop stop-color="#FDAC41" offset="0%"></stop>
                        <stop stop-color="#E38100" offset="100%"></stop>
                      </linearGradient>
                    </defs>
                    <g id="Pages" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                      <g id="Login---V2" transform="translate(-667.000000, -290.000000)">
                        <g id="Login" transform="translate(519.000000, 244.000000)">
                          <g id="Logo" transform="translate(148.000000, 42.000000)">
                            <g id="icon" transform="translate(0.000000, 4.000000)">
                              <path
                                d="M13.8863636,4.72727273 C18.9447899,4.72727273 23.0454545,8.82793741 23.0454545,13.8863636 C23.0454545,18.9447899 18.9447899,23.0454545 13.8863636,23.0454545 C8.82793741,23.0454545 4.72727273,18.9447899 4.72727273,13.8863636 C4.72727273,13.5423509 4.74623858,13.2027679 4.78318172,12.8686032 L8.54810407,12.8689442 C8.48567157,13.19852 8.45300462,13.5386269 8.45300462,13.8863636 C8.45300462,16.887125 10.8856023,19.3197227 13.8863636,19.3197227 C16.887125,19.3197227 19.3197227,16.887125 19.3197227,13.8863636 C19.3197227,10.8856023 16.887125,8.45300462 13.8863636,8.45300462 C13.5386269,8.45300462 13.19852,8.48567157 12.8689442,8.54810407 L12.8686032,4.78318172 C13.2027679,4.74623858 13.5423509,4.72727273 13.8863636,4.72727273 Z"
                                id="Combined-Shape"
                                fill="#4880EA"></path>
                              <path
                                d="M13.5909091,1.77272727 C20.4442608,1.77272727 26,7.19618701 26,13.8863636 C26,20.5765403 20.4442608,26 13.5909091,26 C6.73755742,26 1.18181818,20.5765403 1.18181818,13.8863636 C1.18181818,13.540626 1.19665566,13.1982714 1.22574292,12.8598734 L6.30410592,12.859962 C6.25499466,13.1951893 6.22958398,13.5378796 6.22958398,13.8863636 C6.22958398,17.8551125 9.52536149,21.0724191 13.5909091,21.0724191 C17.6564567,21.0724191 20.9522342,17.8551125 20.9522342,13.8863636 C20.9522342,9.91761479 17.6564567,6.70030817 13.5909091,6.70030817 C13.2336969,6.70030817 12.8824272,6.72514561 12.5388136,6.77314791 L12.5392575,1.81561642 C12.8859498,1.78721495 13.2366963,1.77272727 13.5909091,1.77272727 Z"
                                id="Combined-Shape2"
                                fill="url(#linearGradient-1)"></path>
                              <rect
                                id="Rectangle"
                                fill="url(#linearGradient-2)"
                                x="0"
                                y="0"
                                width="7.68181818"
                                height="7.68181818"></rect>
                            </g>
                          </g>
                        </g>
                      </g>
                    </g>
                  </svg>
                </span>
                <span class="app-brand-text demo h3 mb-0 fw-bold">Sijinak</span>
              </a>
            </div>
            <!-- /Logo -->

            <div class="my-auto">
              <div id="multiStepsValidation" class="bs-stepper shadow-none">
                <div class="bs-stepper-header">
                  <div class="step" data-target="#selectRoleStep">
                    <button type="button" class="step-trigger">
                      <span class="bs-stepper-circle">
                        <i class="bx bx-user-check"></i>
                      </span>
                      <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Pilih Role</span>
                        <span class="bs-stepper-subtitle">Tentukan peran Anda</span>
                      </span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#personalInfoValidation">
                    <button type="button" class="step-trigger">
                      <span class="bs-stepper-circle">
                        <i class="bx bx-user"></i>
                      </span>
                      <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Informasi Akun & Personal</span>
                        <span class="bs-stepper-subtitle">Lengkapi data diri</span>
                      </span>
                    </button>
                  </div>
                </div>
                <div class="bs-stepper-content pt-4">
                  <form id="multiStepsForm" onSubmit="return false;">
                    <!-- Select Role Step -->
                    <div id="selectRoleStep" class="content">
                      <div class="content-header mb-4">
                        <h4>Pilih Role Anda</h4>
                        <span>Klik pada salah satu role di bawah ini.</span>
                      </div>
                      <div class="row gy-3">
                        <div class="col-12">
                           <div class="form-check custom-option custom-option-icon">
                            <label class="form-check-label custom-option-content custom-option-content-simple" for="roleGuru">
                              <span class="custom-option-body">
                                <span class="custom-option-title fs-4">Guru</span>
                              </span>
                              <input name="selectedRole" class="form-check-input" type="radio" value="guru" id="roleGuru" checked/>
                            </label>
                          </div>
                        </div>
                        <div class="col-12">
                           <div class="form-check custom-option custom-option-icon">
                            <label class="form-check-label custom-option-content custom-option-content-simple" for="roleGuruPiket">
                              <span class="custom-option-body">
                                <span class="custom-option-title fs-4">GuruPiket(?)</span>
                              </span>
                              <input name="selectedRole" class="form-check-input" type="radio" value="guru_piket" id="roleGuruPiket" />
                            </label>
                          </div>
                        </div>
                        <div class="col-12">
                           <div class="form-check custom-option custom-option-icon">
                            <label class="form-check-label custom-option-content custom-option-content-simple" for="roleSiswa">
                              <span class="custom-option-body">
                                <span class="custom-option-title fs-4">Siswa</span>
                              </span>
                              <input name="selectedRole" class="form-check-input" type="radio" value="siswa" id="roleSiswa" />
                            </label>
                          </div>
                        </div>
                         <div class="col-12">
                           <div class="form-check custom-option custom-option-icon">
                            <label class="form-check-label custom-option-content custom-option-content-simple" for="roleWaliMurid">
                              <span class="custom-option-body">
                                <span class="custom-option-title fs-4">Wali Murid</span>
                              </span>
                              <input name="selectedRole" class="form-check-input" type="radio" value="wali_murid" id="roleWaliMurid" />
                            </label>
                          </div>
                        </div>
                        <!-- Container untuk pesan error validasi role -->
                        <div class="col-12 fv-plugins-message-container">
                            <div data-field="selectedRole" data-validator="notEmpty"></div>
                        </div>
                      </div>
                      <div class="col-12 d-flex justify-content-between mt-4">
                        <button class="btn btn-label-secondary btn-prev" disabled>
                          <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                          <span class="d-sm-inline-block d-none">Previous</span>
                        </button>
                        <button class="btn btn-primary btn-next">
                          <span class="d-sm-inline-block d-none me-sm-1 me-0">Next</span>
                          <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                        </button>
                      </div>
                    </div>

                    <!-- Personal Info & Account Details -->
                    <div id="personalInfoValidation" class="content">
                      <div class="content-header mb-3">
                        <h4>Informasi Akun & Personal</h4>
                        <span>Lengkapi data akun dan informasi personal Anda.</span>
                      </div>
                      <div class="row g-3">
                        <div class="col-sm-6">
                          <label class="form-label" for="multiStepsUsername">Username</label>
                          <input type="text" name="multiStepsUsername" id="multiStepsUsername" class="form-control" placeholder="johndoe" />
                        </div>
                        <div class="col-sm-6">
                          <label class="form-label" for="multiStepsEmail">Email</label>
                          <input type="email" name="multiStepsEmail" id="multiStepsEmail" class="form-control" placeholder="john.doe@email.com" aria-label="john.doe" />
                        </div>
                        <div class="col-sm-6 form-password-toggle">
                          <label class="form-label" for="multiStepsPass">Password</label>
                          <div class="input-group input-group-merge">
                            <input type="password" id="multiStepsPass" name="multiStepsPass" class="form-control" placeholder="············" aria-describedby="multiStepsPass2" />
                            <span class="input-group-text cursor-pointer" id="multiStepsPass2"><i class="bx bx-hide"></i></span>
                          </div>
                        </div>
                        <div class="col-sm-6 form-password-toggle">
                          <label class="form-label" for="multiStepsConfirmPass">Confirm Password</label>
                          <div class="input-group input-group-merge">
                            <input type="password" id="multiStepsConfirmPass" name="multiStepsConfirmPass" class="form-control" placeholder="············" aria-describedby="multiStepsConfirmPass2" />
                            <span class="input-group-text cursor-pointer" id="multiStepsConfirmPass2"><i class="bx bx-hide"></i></span>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <label class="form-label" for="multiStepsURL">Profile Link (Opsional)</label>
                          <input type="text" name="multiStepsURL" id="multiStepsURL" class="form-control" placeholder="johndoe/profile" aria-label="johndoe" />
                        </div>
                        <div class="col-12 my-2"> <hr/> </div>
                        <div class="col-sm-6">
                          <label class="form-label" for="multiStepsFirstName">First Name</label>
                          <input type="text" id="multiStepsFirstName" name="multiStepsFirstName" class="form-control" placeholder="John" />
                        </div>
                        <div class="col-sm-6">
                          <label class="form-label" for="multiStepsLastName">Last Name</label>
                          <input type="text" id="multiStepsLastName" name="multiStepsLastName" class="form-control" placeholder="Doe" />
                        </div>
                        <div class="col-sm-6">
                          <label class="form-label" for="multiStepsMobile">Mobile</label>
                          <div class="input-group input-group-merge">
                            <span class="input-group-text">ID (+62)</span>
                            <input type="text" id="multiStepsMobile" name="multiStepsMobile" class="form-control multi-steps-mobile" placeholder="812 3456 7890" />
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <label class="form-label" for="multiStepsPincode">Pincode</label>
                          <input type="text" id="multiStepsPincode" name="multiStepsPincode" class="form-control multi-steps-pincode" placeholder="Kode Pos" maxlength="5" />
                        </div>
                        <div class="col-md-12">
                          <label class="form-label" for="multiStepsAddress">Address</label>
                          <input type="text" id="multiStepsAddress" name="multiStepsAddress" class="form-control" placeholder="Alamat Lengkap" />
                        </div>
                        <div class="col-md-12">
                          <label class="form-label" for="multiStepsArea">Landmark (Opsional)</label>
                          <input type="text" id="multiStepsArea" name="multiStepsArea" class="form-control" placeholder="Patokan Area/Bangunan Terdekat" />
                        </div>
                        <div class="col-sm-6">
                          <label class="form-label" for="multiStepsCity">City</label>
                          <input type="text" id="multiStepsCity" name="multiStepsCity" class="form-control" placeholder="Kota" />
                        </div>
                        <div class="col-sm-6">
                          <label class="form-label" for="multiStepsState">State</label>
                          <select id="multiStepsState" name="multiStepsState" class="select2 form-select" data-allow-clear="true">
                            <option value="">Pilih Provinsi</option>
                            <option value="ACEH">Aceh</option>
                            <option value="SUMUT">Sumatera Utara</option>
                            <!-- Tambahkan provinsi lainnya -->
                          </select>
                        </div>
                        <div class="col-12 d-flex justify-content-between mt-4">
                          <button class="btn btn-primary btn-prev">
                            <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                            <span class="d-sm-inline-block d-none">Previous</span>
                          </button>
                          <button type="submit" class="btn btn-success btn-submit">Submit</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- / Multi Steps Registration -->
      </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../../assets/vendor/libs/popper/popper.js"></script>
    <script src="../../assets/vendor/js/bootstrap.js"></script>
    <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../../assets/vendor/libs/hammer/hammer.js"></script>
    <script src="../../assets/vendor/libs/i18n/i18n.js"></script>
    <script src="../../assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="../../assets/vendor/js/menu.js"></script>

    <!-- Vendors JS -->
    <script src="../../assets/vendor/libs/cleavejs/cleave.js"></script>
    <script src="../../assets/vendor/libs/cleavejs/cleave-phone.js"></script>
    <script src="../../assets/vendor/libs/bs-stepper/bs-stepper.js"></script>
    <script src="../../assets/vendor/libs/select2/select2.js"></script>
    <script src="../../assets/vendor/libs/@form-validation/umd/bundle/popular.min.js"></script>
    <script src="../../assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js"></script>
    <script src="../../assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js"></script>

    <!-- Main JS -->
    <script src="../../assets/js/main.js"></script>

    <!-- Page JS -->
    <!-- <script src="../../assets/js/pages-auth-multisteps.js"></script> -->
    <!-- ^^^^ Komentari atau hapus baris di atas jika Anda menggunakan logika JS di bawah ini ^^^^ -->

    <script>
      document.addEventListener('DOMContentLoaded', function () {
        if (window.Helpers) {
          window.Helpers.initCustomOptionCheck();
        }

        const select2 = $('.select2');
        if (select2.length) {
          select2.each(function () {
            var $this = $(this);
            var placeholder = $this.data('placeholder') || 'Pilih';
            $this.wrap('<div class="position-relative"></div>');
            $this.select2({
              placeholder: placeholder,
              dropdownParent: $this.parent(),
              allowClear: !!$this.data('allow-clear')
            });
          });
        }

        const multiStepsValidationEl = document.querySelector('#multiStepsValidation');
        if (typeof multiStepsValidationEl !== 'undefined' && multiStepsValidationEl !== null) {
          const stepper = new Stepper(multiStepsValidationEl, {
            linear: false
          });

          const multiStepsFormEl = multiStepsValidationEl.querySelector('#multiStepsForm');
          const btnNextList = [].slice.call(multiStepsFormEl.querySelectorAll('.btn-next'));
          const btnPrevList = [].slice.call(multiStepsFormEl.querySelectorAll('.btn-prev'));
          const btnSubmitEl = multiStepsFormEl.querySelector('.btn-submit');

          let fvRole, fvAccountPersonal;

          // Validasi Step 1: Pemilihan Role
          fvRole = FormValidation.formValidation(multiStepsFormEl, {
            fields: {
              selectedRole: {
                validators: {
                  notEmpty: {
                    message: 'Silakan pilih role Anda.'
                  }
                }
              }
            },
            plugins: {
              trigger: new FormValidation.plugins.Trigger(),
              bootstrap5: new FormValidation.plugins.Bootstrap5({
                eleValidClass: '',
                rowSelector: '.col-12' // Untuk menempatkan pesan error di bawah grup radio
              }),
              autoFocus: new FormValidation.plugins.AutoFocus()
            },
            init: instance => {
              instance.on('plugins.message.placed', function (e) {
                // Tempatkan pesan error untuk radio button di container yang sudah disiapkan
                if (e.field === 'selectedRole' && e.element.type === 'radio') {
                  const messageContainer = multiStepsFormEl.querySelector('.fv-plugins-message-container [data-field="selectedRole"]');
                  if (messageContainer) {
                    messageContainer.appendChild(e.messageElement);
                    e.messageElement.classList.add('text-danger'); // Tambahkan kelas text-danger
                  }
                }
              });
            }
          });

          // Validasi Step 2: Informasi Akun & Personal
          fvAccountPersonal = FormValidation.formValidation(multiStepsFormEl, {
            fields: {
              multiStepsUsername: { validators: { notEmpty: { message: 'Username wajib diisi.' }, stringLength: { min: 4, message: 'Username minimal 4 karakter.' }}},
              multiStepsEmail: { validators: { notEmpty: { message: 'Email wajib diisi.' }, emailAddress: { message: 'Format email tidak valid.' }}},
              multiStepsPass: { validators: { notEmpty: { message: 'Password wajib diisi.' }, stringLength: { min: 6, message: 'Password minimal 6 karakter.' }}},
              multiStepsConfirmPass: {
                validators: {
                  notEmpty: { message: 'Konfirmasi password wajib diisi.' },
                  identical: { compare: () => multiStepsFormEl.querySelector('[name="multiStepsPass"]').value, message: 'Password dan konfirmasi password tidak cocok.'}
                }
              },
              multiStepsFirstName: { validators: { notEmpty: { message: 'Nama depan wajib diisi.' }}},
              multiStepsLastName: { validators: { notEmpty: { message: 'Nama belakang wajib diisi.' }}},
              multiStepsMobile: { validators: { notEmpty: { message: 'Nomor mobile wajib diisi.' }}},
              multiStepsPincode: { validators: { notEmpty: { message: 'Kode pos wajib diisi.' }, digits: { message: 'Hanya boleh berisi angka.'}, stringLength: { min:5, max: 5, message: 'Kode pos harus 5 digit.' }}},
              multiStepsAddress: { validators: { notEmpty: { message: 'Alamat wajib diisi.' }}},
              multiStepsCity: { validators: { notEmpty: { message: 'Kota wajib diisi.' }}},
              multiStepsState: { validators: { notEmpty: { message: 'Provinsi wajib diisi.' }}}
            },
            plugins: {
              trigger: new FormValidation.plugins.Trigger(),
              bootstrap5: new FormValidation.plugins.Bootstrap5({
                eleValidClass: '',
                rowSelector: function (field, ele) {
                    const parentCol = ele.closest('.col-sm-6, .col-md-12');
                    return parentCol ? '.' + parentCol.className.split(' ').find(cls => cls.startsWith('col-')) : '.row';
                }
              }),
              autoFocus: new FormValidation.plugins.AutoFocus()
            },
             init: instance => {
              instance.on('plugins.message.placed', function (e) {
                if (e.element.parentElement.classList.contains('input-group')) {
                  e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
                } else if (e.element.parentElement.classList.contains('position-relative')) { // Untuk Select2
                  e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
                }
              });
            }
          });

          btnNextList.forEach(btnNext => {
            btnNext.addEventListener('click', event => {
              const currentStepIndex = stepper.getCurrentStepIndex();
              if (currentStepIndex === 0) { // Dari Step 1 ke Step 2
                fvRole.validate().then(function (status) {
                  if (status === 'Valid') {
                    stepper.next();
                  }
                });
              }
            });
          });

          btnPrevList.forEach(btnPrev => {
            btnPrev.addEventListener('click', event => {
              stepper.previous();
            });
          });

          if (btnSubmitEl) {
            btnSubmitEl.addEventListener('click', event => {
              fvAccountPersonal.validate().then(function (status) {
                if (status === 'Valid') {
                  alert('Formulir berhasil divalidasi dan siap untuk disubmit!');
                  // multiStepsFormEl.submit(); // Uncomment untuk submit form HTML standar
                }
              });
            });
          }
        }

        const phoneMask = document.querySelector('.multi-steps-mobile');
        if (phoneMask) {
          new Cleave(phoneMask, { phone: true, phoneRegionCode: 'ID' });
        }
        const pincodeMask = document.querySelector('.multi-steps-pincode');
        if (pincodeMask) {
          new Cleave(pincodeMask, { numericOnly: true, blocks: [5] });
        }

        document.querySelectorAll('.form-password-toggle .input-group-text').forEach(icon => {
            icon.addEventListener('click', e => {
                const N = e.currentTarget.closest(".form-password-toggle"),
                    L = N.querySelector("input"),
                    I = N.querySelector("i");
                "bx-hide" === I.getAttribute("class").split(" ")[1]
                    ? (I.classList.remove("bx-hide"), I.classList.add("bx-show"), (L.type = "text"))
                    : (I.classList.remove("bx-show"), I.classList.add("bx-hide"), (L.type = "password"));
            });
        });
      });
    </script>
  </body>
</html>