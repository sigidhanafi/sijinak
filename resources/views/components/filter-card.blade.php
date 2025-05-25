<!-- Smile, breathe, and go slowly. - Thich Nhat Hanh -->
<div class="d-flex flex-wrap gap-3 m-3">

    <!-- Admin Filter -->
    <div class="btn-group flex-fill d-flex flex-column justify-content-between align-items-start">
        <div class="d-flex flex-column mb-md-1 justify-content-end w-100">
            <label for="admin_filter" class="form-label d-flex align-items-center">
                <b>Admin</b>
            </label>
            <div class="input-group d-flex flex-column">
                <select class="form-select w-100" id="admin_filter" aria-label="Filter admin">
                    <option selected>Choose...</option>
                    <option value="1">Guru Piket</option>
                    <option value="2">Admin</option>
                    <option value="3">Petugas</option>
                </select>
                <div class="form-text d-none d-md-inline">Filter berdasarkan jenis admin</div>
            </div>
        </div>
    </div>

    <!-- Aksi Filter -->
    <div class="btn-group flex-fill d-flex flex-column justify-content-between align-items-start">
        <div class="d-flex flex-column mb-md-1 justify-content-end w-100">
            <label for="aksi_filter" class="form-label d-flex align-items-center">
                <b>Aksi</b>
            </label>
            <div class="input-group d-flex flex-column">
                <select class="form-select w-100" id="aksi_filter" name="aksi_filter" aria-label="Filter aksi">
                    <option value="none" selected>Choose...</option>
                    <option value="1">Log In</option>
                    <option value="2">Create QR</option>
                    <option value="3">Reject Student Request</option>
                    <option value="4">Accept Student Request</option>
                </select>
                <div class="form-text d-none d-md-inline">Filter berdasarkan jenis aksi</div>
            </div>
        </div>
    </div>

    <!-- Waktu Filter -->
    <div class="btn-group flex-fill d-flex flex-column justify-content-between align-items-start flex-wrap">
        <div class="d-flex flex-column mb-md-1 justify-content-end">
            <label for="start_time" class="form-label d-flex align-items-center">
                <b>Waktu</b>
            </label>
            <div class="input-group d-flex flex-column">
                <div class="d-flex flex-row gap-2 w-100">
                    <div class="input-group d-flex flex-grow-0" style="min-width: 160px; max-width: 180px;">
                        <span class="input-group-text">
                            <i class='bx bx-calendar'></i>
                        </span>
                        <input type="datetime-local" class="form-control" id="start_time" name="start_time">
                    </div>
                    <div class="input-group d-flex flex-grow-0" style="min-width: 160px; max-width: 180px;">
                        <span class="input-group-text">
                            <i class='bx bx-calendar'></i>
                        </span>
                        <input type="datetime-local" class="form-control" id="end_time" name="end_time">
                    </div>
                </div>
                <div class="form-text d-none d-md-inline mt-1">Filter berdasarkan rentang waktu</div>
            </div>
        </div>
    </div>

</div>
