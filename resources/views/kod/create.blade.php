@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <a class="text-muted fw-light" href="{{route('kod.index')}}">Kod /</a> 
         @if (isset($kod)) Edit @else Create @endif
    </h4>
    <div class="row">
        <div class="col-12">
            <div class="card">
            <h5 class="card-header">Kod Details</h5>
            <div class="card-body">
                <form class="row g-3" enctype="multipart/form-data" @if (isset($kod)) method="post" action="{{ route('kod.update',$kod) }}" @else method="post" action="{{ route('kod.store') }}" @endif onsubmit="showLoading()">
                @csrf
                <div class="col-md-7">
                    <label class="form-label">Kod Kerja</label>
                    <input
                    type="text"
                    class="form-control"
                    placeholder="A01"
                    name="code"
                    value="{{$kod->code??''}}" 
                    required
                    @if(isset($kod)) readonly @endif/>
                </div>
                <div class="col-md-7">
                    <label class="form-label">Description</label>
                    <input
                    type="text"
                    class="form-control"
                    placeholder="Descriptions "
                    name="description"
                    value="{{$kod->description??''}}" />
                </div>
                <div class="col-md-6">
                    <label class="form-label">Boss Amount</label>
                    <input
                    type="number"
                    min="0"
                    step="0.0001"
                    class="form-control"
                    placeholder="0.123"
                    name="boss_amount"
                    value="{{$kod->boss_amount??''}}" 
                    required/>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Worker Amount</label>
                    <input
                    type="number"
                    min="0"
                    step="0.0001"
                    class="form-control"
                    placeholder="0.123"
                    name="worker_amount"
                    value="{{$kod->worker_amount??''}}" 
                    required/>
                </div>
                @if(isset($kod))
                <div class="col-md-7">
                    <label class="form-label" for="password">Is Active?</label>
                    <select name="is_active" class="form-control">
                        <option value="1" <?php echo isset($kod)&&$kod->is_active == 1?'selected':'' ?>>Active</option>
                        <option value="0" <?php echo isset($kod)&&$kod->is_active == 0?'selected':'' ?>>Inactive</option>
                    </select>
                </div>
                @endif
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
