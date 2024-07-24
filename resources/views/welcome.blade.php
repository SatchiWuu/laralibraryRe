@extends('layouts.master')
@section('content')
{{ dump(Auth::check()) }}
<script src="{{ asset('js/home.js') }}"></script>
    <div id="bookDeck" class="container border border-secondary p-5 m-2 d-flex flex-wrap overflow-auto justify-content-between flex-row align-items-stretch" style="align-items:stretch;align-content: stretch;">
        
    </div>
@endsection