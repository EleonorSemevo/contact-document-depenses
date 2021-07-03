@extends(backpack_view('blank'))

@php
    $widgets['before_content'][] = [
        'type'        => 'my_jumbotron',
      
    ];
@endphp

@section('content')
@endsection