<!DOCTYPE html>
<html class="h-full">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        
    </head>

    <body class="h-auto min-h-full">
        @foreach($entries as $entry)
            <p>{{ $entry->title }}</p>
        @endforeach
    </body>
</html>
