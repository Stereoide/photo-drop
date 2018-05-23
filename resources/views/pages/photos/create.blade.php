@extends('layouts.app')

@section('content')
    <script>
        const uploadUrl = '{{ route('photos.store') }}';
    </script>
    <script src="{{ asset('dropzone-5.4.0/dropzone.js') }}"></script>
    <link href="{{ asset('dropzone-5.4.0/min/dropzone.min.css') }}" rel="stylesheet">
    <script>
        Dropzone.autoDiscover = false;
        Dropzone.options.addedFile = function(file) {
            console.log(file);
        };
    </script>

    <div class="container">
        <div class="card photos photos-index">
            <div class="card-header">Photos hochladen</div>
            <div class="card-body">
                Hier kannst Du einfach alle deine Fotos von der Hochzeitsfeier von Anja und Jörn reinziehen und automatisch hochladen lassen.<br />
                <br />

                <form method="post" action="{{ route('photos.store') }}" enctype="multipart/form-data" class="dropzone" id="dropzone">
                    {{ csrf_field() }}
                    <div class="dz-message">
                        <div class="col-xs-8">
                            <div class="message">
                                <p>Hier Bilder reinfallen lassen oder klicken zum Bilder aussuchen</p>
                            </div>
                        </div>
                    </div>
                    <div class="fallback">
                        <input type="file" name="file" multiple>
                    </div>
                </form>

                <br />
                Bitte keine Bilder hochladen, die Du selbst nur per Whatsapp zugeschickt bekommen hast - diese sind qualitativ leider nicht wirklich brauchbar.<br />
            </div>
            <div class="card-footer text-muted">
                <a href="{{ route('photos.index') }}" class="btn btn-primary">Zur Übersicht</a>
            </div>
        </div>
    </div>
@endsection