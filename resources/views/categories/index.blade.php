@extends('layouts.admin-template')
@section('content')
<div class="row">
    <div class="container-fluid">
        <div class="card shadow mb-4" style="margin:10px;">
            <div class="card-header">
                <h3 class="box-title" style="font-weight: 700;font-size: 20px;">{{ $title }}</h3>
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


        <!-- /.box-header -->
            <div class="card-body">
                <button type="button" style="margin-bottom: 20px;background-color: rgb(10, 14, 255);padding: 8px;border-radius: 5px;color:white;">
                    <a href="{{ route('category.create') }}" style="color: white">
                    <i class="fa-solid fa-plus"></i> Tambah Category
                </a>
                </button>        
                <table id="categories" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th width="10px">ID</th>
                        <th>Name</th>
                        <th width="150px"></th>
                    </tr>
                    </thead>

                    @php
                    $no = 1;
                    @endphp

                    @foreach($categories as $category)
                        <tbody>
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td> {{ $category->name }}</td>
                            <td>
                                <form action="{{ route('category.destroy', ['id' => $category->id]) }}" method="get" onsubmit="return confirm('Delete this posts permanently ?')">
                                    @csrf
                                 
                                    {{-- <input type="submit" class="btn bg-red-active"> --}}
                                    <button type="submit" style="background-color: red;padding: 8px;border-radius: 5px;color:white;">Delete</button>
                                </form>
                            </td>
                        </tr>
                        </tbody>
                    @endforeach
                </table>
            </div>

        </div>
     
    </div>
    </div>
@endsection