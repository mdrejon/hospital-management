@props([
    'latestBlogs' => collect(),
    'blog' => [],
])

@php
$blogFallbackImages = [asset('assets/img/blog-one.png'), asset('assets/img/blog-2.png'), null, asset('assets/img/blog-4.jpg')];
$blogCards = $latestBlogs->isNotEmpty()
    ? $latestBlogs->values()->map(fn ($b, $i) => [
        'title' => $b->title,
        'date'  => ($b->published_at ?: $b->created_at)->format('F j, Y'),
        'image' => $b->feature_image ? asset('storage/' . $b->feature_image) : ($blogFallbackImages[$i % 4] ?? asset('assets/img/blog-2.png')),
        'url'   => route('blog-details', $b->slug),
    ])
    : collect([
        ['title' => 'The Skincare Routine That Works Expert Tips.', 'date' => 'July 6, 2025', 'image' => asset('assets/img/blog-one.png'), 'url' => '#'],
        ['title' => 'The Art of Managing Business and Patient Care', 'date' => 'July 9, 2025', 'image' => asset('assets/img/blog-2.png'), 'url' => '#'],
        ['title' => 'Strategies for Balancing Business Demands wit …', 'date' => 'July 9, 2025', 'image' => null, 'url' => '#'],
        ['title' => 'Effective Healthcare Tips', 'date' => 'July 9, 2025', 'image' => asset('assets/img/blog-4.jpg'), 'url' => '#'],
    ]);
@endphp

<section class="blog">
  <div class="container mx-auto">
    <div class="blog__head">
      <h2 class="blog__title">{{ $blog['blog_home_title'] ?? __('frontend.home.blog_title') }}</h2>
      <a href="{{ route('blog-list') }}" class="btn-view-all">
        {{ __('frontend.common.view_all') }}
        <span class="btn-view-all__icon">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7 17 17 7M9 7h8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </span>
      </a>
    </div>

    <div class="blog__grid">
      @foreach($blogCards as $card)
      @if($loop->index === 0)
      <article class="blog-card blog-card--split is-tall">
        <img src="{{ $card['image'] }}" alt="{{ $card['title'] }}" class="blog-card__img" />
        <span class="blog-card--split__scrim" aria-hidden="true"></span>
        <div class="blog-card--split__top">
          <span class="blog-card__date"><span class="blog-card__date-dot"></span>{{ $card['date'] }}</span>
          <h3 class="blog-card--split__title">{{ $card['title'] }}</h3>
        </div>
        <a href="{{ $card['url'] }}" class="blog-card--split__cta">
          {{ __('frontend.common.read_more') }}
          <span class="blog-card--split__cta-icon">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </span>
        </a>
        <span class="blog-card--split__bubble"></span>
      </article>
      @elseif($loop->index === 2)
      <article class="blog-card blog-card--plain">
        <div>
          <span class="blog-card__date"><span class="blog-card__date-dot"></span>{{ $card['date'] }}</span>
          <h3 class="blog-card--plain__title">{{ $card['title'] }}</h3>
        </div>
        <div class="blog-card--plain__footer">
          <a href="{{ $card['url'] }}" class="blog-card__arrow" aria-label="Read more">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M7 17 17 7M9 7h8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </a>
        </div>
      </article>
      @else
      <article class="blog-card blog-card--photo {{ $loop->index === 1 ? 'is-tall' : '' }}">
        <img src="{{ $card['image'] }}" alt="{{ $card['title'] }}" class="blog-card__img" @if($loop->index === 1) style="object-position: 50% 20%;" @endif />
        <span class="blog-card__overlay"></span>
        <span class="blog-card__date relative z-10 w-fit"><span class="blog-card__date-dot"></span>{{ $card['date'] }}</span>
        <div class="blog-card--photo__footer">
          <h3 class="blog-card--photo__title">{{ $card['title'] }}</h3>
          <a href="{{ $card['url'] }}" class="blog-card__arrow" aria-label="Read more">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M7 17 17 7M9 7h8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </a>
        </div>
      </article>
      @endif
      @endforeach
    </div>
  </div>
</section>
