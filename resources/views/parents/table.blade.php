<div class="table-responsive">
    <table class="table" style="table-layout: fixed;">
        <thead>
            <tr>
                <th style="width: 40%;">Nama</th>
                <th style="width: 40%;">Nama Siswa</th>
                <th style="width: 20%;">Tindakan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($parents as $parent)
            <tr>
                <td style="word-wrap: break-word; white-space: normal;">
                    <span class="fw-medium">{{ $parent->name }}</span>
                </td>
                <td style="word-wrap: break-word; white-space: normal;">
                    @forelse ($parent->students as $student)
                    <span class="fw-medium">{{ $student->name }}</span><br />
                    @empty
                    <span>-</span>
                    @endforelse
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
                            data-bs-target="#offcanvasUbahWali-{{ $parent->id }}"
                            aria-controls="offcanvasUbahWali-{{ $parent->id }}"
                            title="Ubah Wali Siswa"
                        >
                            <i class="bx bx-edit"></i>
                        </button>
                        @php $showEditOffcanvas = ($errors->any() &&
                        session('error_source') === 'update' &&
                        session('edited_id') == $parent->id); @endphp
                        <div
                            class="offcanvas offcanvas-end {{ $showEditOffcanvas ? 'show' : '' }}"
                            id="offcanvasUbahWali-{{ $parent->id }}"
                            tabindex="-1"
                            aria-labelledby="offcanvasUbahWaliLabel-{{ $parent->id }}"
                            style="{{ $showEditOffcanvas ? 'visibility: visible;' : '' }}"
                        >
                            <div class="offcanvas-header">
                                <h3
                                    class="offcanvas-title"
                                    id="offcanvasUbahLabel"
                                >
                                    Ubah Wali Siswa
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
                                    action="{{ route('parents.update', $parent->id) }}"
                                    method="POST"
                                >
                                    @csrf @method('PUT')
                                    <div class="mb-3">
                                        <label for="name" class="form-label"
                                            >Nama Wali Siswa</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="parent_name"
                                            id="parent_name"
                                            value="{{ $showEditOffcanvas ? old('parent_name') : $parent->name }}"
                                            data-initial-value="{{ $parent->name }}"
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
                                            value="{{ $showEditOffcanvas ? old('email') : $parent->user->email }}"
                                            data-initial-value="{{ $parent->user->email }}"
                                            required
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label
                                            for="student_name"
                                            class="form-label"
                                            >Nama Siswa</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="student_name"
                                            id="student_name"
                                            value="{{ $showEditOffcanvas ? old('student_name') : $parent->students->pluck('name')->implode(', ') }}"
                                            data-initial-value="{{ $parent->students->first()->name ?? '' }}"
                                            required
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
                                    id="alert-message-{{ $parent->id }}"
                                    class="alert alert-danger"
                                >
                                    {{ $errors->first() }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <form
                            action="{{ route('parents.destroy', $parent->id) }}"
                            method="POST"
                            class="d-inline-block"
                        >
                            @csrf @method('DELETE')
                            <button
                                type="button"
                                class="btn btn-sm btn-icon btn-delete"
                                data-id="{{ $parent->id }}"
                                data-name="{{ $parent->name }}"
                                title="Hapus Wali Siswa"
                            >
                                <i class="bx bx-trash me-1"></i>
                            </button>
                        </form>
                        <a
                            href="{{ route('parents.show', $parent->id) }}"
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
                <td colspan="4" class="text-center">
                    Tidak ada data wali siswa.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
