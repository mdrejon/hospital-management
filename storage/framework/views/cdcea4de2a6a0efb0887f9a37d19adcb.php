<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'settings'          => [],
    'doctors'           => collect(),
    'specializations'   => collect(),
    'source'            => 'appointment_page',
    'preselectedDoctor' => null,
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'settings'          => [],
    'doctors'           => collect(),
    'specializations'   => collect(),
    'source'            => 'appointment_page',
    'preselectedDoctor' => null,
]); ?>
<?php foreach (array_filter(([
    'settings'          => [],
    'doctors'           => collect(),
    'specializations'   => collect(),
    'source'            => 'appointment_page',
    'preselectedDoctor' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
  $apptBadge        = $settings['appt_badge']         ?? __('frontend.home.appt_badge');
  $apptTitle        = $settings['appt_title']         ?? __('frontend.home.appt_title');
  $apptFormTitle    = $settings['appt_form_title']    ?? __('frontend.home.appt_form_title');
  $apptFormSubtitle = $settings['appt_form_subtitle'] ?? __('frontend.home.appt_form_subtitle');
  $apptImage        = !empty($settings['appt_image']) ? asset('storage/' . $settings['appt_image']) : asset('assets/img/appoinment-img.jpg');

  $apptDoctors = $doctors instanceof \Illuminate\Support\Collection ? $doctors : collect();
  $apptSpecializations = $specializations instanceof \Illuminate\Support\Collection ? $specializations : collect();
?>

<section class="book-appointment">
  <span class="book-appointment__watermark" aria-hidden="true">Make An Appointment</span>

  <div class="container relative mx-auto">
    <div class="book-appointment__head">
      <p class="book-appointment__eyebrow"><?php echo e($apptBadge); ?></p>
      <h2 class="book-appointment__title"><?php echo e($apptTitle); ?></h2>
    </div>

    <div class="relative z-10 mt-12 bg-white rounded-2xl shadow-[0_4px_25px_rgba(0,0,0,0.05)] border border-gray-100 p-6 md:p-10 mb-10 w-full max-w-4xl mx-auto">
      <div class="w-full">
        <?php if(session('success')): ?>
        <div class="flex items-start gap-3 p-4 mb-6 text-green-800 bg-green-50 border border-green-200 rounded-lg shadow-sm">
          <svg class="w-5 h-5 shrink-0 text-green-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <div class="text-[15px] font-medium leading-relaxed"><?php echo e(session('success')); ?></div>
        </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
        <div class="flex items-start gap-3 p-4 mb-6 text-red-800 bg-red-50 border border-red-200 rounded-lg shadow-sm">
          <svg class="w-5 h-5 shrink-0 text-red-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <div class="text-[15px] font-medium leading-relaxed"><?php echo e($errors->first()); ?></div>
        </div>
        <?php endif; ?>

        <form action="<?php echo e(route('appointment.submit')); ?>" method="POST" enctype="multipart/form-data" data-booking-form>
          <?php echo csrf_field(); ?>
          <input type="hidden" name="source" value="<?php echo e($source); ?>" />
          <input type="hidden" name="time_slot" data-field="time_slot" />

          <h3 class="text-[18px] font-bold text-navy mb-1"><?php echo e($apptFormTitle); ?></h3>
          <p class="text-sm text-gray-500 mb-6"><?php echo e($apptFormSubtitle); ?></p>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
            <!-- Patient Name -->
            <div class="flex flex-col gap-1.5">
              <label class="text-[14px] font-semibold text-navy"><?php echo e(__('frontend.appointment_form.patient_name')); ?> <span class="text-red-500">*</span></label>
              <div class="flex items-center justify-between w-full bg-[#F7F8FA] rounded-lg px-4 h-[54px] border border-transparent focus-within:border-brand-cyan transition-colors">
                <input type="text" name="patient_name" value="<?php echo e(old('patient_name')); ?>" class="w-full bg-transparent border-none outline-none focus:ring-0 text-[15px] text-gray-700 placeholder-gray-400 p-0" placeholder="e.g. John Doe" required />
                <span class="text-gray-400 ml-2 shrink-0">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="8" r="3.2" stroke="currentColor" stroke-width="1.6"/>
                    <path d="M5 20c0-3.5 3-6 7-6s7 2.5 7 6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                  </svg>
                </span>
              </div>
            </div>

            <!-- Email -->
            <div class="flex flex-col gap-1.5">
              <label class="text-[14px] font-semibold text-navy"><?php echo e(__('frontend.appointment_form.email')); ?> <span class="text-gray-400 font-normal text-xs">(Optional)</span></label>
              <div class="flex items-center justify-between w-full bg-[#F7F8FA] rounded-lg px-4 h-[54px] border border-transparent focus-within:border-brand-cyan transition-colors">
                <input type="email" name="email" value="<?php echo e(old('email')); ?>" class="w-full bg-transparent border-none outline-none focus:ring-0 text-[15px] text-gray-700 placeholder-gray-400 p-0" placeholder="e.g. john@example.com" />
                <span class="text-gray-400 ml-2 shrink-0">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 4h16v16H4z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                    <path d="m4 6 8 7 8-7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
              </div>
            </div>

            <!-- Date of Birth -->
            <div class="flex flex-col gap-1.5">
              <label class="text-[14px] font-semibold text-navy"><?php echo e(__('frontend.appointment_form.dob')); ?> <span class="text-gray-400 font-normal text-xs">(Optional)</span></label>
              <div class="flex items-center justify-between w-full bg-[#F7F8FA] rounded-lg px-4 h-[54px] border border-transparent focus-within:border-brand-cyan transition-colors">
                <input type="date" name="date_of_birth" value="<?php echo e(old('date_of_birth')); ?>" class="w-full bg-transparent border-none outline-none focus:ring-0 text-[15px] text-gray-700 placeholder-gray-400 p-0" data-field="dob" max="<?php echo e(now()->toDateString()); ?>" />
                <span class="text-gray-400 ml-2 shrink-0">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="3.5" y="5" width="17" height="16" rx="2.5" stroke="currentColor" stroke-width="1.6"/>
                    <path d="M3.5 9.5h17M8 3v3.5M16 3v3.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                  </svg>
                </span>
              </div>
            </div>

            <!-- Phone Number -->
            <div class="flex flex-col gap-1.5">
              <label class="text-[14px] font-semibold text-navy"><?php echo e(__('frontend.appointment_form.mobile')); ?> <span class="text-red-500">*</span></label>
              <div class="flex items-center justify-between w-full bg-[#F7F8FA] rounded-lg px-4 h-[54px] border border-transparent focus-within:border-brand-cyan transition-colors">
                <input type="tel" name="phone" value="<?php echo e(old('phone')); ?>" class="w-full bg-transparent border-none outline-none focus:ring-0 text-[15px] text-gray-700 placeholder-gray-400 p-0" placeholder="e.g. +8801XXXXXXXXX" required />
                <span class="text-gray-400 ml-2 shrink-0">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" stroke="currentColor" stroke-width="1.6"/>
                  </svg>
                </span>
              </div>
            </div>
          </div>

          <!-- Gender & Age -->
          <div class="flex flex-wrap items-center gap-6 mb-6">
            <span class="font-bold text-navy text-[15px]">Gender <span class="text-red-500">*</span></span>
            <label class="flex items-center gap-2 cursor-pointer text-gray-600 text-[15px]">
              <input type="radio" name="gender" value="male" class="text-brand-cyan focus:ring-brand-cyan w-4 h-4 rounded border-gray-300" <?php echo e(old('gender') !== 'female' && old('gender') !== 'other' ? 'checked' : ''); ?> required />
              <?php echo e(__('frontend.appointment_form.male')); ?>

            </label>
            <label class="flex items-center gap-2 cursor-pointer text-gray-600 text-[15px]">
              <input type="radio" name="gender" value="female" class="text-brand-cyan focus:ring-brand-cyan w-4 h-4 rounded border-gray-300" <?php echo e(old('gender') === 'female' ? 'checked' : ''); ?> />
              <?php echo e(__('frontend.appointment_form.female')); ?>

            </label>
            <label class="flex items-center gap-2 cursor-pointer text-gray-600 text-[15px]">
              <input type="radio" name="gender" value="other" class="text-brand-cyan focus:ring-brand-cyan w-4 h-4 rounded border-gray-300" <?php echo e(old('gender') === 'other' ? 'checked' : ''); ?> />
              <?php echo e(__('frontend.appointment_form.other')); ?>

            </label>

            <!-- Hidden Age Field -->
            <input type="number" min="0" max="130" class="hidden" placeholder="<?php echo e(__('frontend.appointment_form.age')); ?>" data-field="age" />
          </div>

          <div class="flex flex-col gap-5 mb-5">
            <!-- Appt Type (OPD / Follow up) -->
            <div class="flex items-center justify-between w-full bg-[#F7F8FA] rounded-lg px-4 h-[54px]">
              <span class="font-semibold text-navy text-[14px] shrink-0"><?php echo e(__('frontend.appointment_form.appt_details')); ?> <span class="text-red-500">*</span></span>
              <div class="flex gap-4">
                <label class="flex items-center gap-2 cursor-pointer text-gray-600 text-[14px]">
                  <input type="radio" name="appointment_type" value="opd" class="text-brand-cyan focus:ring-brand-cyan w-4 h-4 rounded border-gray-300" <?php echo e(old('appointment_type') !== 'follow_up' ? 'checked' : ''); ?> required />
                  <?php echo e(__('frontend.appointment_form.opd')); ?>

                </label>
                <label class="flex items-center gap-2 cursor-pointer text-gray-600 text-[14px]">
                  <input type="radio" name="appointment_type" value="follow_up" class="text-brand-cyan focus:ring-brand-cyan w-4 h-4 rounded border-gray-300" <?php echo e(old('appointment_type') === 'follow_up' ? 'checked' : ''); ?> />
                  <?php echo e(__('frontend.appointment_form.follow_up')); ?>

                </label>
              </div>
            </div>

            <!-- Select Service / Specialization -->
            <div class="flex flex-col gap-1.5">
              <label class="text-[14px] font-semibold text-navy">Service / Specialization <span class="text-gray-400 font-normal text-xs">(Optional)</span></label>
              <div class="relative flex items-center justify-between w-full bg-[#F7F8FA] rounded-lg px-4 h-[54px] border border-transparent focus-within:border-brand-cyan transition-colors">
                <select class="w-full bg-transparent border-none outline-none focus:ring-0 text-[15px] text-gray-700 p-0 appearance-none" data-field="specialization">
                  <option value="">Select Service / <?php echo e(__('frontend.appointment_form.all_spec')); ?></option>
                  <?php $__currentLoopData = $apptSpecializations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($spec->id); ?>"><?php echo e($spec->name); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <span class="text-gray-400 shrink-0 pointer-events-none">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="m6 9 6 6 6-6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
              </div>
            </div>

            <!-- Select Doctor -->
            <div class="flex flex-col gap-1.5">
              <label class="text-[14px] font-semibold text-navy">Select Doctor <span class="text-red-500">*</span></label>
              <div class="relative flex items-center justify-between w-full bg-[#F7F8FA] rounded-lg px-4 h-[54px] border border-transparent focus-within:border-brand-cyan transition-colors">
                <?php
                  $selectedDoctorId = old('doctor_id') ?: data_get($preselectedDoctor, 'id');
                ?>
                <select name="doctor_id" class="w-full bg-transparent border-none outline-none focus:ring-0 text-[15px] text-gray-700 p-0 appearance-none" data-field="doctor" required>
                  <option value="" <?php echo e($selectedDoctorId ? '' : 'selected'); ?> hidden>Select Doctor</option>
                  <?php $__empty_1 = true; $__currentLoopData = $apptDoctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                  <option value="<?php echo e($doc->id); ?>" data-spec-id="<?php echo e($doc->doctor_specialization_id); ?>" data-fee="<?php echo e($doc->consultation_fee); ?>" <?php echo e((string) $selectedDoctorId === (string) $doc->id ? 'selected' : ''); ?>>
                    <?php echo e($doc->name); ?><?php echo e($doc->role ? ' — ' . $doc->role : ''); ?>

                  </option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                  <option value="" disabled><?php echo e(__('frontend.appointment_form.no_doctors')); ?></option>
                  <?php endif; ?>
                </select>
                <span class="text-gray-400 shrink-0 pointer-events-none">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="m6 9 6 6 6-6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
              </div>
              <p class="text-[13px] text-red-500" data-field="doctor-hint"></p>
            </div>

            <!-- Appointment Date -->
            <div class="flex flex-col gap-1.5">
              <label class="text-[14px] font-semibold text-navy"><?php echo e(__('frontend.appointment_form.appt_date')); ?> <span class="text-red-500">*</span></label>
              <div class="flex items-center justify-between w-full bg-[#F7F8FA] rounded-lg px-4 h-[54px] border border-transparent focus-within:border-brand-cyan transition-colors">
                <input type="date" name="appointment_date" value="<?php echo e(old('appointment_date')); ?>" class="w-full bg-transparent border-none outline-none focus:ring-0 text-[15px] text-gray-700 placeholder-gray-400 p-0" placeholder="mm/dd/yyyy" data-field="date" disabled required />
                <span class="text-gray-400 ml-2 shrink-0">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="3.5" y="5" width="17" height="16" rx="2.5" stroke="currentColor" stroke-width="1.6"/>
                    <path d="M3.5 9.5h17M8 3v3.5M16 3v3.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                  </svg>
                </span>
              </div>
              <p class="text-[13px] text-red-500" data-field="date-hint"></p>
            </div>

            <!-- Time Slots (Dynamic) -->
            <div class="w-full">
              <p class="font-bold text-navy text-[15px] mb-2" data-field="slots-label" style="display:none;">Doctor Availability</p>
              <div class="flex flex-wrap gap-2" data-field="slots"></div>
            </div>

            <!-- Note To Doctor -->
            <div class="flex flex-col gap-1.5">
              <label class="text-[14px] font-semibold text-navy"><?php echo e(__('frontend.appointment_form.symptoms')); ?> <span class="text-gray-400 font-normal text-xs">(Optional)</span></label>
              <div class="w-full bg-[#F7F8FA] rounded-lg p-4 border border-transparent focus-within:border-brand-cyan transition-colors">
                <textarea name="symptoms" class="w-full bg-transparent border-none outline-none focus:ring-0 text-[15px] text-gray-700 placeholder-gray-400 p-0 resize-none" placeholder="Describe any symptoms or note for the doctor..." rows="4"><?php echo e(old('symptoms')); ?></textarea>
              </div>
            </div>
            
            <!-- Address (Hidden) -->
            <input type="hidden" data-field="address" name="address" value="<?php echo e(old('address')); ?>">

            <!-- Dropzone -->
            <div class="flex flex-col gap-1.5">
              <label class="text-[14px] font-semibold text-navy">Medical Documents <span class="text-gray-400 font-normal text-xs">(Optional)</span></label>
              <div class="book-appointment__dropzone w-full bg-[#F7F8FA] rounded-lg border-dashed border-2 border-gray-200" data-field="dropzone" tabindex="0" role="button" aria-label="Upload medical documents">
                <input type="file" name="medical_documents[]" class="book-appointment__dropzone-input" data-field="file-input" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" multiple hidden />
                <div class="book-appointment__dropzone-prompt" data-field="dropzone-empty">
                  <span class="book-appointment__dropzone-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 16V4M12 4 7 9M12 4l5 5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                  </span>
                  <p class="book-appointment__dropzone-text" data-field="dropzone-label">
                    <span class="book-appointment__dropzone-browse text-brand-cyan font-semibold"><?php echo e(__('frontend.appointment_form.upload_docs')); ?></span> <?php echo __('frontend.appointment_form.drag_drop'); ?>

                  </p>
                  <p class="book-appointment__dropzone-hint text-xs text-gray-400 mt-1"><?php echo e(__('frontend.appointment_form.upload_hint')); ?></p>
                </div>
                <div class="book-appointment__dropzone-list" data-field="dropzone-list"></div>
              </div>
              <p class="text-[13px] text-red-500" data-field="file-hint"></p>
            </div>

            <!-- Payment -->
            <?php
              $paymentSettings = \App\Services\PaymentService::getActiveGateways();
            ?>
            <?php if($paymentSettings['has_online'] || $paymentSettings['allow_without_pay']): ?>
            <div class="w-full mt-2">
              <p class="font-bold text-navy text-[15px] mb-2"><?php echo e(__('frontend.appointment_form.payment_option')); ?></p>
              <div class="flex flex-wrap gap-4">
                <?php if($paymentSettings['allow_without_pay']): ?>
                <label class="flex items-center gap-2 px-4 py-2 bg-[#F7F8FA] border border-gray-200 rounded-lg cursor-pointer transition-colors hover:bg-gray-100">
                  <input type="radio" name="payment_type" value="without_pay" class="text-brand-cyan focus:ring-brand-cyan" checked data-payment-type />
                  <span class="text-gray-700 text-[14px]">🏥 <?php echo e(__('frontend.appointment_form.pay_hospital')); ?></span>
                </label>
                <?php endif; ?>
                <?php if($paymentSettings['has_online']): ?>
                <label class="flex items-center gap-2 px-4 py-2 bg-[#F7F8FA] border border-gray-200 rounded-lg cursor-pointer transition-colors hover:bg-gray-100">
                  <input type="radio" name="payment_type" value="online" class="text-brand-cyan focus:ring-brand-cyan" <?php echo e(!$paymentSettings['allow_without_pay'] ? 'checked' : ''); ?> data-payment-type />
                  <span class="text-gray-700 text-[14px]">💳 <?php echo e(__('frontend.appointment_form.pay_online')); ?></span>
                </label>
                <?php endif; ?>
              </div>

              <?php if($paymentSettings['has_online']): ?>
              <div class="flex gap-4 mt-3" data-gateway-selector style="<?php echo e(!$paymentSettings['allow_without_pay'] ? '' : 'display:none;'); ?>">
                <?php if(!empty($paymentSettings['gateways']['bkash'])): ?>
                <label class="flex items-center gap-2 px-4 py-2 bg-pink-50 border border-pink-200 rounded-lg cursor-pointer text-pink-600 font-semibold text-[13px] transition-colors hover:bg-pink-100">
                  <input type="radio" name="payment_gateway" value="bkash" class="text-pink-600 focus:ring-pink-600" checked />
                  <span><?php echo e(__('frontend.appointment_form.bkash')); ?></span>
                </label>
                <?php endif; ?>
                <?php if(!empty($paymentSettings['gateways']['sslcommerz'])): ?>
                <label class="flex items-center gap-2 px-4 py-2 bg-blue-50 border border-blue-200 rounded-lg cursor-pointer text-blue-600 font-semibold text-[13px] transition-colors hover:bg-blue-100">
                  <input type="radio" name="payment_gateway" value="sslcommerz" class="text-blue-600 focus:ring-blue-600" <?php echo e(empty($paymentSettings['gateways']['bkash']) ? 'checked' : ''); ?> />
                  <span><?php echo e(__('frontend.appointment_form.sslcommerz')); ?></span>
                </label>
                <?php endif; ?>
              </div>
              <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- Terms & Conditions -->
            <label class="flex items-center gap-3 mt-4 mb-2 cursor-pointer">
              <input type="checkbox" required class="w-4 h-4 text-[#00c853] border-gray-300 rounded focus:ring-[#00c853]">
              <span class="text-[14px] text-gray-600">I accept <a href="<?php echo e(url('privacy')); ?>" class="text-brand-cyan hover:underline">Privacy Policy</a> and <a href="<?php echo e(url('policy')); ?>" class="text-brand-cyan hover:underline">Terms & Conditions</a></span>
            </label>

            <!-- Submit Button -->
            <div class="mt-2">
              <button type="submit" class="inline-flex items-center justify-center gap-2 bg-[#00c853] hover:bg-green-600 text-white font-semibold text-[15px] px-8 py-3.5 rounded disabled:bg-gray-300 disabled:text-gray-500 disabled:cursor-not-allowed transition-colors shadow-sm" data-field="submit" disabled>
                Book Appointment
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </button>
            </div>
          </div>
        </form>
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
          noDocOpt.textContent = "<?php echo e(__('frontend.appointment_form.no_doctors')); ?>";
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
      dateHint.textContent = (opt && opt.dataset.fee) ? '<?php echo e(__('frontend.appointment_form.fee_prefix')); ?>' + opt.dataset.fee : '';

      fetch('<?php echo e(route('appointment.availability')); ?>?doctor_id=' + encodeURIComponent(doctorSelect.value))
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
        slotsWrap.innerHTML = '<span class="book-appointment__hint is-error text-red-500"><?php echo e(__('frontend.appointment_form.err_unavailable')); ?></span>';
        return;
      }

      slotsLabel.style.display = '';
      slotsWrap.innerHTML = '<span class="book-appointment__hint text-gray-500">Checking availability...</span>';

      fetch('<?php echo e(route('appointment.slots')); ?>?doctor_id=' + encodeURIComponent(doctorSelect.value) + '&date=' + encodeURIComponent(dateInput.value))
        .then(function (r) { return r.json(); })
        .then(function (data) {
          slotsWrap.innerHTML = '';
          if (data.start_time && data.end_time) {
            slotsWrap.innerHTML = '<span class="text-green-600 font-medium">Doctor is available from ' + data.start_time + ' to ' + data.end_time + ' on this date.</span>';
            slotInput.value = data.start_time; // Optionally set a default slot
          } else {
             slotsWrap.innerHTML = '<span class="book-appointment__hint is-error text-red-500"><?php echo e(__('frontend.appointment_form.err_no_slots')); ?></span>';
          }
          updateSubmitState();
        })
        .catch(function () {
          slotsWrap.innerHTML = '<span class="book-appointment__hint is-error text-red-500">Failed to load availability.</span>';
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
      var browseText = selectedFiles.length === 0 ? '<?php echo e(__('frontend.appointment_form.upload_docs')); ?>' : '<?php echo e(__('frontend.appointment_form.add_another')); ?>';
      promptLabel.innerHTML = '<span class="book-appointment__dropzone-browse">' + browseText + '</span> or drag &amp; drop';
      promptView.style.display = selectedFiles.length < maxFiles ? '' : 'none';
    }

    function acceptFile(file) {
      var allowed = ['image/jpeg', 'image/png', 'application/pdf', 'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
      if (allowed.indexOf(file.type) === -1) {
        fileHint.textContent = '<?php echo e(__('frontend.appointment_form.unsupported_file')); ?>'.replace(':file', file.name);
        return false;
      }
      if (file.size > maxFileBytes) {
        fileHint.textContent = '<?php echo e(__('frontend.appointment_form.file_too_large')); ?>'.replace(':file', file.name);
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
          fileHint.textContent = '<?php echo e(__('frontend.appointment_form.max_files')); ?>'.replace(':max', maxFiles);
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
<?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views/components/frontend/book-appointment.blade.php ENDPATH**/ ?>