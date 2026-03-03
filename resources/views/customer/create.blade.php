@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <a class="text-muted fw-light" href="{{route('customer.index')}}">Customer /</a> 
         @if (isset($customer)) Edit @else Create @endif
    </h4>
    <div class="row">
        <div class="col-12">
            <div class="card">
            <h5 class="card-header">Customer Details</h5>
            <div class="card-body">
                <form class="row g-3" enctype="multipart/form-data" @if (isset($customer)) method="post" action="{{ route('customer.update',$customer) }}" @else method="post" action="{{ route('customer.store') }}" @endif onsubmit="showLoading()">
                @csrf
                <div class="col-md-6">
                    <label class="form-label">Customer Name</label>
                    <input
                    type="text"
                    class="form-control"
                    placeholder="customer name"
                    name="customer_name"
                    value="{{$customer->customer_name??''}}" 
                    required
                    @if(isset($customer)) readonly @endif />
                </div>
                <div class="col-md-6">
                    <label class="form-label">Customer Contact</label>
                    <input
                    type="text"
                    class="form-control"
                    placeholder="customer contact"
                    name="customer_contact" 
                    value="{{$customer->customer_contact??''}}"
                    />
                </div>
                <div class="col-md-6">
                    <label class="form-label">Address</label>
                    <input
                    type="text"
                    class="form-control"
                    placeholder="address"
                    name="address" 
                    value="{{$customer->address??''}}"
                    />
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
