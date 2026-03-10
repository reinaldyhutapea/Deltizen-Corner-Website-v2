@extends('layouts.admin-template')
@section('content')
<div class="box-header with-border">
   @if(session('status'))
       <div class="alert alert-success alert-dismissible" style="margin: 8px;">
           <button type="button" class="close" data-dismiss="alert"  aria-hidden="true">&times;</button>
           <i class="icon fa fa-check"></i> Success! &nbsp;
           {{ session('status') }}
       </div>
   @endif
</div>

<div class="container-fluid">
    <div class="header">
        <h4>Tambahkan Produk</h4>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header">
            <div class="card-body">
                <form role="form" method="post" action="{{ route('product.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Nama Produk -->
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="{{ old('name') }}" autofocus required maxlength="50">
                        <div id="name-error" class="alert alert-danger" style="display: none;"></div>
                    </div>

                    <!-- Deskripsi Produk -->
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" maxlength="200">{{ old('description') }}</textarea>
                        <div id="description-error" class="alert alert-danger" style="display: none;"></div>
                    </div>

                    <!-- Kategori Produk -->
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="category_id" class="form-control">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Harga Produk -->
                    <div class="form-group">
                        <label>Harga</label>
                        <input type="text" class="form-control" id="price" name="price" placeholder="Enter price" value="{{ old('price') }}" autofocus required maxlength="15">
                        <div id="price-error" class="alert alert-danger" style="display: none;"></div>
                    </div>

                    <!-- Stok Produk -->
                    <div class="form-group">
                        <label>Stok</label>
                        <select name="stoks" class="form-control">
                            <option value="1">Ada</option>
                            <option value="0">Habis</option>
                        </select>
                    </div>

                    <!-- Gambar Produk -->
                    <div class="form-group">
                        <label>Gambar</label>
                        <input type="file" class="form-control" id="image" name="image" placeholder="Enter image" value="{{ old('image') }}" required accept=".png, .jpg, .jpeg">
                        <div id="image-error" class="alert alert-danger" style="display: none;"></div>
                    </div>

                    <div class="submit" style="float: right;">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
                <a href="{{ route('product.index') }}" class="btn btn-primary">Kembali</a>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Nama Produk - Realtime validation
        $('#name').on('input', function() {
            var name = $(this).val();
            if (name.length > 50) {
                $('#name-error').text('Nama produk tidak boleh lebih dari 50 karakter').show();
            } else if (name.trim() === '') {
                $('#name-error').text('Nama produk wajib diisi').show();
            } else {
                $('#name-error').hide();
            }
        });

        // Deskripsi Produk - Realtime validation
        $('#description').on('input', function() {
            var description = $(this).val();
            if (description.length > 200) {
                $('#description-error').text('Deskripsi tidak boleh lebih dari 200 karakter').show();
            } else if (description.trim() === '') {
                $('#description-error').text('Deskripsi wajib diisi').show();
            } else {
                $('#description-error').hide();
            }
        });

        // Harga Produk - Realtime validation
        $('#price').on('input', function() {
            var price = $(this).val();
            if (isNaN(price) || price.trim() === '') {
                $('#price-error').text('Harga harus berupa angka dan tidak boleh kosong').show();
            } else {
                $('#price-error').hide();
            }
        });

        // Gambar Produk - Realtime validation
        $('#image').on('change', function() {
            var file = this.files[0];
            if (file) {
                var fileType = file.type.split('/')[1].toLowerCase();
                var fileSize = file.size / 1024 / 1024; // in MB
                if (['jpeg', 'png', 'jpg'].indexOf(fileType) === -1) {
                    $('#image-error').text('Format gambar harus jpg/jpeg/png').show();
                } else if (fileSize > 10) {
                    $('#image-error').text('Ukuran gambar tidak boleh lebih dari 10 MB').show();
                } else {
                    $('#image-error').hide();
                }
            }
        });
    });
</script>
@endsection
