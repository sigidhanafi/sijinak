<!-- It is not the man who has too little, but the man who craves more, that is poor. - Seneca -->

<div class="btn-group  flex-fill">
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        {{$title}}
    </button>

    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <div class="list-group m-2">
            {{ $slot }}
            <div id="floatingInputHelp" class="form-text">
                {{ $helperMessage }}
            </div>
        </div>
    </ul>
</div>

{{-- kalau tipe admin ada span buat encapsulate label tampilan --}}


{{-- 
role.petugas dan lainnya enum => label prop
aksi.qr dan lainnya enum  


title jenis admin dan jenis aksi extend dari tipe 
tipe: admin dan aksi: string input aja dari front
label: string petugas dan lainnya ambil dari role.petugas enum 
helperMessage
badge

aksi.qr.badge
{{-- Filter berdasarkan jenis aksi
Filter berdasarkan jenis admin 

jadiin ke dalem enum di view component phpnya--}}
