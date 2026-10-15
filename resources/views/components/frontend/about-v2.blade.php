@props([
'about' => [],
'headerSettings' => [],
])

@php
$aboutSurgeryPhoto = !empty($about['about_surgery_photo'])
? asset('storage/' . $about['about_surgery_photo'])
: asset('assets/img/about-surgery.jpg');

$aboutDoctorPhoto = !empty($about['about_doctor_photo'])
? asset('storage/' . $about['about_doctor_photo'])
: (!empty($about['about_photo'])
? asset('storage/' . $about['about_photo'])
: asset('assets/img/about-doctor.jpg'));

$aboutSiteName = $headerSettings['header_site_name'] ?? 'Medicare Lab';
$aboutEyebrow = !empty(trim($about['about_mv_title'] ?? '')) ? $about['about_mv_title'] : null;
$aboutTitle = !empty(trim($about['about_title'] ?? '')) ? $about['about_title'] : null;

// Tab data loaded dynamically from backend (about_mv_cards)
$mvCards = !empty($about['about_mv_cards']) ? $about['about_mv_cards'] : [
[
'title' => 'Our Mission',
'description' => 'We are dedicated to providing exceptional healthcare services with compassion, innovation, and excellence. Our mission is to enhance the well-being of our patients through comprehensive medical care, cutting-edge technology.'
],
[
'title' => 'Our Vision',
'description' => 'To build a modern hospital, diagnostic center and an international-standard nursing college on our own land — creating a healthier, disease-free next generation.'
],
[
'title' => 'Our Goals',
'description' => 'To ensure modern, quality healthcare for all patients with complete integrity and dedication — through 24-hour emergency, specialized diagnostics and multidisciplinary expert medical care.'
],
];

$aboutBtnText = $about['about_more_btn_text'] ?? __('frontend.common.read_more');
$aboutBtnUrl = ($about['about_more_btn_url'] ?? null) ?: route('about');
$aboutExpYears = !empty(trim($about['about_exp_years'] ?? '')) ? $about['about_exp_years'] : null;
$aboutExpLabel = !empty(trim($about['about_exp_label'] ?? '')) ? $about['about_exp_label'] : null;
@endphp

