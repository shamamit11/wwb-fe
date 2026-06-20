@props([
    'title' => config('site.name', config('app.name')),
    'description' => config('site.description'),
    'canonical' => null,
    'image' => null,
    'type' => 'website',
    'robots' => 'index,follow',
    'schema' => [],
])

<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<meta name="robots" content="{{ $robots }}">

@if ($canonical)
    <link rel="canonical" href="{{ $canonical }}">
@endif

<meta property="og:site_name" content="{{ config('site.name', config('app.name')) }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:type" content="{{ $type }}">
<meta property="og:url" content="{{ $canonical ?? url()->current() }}">

<meta name="twitter:card" content="{{ $image ? 'summary_large_image' : 'summary' }}">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">

@if ($image)
    <meta property="og:image" content="{{ $image }}">
    <meta name="twitter:image" content="{{ $image }}">
@endif

@foreach ($schema as $entry)
    <script type="application/ld+json">{!! json_encode($entry, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}</script>
@endforeach
