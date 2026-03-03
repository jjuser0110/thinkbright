@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <a class="text-muted fw-light" href="{{route('holiday.index')}}">Public Holiday /</a> 
         @if (isset($holiday)) Edit @else Create @endif
    </h4>
    <div class="row">
        <div class="col-12">
            <div class="card">
            <h5 class="card-header">Public Holiday Details</h5>
            <div class="card-body">
                <form class="row g-3" enctype="multipart/form-data" @if (isset($holiday)) method="post" action="{{ route('holiday.update',$holiday) }}" @else method="post" action="{{ route('holiday.store') }}" @endif onsubmit="showLoading()">
                @csrf
                <div class="col-md-6">
                    <label class="form-label">Title</label>
                    <input
                    type="text"
                    class="form-control"
                    placeholder="Chinese New Year"
                    name="title"
                    value="{{$holiday->title??''}}" 
                    required/>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Date</label>
                    <input
                    type="date"
                    class="form-control"
                    name="date" 
                    value="{{$holiday->date??''}}"
                    required/>
                </div>
                <hr>
                <div class="col-12">
                    <button type="submit" name="submitButton" class="btn btn-primary">Submit</button>
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
