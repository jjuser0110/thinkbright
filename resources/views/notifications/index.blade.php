@extends('layouts.app')

@section('title', __('Notifications'))

@section('body')
<div class="card">
  <div class="card-header pb-0 d-flex justify-content-between align-items-center">
    <h6 class="mb-0">{{ __('Notifications') }}</h6>
    @if (auth()->user()->unreadNotifications()->exists())
      <form method="POST" action="{{ route('notifications.read_all') }}">
        @csrf
        <button type="submit" class="btn btn-sm btn-outline-secondary mb-0">{{ __('Mark all read') }}</button>
      </form>
    @endif
  </div>
  <div class="card-body">
    <ul class="list-group list-group-flush">
      @forelse ($notifications as $n)
        <li class="list-group-item bg-transparent px-0 d-flex justify-content-between align-items-start">
          <a href="{{ route('notifications.open', $n->id) }}" class="text-sm {{ $n->read_at ? 'text-secondary' : 'font-weight-bold text-dark' }}">
            @unless ($n->read_at)<i class="fa-solid fa-circle text-primary me-2" style="font-size:.5rem;vertical-align:middle"></i>@endunless
            {{ $n->data['message'] ?? __('Notification') }}
          </a>
          <span class="text-xs text-secondary text-nowrap ms-3">{{ $n->created_at->diffForHumans() }}</span>
        </li>
      @empty
        <li class="list-group-item bg-transparent px-0 text-sm text-secondary">{{ __('No notifications yet.') }}</li>
      @endforelse
    </ul>
    <div class="mt-3">{{ $notifications->links('pagination::bootstrap-5') }}</div>
  </div>
</div>
@endsection
