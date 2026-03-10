@extends('layouts.admin-template')

@section('content')
    <!-- Link CSS -->
    <link href="{{ asset('/css/product_edit.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/product.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    
    <!-- Font Google -->
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@400;500;600;700&family=Montserrat:ital,wght@0,500;0,700;1,600;1,700&family=Roboto:wght@100;400;500;700;900&family=Sora:wght@300;400;500;600;700&family=Ubuntu&display=swap" rel="stylesheet">

    <!-- Meta Tag -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/f4cf3b69a5.js" crossorigin="anonymous"></script>

    <!-- Section Content -->
    <div class="box-header with-border">
        @if (session('status'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="icon fa fa-check"></i> Success! &nbsp; {{ session('status') }}
            </div>
        @endif
    </div>

    <body>
        <div class="container-fluid">
            <!-- Desktop UI -->
            <div class="none-mobile-ui">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h4 style="font-weight: 700">Daftar Produk</h4>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="float: right;">
                            <i class="fa-solid fa-plus"></i> Tambah Produk
                        </button>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="product-table" width=100%>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Pesanan</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Gambar</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Mobile UI -->
            <div class="mobile-ui">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h4 style="font-weight: 700">Daftar Produk</h4>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="float: right;">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div style="overflow: auto;">
                            <table class="table" id="product-table2" width="100%">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Optional JavaScript -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

        <!-- Modal Create Product -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Tambah Data Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="product-form" role="form" method="post" action="{{ route('product.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" maxlength="50" value="{{ old('name') }}" autofocus required>
                                <span id="nameError" class="text-danger"></span>
                            </div>

                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea class="form-control" id="description" name="description" maxlength="
                                200">{{ old('description') }}</textarea>
                                <span id="descriptionError" class="text-danger"></span>
                            </div>

                            <div class="form-group">
                                <label>Kategori</label>
                                <select name="category_id" class="form-control">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Harga</label>
                                <input type="text" class="form-control" id="price" name="price" placeholder="Enter price" value="{{ old('price') }}" autofocus required maxlength="15">
                                <span id="priceError" class="text-danger"></span>
                            </div>

                            <div class="form-group">
                                <label>Stok</label>
                                <select name="stoks" class="form-control">
                                    <option value="1">Ada</option>
                                    <option value="0">Habis</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Gambar</label>
                                <input type="file" class="form-control" id="image" name="image" placeholder="Enter image" value="{{ old('image') }}" required accept=".jpg, .jpeg, .png">
                                <span id="imageError" class="text-danger"></span>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </form>
                        <!-- Alert for form submission errors -->
                        <div id="submitErrorAlert" class="alert alert-danger" style="display: none;">
                            <strong>Error!</strong> Form tidak dapat disubmit, pastikan semua kolom sudah terisi dengan benar.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script>
            $(document).ready(function() {
                // Table Initialization
                $('#product-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{!! url('/product/data') !!}',
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'id', name: 'products.id' },
                        { data: 'pname', name: 'products.name' },
                        { data: 'cname', name: 'categories.name' },
                        { data: 'price', name: 'products.price' },
                        { data: 'stoks', name: 'products.stoks' },
                        { data: 'image', name: 'products.image' },
                        { data: 'action', name: 'action', orderable: false, searchable: false }
                    ]
                });

                $('#product-table2').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{!! url('/product/data') !!}',
                    columns: [
                        { data: 'pname', name: 'products.name' },
                        { data: 'cname', name: 'categories.name' },
                        { data: 'price', name: 'products.price' },
                        { data: 'stoks', name: 'products.stoks' },
                        { data: 'action', name: 'action', orderable: false, searchable: false }
                    ]
                });

                // Form Validations
                $('#product-form').on('submit', function(event) {
                    var isValid = true;

                    // Validate Name
                    const name = $('#name').val();
                    const nameError = $('#nameError');
                    if (!name) {
                        nameError.text('Nama harus diisi.');
                        isValid = false;
                    } else if (name.length > 50) {
                        nameError.text('Nama tidak boleh lebih dari 50 karakter.');
                        isValid = false;
                    } else {
                        nameError.text('');
                    }

                    // Validate Description
                    const desc = $('#description').val();
                    const descriptionError = $('#descriptionError');
                    if (!desc) {
                        descriptionError.text('Deskripsi harus diisi.');
                        isValid = false;
                    } else if (desc.length > 200) {
                        descriptionError.text('Deskripsi tidak boleh lebih dari 200 karakter.');
                        isValid = false;
                    } else {
                        descriptionError.text('');
                    }

                    // Validate Price
                    const price = $('#price').val();
                    const priceError = $('#priceError');
                    if (!price) {
                        priceError.text('Harga harus diisi.');
                        isValid = false;
                    } else if (isNaN(price)) {
                        priceError.text('Harga harus berupa angka.');
                        isValid = false;
                    } else {
                        priceError.text('');
                    }

                    // Validate Image
                    const file = $('#image')[0].files[0];
                    const imageError = $('#imageError');
                    if (!file) {
                        imageError.text('Gambar harus diunggah.');
                        isValid = false;
                    } else if (!['image/jpeg', 'image/png', 'image/jpg'].includes(file.type)) {
                        imageError.text('Format gambar harus JPG atau PNG.');
                        isValid = false;
                    } else if (file.size > 10 * 1024 * 1024) {
                        imageError.text('Ukuran gambar tidak boleh lebih dari 10MB.');
                        isValid = false;
                    } else {
                        imageError.text('');
                    }

                    // Show or hide error alert
                    if (!isValid) {
                        event.preventDefault(); // Prevent form submission
                        $('#submitErrorAlert').show(); // Show the error alert
                    } else {
                        $('#submitErrorAlert').hide(); // Hide error alert if the form is valid
                    }
                });
            });
        </script>
    </body>
@endsection
