@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>

    <div class="container">
        <div class="card photos photos-index">
            <div class="card-header">Deine Photos</div>
            <div class="card-body">
            @if ($user->photos->isEmpty())
                Du hast bisher noch keine Photos hochgeladen.
            @else
                @foreach ($user->photos as $photo)
                    <a class="photo thumbnail" data-fancybox="gallery" href="{{ '/photo-drop/public' . optional($photo)->getFirstMediaUrl() }}"><img src="{{ '/photo-drop/public' . optional($photo->getFirstMedia())->getUrl('thumbnail') }}" alt="" border="0" /></a>
                @endforeach
            @endif
            </div>
            <div class="card-footer text-muted">
                <a href="{{ route('photos.create') }}" class="btn btn-primary">Photos hochladen</a>
            </div>
        </div>
    </div>
@endsection