@extends('layouts.dashboard')
@section('title')
    <title>EXAM CRUD</title>
@endsection
@section('main')
    <h1>It's a Quiz Page</h1>
    <h2>Quiz Title: {{$quiz->title}}</h2>
    <h3>Exam Time: {{$quiz->duration}} Minutes or {{$quiz->duration*60}} Seconds</h3>

    <div class="text-center">
        <form method="post" id='examsQuestion' action="#">
            @csrf
            <input type="hidden" name="quiz_id" value="{{$quiz->id}}" readonly required>
            <input id="start_time" type="hidden" name="start_time" value="{{$start_time}}" readonly required>
            @php
            $i=1;
            @endphp
            @foreach($questions as $question)
                <select name="answer[{{$i++}}]" class="form-control" required>
                <option selected disabled value>Question: {{$question->question}}</option>
                    <option value="option_a">{{$question->option_a}}</option>
                    <option value="option_b">{{$question->option_b}}</option>
                    <option value="option_c">{{$question->option_c}}</option>
                    <option value="option_d">{{$question->option_d}}</option>
                </select>

                <hr>
            @endforeach
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

@endsection

@push('script')

<script>
    $("#examsQuestion").submit(function(e){
        e.preventDefault();
        var formdata = $(this).serialize();

        $.ajax({
                type:'POST',
               url:"{{route('store.answer')}}",
               data: formdata,
               dataType: 'json',
               headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
               success:function(data) {
                if (data.message ==="success") {
                    Swal.fire(data.data).then((req) =>{
                        location.href = "{{route('results')}}"
                    })

                }else{
                    Swal.fire(data.data)
                }
                $("#addExam").get(0).reset();

            }
        });
    });
  </script>

@endpush
