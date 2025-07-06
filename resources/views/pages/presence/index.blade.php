@extends('layouts.main')
@section('content')
<div class="container my-4">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h4 class="card-title">
                        Daftar Kegiatan</h4>

                </div>
                <div class="col text-end">
                    <a href="{{route('presence.create')}}" class="btn btn-primary">
                        Tambah Data</a>
                 </div>
                </div>
            </div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
    </div>
</div>
@endsection

{{-- @push('js')
    <script >
        new DataTable('#datatable');
    </script>
@endpush --}}

@push('js')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}

<script>
    $(document).ready(function(){
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
    });
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        //const form = $(this).closest('form');
        let url = $(this).attr('href');

        if(confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            $.ajax({
                url: url,
                type: 'DELETE',
                success: function(data) {
                    
                    window.location.reload();
                },
                error: function(xhr, status, erorr) {
                    // Handle error response
                    console.log(error);
                }
            });
        }
        // if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        //     form.submit();
        // }
    });
</script>
@endpush