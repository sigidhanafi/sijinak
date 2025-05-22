<div class="table-responsive">
    <table class="table" style="table-layout: fixed;">
        <thead>
            <tr>
                <th style="width: 40%;">Nama</th>
                <th style="width: 20%;">NISN</th>
                <th style="width: 20%;">Kelas</th>
                <th style="width: 20%;">Tindakan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($students as $student)
            <tr>
                <td style="word-wrap: break-word; white-space: normal;">
                    <span class="fw-medium">{{ $student->name }}</span>
                </td>
                <td style="word-wrap: break-word; white-space: normal;">
                    <span class="fw-medium">{{ $student->nisn ?? '-'}}</span>
                </td>
                <td style="word-wrap: break-word; white-space: normal;">
                    <span class="fw-medium"
                        >{{ $student->classes->className ?? '-' }}</span
                    >
                </td>
                <td class="" style="word-wrap: break-word; white-space: normal;">
                    <div class="d-inline-block">
                        <button
                            class="btn btn-sm btn-icon btn-edit"
                            type="button"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasUbahSiswa-{{ $student->id }}"
                            aria-controls="offcanvasUbahSiswa-{{ $student->id }}"
                            title="Ubah Siswa"
                        >
                            <i class="bx bx-edit"></i>
                        </button>
                        @php $showEditOffcanvas = ($errors->any() &&
                        session('error_source') === 'update' &&
                        session('edited_id') == $student->id); @endphp
                        <div
                            class="offcanvas offcanvas-end {{ $showEditOffcanvas ? 'show' : '' }}"
                            id="offcanvasUbahSiswa-{{ $student->id }}"
                            tabindex="-1"
                            aria-labelledby="offcanvasUbahSiswaLabel-{{ $student->id }}"
                            style="{{ $showEditOffcanvas ? 'visibility: visible;' : '' }}"
                        >
                            <div class="offcanvas-header">
                                <h3
                                    class="offcanvas-title"
                                    id="offcanvasUbahLabel"
                                >
                                    Ubah Siswa
                                </h3>
                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="offcanvas"
                                    aria-label="Close"
                                ></button>
                            </div>
                            <div class="offcanvas-body">
                                <form
                                    action="{{ route('students.update', $student->id) }}"
                                    method="POST"
                                >
                                    @csrf @method('PUT')
                                    <div class="mb-3">
                                        <label for="name" class="form-label"
                                            >Nama</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="name"
                                            id="name"
                                            value="{{ $showEditOffcanvas ? old('name') : $student->name }}"
                                            data-initial-value="{{ $student->name }}"
                                            required
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label"
                                            >Email</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="email"
                                            id="email"
                                            value="{{ $showEditOffcanvas ? old('email') : $student->user->email }}"
                                            data-initial-value="{{ $student->user->email }}"
                                            required
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label for="nisn" class="form-label"
                                            >NISN</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="nisn"
                                            id="nisn"
                                            value="{{ $showEditOffcanvas ? old('nisn') : $student->nisn }}"
                                            data-initial-value="{{ $student->nisn }}"
                                            required
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label
                                            for="defaultSelect"
                                            class="form-label"
                                            >Pilih Kelas</label
                                        >
                                        <select name="classId" class="form-select" required>
                                            <option value="" disabled
                                                {{ $showEditOffcanvas
                                                    ? (old('classId') ? '' : 'selected')
                                                    : ($student->classId ? '' : 'selected') }}>
                                                Pilih Kelas
                                            </option>

                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}"
                                                    {{ $showEditOffcanvas
                                                        ? (old('classId') == $class->id ? 'selected' : '')
                                                        : ($student->classId == $class->id ? 'selected' : '') }}>
                                                    {{ $class->className }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="d-flex gap-2 mt-2 mb-3">
                                        <button
                                            type="submit"
                                            class="btn btn-primary mt-2"
                                        >
                                            Simpan
                                        </button>
                                        <button
                                            type="reset"
                                            class="btn btn-label-primary mt-2"
                                            data-bs-dismiss="offcanvas"
                                        >
                                            Batal
                                        </button>
                                    </div>
                                </form>
                                @if($showEditOffcanvas)
                                <div
                                    id="alert-message-{{ $student->id }}"
                                    class="alert alert-danger"
                                >
                                    {{ $errors->first() }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <form
                            action="{{ route('students.destroy', $student->id) }}"
                            method="POST"
                            class="d-inline-block"
                        >
                            @csrf @method('DELETE')
                            <button
                                type="button"
                                class="btn btn-sm btn-icon btn-delete"
                                data-id="{{ $student->id }}"
                                data-name="{{ $student->name }}"
                                title="Hapus Siswa"
                            >
                                <i class="bx bx-trash me-1"></i>
                            </button>
                        </form>
                        <a
                            href="{{ route('students.show', $student->id) }}"
                            class="btn btn-sm btn-icon btn-view"
                            title="Lihat Detail"
                        >
                            <i class="bx bx-show-alt me-1"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Tidak ada data siswa.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>