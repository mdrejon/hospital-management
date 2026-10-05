<footer class="relative bg-[#1f2937] text-white overflow-hidden">
  <!-- Background Image & Overlay -->
  @if(!empty($footerSettings['footer_bg_image']))
  <div class="absolute inset-0 z-0">
    <img src="{{ asset('storage/' . $footerSettings['footer_bg_image']) }}" class="w-full h-full object-cover" alt="Footer Background">
    <div class="absolute inset-0 bg-gray-900/80"></div>
  </div>
  @else
  <div class="absolute inset-0 bg-[#2b2b2b] z-0"></div> <!-- dark grey fallback -->
  @endif

  <!-- Main Footer Content -->
  <div class="relative z-10 container mx-auto px-4 pt-16 lg:pt-24 pb-12">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
      
      <!-- Col 1: Brand & Socials -->
      <div>
        <a href="{{ route('home') }}" class="inline-block mb-6 bg-white p-2 rounded shadow-sm">
          <img src="{{ !empty($footerSettings['footer_logo']) ? asset('storage/' . $footerSettings['footer_logo']) : asset('assets/img/logo.png') }}" alt="{{ $footerSettings['header_site_name'] ?? 'Medinosi' }}" class="h-14 w-auto" />
        </a>
        <p class="text-[15px] text-gray-300 mb-6 leading-relaxed">
          {{ $footerSettings['footer_brand_description'] ?? 'Our approach to it is unique around know work an we know doesn\'t work verified factors in play.' }}
        </p>
        <h4 class="text-white font-bold mb-4">Social Media:</h4>
        <div class="flex items-center gap-3">
          @if(!empty($footerSettings['footer_facebook_url']))
          <a href="{{ $footerSettings['footer_facebook_url'] }}" class="w-9 h-9 rounded-full border border-gray-500 flex items-center justify-center text-gray-400 hover:text-white hover:border-white transition" aria-label="Facebook">
             <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M14 13.5h2.5l1-4H14v-2c0-1.03 0-2 2-2h1.5V2.14c-.326-.043-1.557-.14-2.857-.14C11.928 2 10 3.657 10 6.7v2.8H7v4h3V22h4v-8.5z"/></svg>
          </a>
          @endif
          @if(!empty($footerSettings['footer_twitter_url']))
          <a href="{{ $footerSettings['footer_twitter_url'] }}" class="w-9 h-9 rounded-full border border-gray-500 flex items-center justify-center text-gray-400 hover:text-white hover:border-white transition" aria-label="Twitter">
             <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.05c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/></svg>
          </a>
          @endif
          @if(!empty($footerSettings['footer_instagram_url']))
          <a href="{{ $footerSettings['footer_instagram_url'] }}" class="w-9 h-9 rounded-full border border-gray-500 flex items-center justify-center text-gray-400 hover:text-white hover:border-white transition" aria-label="Instagram">
             <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.16c3.2 0 3.58.01 4.85.07 3.25.15 4.77 1.69 4.92 4.92.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.15 3.23-1.66 4.77-4.92 4.92-1.27.06-1.64.07-4.85.07s-3.58-.01-4.85-.07c-3.26-.15-4.77-1.7-4.92-4.92-.06-1.27-.07-1.64-.07-4.85s.01-3.58.07-4.85c.15-3.23 1.66-4.77 4.92-4.92 1.27-.06 1.65-.07 4.85-.07m0-2.16C8.74 0 8.33.01 7.05.07 2.7.27.27 2.7.07 7.05.01 8.33 0 8.74 0 12s.01 3.67.07 4.95c.2 4.35 2.63 6.78 6.98 6.98 1.28.06 1.69.07 4.95.07s3.67-.01 4.95-.07c4.35-.2 6.78-2.63 6.98-6.98.06-1.28.07-1.69.07-4.95s-.01-3.67-.07-4.95c-.2-4.35-2.63-6.78-6.98-6.98-1.28-.06-1.69-.07-4.95-.07zM12 5.84A6.16 6.16 0 1 0 18.16 12 6.16 6.16 0 0 0 12 5.84zm0 10.16A4 4 0 1 1 16 12a4 4 0 0 1-4 4zm5.23-10.6a1.44 1.44 0 1 1-2.88 0 1.44 1.44 0 0 1 2.88 0z"/></svg>
          </a>
          @endif
          @if(!empty($footerSettings['footer_youtube_url']))
          <a href="{{ $footerSettings['footer_youtube_url'] }}" class="w-9 h-9 rounded-full border border-gray-500 flex items-center justify-center text-gray-400 hover:text-white hover:border-white transition" aria-label="YouTube">
             <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.5 6.14a3 3 0 0 0-2.11-2.14C19.53 3.5 12 3.5 12 3.5s-7.53 0-9.39.5A3 3 0 0 0 .5 6.14 31.42 31.42 0 0 0 0 12a31.42 31.42 0 0 0 .5 5.86 3 3 0 0 0 2.11 2.14C4.47 20.5 12 20.5 12 20.5s7.53 0 9.39-.5A3 3 0 0 0 23.5 17.86 31.42 31.42 0 0 0 24 12a31.42 31.42 0 0 0-.5-5.86zM9.5 15.5v-7l6.5 3.5-6.5 3.5z"/></svg>
          </a>
          @endif
        </div>
      </div>

      <!-- Col 2: Service Links (Two cols internally) -->
      <div>
        <h4 class="text-lg font-bold text-white mb-6">Service Links</h4>
        <div class="grid grid-cols-2 gap-y-3 gap-x-4">
          @forelse(($footerSettings['footer_service_links'] ?? []) as $link)
          <a href="{{ $link['url'] }}" class="text-gray-300 hover:text-white transition text-[15px]">{{ $link['label'] }}</a>
          @empty
          <a href="{{ route('faq') }}" class="text-gray-300 hover:text-white transition text-[15px]">Faq</a>
          <a href="{{ url('privacy') }}" class="text-gray-300 hover:text-white transition text-[15px]">Privacy</a>
          <a href="{{ url('policy') }}" class="text-gray-300 hover:text-white transition text-[15px]">Policy</a>
          <a href="{{ route('about') }}" class="text-gray-300 hover:text-white transition text-[15px]">About</a>
          <a href="{{ route('contact') }}" class="text-gray-300 hover:text-white transition text-[15px]">Support</a>
          <a href="{{ route('services') }}" class="text-gray-300 hover:text-white transition text-[15px]">Skill</a>
          <a href="{{ route('doctors') }}" class="text-gray-300 hover:text-white transition text-[15px]">Team</a>
          <a href="{{ route('blog-list') }}" class="text-gray-300 hover:text-white transition text-[15px]">Blog</a>
          <a href="{{ route('services') }}" class="text-gray-300 hover:text-white transition text-[15px]">Projects</a>
          <a href="{{ route('contact') }}" class="text-gray-300 hover:text-white transition text-[15px]">Contact</a>
          @endforelse
        </div>
      </div>

      <!-- Col 3: Open Time -->
      <div>
        <h4 class="text-lg font-bold text-white mb-6">Open Time</h4>
        <ul class="text-[15px] text-gray-300 space-y-3">
          @if(!empty($footerSettings['footer_opening_time']))
           <li class="flex justify-between border-b border-gray-600/50 border-dotted pb-2">
             <span>{{ $footerSettings['footer_opening_time'] }}</span>
           </li>
          @else
           <li class="flex justify-between border-b border-gray-600/50 border-dotted pb-2"><span>Friday</span> <span>9AM-9PM</span></li>
           <li class="flex justify-between border-b border-gray-600/50 border-dotted pb-2"><span>Saturday</span> <span>9AM-9PM</span></li>
           <li class="flex justify-between border-b border-gray-600/50 border-dotted pb-2"><span>Sunday</span> <span>9AM-8PM</span></li>
           <li class="flex justify-between border-b border-gray-600/50 border-dotted pb-2"><span>Monday</span> <span>9AM-8PM</span></li>
           <li class="flex justify-between border-b border-gray-600/50 border-dotted pb-2"><span>Tuesday</span> <span>9AM-8PM</span></li>
          @endif
        </ul>
      </div>

      <!-- Col 4: Newsletter -->
      <div>
        <h4 class="text-lg font-bold text-white mb-6">Newsletter</h4>
        <p class="text-[15px] text-gray-300 mb-6 leading-relaxed">
          {{ $footerSettings['footer_newsletter_title'] ?? 'In alteration insipidity impression by travelling up motionless.' }}
        </p>
        <form action="#" class="flex flex-col gap-3">
          <input type="email" placeholder="Your email address" class="w-full px-5 py-3.5 rounded-full text-[15px] text-gray-800 focus:outline-none" required>
          <button type="submit" class="w-full bg-[#f59e0b] hover:bg-[#d97706] text-white px-5 py-3.5 rounded-full text-[15px] font-bold flex items-center justify-center gap-2 transition tracking-wider">
            SEND REQUEST
            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
          </button>
        </form>
      </div>

    </div>
  </div>

  <!-- Copyright Bar -->
  <div class="relative z-10 border-t border-gray-700/60 mt-2">
    <div class="container mx-auto px-4 py-6 text-center text-[15px] text-gray-300">
      &copy; {{ date('Y') }} Medicare Lab. All rights reserved. | Design & Development by <a href="https://www.wexnix.com" target="_blank" class="text-white hover:text-[#f59e0b] transition-colors underline decoration-gray-500 underline-offset-4">Wexnix Technologies Ltd.</a>
    </div>
  </div>
</footer>