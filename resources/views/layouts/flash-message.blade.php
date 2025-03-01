@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">  
    <strong>{{ $message }}</strong>
</div>
@endif
  
@if ($message = Session::get('error'))
<div class="alert alert-danger alert-block" style="color:white">  
    <strong>{{ $message }}</strong>
</div>
@endif
   
@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-block" style="color:white">  
    <strong>{{ $message }}</strong>
</div>
@endif
   
@if ($message = Session::get('info'))
<div class="alert alert-info alert-block">  
    <strong>{{ $message }}</strong>
</div>
@endif
  
@if ($errors->any())
<div class="alert alert-danger" style="color:white">  
    @foreach ($errors->all() as $error)
         <div>{{$error}}</div>
     @endforeach
</div>
@endif