<section class="about-v2 py-section bg-white relative overflow-hidden" data-about-v2>
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">

      <!-- Left Column: Media & Badges -->
      <div class="lg:col-span-6 relative">
        <div class="relative max-w-lg mx-auto lg:max-w-none pt-6 pl-4 sm:pt-8 sm:pl-6 pb-12 pr-6 sm:pb-16 sm:pr-8">

          <!-- Main Surgery Operation Image -->
          <div class="relative rounded-3xl overflow-hidden shadow-2xl bg-gray-100 border border-gray-100">
            <img
              src="{{ $aboutSurgeryPhoto }}"
              alt="{{ $aboutTitle ?? 'About Us' }}"
              class="w-full aspect-[4/3] object-cover" />
          </div>

          @if(!empty($aboutExpYears))
          <!-- Top-Left Floating Experience Badge -->
          <div class="absolute top-0 left-0 z-20 bg-[#3b1263] text-white p-5 sm:p-6 rounded-2xl shadow-2xl flex flex-col justify-between w-44 sm:w-52">
            <div class="flex items-center justify-between mb-2">
              <span class="text-h2 font-extrabold tracking-tight text-white leading-none">{{ $aboutExpYears }}</span>
              <span class="w-10 h-10 rounded-xl bg-white/15 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m-4-4h8" />
                </svg>
              </span>
            </div>
            @if(!empty($aboutExpLabel))
            <span class="text-small font-semibold text-white/90 leading-tight">{{ $aboutExpLabel }}</span>
            @endif
          </div>
          @endif

          <!-- Bottom-Right Overlapping Doctor Photo -->
          <div class="absolute -bottom-4 -right-2 sm:-bottom-6 sm:-right-4 z-20 w-44 sm:w-56 md:w-60 rounded-2xl overflow-hidden shadow-2xl border-4 border-white bg-white">
            <img
              src="{{ $aboutDoctorPhoto }}"
              alt="{{ $aboutTitle ?? 'About Us' }}"
              class="w-full aspect-[3/4] object-cover" />
          </div>

        </div>
      </div>

      <!-- Right Column: Content & Tabs -->
      <div class="lg:col-span-6 flex flex-col">

        @if(!empty($aboutEyebrow))
        <!-- Eyebrow -->
        <span class="text-eyebrow font-bold tracking-wider text-gray-500 mb-2">
          {{ $aboutEyebrow }}
        </span>
        @endif

        @if(!empty($aboutTitle))
        <!-- Main Title -->
        <h2 class="text-h2 font-extrabold text-navy mb-6">
          {{ $aboutTitle }}
        </h2>
        @endif

        @if(!empty($mvCards))
        <!-- Tab Navigation (Backend-Driven) -->
        <div class="flex items-center gap-4 sm:gap-8 border-b border-gray-200 mb-6 overflow-x-auto no-scrollbar" data-about-tab-nav>
          @foreach($mvCards as $idx => $card)
          <button
            type="button"
            class="about-tab-btn flex items-center gap-2 pb-3 font-semibold text-btn-lg border-b-2 whitespace-nowrap {{ $loop->first ? 'border-[#3b1263] text-[#3b1263] font-bold' : 'border-transparent text-gray-500 hover:text-navy' }} transition-colors"
            data-tab-target="tab-{{ $idx }}">
            @if($idx === 0)
            <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
              <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
            </svg>
            @elseif($idx === 1)
            <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="3"></circle>
              <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0z"></path>
            </svg>
            @else
            <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"></circle>
              <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon>
            </svg>
            @endif
            <span>{{ $card['title'] }}</span>
          </button>
          @endforeach
        </div>

        <!-- Tab Contents (Backend-Driven) -->
        <div class="mb-8 min-h-[90px]" data-about-tab-content>
          @foreach($mvCards as $idx => $card)
          <div
            class="about-tab-pane {{ $loop->first ? 'block' : 'hidden' }} text-gray-600 text-body leading-relaxed"
            data-tab-pane="tab-{{ $idx }}">
            {{ $card['description'] }}
          </div>
          @endforeach
        </div>
        @endif

        <!-- Read More CTA Button (Backend-Driven) -->
        @if(!empty($aboutBtnText))
        <div class="pt-2">
          <a
            href="{{ $aboutBtnUrl }}"
            class="inline-flex items-center gap-2.5 bg-[#3b1263] hover:bg-[#2a0c49] text-white font-semibold text-btn px-8 py-3.5 rounded-full shadow-lg shadow-[#3b1263]/20 transition-all duration-200 group">
            <span>{{ $aboutBtnText }}</span>
            <svg class="w-4 h-4 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <line x1="7" y1="17" x2="17" y2="7"></line>
              <polyline points="7 7 17 7 17 17"></polyline>
            </svg>
          </a>
        </div>
        @endif

      </div>

    </div>
  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('[data-about-v2]');
    if (!container) return;

    const tabs = container.querySelectorAll('.about-tab-btn');
    const panes = container.querySelectorAll('.about-tab-pane');

    tabs.forEach(tab => {
      tab.addEventListener('click', () => {
        const target = tab.getAttribute('data-tab-target');

        // Update tab styles
        tabs.forEach(t => {
          t.classList.remove('border-[#3b1263]', 'text-[#3b1263]', 'font-bold');
          t.classList.add('border-transparent', 'text-gray-500', 'font-semibold');
        });
        tab.classList.remove('border-transparent', 'text-gray-500', 'font-semibold');
        tab.classList.add('border-[#3b1263]', 'text-[#3b1263]', 'font-bold');

        // Update panes
        panes.forEach(pane => {
          if (pane.getAttribute('data-tab-pane') === target) {
            pane.classList.remove('hidden');
            pane.classList.add('block');
          } else {
            pane.classList.remove('block');
            pane.classList.add('hidden');
          }
        });
      });
    });
  });
</script>