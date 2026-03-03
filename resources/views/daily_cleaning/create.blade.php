@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <a class="text-muted fw-light" href="{{ route('daily_cleaning.index') }}">Daily Cleaning /</a>
        @if (isset($daily_cleaning)) Edit @else Create @endif
    </h4>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <h5 class="card-header">Daily Cleaning Details</h5>
                <div class="card-body">
                    <form enctype="multipart/form-data" @if (isset($daily_cleaning)) method="post" action="{{ route('daily_cleaning.update',$daily_cleaning) }}" @else method="post" action="{{ route('daily_cleaning.store') }}" @endif onsubmit="showLoading()" >
                        @csrf
                        <div class="row g-3">
                            <!-- Cleaning Info -->
                            <div class="col-md-4">
                                <label class="form-label">Daily Cleaning No.</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="daily_cleaning_no"
                                    value="{{ $daily_cleaning->daily_cleaning_no ?? $daily_cleaning_no ?? '' }}"
                                    required
                                    readonly
                                />
                                <input type="hidden" name="code" value="{{ $code ?? '' }}">
                                <input type="hidden" name="year" value="{{ $year ?? '' }}">
                                <input type="hidden" name="month" value="{{ $month ?? '' }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Date</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    name="daily_cleaning_date"
                                    value="{{ $daily_cleaning->daily_cleaning_date ?? date('Y-m-d') }}"
                                    required
                                    @if(isset($daily_cleaning)) readonly @endif
                                />
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Sales (RM)</label>
                                <input
                                    type="number"
                                    step="0.01"
                                    class="form-control"
                                    name="sales"
                                    value="{{ $daily_cleaning->sales ?? '' }}"
                                    placeholder="Enter amount collected"
                                    required
                                />
                            </div>

                            <!-- Customer Info -->
                            <div class="col-md-4">
                                <label class="form-label">Customer Name</label>
                                <input
                                    list="customerList"
                                    type="text"
                                    class="form-control"
                                    name="customer_name"
                                    id="customer_name"
                                    value="{{ $daily_cleaning->customer_name ?? '' }}"
                                    placeholder="Enter customer name"
                                    required
                                    autocomplete="off"
                                    @if(isset($daily_cleaning)) readonly @endif
                                />

                                <datalist id="customerList">
                                    @foreach($customer as $cust)
                                        <option 
                                            value="{{ $cust->customer_name }}" 
                                            data-contact="{{ $cust->customer_contact }}"
                                            data-address="{{ $cust->address }}"
                                        ></option>
                                    @endforeach
                                </datalist>
                            </div>


                            <div class="col-md-6">
                                <label class="form-label">Customer Contact</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="customer_contact"
                                    name="customer_contact"
                                    value="{{ $daily_cleaning->customer_contact ?? '' }}"
                                    placeholder="Enter customer phone number"
                                />
                            </div>

                            <div class="col-12">
                                <label class="form-label">Address</label>
                                <textarea
                                    class="form-control"
                                    id="address"
                                    name="address"
                                    rows="2"
                                    placeholder="Enter customer address"
                                >{{ $daily_cleaning->address ?? '' }}</textarea>
                            </div>


                            <!-- Time Info -->
                            <div class="col-md-6">
                                <label class="form-label">Start Time</label>
                                <input
                                    type="time"
                                    class="form-control"
                                    name="start_time"
                                    value="{{ $daily_cleaning->start_time ?? '' }}"
                                    required
                                />
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">End Time</label>
                                <input
                                    type="time"
                                    class="form-control"
                                    name="end_time"
                                    value="{{ $daily_cleaning->end_time ?? '' }}"
                                    required
                                />
                            </div>

                            <!-- Driver and Cleaner -->
                            <div class="col-md-6 mb-4">
                                <label for="select2Basic" class="form-label">Driver</label>
                                <select id="select2Basic" name="driver_id" class="select2 form-select" data-allow-clear="true" @if(isset($daily_cleaning)) disabled @endif>
                                    @foreach($drivers as $driver)
                                        <option value="{{ $driver->id }}" @if(isset($daily_cleaning) && $daily_cleaning->driver_id == $driver->id) selected @endif>
                                            {{ $driver->name ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="select2Multiple" class="form-label">Cleaners</label>
                                <select id="select2Multiple" name="cleaner_ids[]" class="select2 form-select" multiple>
                                    @foreach($cleaners as $cleaner)
                                        <option value="{{ $cleaner->id }}" @if(isset($daily_cleaning) && in_array($cleaner->id, $daily_cleaning->cleaner_ids)) selected @endif>
                                            {{ $cleaner->name ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <hr>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('customer_name');
    const contactInput = document.getElementById('customer_contact');
    const addressTextarea = document.getElementById('address');
    const options = document.querySelectorAll('#customerList option');

    nameInput.addEventListener('input', function() {
        const inputValue = this.value.trim();
        const match = Array.from(options).find(opt => opt.value === inputValue);
        if (match) {
            contactInput.value = match.getAttribute('data-contact') || '';
            addressTextarea.value = match.getAttribute('data-address') || '';
        } else {
            contactInput.value = '';
            addressTextarea.value = '';
        }
    });
});
</script>
@endsection

