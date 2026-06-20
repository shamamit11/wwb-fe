<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
<title>{{ config('site.name', config('app.name')) }}</title>
<link>{{ url('/') }}</link>
<description>{{ config('site.description') }}</description>
<language>{{ str_replace('_', '-', app()->getLocale()) }}</language>
<lastBuildDate>{{ $lastBuildDate }}</lastBuildDate>
<atom:link href="{{ route('rss.feed') }}" rel="self" type="application/rss+xml" />
@foreach ($items as $item)
<item>
<title>{{ e((string) data_get($item, 'title', 'Untitled')) }}</title>
<link>{{ e((string) data_get($item, 'link', url('/'))) }}</link>
<guid isPermaLink="true">{{ e((string) data_get($item, 'link', url('/'))) }}</guid>
<description>{{ e((string) data_get($item, 'description', '')) }}</description>
<pubDate>{{ \Carbon\CarbonImmutable::parse((string) data_get($item, 'published_at', now()->toISOString()))->toRfc2822String() }}</pubDate>
@if (filled(data_get($item, 'author.name')))
<author>{{ e((string) data_get($item, 'author.name')) }}</author>
@endif
@if (filled(data_get($item, 'category.name')))
<category>{{ e((string) data_get($item, 'category.name')) }}</category>
@endif
</item>
@endforeach
</channel>
</rss>
