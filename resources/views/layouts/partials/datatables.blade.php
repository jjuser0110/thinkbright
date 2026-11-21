{{-- Usage: @include('layouts.partials.datatables', ['table' => '#my-table', 'options' => ['order' => [[0, 'asc']]]]) --}}
@push('styles')
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush
@push('scripts')
  <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script>
    $(function () {
      $(@json($table)).DataTable(Object.assign({ lengthChange: false, autoWidth: false, pageLength: 25 }, @json($options ?? (object) [])));
    });
  </script>
@endpush
