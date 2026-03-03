@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <a class="text-muted fw-light" href="{{route('driver.index')}}">Driver /</a> 
         @if (isset($driver)) Edit @else Create @endif
    </h4>
    <div class="row">
        <div class="col-12">
            <div class="card">
            <h5 class="card-header">Driver Details</h5>
            <div class="card-body">
                <form class="row g-3" enctype="multipart/form-data" @if (isset($driver)) method="post" action="{{ route('driver.update',$driver) }}" @else method="post" action="{{ route('driver.store') }}" @endif onsubmit="showLoading()">
                @csrf
                <div class="col-md-7">
                    <label class="form-label" for="leader_name">Driver Name</label>
                    <input
                    type="text"
                    class="form-control"
                    placeholder="Driver Name"
                    name="name"
                    value="{{$driver->name??''}}" 
                    required/>
                </div>
                <div class="col-md-7">
                    <label class="form-label" for="leader_username">Driver Username</label>
                    <input
                    type="text"
                    class="form-control"
                    placeholder="username"
                    name="username" 
                    value="{{$driver->username??''}}"
                    required
                    @if(isset($driver)) readonly @endif
                    />
                </div>
                <div class="col-md-7">
                    <label class="form-label" for="password">Password</label>
                    <input
                    type="password"
                    class="form-control"
                    placeholder="password"
                    name="password"
                    @if(!isset($driver)) required @endif />
                </div>
                <div class="col-md-7">
                    <label class="form-label">Salary Per Day (RM) (For Full Time)</label>
                    <input
                        type="number"
                        step="0.01"
                        class="form-control"
                        name="salary_per_day"
                        value="{{ $driver->salary_per_day ?? 0}}"
                        placeholder="Enter daily salary"
                    />
                </div>
                <div class="col-md-7">
                    <label class="form-label">Salary Per Hour (RM) (For Part Time)</label>
                    <input
                        type="number"
                        step="0.01"
                        class="form-control"
                        name="salary_per_hour"
                        value="{{ $driver->salary_per_hour ?? 0 }}"
                        placeholder="Enter hourly salary"
                    />
                </div>
                @if(isset($driver))
                <div class="col-md-7">
                    <label class="form-label" for="password">Is Active?</label>
                    <select name="is_active" class="form-control">
                        <option value="1" <?php echo isset($driver)&&$driver->is_active == 1?'selected':'' ?>>Active</option>
                        <option value="0" <?php echo isset($driver)&&$driver->is_active == 0?'selected':'' ?>>Inactive</option>
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
