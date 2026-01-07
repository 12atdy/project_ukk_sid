@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 text-gray-800 fw-bold"><i class="fas fa-edit me-2"></i> Edit Berita</h1>
                <a href="{{ route('berita.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="card border-0 shadow-lg rounded-3">
                <div class="card-body p-5">
                    <form action="{{ route('berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- PENTING UNTUK UPDATE DATA -->

                        <div class="row">
                            <!-- Kolom Kiri: Input Teks -->
                            <div class="col-md-8">
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-primary">Judul Berita</label>
                                    <input type="text" name="judul" class="form-control form-control-lg @error('judul') is-invalid @enderror" 
                                           value="{{ old('judul', $berita->judul) }}" required>
                                    @error('judul') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold text-primary">Isi Berita</label>
                                    <textarea name="isi" class="form-control @error('isi') is-invalid @enderror" rows="10" required>{{ old('isi', $berita->isi) }}</textarea>
                                    @error('isi') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Kolom Kanan: Upload Gambar -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-primary">Gambar Utama</label>
                                    
                                    <!-- Tampilkan Gambar Lama -->
                                    <div class="card bg-light border-dashed text-center mb-2" style="height: 200px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                        @if($berita->gambar)
                                            <img id="preview-img" src="{{ asset('storage/berita/' . $berita->gambar) }}" class="img-fluid" style="max-height: 100%; object-fit: cover;">
                                        @else
                                            <img id="preview-img" src="https://via.placeholder.com/300x200?text=No+Image" class="img-fluid">
                                        @endif
                                    </div>

                                    <input type="file" name="gambar" id="gambar-input" class="form-control form-control-sm" accept="image/*" onchange="previewImage()">
                                    <small class="text-muted d-block mt-1">*Biarkan kosong jika tidak ingin mengganti gambar.</small>
                                    @error('gambar') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-warning text-white px-5 fw-bold shadow">
                                <i class="fas fa-save me-2"></i> UPDATE BERITA
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Script Preview Gambar -->
<script>
    function previewImage() {
        const image = document.querySelector('#gambar-input');
        const imgPreview = document.querySelector('#preview-img');

        if(image.files && image.files[0]){
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);
            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    }
</script>
@endsection