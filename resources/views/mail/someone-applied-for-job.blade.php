{{--@formatter:off--}}
<x-mail::message>
Für den Job...

**{{ $jobApplication->job?->title }}**

...ging folgende Anfrage ein:

Name: {{ $jobApplication->name }}

E-Mail: {{ $jobApplication->email }}

Telefon: {{ $jobApplication->phone }}

Anschreiben:

{!! nl2br($jobApplication->cover_letter) !!}

Portfolio:

{!! nl2br($jobApplication->links) !!}

@foreach($jobApplication->getCdnUrls('files') as $fileIndex => $file)
[Datei {{ $fileIndex + 1 }}]({{ $file }})<br>
@endforeach
</x-mail::message>

