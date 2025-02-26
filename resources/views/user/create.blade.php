@extends('layouts.app')

@section('body')
<script src="{{ asset('js/jquery-3.4.1.min.js')}}"></script>
<h4 class="font-weight-bolder mb-0">Add/Edit Teacher</h4>
<div class="row margin_top">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
              
            <form enctype="multipart/form-data" @if (isset($user)) method="post" action="{{ route('user.update',$user) }}" @else method="post" action="{{ route('user.store') }}" @endif>
              @csrf
              <div class="form-group row">
                <div class="col-sm-6 margin_top">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Name...." @if(isset($user)) value="{{$user->name}}" @endif required autocomplete="off">
                </div>
                <div class="col-sm-6 margin_top">
                <label for="name">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="username...." @if(isset($user)) value="{{$user->username}}" @endif required autocomplete="off" @if(isset($user)) readonly @endif>
                </div>
                <div class="col-sm-6 margin_top">
                <label for="name">IC</label>
                <input type="text" class="form-control" id="ic" name="ic" placeholder="ic...." @if(isset($user)) value="{{$user->ic}}" @endif required autocomplete="off">
                </div>
                <div class="col-sm-6 margin_top">
                <label for="name">Contact</label>
                <input type="text" class="form-control" id="contact" name="contact" placeholder="contact...." @if(isset($user)) value="{{$user->contact}}" @endif required autocomplete="off">
                </div>
                <div class="col-sm-6 margin_top">
                <label for="name">Is Active</label>
                <select class="form-control" name="is_active">
                  <option value="1" <?php echo isset($user)&&$user->is_active == 1?'selected':'' ?>>Yes</option>
                  <option value="0" <?php echo isset($user)&&$user->is_active == 0?'selected':'' ?>>No</option>
                </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-12 margin_top">
                  <button type="submit" class="btn btn-success mr-2 float-right">Submit</button>
                  <a class="btn btn-light float-right margin-right" onclick="window.location.href='{{ route('user.index') }}'">Back</a>
                </div>
              </div>
            </form>
        </div>
      </div>
    </div>
</div>

@endsection