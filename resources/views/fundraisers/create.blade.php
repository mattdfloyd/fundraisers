@extends('layouts.content')

@section('header', 'Add Fundraiser')

@section('main')

<form action="{{ route('fundraisers.store') }}" method="POST">
    @csrf

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ old('name') }}" required>

        @if ($errors->has('name'))
            <div class="invalid-feedback">
                {{ $errors->first('name') }}
            </div>
        @endif
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection
