@extends('layouts.app')

@section('body')
<script src="{{ asset('js/jquery-3.4.1.min.js')}}"></script>
<h4 class="font-weight-bolder mb-0">Change Password</h4>
<div class="row margin_top">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
              
            
						<form enctype="multipart/form-data" method="post" action="{{ route('user.changePassword') }}">
              			@csrf
                <div class="form-group">
                  <div class="col-sm-6 margin_top">
                  <label for="change-password"><b>Current password</b></label>
                  <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" autocomplete="current_password" placeholder="Current Password..">
                  @error('current_password')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
							</div>
							<div class="form-group">
                  <div class="col-sm-6 margin_top">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="password" placeholder="New Password..">
                      @error('password')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                </div>
							</div>
							<div class="form-group">
                  <div class="col-sm-6 margin_top">
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" autocomplete="password_confirmation" placeholder="Confirm Password..">
                      @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                </div>
							</div>
              <div class="form-group row">
                <div class="col-sm-6 margin_top">
                  <button type="submit" class="btn btn-success mr-2 float-right">Submit</button>
                </div>
              </div>
            </form>
        </div>
      </div>
    </div>
</div>

@endsection