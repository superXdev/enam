@extends('layouts.auth', ['title' => 'Register - '.config('app.name')])

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="../../index2.html" class="h1"><b>Admin</b>LTE</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form action="{{ route('register') }}" method="post">
        @csrf
          @error('name')
          <div class="text-danger">
            {{ $message }}
          </div>
          @enderror
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="name" placeholder="Nama lengkap">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
          @error('email')
          <div class="text-danger">
            {{ $message }}
          </div>
          @enderror
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
          @error('password')
          <div class="text-danger">
            {{ $message }}
          </div>
          @enderror
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
          @error('password_confirmation')
          <div class="text-danger">
            {{ $message }}
          </div>
          @enderror
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <label for="agreeTerms">
               I agree to the <a href="#">terms</a>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <a href="login.html" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
  @endsection