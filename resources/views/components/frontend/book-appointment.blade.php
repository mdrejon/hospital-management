@props([
    'settings'          => [],
    'doctors'           => collect(),
    'specializations'   => collect(),
    'source'            => 'appointment_page',
    'preselectedDoctor' => null,
])

@php
  $apptBadge        = $settings['appt_badge']         ?? __('frontend.home.appt_badge');
  $apptTitle        = $settings['appt_title']         ?? __('frontend.home.appt_title');
  $apptFormTitle    = $settings['appt_form_title']    ?? __('frontend.home.appt_form_title');
  $apptFormSubtitle = $settings['appt_form_subtitle'] ?? __('frontend.home.appt_form_subtitle');
  $apptImage        = !empty($settings['appt_image']) ? asset('storage/' . $settings['appt_image']) : asset('assets/img/appoinment-img.jpg');

  $apptDoctors = $doctors instanceof \Illuminate\Support\Collection ? $doctors : collect();
  $apptSpecializations = $specializations instanceof \Illuminate\Support\Collection ? $specializations : collect();
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
        <p class="book-appointment__alert book-appointment__alert--success">{{ session('success') }}</p>
        @endif
        @if($errors->any())
        <p class="book-appointment__alert book-appointment__alert--error">{{ $errors->first() }}</p>
        @endif

        <form class="book-appointment__form" action="{{ route('appointment.submit') }}" method="POST" enctype="multipart/form-data" data-booking-form>
          @csrf
          <input type="hidden" name="source" value="{{ $source }}" />
          <input type="hidden" name="time_slot" data-field="time_slot" />

          <p class="book-appointment__section-label">{{ __('frontend.appointment_form.patient_info') }}</p>

          <label class="book-appointment__field">
            <span class="book-appointment__field-icon">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="8" r="3.2" stroke="currentColor" stroke-width="1.6"/>
                <path d="M5 20c0-3.5 3-6 7-6s7 2.5 7 6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
              </svg>
            </span>
            <input type="text" name="patient_name" value="{{ old('patient_name') }}" class="book-appointment__input" placeholder="{{ __('frontend.appointment_form.patient_name') }}" required />
          </label>

          <div class="book-appointment__radio-group">
            <label class="book-appointment__radio">
              <input type="radio" name="gender" value="male" {{ old('gender') !== 'female' && old('gender') !== 'other' ? 'checked' : '' }} required /> {{ __('frontend.appointment_form.male') }}
            </label>
            <label class="book-appointment__radio">
              <input type="radio" name="gender" value="female" {{ old('gender') === 'female' ? 'checked' : '' }} /> {{ __('frontend.appointment_form.female') }}
            </label>
            <label class="book-appointment__radio">
              <input type="radio" name="gender" value="other" {{ old('gender') === 'other' ? 'checked' : '' }} /> {{ __('frontend.appointment_form.other') }}
            </label>
          </div>

          <label class="book-appointment__field">
            <span class="book-appointment__field-icon">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="3.5" y="5" width="17" height="16" rx="2.5" stroke="currentColor" stroke-width="1.6"/>
                <path d="M3.5 9.5h17M8 3v3.5M16 3v3.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
              </svg>
            </span>
            <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="book-appointment__input" placeholder="{{ __('frontend.appointment_form.dob') }}" data-field="dob" max="{{ now()->toDateString() }}" />
          </label>

          <label class="book-appointment__field">
            <span class="book-appointment__field-icon">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 20h9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
              </svg>
            </span>
            <input type="number" min="0" max="130" class="book-appointment__input" placeholder="{{ __('frontend.appointment_form.age') }}" data-field="age" />
          </label>

          <label class="book-appointment__field">
            <span class="book-appointment__field-icon">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" stroke="currentColor" stroke-width="1.6"/>
              </svg>
            </span>
            <input type="tel" name="phone" value="{{ old('phone') }}" class="book-appointment__input" placeholder="{{ __('frontend.appointment_form.mobile') }}" required />
          </label>

          <label class="book-appointment__field">
            <span class="book-appointment__field-icon">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 4h16v16H4z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                <path d="m4 6 8 7 8-7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </span>
            <input type="email" name="email" value="{{ old('email') }}" class="book-appointment__input" placeholder="{{ __('frontend.appointment_form.email') }}" />
          </label>

          <label class="book-appointment__field book-appointment__message">
            <span class="book-appointment__field-icon">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 3v6a4 4 0 0 0 8 0V3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
              </svg>
            </span>
            <textarea class="book-appointment__textarea" placeholder="{{ __('frontend.appointment_form.address') }}" rows="2" data-field="address" name="address">{{ old('address') }}</textarea>
          </label>

          <p class="book-appointment__section-label">{{ __('frontend.appointment_form.appt_details') }}</p>

          <div class="book-appointment__radio-group">
            <label class="book-appointment__radio">
              <input type="radio" name="appointment_type" value="opd" {{ old('appointment_type') !== 'follow_up' ? 'checked' : '' }} required /> {{ __('frontend.appointment_form.opd') }}
            </label>
            <label class="book-appointment__radio">
              <input type="radio" name="appointment_type" value="follow_up" {{ old('appointment_type') === 'follow_up' ? 'checked' : '' }} /> {{ __('frontend.appointment_form.follow_up') }}
            </label>
          </div>

          <label class="book-appointment__field">
            <span class="book-appointment__field-icon">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 3v6a4 4 0 0 0 8 0V3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
              </svg>
            </span>
            <select class="book-appointment__select" data-field="specialization">
              <option value="">{{ __('frontend.appointment_form.all_spec') }}</option>
              @foreach($apptSpecializations as $spec)
              <option value="{{ $spec->id }}">{{ $spec->name }}</option>
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
            @php
              $selectedDoctorId = old('doctor_id') ?: data_get($preselectedDoctor, 'id');
            @endphp
            <select name="doctor_id" class="book-appointment__select" data-field="doctor" required>
              <option value="" {{ $selectedDoctorId ? '' : 'selected' }} hidden>{{ __('frontend.appointment_form.choose_doctor') }}</option>
              @forelse($apptDoctors as $doc)
              <option value="{{ $doc->id }}" data-spec-id="{{ $doc->doctor_specialization_id }}" data-fee="{{ $doc->consultation_fee }}" {{ (string) $selectedDoctorId === (string) $doc->id ? 'selected' : '' }}>
                {{ $doc->name }}{{ $doc->role ? ' — ' . $doc->role : '' }}
              </option>
              @empty
              <option value="" disabled>{{ __('frontend.appointment_form.no_doctors') }}</option>
              @endforelse
            </select>
            <span class="book-appointment__field-caret">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="m6 9 6 6 6-6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </span>
          </label>
          <p class="book-appointment__hint" data-field="doctor-hint"></p>

          <label class="book-appointment__field">
            <span class="book-appointment__field-icon">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="3.5" y="5" width="17" height="16" rx="2.5" stroke="currentColor" stroke-width="1.6"/>
                <path d="M3.5 9.5h17M8 3v3.5M16 3v3.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
              </svg>
            </span>
            <input type="date" name="appointment_date" value="{{ old('appointment_date') }}" class="book-appointment__input" placeholder="{{ __('frontend.appointment_form.appt_date') }}" data-field="date" disabled required />
          </label>
          <p class="book-appointment__hint" data-field="date-hint"></p>

          <p class="book-appointment__section-label" data-field="slots-label" style="display:none;">{{ __('frontend.appointment_form.time_slot') }}</p>
          <div class="book-appointment__slots" data-field="slots"></div>

          <label class="book-appointment__field book-appointment__message">
            <span class="book-appointment__field-icon">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 20h9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
              </svg>
            </span>
            <textarea name="symptoms" class="book-appointment__textarea" placeholder="{{ __('frontend.appointment_form.symptoms') }}" rows="3">{{ old('symptoms') }}</textarea>
          </label>

          <div class="book-appointment__dropzone sm:col-span-2" data-field="dropzone" tabindex="0" role="button" aria-label="Upload medical documents">
            <input type="file" name="medical_documents[]" class="book-appointment__dropzone-input" data-field="file-input"
              accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" multiple hidden />

            <div class="book-appointment__dropzone-prompt" data-field="dropzone-empty">
              <span class="book-appointment__dropzone-icon">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12 16V4M12 4 7 9M12 4l5 5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
              <p class="book-appointment__dropzone-text" data-field="dropzone-label">
                <span class="book-appointment__dropzone-browse">{{ __('frontend.appointment_form.upload_docs') }}</span> {!! __('frontend.appointment_form.drag_drop') !!}
              </p>
              <p class="book-appointment__dropzone-hint">{{ __('frontend.appointment_form.upload_hint') }}</p>
            </div>

            <div class="book-appointment__dropzone-list" data-field="dropzone-list"></div>
          </div>
          <p class="book-appointment__hint is-error" data-field="file-hint"></p>

          @php
            $paymentSettings = \App\Services\PaymentService::getActiveGateways();
          @endphp
          @if($paymentSettings['has_online'] || $paymentSettings['allow_without_pay'])
          <p class="book-appointment__section-label">{{ __('frontend.appointment_form.payment_option') }}</p>
          <div class="book-appointment__radio-group" style="grid-column: span 2; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px;">
            @if($paymentSettings['allow_without_pay'])
            <label class="book-appointment__radio" style="padding: 10px 14px; border: 1px solid #e2e8f0; background: #f8fafc; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 500;">
              <input type="radio" name="payment_type" value="without_pay" checked data-payment-type />
              <span>🏥 {{ __('frontend.appointment_form.pay_hospital') }}</span>
            </label>
            @endif
            @if($paymentSettings['has_online'])
            <label class="book-appointment__radio" style="padding: 10px 14px; border: 1px solid #e2e8f0; background: #f8fafc; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 500;">
              <input type="radio" name="payment_type" value="online" {{ !$paymentSettings['allow_without_pay'] ? 'checked' : '' }} data-payment-type />
              <span>💳 {{ __('frontend.appointment_form.pay_online') }}</span>
            </label>
            @endif
          </div>

          @if($paymentSettings['has_online'])
          <div class="book-appointment__gateway-group" data-gateway-selector style="{{ !$paymentSettings['allow_without_pay'] ? 'display:grid;' : 'display:none;' }} grid-column: span 2; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 10px; margin-top: 4px; margin-bottom: 8px;">
            @if(!empty($paymentSettings['gateways']['bkash']))
            <label style="padding: 10px 14px; border: 1px solid #fbcfe8; background: #fdf2f8; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; color: #be185d;">
              <input type="radio" name="payment_gateway" value="bkash" checked />
              <span>{{ __('frontend.appointment_form.bkash') }}</span>
            </label>
            @endif
            @if(!empty($paymentSettings['gateways']['sslcommerz']))
            <label style="padding: 10px 14px; border: 1px solid #bfdbfe; background: #eff6ff; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; color: #1d4ed8;">
              <input type="radio" name="payment_gateway" value="sslcommerz" {{ empty($paymentSettings['gateways']['bkash']) ? 'checked' : '' }} />
              <span>{{ __('frontend.appointment_form.sslcommerz') }}</span>
            </label>
            @endif
          </div>
          @endif
          @endif

          <div class="book-appointment__submit-wrap">
            <button type="submit" class="book-appointment__submit" data-field="submit" disabled>
              {{ __('frontend.appointment_form.submit') }}
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

