@extends('layouts.admin-template')

@section('content')
<link href="{{ asset('/css/product_edit.css') }}" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@400;500;600;700&family=Montserrat:ital,wght@0,500;0,700;1,600;1,700&family=Roboto:wght@100;400;500;700;900&family=Sora:wght@300;400;500;600;700&family=Ubuntu&display=swap" rel="stylesheet">

    <div class="container-fluid">
        <!-- Success Message Alert -->
        @if(session('status'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="icon fa fa-check"></i> Success! &nbsp; {{ session('status') }}
            </div>
        @endif

        <!-- Edit Product Form -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h4 style="font-weight: 700;font-size: 20px">Ubah Data Produk</h4>
            </div>
            <div class="card-body">
                <form id="product-form" role="form" method="POST" action="{{ route('product.update', ['id' => $product->id]) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $product->id }}">

                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="{{ old('name', $product->name) }}" autofocus required maxlength="50">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" maxlength="200">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="category_id" class="form-control">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ ($product->category_id == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Harga</label>
                        <input type="text" class="form-control" id="price" name="price" placeholder="Enter price" value="{{ old('price', $product->price) }}" required maxlength="15">
                        @error('price')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Gambar</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" onchange="readURL(this);" name="image" accept=".png, .jpg, .jpeg">
                            <label class="custom-file-label" for="image">Choose file</label>
                        </div>
                        <img id="blah" width="200" style="margin-top: 30px;" src="{{ asset($product->image) }}" height="100px" alt="your image" />
                        @error('image')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Status Stok</label>
                        <select name="stoks" class="form-control">
                            <option value="1" {{ $product->stoks == 1 ? 'selected' : '' }}>Ada</option>
                            <option value="0" {{ $product->stoks == 0 ? 'selected' : '' }}>Habis</option>
                        </select>
                    </div>

                    <div class="submit" style="text-align: center">
                        <a href="{{ route('product.index') }}" class="btn btn-primary">Kembali</a>
                        <button type="submit" style="background-color: rgb(2, 156, 84)" class="btn text-white">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
