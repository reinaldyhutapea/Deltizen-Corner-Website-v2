{{-- resources/views/customer/confirm.blade.php --}}
@extends('layouts.frontend')

@section('title', 'Konfirmasi Pembayaran - Deltizen Corner')

@section('content')
<section class="section">
    <div class="container section-title" data-aos="fade-up">
        <h2>Konfirmasi Pembayaran</h2>
        <p><span>Upload</span> <span class="description-title">Bukti Pembayaran Anda</span></p>
    </div>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                {{-- Order Info Card --}}
                <div class="card mb-4" data-aos="fade-up">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1">Kode Pesanan</p>
                                <h4 class="fw-bold mb-0">#{{ $order->id }}</h4>
                            </div>
                            <div class="text-end">
                                <p class="text-muted mb-1">Total Bayar</p>
                                <h4 class="fw-bold mb-0" style="color: var(--dc-accent);">{{ formatRupiah($order->total_price) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Upload Form Card --}}
                <div class="card" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('confirm.store') }}" enctype="multipart/form-data" id="confirmForm">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            
                            {{-- Upload Area --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-upload me-1"></i>Bukti Pembayaran
                                </label>
                                <div class="upload-area p-4 text-center rounded-3" 
                                     style="border: 2px dashed var(--dc-border); background: var(--dc-bg-light); cursor: pointer;"
                                     onclick="document.getElementById('imageInput').click()">
                                    <div id="uploadPlaceholder">
                                        <i class="bi bi-cloud-arrow-up" style="font-size: 48px; color: var(--dc-accent);"></i>
                                        <p class="mt-2 mb-1">Klik atau seret gambar ke sini</p>
                                        <p class="text-muted small mb-0">Format: JPG, PNG, GIF (Maks. 2MB)</p>
                                    </div>
                                    <div id="imagePreview" style="display: none;">
                                        <img id="previewImg" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                                        <p class="mt-2 mb-0 text-success"><i class="bi bi-check-circle me-1"></i>Gambar siap diupload</p>
                                    </div>
                                </div>
                                <input type="file" 
                                       class="form-control d-none @error('image') is-invalid @enderror" 
                                       id="imageInput" 
                                       name="image" 
                                       accept=".jpg,.jpeg,.png,.gif,.webp"
                                       required>
                                @error('image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            {{-- Tips --}}
                            <div class="alert alert-info mb-4">
                                <h6 class="alert-heading fw-semibold"><i class="bi bi-lightbulb me-1"></i>Tips</h6>
                                <ul class="mb-0 ps-3 small">
                                    <li>Pastikan bukti pembayaran terlihat jelas</li>
                                    <li>Screenshot nominal transfer dan tanggal transaksi</li>
                                    <li>Admin akan verifikasi dalam 5-10 menit</li>
                                </ul>
                            </div>
                            
                            {{-- Action Buttons --}}
                            <div class="d-flex justify-content-between gap-2">
                                <a href="{{ route('pembayaran', ['id' => $order->id]) }}" class="btn btn-outline-secondary px-4">
                                    <i class="bi bi-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn-get-started px-4" id="submitBtn">
                                    <i class="bi bi-check-circle me-2"></i>Kirim Bukti Bayar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('imageInput');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const uploadArea = document.querySelector('.upload-area');
    
    // Handle file selection
    imageInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            
            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                this.value = '';
                return;
            }
            
            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                uploadPlaceholder.style.display = 'none';
                imagePreview.style.display = 'block';
                uploadArea.style.borderColor = 'var(--dc-success)';
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Drag and drop support
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.style.borderColor = 'var(--dc-accent)';
        this.style.background = 'rgba(230, 126, 34, 0.05)';
    });
    
    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.style.borderColor = 'var(--dc-border)';
        this.style.background = 'var(--dc-bg-light)';
    });
    
    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.style.borderColor = 'var(--dc-border)';
        this.style.background = 'var(--dc-bg-light)';
        
        const files = e.dataTransfer.files;
        if (files.length) {
            imageInput.files = files;
            imageInput.dispatchEvent(new Event('change'));
        }
    });
});
</script>
@endpush
