@extends('layouts.app')
@section('title')
    ButikTrend

    @endsection
@section('content')


<script>
    window.user = @json($user);
</script>
<div id="app">

</div>
@endsection
