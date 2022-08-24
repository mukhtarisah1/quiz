@extends('layouts.dashboard')
@section('title')
    <title>Dashboard</title>
@endsection
@section('main')
    <h1>Exam List</h1>
    <div class="text-center">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">From</th>
                <th scope="col">To</th>
                <th scope="col">Duration</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @php
            $sl=1;
            @endphp
            @foreach($quiz_list as $quiz)
                <tr>
                    <th scope="row">{{$sl++}}</th>
                    <td><a href="/add-question/{{$quiz->id}}" target="_blank">{{$quiz->title}}</a></td>
                    <td>{{$quiz->from_time}}</td>
                    <td>{{$quiz->to_time}}</td>
                    <td>{{$quiz->duration}} minutes</td>
                    <td><a class="btn btn-success" href="/give-quiz/{{ $quiz->id }}/edit">EDIT</a> <div class="btn btn-danger del" delete-id="{{ $quiz->id }}" >DELETE</div> </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('script')

<script>
    $('.del').click(function(){
        var id = $(this).attr('delete-id');

        Swal.fire({
        title: 'Do you want to delete this question?',
        showCancelButton: true,
        confirmButtonText: 'YES',
        }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                type:'post',
                url: "{{ route('store.delete')  }}",
                dataType:'json',
                data:{id:id},
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success : function(data){
                    Swal.fire(data.data).then((result) => {
                        // Reload the Page
                        location.reload();
                        });
                }
            });


        }
        })

    });
</script>
@endpush
