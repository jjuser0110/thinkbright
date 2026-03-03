@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <a class="text-muted fw-light" href="{{route('cleaner.index')}}">Cleaner /</a> 
         @if (isset($cleaner)) Edit @else Create @endif
    </h4>
    <div class="row">
        <div class="col-12">
            <div class="card">
            <h5 class="card-header">Cleaner Details</h5>
            <div class="card-body">
                <form class="row g-3" enctype="multipart/form-data" @if (isset($cleaner)) method="post" action="{{ route('cleaner.update',$cleaner) }}" @else method="post" action="{{ route('cleaner.store') }}" @endif onsubmit="showLoading()">
                @csrf
                <div class="col-md-7">
                    <label class="form-label" for="leader_name">Cleaner Name</label>
                    <input
                    type="text"
                    class="form-control"
                    placeholder="Cleaner Name"
                    name="name"
                    value="{{$cleaner->name??''}}" 
                    required/>
                </div>
                <div class="col-md-7">
                    <label class="form-label" for="leader_username">Cleaner Username</label>
                    <input
                    type="text"
                    class="form-control"
                    placeholder="username"
                    name="username" 
                    value="{{$cleaner->username??''}}"
                    required
                    @if(isset($cleaner)) readonly @endif
                    />
                </div>
                <div class="col-md-7">
                    <label class="form-label" for="password">Password</label>
                    <input
                    type="password"
                    class="form-control"
                    placeholder="password"
                    name="password"
                    @if(!isset($cleaner)) required @endif />
                </div>
                <div class="col-md-7">
                    <label class="form-label">Salary Per Day (RM) (For Full Time)</label>
                    <input
                        type="number"
                        step="0.01"
                        class="form-control"
                        name="salary_per_day"
                        value="{{ $cleaner->salary_per_day ?? 0}}"
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
                        value="{{ $cleaner->salary_per_hour ?? 0 }}"
                        placeholder="Enter hourly salary"
                    />
                </div>
                @if(isset($cleaner))
                <div class="col-md-7">
                    <label class="form-label" for="password">Is Active?</label>
                    <select name="is_active" class="form-control">
                        <option value="1" <?php echo isset($cleaner)&&$cleaner->is_active == 1?'selected':'' ?>>Active</option>
                        <option value="0" <?php echo isset($cleaner)&&$cleaner->is_active == 0?'selected':'' ?>>Inactive</option>
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
