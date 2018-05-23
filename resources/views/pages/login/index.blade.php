@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('login.store') }}">
    @csrf

    <div class="container">
        <div class="card login">
            <div class="card-header">Anmeldung</div>
            <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

                <div class="form-group">
                    <label for="token">Bitte gebe hier deine persönliche Kennung ein, die dir per Mail oder WhatsApp mitgeteilt wurde:</label>
                    <input type="text" name="token" class="form-control" id="token" aria-describedby="tokenHelp">
                    <small id="tokenHelp" class="form-text text-muted">Beispiel: 12345678-abcd-9876-zyxw-1a2b3c4d5e6f</small>
                </div>
            </div>
            <div class="card-footer text-muted">
                <input type="submit" class="btn btn-primary" value="Anmelden">
            </div>
        </div>
    </div>

    </form>
@endsection