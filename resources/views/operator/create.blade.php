@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <a class="text-muted fw-light" href="{{route('operator.index')}}">Operator /</a> 
         @if (isset($operator)) Edit @else Create @endif
    </h4>
    <div class="row">
        <div class="col-12">
            <div class="card">
            <h5 class="card-header">Operator Details</h5>
            <div class="card-body">
                <form class="row g-3" enctype="multipart/form-data" @if (isset($operator)) method="post" action="{{ route('operator.update',$operator) }}" @else method="post" action="{{ route('operator.store') }}" @endif onsubmit="showLoading()">
                @csrf
                <div class="col-md-7">
                    <label class="form-label" for="operator_name">Operator Name</label>
                    <input
                    type="text"
                    class="form-control"
                    placeholder="Operator Name"
                    name="name"
                    value="{{$operator->name??''}}" 
                    required/>
                </div>
                <div class="col-md-7">
                    <label class="form-label" for="operator_username">Operator Username</label>
                    <input
                    type="text"
                    class="form-control"
                    placeholder="username"
                    name="username" 
                    value="{{$operator->username??''}}"
                    required
                    @if(isset($operator)) readonly @endif
                    />
                </div>
                <div class="col-md-7">
                    <label class="form-label" for="password">Password</label>
                    <input
                    type="password"
                    class="form-control"
                    placeholder="password"
                    name="password"
                    @if(!isset($operator)) required @endif />
                </div>
                <div class="col-md-7">
                    <label class="form-label">Salary Per Day (RM) (For Full Time)</label>
                    <input
                        type="number"
                        step="0.01"
                        class="form-control"
                        name="salary_per_day"
                        value="{{ $operator->salary_per_day ?? 0 }}"
                        placeholder="Enter daily salary"
                    />
                </div>
                @if(isset($operator))
                <div class="col-md-7">
                    <label class="form-label" for="password">Is Active?</label>
                    <select name="is_active" class="form-control">
                        <option value="1" <?php echo isset($operator)&&$operator->is_active == 1?'selected':'' ?>>Active</option>
                        <option value="0" <?php echo isset($operator)&&$operator->is_active == 0?'selected':'' ?>>Inactive</option>
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
