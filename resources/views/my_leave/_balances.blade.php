{{-- Leave balance cards. Expects $balances from MyLeaveController::balances(). --}}
@php $fmt = fn ($n) => rtrim(rtrim(number_format($n, 1), '0'), '.'); @endphp
<div class="row g-3">
  @foreach ($balances as $type => $b)
    <div class="col-6">
      <div class="card">
        <div class="card-body p-3">
          <p class="text-sm mb-1 text-secondary">{{ $b['label'] }}</p>
          <h4 class="font-weight-bolder mb-0">{{ $fmt($b['balance']) }} <span class="text-sm text-secondary font-weight-normal">/ {{ $fmt($b['entitled']) }} {{ __('days left') }}</span></h4>
          @php $pct = $b['entitled'] > 0 ? min(100, $b['used'] / $b['entitled'] * 100) : 0; @endphp
          <div class="progress mt-2" style="height:6px">
            <div class="progress-bar {{ $type === 'sick' ? 'bg-gradient-info' : 'bg-gradient-primary' }}" style="width: {{ $pct }}%"></div>
          </div>
          <p class="text-xs text-secondary mb-0 mt-1">{{ __(':used day(s) used this year', ['used' => $fmt($b['used'])]) }}</p>
        </div>
      </div>
    </div>
  @endforeach
</div>
