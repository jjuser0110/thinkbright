@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <a class="text-muted fw-light" href="{{route('supervisor.index')}}">Supervisor /</a> 
         @if (isset($supervisor)) Edit @else Create @endif
    </h4>
    <div class="row">
        <div class="col-12">
            <div class="card">
            <h5 class="card-header">Supervisor Details</h5>
            <div class="card-body">
                <form class="row g-3" enctype="multipart/form-data" @if (isset($supervisor)) method="post" action="{{ route('supervisor.update',$supervisor) }}" @else method="post" action="{{ route('supervisor.store') }}" @endif onsubmit="showLoading()">
                @csrf
                <div class="col-md-7">
                    <label class="form-label" for="supervisor_name">Supervisor Name</label>
                    <input
                    type="text"
                    class="form-control"
                    placeholder="Supervisor Name"
                    name="name"
                    value="{{$supervisor->name??''}}" 
                    required/>
                </div>
                <div class="col-md-7">
                    <label class="form-label" for="supervisor_username">Supervisor Username</label>
                    <input
                    type="text"
                    class="form-control"
                    placeholder="username"
                    name="username" 
                    value="{{$supervisor->username??''}}"
                    required
                    @if(isset($supervisor)) readonly @endif
                    />
                </div>
                <div class="col-md-7">
                    <label class="form-label" for="password">Password</label>
                    <input
                    type="password"
                    class="form-control"
                    placeholder="password"
                    name="password"
                    @if(!isset($supervisor)) required @endif />
                </div>
                @if(isset($supervisor))
                <div class="col-md-7">
                    <label class="form-label" for="password">Is Active?</label>
                    <select name="is_active" class="form-control">
                        <option value="1" <?php echo isset($supervisor)&&$supervisor->is_active == 1?'selected':'' ?>>Active</option>
                        <option value="0" <?php echo isset($supervisor)&&$supervisor->is_active == 0?'selected':'' ?>>Inactive</option>
                    </select>
                </div>
                @endif
                <hr>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
@endsection

@section('scripts')
@endsection