<script>
(function () {
  document.querySelectorAll('[data-booking-form]').forEach(function (form) {
    var specSelect   = form.querySelector('[data-field="specialization"]');
    var doctorSelect = form.querySelector('[data-field="doctor"]');
    var doctorOptions = Array.from(doctorSelect ? doctorSelect.options : []);
    var doctorHint   = form.querySelector('[data-field="doctor-hint"]');
    var dateInput    = form.querySelector('[data-field="date"]');
    var dateHint     = form.querySelector('[data-field="date-hint"]');
    var slotsLabel   = form.querySelector('[data-field="slots-label"]');
    var slotsWrap    = form.querySelector('[data-field="slots"]');
    var slotInput    = form.querySelector('[data-field="time_slot"]');
    var submitBtn    = form.querySelector('[data-field="submit"]');
    var dobInput     = form.querySelector('[data-field="dob"]');
    var ageInput     = form.querySelector('[data-field="age"]');

    var today = new Date();
    var maxDate = new Date();
    maxDate.setDate(today.getDate() + 30);
    if (dateInput) {
      dateInput.min = today.toISOString().slice(0, 10);
      dateInput.max = maxDate.toISOString().slice(0, 10);
    }

    var unavailableDates = [];

    form.querySelectorAll('[data-payment-type]').forEach(function(radio) {
      radio.addEventListener('change', function() {
        var gatewaySelector = form.querySelector('[data-gateway-selector]');
        if (gatewaySelector) {
          gatewaySelector.style.display = this.value === 'online' ? 'grid' : 'none';
        }
      });
    });

    function resetDate() {
      dateInput.value = '';
      dateInput.disabled = !doctorSelect.value;
      dateHint.textContent = '';
      resetSlots();
    }

    function resetSlots() {
      slotsWrap.innerHTML = '';
      slotsLabel.style.display = 'none';
      slotInput.value = '';
      updateSubmitState();
    }

    function updateSubmitState() {
      submitBtn.disabled = !(doctorSelect.value && dateInput.value);
    }

    if (specSelect) {
      specSelect.addEventListener('change', function () {
        var selectedSpec = this.value;
        doctorSelect.innerHTML = '';
        var hasDoctors = false;
        
        doctorOptions.forEach(function (opt) {
          if (!opt.value) { // The hidden "Choose a Doctor" option
            doctorSelect.appendChild(opt);
          } else if (!selectedSpec || opt.dataset.specId === selectedSpec) {
            doctorSelect.appendChild(opt);
            hasDoctors = true;
          }
        });

        if (!hasDoctors) {
          var noDocOpt = document.createElement('option');
          noDocOpt.value = "";
          noDocOpt.disabled = true;
          noDocOpt.selected = true;
          noDocOpt.textContent = "{{ __('frontend.appointment_form.no_doctors') }}";
          doctorSelect.appendChild(noDocOpt);
        } else {
          doctorSelect.value = ""; // reset doctor
        }
        doctorSelect.dispatchEvent(new Event('change'));
      });
    }

    doctorSelect.addEventListener('change', function () {
      resetDate();
      unavailableDates = [];
      if (!doctorSelect.value) return;

      dateInput.disabled = false;
      var opt = doctorSelect.options[doctorSelect.selectedIndex];
      dateHint.textContent = (opt && opt.dataset.fee) ? '{{ __('frontend.appointment_form.fee_prefix') }}' + opt.dataset.fee : '';

      fetch('{{ route('appointment.availability') }}?doctor_id=' + encodeURIComponent(doctorSelect.value))
        .then(function (r) { return r.json(); })
        .then(function (data) { unavailableDates = data.unavailable_dates || []; })
        .catch(function () {});
    });

    // A doctor may already be selected on load (e.g. arriving from that doctor's
    // profile page) — kick off the same availability/fee lookup the change handler does.
    if (doctorSelect.value) {
      doctorSelect.dispatchEvent(new Event('change'));
    }

    dateInput.addEventListener('change', function () {
      resetSlots();
      if (!dateInput.value || !doctorSelect.value) return;

      if (unavailableDates.indexOf(dateInput.value) !== -1) {
        slotsLabel.style.display = '';
        slotsWrap.innerHTML = '<span class="book-appointment__hint is-error">{{ __('frontend.appointment_form.err_unavailable') }}</span>';
        return;
      }

      slotsLabel.style.display = '';
      slotsWrap.innerHTML = '<span class="book-appointment__hint">{{ __('frontend.appointment_form.loading_slots') }}</span>';

      fetch('{{ route('appointment.slots') }}?doctor_id=' + encodeURIComponent(doctorSelect.value) + '&date=' + encodeURIComponent(dateInput.value))
        .then(function (r) { return r.json(); })
        .then(function (data) {
          slotsWrap.innerHTML = '';
          if (!data.start_time || !data.end_time) {
            slotsWrap.innerHTML = '<span class="book-appointment__hint is-error">{{ __('frontend.appointment_form.err_no_slots') }}</span>';
            return;
          }
          slotInput.value = data.start_time;
          slotsWrap.innerHTML = '<span class="book-appointment__hint" style="color: #059669;">Doctor is available from ' + data.start_time + ' to ' + data.end_time + ' on this date.</span>';
          updateSubmitState();
        })
        .catch(function () {
          slotsWrap.innerHTML = '<span class="book-appointment__hint is-error">{{ __('frontend.appointment_form.err_load_slots') }}</span>';
        });
    });

    // ── Drag & drop medical document upload (multiple files) ──
    var dropzone     = form.querySelector('[data-field="dropzone"]');
    var fileInput    = form.querySelector('[data-field="file-input"]');
    var promptView   = form.querySelector('[data-field="dropzone-empty"]');
    var promptLabel  = form.querySelector('[data-field="dropzone-label"]');
    var listView     = form.querySelector('[data-field="dropzone-list"]');
    var fileHint     = form.querySelector('[data-field="file-hint"]');
    var maxFileBytes = 5 * 1024 * 1024;
    var maxFiles     = 5;
    var selectedFiles = [];

    function formatSize(bytes) {
      return (bytes / 1024 / 1024).toFixed(1) + ' MB';
    }

    function syncFileInput() {
      var dt = new DataTransfer();
      selectedFiles.forEach(function (file) { dt.items.add(file); });
      fileInput.files = dt.files;
    }

    function renderList() {
      listView.innerHTML = '';
      selectedFiles.forEach(function (file, index) {
        var row = document.createElement('div');
        row.className = 'book-appointment__dropzone-file';
        row.innerHTML =
          '<span class="book-appointment__dropzone-file-icon">' +
            '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">' +
              '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>' +
              '<path d="M14 2v6h6" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>' +
            '</svg>' +
          '</span>' +
          '<span class="book-appointment__dropzone-file-name"></span>' +
          '<button type="button" class="book-appointment__dropzone-remove">' +
            '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">' +
              '<path d="M18 6 6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>' +
            '</svg>' +
          '</button>';
        row.querySelector('.book-appointment__dropzone-file-name').textContent = file.name + ' (' + formatSize(file.size) + ')';
        var removeBtn = row.querySelector('.book-appointment__dropzone-remove');
        removeBtn.setAttribute('aria-label', 'Remove ' + file.name);
        removeBtn.addEventListener('click', function (e) {
          e.stopPropagation();
          selectedFiles.splice(index, 1);
          syncFileInput();
          renderList();
        });
        listView.appendChild(row);
      });

      dropzone.classList.toggle('has-file', selectedFiles.length > 0);
      var browseText = selectedFiles.length === 0 ? '{{ __('frontend.appointment_form.upload_docs') }}' : '{{ __('frontend.appointment_form.add_another') }}';
      promptLabel.innerHTML = '<span class="book-appointment__dropzone-browse">' + browseText + '</span> or drag &amp; drop';
      promptView.style.display = selectedFiles.length < maxFiles ? '' : 'none';
    }

    function acceptFile(file) {
      var allowed = ['image/jpeg', 'image/png', 'application/pdf', 'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
      if (allowed.indexOf(file.type) === -1) {
        fileHint.textContent = '{{ __('frontend.appointment_form.unsupported_file') }}'.replace(':file', file.name);
        return false;
      }
      if (file.size > maxFileBytes) {
        fileHint.textContent = '{{ __('frontend.appointment_form.file_too_large') }}'.replace(':file', file.name);
        return false;
      }
      var isDuplicate = selectedFiles.some(function (f) {
        return f.name === file.name && f.size === file.size && f.lastModified === file.lastModified;
      });
      if (isDuplicate) return false;
      return true;
    }

    function addFiles(fileList) {
      fileHint.textContent = '';
      Array.prototype.forEach.call(fileList, function (file) {
        if (selectedFiles.length >= maxFiles) {
          fileHint.textContent = '{{ __('frontend.appointment_form.max_files') }}'.replace(':max', maxFiles);
          return;
        }
        if (acceptFile(file)) selectedFiles.push(file);
      });
      syncFileInput();
      renderList();
    }

    dropzone.addEventListener('click', function (e) {
      if (e.target.closest('.book-appointment__dropzone-remove')) return;
      if (selectedFiles.length >= maxFiles) return;
      fileInput.click();
    });
    dropzone.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); if (selectedFiles.length < maxFiles) fileInput.click(); }
    });

    fileInput.addEventListener('change', function () {
      if (fileInput.files && fileInput.files.length) addFiles(fileInput.files);
    });

    ['dragenter', 'dragover'].forEach(function (evt) {
      dropzone.addEventListener(evt, function (e) {
        e.preventDefault(); e.stopPropagation();
        dropzone.classList.add('is-dragover');
      });
    });
    ['dragleave', 'drop'].forEach(function (evt) {
      dropzone.addEventListener(evt, function (e) {
        e.preventDefault(); e.stopPropagation();
        dropzone.classList.remove('is-dragover');
      });
    });
    dropzone.addEventListener('drop', function (e) {
      if (e.dataTransfer.files && e.dataTransfer.files.length) addFiles(e.dataTransfer.files);
    });

    form.addEventListener('submit', function (e) {
      if (!doctorSelect.value || !dateInput.value || !slotInput.value) {
        e.preventDefault();
      }
    });
  });
})();
</script>
