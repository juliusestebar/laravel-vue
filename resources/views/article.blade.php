<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <!-- Styles -->
        </head>
    <body>
        <div>
            @foreach($post as $article)
            <h1>{{ $article->status }}</h1>
            <h3>{{ $article->title }}</h3>
            <p>{{ $article->content }}</p>
            <img src="{{  asset("storage/".$article->image) }}"/>
            <p class="tags">{{ $article->tags }}</p>
            @endforeach
        </div>
    </body>

</html>
