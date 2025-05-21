<div class="table-responsive">
    <table class="table" style="table-layout: fixed;">
        <thead>
            <tr>
                <th style="width: 20%;">Kelas</th>
                <th style="width: 40%;">Wali Kelas</th>
                <th style="width: 20%;">Jumlah Siswa</th>
                <th style="width: 20%;">Tindakan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($classes as $class)
            <tr>
                <td style="word-wrap: break-word; white-space: normal;">
                    <span class="fw-medium">{{ $class->className }}</span>
                </td>
                <td style="word-wrap: break-word; white-space: normal;">
                    <span class="fw-medium"
                        >{{ $class->teacher->name ?? 'Belum ditentukan' }}</span
                    >
                </td>
                <td style="word-wrap: break-word; white-space: normal;">
                    <span class="fw-medium"
                        >{{ $class->totalStudents($class->id) }}</span
                    >
                </td>
                <td
                    class=""
                    style="word-wrap: break-word; white-space: normal;"
                >
                    <div class="d-inline-block text-nowrap">
                        <button
                            class="btn btn-sm btn-icon btn-edit"
                            type="button"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasUbahKelas-{{ $class->id }}"
                            aria-controls="offcanvasUbahKelas-{{ $class->id }}"
                            title="Ubah Kelas"
                        >
                            <i class="bx bx-edit"></i>
                        </button>
                        @php $showEditOffcanvas = ($errors->any() &&
                        session('error_source') === 'update' &&
                        session('edited_id') == $class->id); @endphp
                        <div
                            class="offcanvas offcanvas-end {{ $showEditOffcanvas ? 'show' : '' }}"
                            id="offcanvasUbahKelas-{{ $class->id }}"
                            tabindex="-1"
                            aria-labelledby="offcanvasUbahKelasLabel-{{ $class->id }}"
                            style="{{ $showEditOffcanvas ? 'visibility: visible;' : '' }}"
                        >
                            <div class="offcanvas-header">
                                <h3
                                    class="offcanvas-title"
                                    id="offcanvasUbahLabel"
                                >
                                    Ubah Kelas
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
                                    action="{{ route('classes.update', $class->id) }}"
                                    method="POST"
                                >
                                    @csrf @method('PUT')
                                    <div class="mb-3">
                                        <label
                                            for="className"
                                            class="form-label"
                                            >Kelas</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="className"
                                            name="className"
                                            value="{{ $showEditOffcanvas ? old('className') : $class->className }}"
                                            data-initial-value="{{ $class->className }}"
                                            required
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label
                                            for="teacherName"
                                            class="form-label"
                                            >Nama Wali Kelas</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="teacherName"
                                            name="teacherName"
                                            value="{{ $showEditOffcanvas ? old('teacherName') : $class->teacher?->name }}"
                                            data-initial-value="{{ $class->teacher?->name }}"
                                        />
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
                                    id="alert-message-{{ $class->id }}"
                                    class="alert alert-danger"
                                >
                                    {{ $errors->first() }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <form
                            action="{{ route('classes.destroy', $class->id) }}"
                            method="POST"
                            class="d-inline-block"
                        >
                            @csrf @method('DELETE')
                            <button
                                type="button"
                                class="btn btn-sm btn-icon btn-delete"
                                data-id="{{ $class->id }}"
                                data-name="{{ $class->className }}"
                                title="Hapus Kelas"
                            >
                                <i class="bx bx-trash me-1"></i>
                            </button>
                        </form>
                        <a
                            href="{{ route('classes.show', $class->id) }}"
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
                <td colspan="4" class="text-center">Tidak ada data kelas.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
