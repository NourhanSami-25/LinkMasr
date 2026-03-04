@extends('layout.app')

@section('title')
    {{ __('general.create_expense') }}
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h1>Test Page</h1>
            <p>This is a test page to check if the basic structure works.</p>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        console.log('Test page loaded');
    </script>
@endsection