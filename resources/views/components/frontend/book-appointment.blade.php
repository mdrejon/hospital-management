@props([
    'settings'    => [],
    'doctors'     => collect(),
    'departments' => collect(),
    'source'      => 'appointment_page',
])

@php
  $apptBadge        = $settings['appt_badge']         ?? 'Make an Appointment';
  $apptTitle        = $settings['appt_title']         ?? 'Fast & Easy Scheduling Today!';
  $apptFormTitle    = $settings['appt_form_title']    ?? 'Please enter your info';
  $apptFormSubtitle = $settings['appt_form_subtitle'] ?? 'Strong communication and teamwork skills enable effective collaboration';
  $apptImage        = !empty($settings['appt_image']) ? asset('storage/' . $settings['appt_image']) : asset('assets/img/appoinment-img.jpg');

  $apptDepartments = $departments->isNotEmpty() ? $departments : collect(['Cardiology', 'Pediatrics', 'Neurology', 'Orthopedics', 'Dermatology']);
  $apptDoctors     = $doctors->isNotEmpty() ? $doctors : collect(['Dr. Laron Metar', 'Dr. Smith Karo', 'Dr. Merata Baron', 'Dr. Elena Cross', 'Dr. Michael Reyes', 'Dr. Sara Owens']);
@endphp

<section class="book-appointment">
  <span class="book-appointment__watermark" aria-hidden="true">Make An Appointment</span>

  <div class="container relative mx-auto">
    <div class="book-appointment__head">
      <p class="book-appointment__eyebrow">{{ $apptBadge }}</p>
      <h2 class="book-appointment__title">{{ $apptTitle }}</h2>
    </div>

    <div class="book-appointment__card">
      <div class="book-appointment__form-col">
        <h3 class="book-appointment__form-title">{{ $apptFormTitle }}</h3>
        <p class="book-appointment__subtitle">{{ $apptFormSubtitle }}</p>

        @if(session('success'))
        <p class="book-appointment__subtitle" style="color: #16a34a;">{{ session('success') }}</p>
        @endif
        @if($errors->any())
        <p class="book-appointment__subtitle" style="color: #dc2626;">{{ $errors->first() }}</p>
        @endif

        <form class="book-appointment__form" action="{{ route('appointment.submit') }}" method="POST">
          @csrf
          <input type="hidden" name="source" value="{{ $source }}" />

          <label class="book-appointment__field">
            <span class="book-appointment__field-icon">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="8" r="3.2" stroke="currentColor" stroke-width="1.6"/>
                <path d="M5 20c0-3.5 3-6 7-6s7 2.5 7 6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
              </svg>
            </span>
            <input type="text" name="name" value="{{ old('name') }}" class="book-appointment__input" placeholder="Name" required />
          </label>

          <label class="book-appointment__field">
            <span class="book-appointment__field-icon">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 4h16v16H4z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                <path d="m4 6 8 7 8-7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </span>
            <input type="email" name="email" value="{{ old('email') }}" class="book-appointment__input" placeholder="Email Address" required />
          </label>

          <label class="book-appointment__field">
            <span class="book-appointment__field-icon">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" stroke="currentColor" stroke-width="1.6"/>
              </svg>
            </span>
            <input type="tel" name="phone" value="{{ old('phone') }}" class="book-appointment__input" placeholder="Phone no" />
            <span class="book-appointment__field-spinner" aria-hidden="true">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="m8 10 4-4 4 4M8 14l4 4 4-4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </span>
          </label>

          <label class="book-appointment__field">
            <span class="book-appointment__field-icon">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="3.5" y="5" width="17" height="16" rx="2.5" stroke="currentColor" stroke-width="1.6"/>
                <path d="M3.5 9.5h17M8 3v3.5M16 3v3.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
              </svg>
            </span>
            <input type="text" name="preferred_date" value="{{ old('preferred_date') }}" class="book-appointment__input" placeholder="Date &amp; Time" />
          </label>

          <label class="book-appointment__field">
            <span class="book-appointment__field-icon">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 21V9l8-5 8 5v12" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                <path d="M9 21v-6h6v6" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
              </svg>
            </span>
            <select name="department" class="book-appointment__select">
              <option value="" {{ old('department') ? '' : 'selected' }} hidden>Choose Department</option>
              @foreach($apptDepartments as $dept)
              <option value="{{ $dept }}" {{ old('department') === $dept ? 'selected' : '' }}>{{ $dept }}</option>
              @endforeach
            </select>
            <span class="book-appointment__field-caret">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="m6 9 6 6 6-6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </span>
          </label>

          <label class="book-appointment__field">
            <span class="book-appointment__field-icon">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 3v6a4 4 0 0 0 8 0V3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                <path d="M6 3H4.5M14 3h1.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                <circle cx="18" cy="14" r="2.2" stroke="currentColor" stroke-width="1.6"/>
                <path d="M14 9v3a4 4 0 0 0 4 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
              </svg>
            </span>
            <select name="preferred_doctor" class="book-appointment__select">
              <option value="" {{ old('preferred_doctor') ? '' : 'selected' }} hidden>Doctors</option>
              @foreach($apptDoctors as $doctorName)
              <option value="{{ $doctorName }}" {{ old('preferred_doctor') === $doctorName ? 'selected' : '' }}>{{ $doctorName }}</option>
              @endforeach
            </select>
            <span class="book-appointment__field-caret">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="m6 9 6 6 6-6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </span>
          </label>

          <label class="book-appointment__field book-appointment__message">
            <span class="book-appointment__field-icon">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 20h9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
              </svg>
            </span>
            <textarea name="message" class="book-appointment__textarea" placeholder="Write message..." rows="3">{{ old('message') }}</textarea>
          </label>

          <div class="book-appointment__submit-wrap">
            <button type="submit" class="book-appointment__submit">
              Submit now
              <span class="book-appointment__submit-icon">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M7 17 17 7M9 7h8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
            </button>
          </div>
        </form>
      </div>

      <div class="book-appointment__media">
        <img src="{{ $apptImage }}" alt="Nurse assisting an elderly patient from a wheelchair" class="book-appointment__img" />
      </div>
    </div>
  </div>
</section>
