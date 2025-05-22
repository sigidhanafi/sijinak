<div class="table-responsive">
    <table class="table" style="table-layout: fixed;">
        <thead>
            <tr>
                <th style="width: 40%;">Nama</th>
                <th style="width: 30%;">NIP</th>
                <th style="width: 30%;">Tindakan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($teachers as $teacher)
            <tr>
                <td style="word-wrap: break-word; white-space: normal;">
                    <span class="fw-medium">{{ $teacher->name }}</span>
                </td>
                <td style="word-wrap: break-word; white-space: normal;">
                    <span class="fw-medium">{{ $teacher->nip ?? '-'}}</span>
                </td>
                <td class="" style="word-wrap: break-word; white-space: normal;">
                    <div class="d-inline-block">
                        <button
                            class="btn btn-sm btn-icon btn-edit"
                            type="button"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasUbahGuru-{{ $teacher->id }}"
                            aria-controls="offcanvasUbahGuru-{{ $teacher->id }}"
                            title="Ubah Guru"
                        >
                            <i class="bx bx-edit"></i>
                        </button>
                        @php $showEditOffcanvas = ($errors->any() &&
                        session('error_source') === 'update' &&
                        session('edited_id') == $teacher->id); @endphp
                        <div
                            class="offcanvas offcanvas-end {{ $showEditOffcanvas ? 'show' : '' }}"
                            id="offcanvasUbahGuru-{{ $teacher->id }}"
                            tabindex="-1"
                            aria-labelledby="offcanvasUbahGuruLabel-{{ $teacher->id }}"
                            style="{{ $showEditOffcanvas ? 'visibility: visible;' : '' }}"
                        >
                            <div class="offcanvas-header">
                                <h3
                                    class="offcanvas-title"
                                    id="offcanvasUbahLabel"
                                >
                                    Ubah Guru
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
                                    action="{{ route('teachers.update', $teacher->id) }}"
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
                                            value="{{ $showEditOffcanvas ? old('name') : $teacher->name }}"
                                            data-initial-value="{{ $teacher->name }}"
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
                                            value="{{ $showEditOffcanvas ? old('email') : $teacher->user->email }}"
                                            data-initial-value="{{ $teacher->user->email }}"
                                            required
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label for="nip" class="form-label"
                                            >NIP</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="nip"
                                            id="nip"
                                            value="{{ $showEditOffcanvas ? old('nip') : $teacher->nip }}"
                                            data-initial-value="{{ $teacher->nip }}"
                                            required
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label
                                            for="defaultSelect"
                                            class="form-label"
                                            >Status Guru</label
                                        >
                                        <select name="is_on_duty" class="form-select" required>
                                            <option value="" disabled
                                                {{ $showEditOffcanvas
                                                    ? (old('is_on_duty') !== null ? '' : 'selected')
                                                    : ($teacher->is_on_duty === null ? 'selected' : '') }}>
                                                Status Guru
                                            </option>
                                            <option value="0"
                                                {{ $showEditOffcanvas
                                                    ? (old('is_on_duty') === '0' ? 'selected' : '')
                                                    : ($teacher->is_on_duty == 0 ? 'selected' : '') }}>
                                                Guru
                                            </option>
                                            <option value="1"
                                                {{ $showEditOffcanvas
                                                    ? (old('is_on_duty') === '1' ? 'selected' : '')
                                                    : ($teacher->is_on_duty == 1 ? 'selected' : '') }}>
                                                Guru Piket
                                            </option>
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
                                    id="alert-message-{{ $teacher->id }}"
                                    class="alert alert-danger"
                                >
                                    {{ $errors->first() }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <form
                            action="{{ route('teachers.destroy', $teacher->id) }}"
                            method="POST"
                            class="d-inline-block"
                        >
                            @csrf @method('DELETE')
                            <button
                                type="button"
                                class="btn btn-sm btn-icon btn-delete"
                                data-id="{{ $teacher->id }}"
                                data-name="{{ $teacher->name }}"
                                title="Hapus Guru"
                            >
                                <i class="bx bx-trash me-1"></i>
                            </button>
                        </form>
                        <a
                            href="{{ route('teachers.show', $teacher->id) }}"
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
                <td colspan="4" class="text-center">Tidak ada data guru.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>