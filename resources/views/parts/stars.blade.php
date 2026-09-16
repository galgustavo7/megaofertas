@props(['rating'])
@php $pct = min(100, (float) $rating / 5 * 100); @endphp
<span class="stars" style="--pct: {{ $pct }}%" role="img" aria-label="{{ $rating }} de 5 estrellas">
    <span class="stars-bg">★★★★★</span>
    <span class="stars-fg" style="width: {{ $pct }}%">★★★★★</span>
</span>
