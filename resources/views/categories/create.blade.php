@extends('layouts.admin-template')
@section('content')
<div class="row">
<div class="container-fluid">
    <div class="card shadow mb-4" style="margin: 10px;">
        <div class="card-header ">
            <h3 style="font-weight: 700;font-size: 20px;">{{ $title }}</h3>
        </div>
        @if(session('status'))
        <div class="box-header">
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="icon fa fa-check"></i> Success! &nbsp;
                {{ session('status') }}
            </div>
        </div>
@endif
        <form role="form" method="post" action="{{ route('category.store')  }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Kategori</label>
                    <select class="form-control" id="name" name="name" required autofocus>
                        <option value="" disabled selected>Pilih kategori</option>
                        <option value="Makanan" {{ old('name') == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                        <option value="Minuman" {{ old('name') == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                        <option value="Promo" {{ old('name') == 'Promo' ? 'selected' : '' }}>Promo</option>
                    </select>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" style="background-color: blue">Submit</button>
            </div>
        </form>
    </div>
 
</div>
</div>
@endsection