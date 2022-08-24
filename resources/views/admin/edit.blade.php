@extends('layouts.dashboard')
@section('title')
    <title>Dashboard</title>
@endsection
@section('main')
    <h1>Edit Exam</h1>

    <div id="msg" class="p-3"></div>
    <div>
        <div>
            <div >
                <form method="post" id="addExam" action="'/give-quiz/{id}/edit'">
                    @csrf
                    <div class="form-group">
                        <input type="text" placeholder="Quiz Title" name="title" required value="{{$quiz->title}}" class="form-control">
                        <label>Valid From</label>
                        <input name="from_time" value="{{$quiz->from_time}}" type="datetime-local">
                        <label>Valid Till</label>
                        <input name="to_time" value="{{$quiz->to_time}}" type="datetime-local">
                        
                        
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Duration in Minute" value="{{$quiz->duration}}" name="duration" type="number" required>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('script')
<script>
    $("#addExam").submit(function(e){
        e.preventDefault();
        var formdata = $(this).serialize();

        $.ajax({
                type:'POST',
               url:"{{route('update.quiz')}}",
               data: formdata,
               dataType: 'json',
               headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
               success:function(data) {
                if (data.message ==="success") {
                    Swal.fire(data.data)

                }else{
                    Swal.fire(data.data)
                }
                $("#addExam").get(0).reset();

            }
        });
    });
  </script>



@endpush
