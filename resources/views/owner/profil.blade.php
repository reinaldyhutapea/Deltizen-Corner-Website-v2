@extends('layouts.owner-template')
@section('content')
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="{{ asset('/css/profil.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/f4cf3b69a5.js" crossorigin="anonymous"></script>
</head>
<div class="container-fluid">
    
    <div class="card shadow mb-4">
        <div class="card-header">
            <h4 style="font-weight: 700;">Profil</h4>         
        </div>
        <div class="card-body">
      <img class="img" src="{{ asset('user.png')}}" alt="profil">
      <table class="table table-borderless" style="width:30%;margin-top: 30px;">
          <tr>
              <th> 
                <i class="fa-solid fa-address-card" style="margin-right: 5px;color: brown;"></i>Nama
              </th>
              <td>
                {{  Auth::user()->name }}
              </td>
            </tr>
              <tr>
              <th>
                <i class="fa-solid fa-at" style="margin-right: 5px;color: rgb(0, 175, 61);"></i>Email
              </th>
              <td>
                {{  Auth::user()->email }}
            </td>
        </tr>
      </table>

    </div>
</div>

            <div class="card">
                <div class="card-header">
                    <h4 style="font-weight: 700;">Ubah Password</h4>
                </div>
   
                <div class="card-body">
                    <form method="POST"  action="{{ route('change.password') }}" >
                        @csrf 

                        @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>    
                            <strong>{{ $message }}</strong>
                        </div>
                        @endif
   
                         @foreach ($errors->all() as $error)
                            <p class="text-danger">{{ $error }}</p>
                         @endforeach 
  
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Current Password</label>
  
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="current_password" autocomplete="current-password">
                            </div>
                        </div>
  
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>
  
                            <div class="col-md-6">
                                <input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password">
                            </div>
                        </div>
  
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">New Confirm Password</label>
    
                            <div class="col-md-6">
                                <input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" autocomplete="current-password">
                            </div>
                        </div>
   
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Update Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
 
@endsection