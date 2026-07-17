@extends('layouts.frontend')

@section('title', 'Blog Details | ClinicMaster Medical & Health Care Services')

@section('content')

    <!-- ===================== Breadcrumb / Page header ===================== -->
    <section class="page-header">
      <div class="page-header__media">
        <img src="{{ asset('assets/img/breadcumb.webp') }}" alt="Team of ClinicMaster doctors" class="page-header__bg" />
        <span class="page-header__overlay"></span>
      </div>

      <span class="page-header__badge">24/7 Emergency Service</span>

      <div class="page-header__social">
        <a href="#" class="page-header__social-link" aria-label="Facebook">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M13.5 21v-7.5h2.5l.4-3H13.5V8.4c0-.87.24-1.46 1.5-1.46h1.6V4.35C16.3 4.24 15.4 4.15 14.3 4.15c-2.3 0-3.9 1.4-3.9 4v2.35H8v3h2.4V21h3.1z"/></svg>
        </a>
        <a href="#" class="page-header__social-link" aria-label="Twitter">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M22 5.9c-.7.3-1.5.6-2.3.7.8-.5 1.5-1.3 1.8-2.3-.8.5-1.7.8-2.6 1a4.1 4.1 0 0 0-7 3.7A11.6 11.6 0 0 1 3.4 4.6a4.1 4.1 0 0 0 1.3 5.5c-.7 0-1.3-.2-1.9-.5v.1c0 2 1.4 3.6 3.3 4a4.1 4.1 0 0 1-1.9.1c.5 1.7 2.1 2.9 4 2.9A8.2 8.2 0 0 1 2 18.6a11.6 11.6 0 0 0 6.3 1.8c7.5 0 11.7-6.3 11.7-11.7v-.5c.8-.6 1.5-1.3 2-2.1z"/></svg>
        </a>
        <a href="#" class="page-header__social-link" aria-label="LinkedIn">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M6.9 8.4H3.5V20h3.4V8.4zM5.2 3.5a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM20.5 20h-3.4v-6.1c0-1.5-.5-2.5-1.8-2.5-1 0-1.6.7-1.9 1.3-.1.2-.1.6-.1.9V20H9.9s.1-10.6 0-11.6h3.4v1.6c.5-.7 1.3-1.8 3.1-1.8 2.3 0 4 1.5 4 4.6V20z"/></svg>
        </a>
        <a href="#" class="page-header__social-link" aria-label="Instagram">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3.5" y="3.5" width="17" height="17" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.2" cy="6.8" r="1"/></svg>
        </a>
      </div>

      <div class="page-header__inner">
        <h1 class="page-header__title">Blog Details</h1>
        <nav class="page-header__breadcrumb" aria-label="Breadcrumb">
          <a href="{{ route('home') }}">Home</a>
          <span class="page-header__breadcrumb-sep">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="m7 6 5 6-5 6M13 6l5 6-5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
          <span>Blog Details</span>
        </nav>
      </div>

      <a href="tel:11234567890" class="page-header__call">
        <span class="page-header__call-icon">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" stroke="currentColor" stroke-width="1.6"/>
          </svg>
        </span>
        <span class="page-header__call-text">1 123 456 7890</span>
      </a>
    </section>

    <!-- ===================== Blog Details ===================== -->
    <section class="blog-list">
      <div class="container mx-auto">
        <div class="blog-list__grid">
          <article class="blog-details__article">
            <img src="{{ asset('assets/img/slider-1.3.jpg') }}" alt="Medical team wearing masks" class="blog-details__hero-img" />

            <p class="blog-details__meta">
              July 14, 2025
              <span class="blog-post-card__meta-dot"></span>
              BY <span class="blog-post-card__meta-author">Kelly Smith</span>
            </p>
            <h2 class="blog-details__title">The Role of Nutrition in Preventative Medicine</h2>

            <p class="blog-details__text">
              Nutrition is one of the most powerful tools in preventing chronic disease and promoting long-term
              wellness. This blog explores how balanced, nutrient-rich diets support the immune system, reduce
              inflammation, and lower the risk of conditions like diabetes, heart disease, and obesity&mdash;making
              food a first line of defense in modern medicine.
            </p>

            <blockquote class="blog-details__quote">
              Let food be thy medicine and medicine be thy food. &ndash; Hippocrates
              Modern science proves: prevention starts on your plate.
            </blockquote>

            <p class="blog-details__text">
              In the world of preventative healthcare, what you eat matters. This article dives into how strategic
              nutrition can prevent illness before it starts. Learn how everyday choices&mdash;from fiber to
              antioxidants&mdash;play a vital role in supporting optimal health and reducing dependence on
              medication.
            </p>

            <div class="blog-details__share">
              <div class="blog-details__share-tags">
                <span class="blog-details__share-label">Tags:</span>
                <a href="#" class="blog-details__share-tag">Health</a>
                <a href="#" class="blog-details__share-tag">Blood</a>
              </div>
              <div class="blog-details__share-socials">
                <a href="#" class="blog-details__share-social" aria-label="Share on Facebook">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M13.5 21v-7.5h2.5l.4-3H13.5V8.4c0-.87.24-1.46 1.5-1.46h1.6V4.35C16.3 4.24 15.4 4.15 14.3 4.15c-2.3 0-3.9 1.4-3.9 4v2.35H8v3h2.4V21h3.1z"/></svg>
                </a>
                <a href="#" class="blog-details__share-social" aria-label="Share on Twitter">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M22 5.9c-.7.3-1.5.6-2.3.7.8-.5 1.5-1.3 1.8-2.3-.8.5-1.7.8-2.6 1a4.1 4.1 0 0 0-7 3.7A11.6 11.6 0 0 1 3.4 4.6a4.1 4.1 0 0 0 1.3 5.5c-.7 0-1.3-.2-1.9-.5v.1c0 2 1.4 3.6 3.3 4a4.1 4.1 0 0 1-1.9.1c.5 1.7 2.1 2.9 4 2.9A8.2 8.2 0 0 1 2 18.6a11.6 11.6 0 0 0 6.3 1.8c7.5 0 11.7-6.3 11.7-11.7v-.5c.8-.6 1.5-1.3 2-2.1z"/></svg>
                </a>
                <a href="#" class="blog-details__share-social" aria-label="Share on LinkedIn">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M6.9 8.4H3.5V20h3.4V8.4zM5.2 3.5a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM20.5 20h-3.4v-6.1c0-1.5-.5-2.5-1.8-2.5-1 0-1.6.7-1.9 1.3-.1.2-.1.6-.1.9V20H9.9s.1-10.6 0-11.6h3.4v1.6c.5-.7 1.3-1.8 3.1-1.8 2.3 0 4 1.5 4 4.6V20z"/></svg>
                </a>
                <a href="#" class="blog-details__share-social" aria-label="Share on Instagram">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3.5" y="3.5" width="17" height="17" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.2" cy="6.8" r="1"/></svg>
                </a>
              </div>
            </div>

            <div class="blog-details__author">
              <img src="{{ asset('assets/img/about-image.webp') }}" alt="Kelly Smith" class="blog-details__author-photo" />
              <div>
                <h3 class="blog-details__author-name">By Kelly Smith</h3>
                <p class="blog-details__author-bio">
                  A dedicated medical professional with extensive experience in providing compassionate,
                  patient-centered care. With a strong commitment to improving the health and well-being of
                  patients, this doctor utilizes evidence-based practices and personalized treatment plans to
                  ensure the best possible outcomes.
                </p>
              </div>
            </div>

            <div class="related-blog">
              <h3 class="related-blog__title">Related Blog</h3>
              <div class="related-blog__grid">
                <a href="{{ route('blog-details') }}" class="related-card">
                  <img src="{{ asset('assets/img/sr-1-3.jpg') }}" alt="Doctor reading a book" class="related-card__img" />
                  <span class="related-card__overlay" aria-hidden="true"></span>
                  <span class="related-card__date"><span class="related-card__date-dot"></span>July 14, 2025</span>
                  <h4 class="related-card__name">Aging and Longevity: Exploring the Science of Healthy A ...</h4>
                  <span class="related-card__arrow">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M7 17 17 7M9 7h8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </span>
                </a>

                <a href="{{ route('blog-details') }}" class="related-card">
                  <img src="{{ asset('assets/img/sr-1-2.jpg') }}" alt="Therapist comforting a patient" class="related-card__img" />
                  <span class="related-card__overlay" aria-hidden="true"></span>
                  <span class="related-card__date"><span class="related-card__date-dot"></span>July 14, 2025</span>
                  <h4 class="related-card__name">Mental Health in the Modern World: Breaking the Stigma ...</h4>
                  <span class="related-card__arrow">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M7 17 17 7M9 7h8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </span>
                </a>
              </div>
            </div>

            <div class="comments">
              <h3 class="comments__count">0 Comments</h3>
              <h4 class="comments__title">Leave A Reply</h4>
              <form class="comments__form">
                <div class="comments__row">
                  <input type="text" class="comments__input" placeholder="Name" required />
                  <input type="email" class="comments__input" placeholder="Email" required />
                </div>
                <input type="url" class="comments__input" placeholder="Website url" />
                <textarea class="comments__textarea" placeholder="Comment" required></textarea>
                <button type="submit" class="comments__submit">Submit Now</button>
              </form>
            </div>
          </article>

          <aside class="blog-sidebar" data-sticky-sidebar>
            <!-- Search -->
            <div class="blog-sidebar__card">
              <h3 class="blog-sidebar__title">Search</h3>
              <form class="blog-sidebar__search">
                <input type="text" class="blog-sidebar__search-input" placeholder="Search.." />
                <button type="submit" class="blog-sidebar__search-btn" aria-label="Search">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/>
                    <path d="m20 20-3.5-3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                  </svg>
                </button>
              </form>
            </div>

            <!-- Category -->
            <div class="blog-sidebar__card">
              <h3 class="blog-sidebar__title">Category</h3>
              <div class="blog-sidebar__cat-list">
                <a href="#" class="blog-sidebar__cat-link">
                  <span class="blog-sidebar__cat-left">
                    <span class="blog-sidebar__cat-arrow">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </span>
                    Acupressure
                  </span>
                  <span class="blog-sidebar__cat-count">(4)</span>
                </a>
                <a href="#" class="blog-sidebar__cat-link">
                  <span class="blog-sidebar__cat-left">
                    <span class="blog-sidebar__cat-arrow">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </span>
                    Walking
                  </span>
                  <span class="blog-sidebar__cat-count">(3)</span>
                </a>
                <a href="#" class="blog-sidebar__cat-link">
                  <span class="blog-sidebar__cat-left">
                    <span class="blog-sidebar__cat-arrow">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </span>
                    Food
                  </span>
                  <span class="blog-sidebar__cat-count">(3)</span>
                </a>
                <a href="#" class="blog-sidebar__cat-link">
                  <span class="blog-sidebar__cat-left">
                    <span class="blog-sidebar__cat-arrow">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </span>
                    Therapy
                  </span>
                  <span class="blog-sidebar__cat-count">(5)</span>
                </a>
                <a href="#" class="blog-sidebar__cat-link">
                  <span class="blog-sidebar__cat-left">
                    <span class="blog-sidebar__cat-arrow">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </span>
                    Health
                  </span>
                  <span class="blog-sidebar__cat-count">(1)</span>
                </a>
                <a href="#" class="blog-sidebar__cat-link">
                  <span class="blog-sidebar__cat-left">
                    <span class="blog-sidebar__cat-arrow">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </span>
                    Allgemein
                  </span>
                  <span class="blog-sidebar__cat-count">(3)</span>
                </a>
                <a href="#" class="blog-sidebar__cat-link">
                  <span class="blog-sidebar__cat-left">
                    <span class="blog-sidebar__cat-arrow">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </span>
                    Blood
                  </span>
                  <span class="blog-sidebar__cat-count">(2)</span>
                </a>
                <a href="#" class="blog-sidebar__cat-link">
                  <span class="blog-sidebar__cat-left">
                    <span class="blog-sidebar__cat-arrow">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </span>
                    Mental Health
                  </span>
                  <span class="blog-sidebar__cat-count">(2)</span>
                </a>
              </div>
            </div>

            <!-- Latest Post -->
            <div class="blog-sidebar__card">
              <h3 class="blog-sidebar__title">Latest Post</h3>
              <div class="blog-sidebar__latest-list">
                <a href="{{ route('blog-details') }}" class="blog-sidebar__latest-item">
                  <img src="{{ asset('assets/img/projects-3.jpg') }}" alt="" class="blog-sidebar__latest-thumb" />
                  <div>
                    <p class="blog-sidebar__latest-date">July 14, 2025</p>
                    <p class="blog-sidebar__latest-title">Cardiovascular Disease: New Treatments a ...</p>
                  </div>
                </a>
                <a href="{{ route('blog-details') }}" class="blog-sidebar__latest-item">
                  <img src="{{ asset('assets/img/sr-1-3.jpg') }}" alt="" class="blog-sidebar__latest-thumb" />
                  <div>
                    <p class="blog-sidebar__latest-date">July 14, 2025</p>
                    <p class="blog-sidebar__latest-title">Aging and Longevity: Exploring the Scien ...</p>
                  </div>
                </a>
                <a href="{{ route('blog-details') }}" class="blog-sidebar__latest-item">
                  <img src="{{ asset('assets/img/sr-1-2.jpg') }}" alt="" class="blog-sidebar__latest-thumb" />
                  <div>
                    <p class="blog-sidebar__latest-date">July 14, 2025</p>
                    <p class="blog-sidebar__latest-title">Mental Health in the Modern World: Break ...</p>
                  </div>
                </a>
              </div>
            </div>

            <!-- Tags -->
            <div class="blog-sidebar__card">
              <h3 class="blog-sidebar__title">Tags</h3>
              <div class="blog-sidebar__tags">
                <a href="#" class="blog-sidebar__tag">Food</a>
                <a href="#" class="blog-sidebar__tag">Walking</a>
                <a href="#" class="blog-sidebar__tag">Mental Health</a>
                <a href="#" class="blog-sidebar__tag">Acupressure</a>
                <a href="#" class="blog-sidebar__tag">Health</a>
                <a href="#" class="blog-sidebar__tag">Blood</a>
              </div>
            </div>
          </aside>
        </div>
      </div>
    </section>
@endsection
