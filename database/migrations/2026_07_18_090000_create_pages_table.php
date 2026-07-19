<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('pages')->nullOnDelete();
            $table->string('title');
            $table->string('slug');
            $table->string('breadcrumb_title')->nullable();
            $table->string('hero_image')->nullable();
            $table->longText('content')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->string('seo_title')->nullable();
            $table->string('seo_description')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->string('seo_og_image')->nullable();
            $table->timestamps();

            $table->unique(['parent_id', 'slug']);
        });

        $now = now();

        DB::table('pages')->insert([
            [
                'parent_id'   => null,
                'title'       => 'Privacy Policy',
                'slug'        => 'privacy-policy',
                'content'     => $this->privacyPolicyContent(),
                'is_active'   => true,
                'sort_order'  => 0,
                'seo_title'   => 'Privacy Policy | ClinicMaster Medical & Health Care Services',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'parent_id'   => null,
                'title'       => 'Terms & Conditions',
                'slug'        => 'terms-conditions',
                'content'     => $this->termsConditionsContent(),
                'is_active'   => true,
                'sort_order'  => 1,
                'seo_title'   => 'Terms & Conditions | ClinicMaster Medical & Health Care Services',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }

    private function privacyPolicyContent(): string
    {
        return <<<'HTML'
<p>ClinicMaster ("we", "us", or "our") is committed to protecting the privacy of our patients and website visitors. This Privacy Policy explains what information we collect, how we use it, and the choices you have regarding your data.</p>
<h2>Information We Collect</h2>
<p>We may collect personal information you provide directly, such as your name, contact details, date of birth, and medical history when you book an appointment, fill out a contact form, or subscribe to our newsletter.</p>
<ul>
<li>Contact information: name, email address, phone number, and postal address.</li>
<li>Appointment details: preferred department, doctor, and visit date/time.</li>
<li>Health information relevant to the care you request.</li>
<li>Technical data such as browser type and pages visited, collected automatically.</li>
</ul>
<h2>How We Use Your Information</h2>
<p>We use the information we collect to schedule and confirm appointments, provide medical care, respond to inquiries, send appointment reminders, and improve our services. We do not sell your personal information to third parties.</p>
<h2>Data Security</h2>
<p>We use administrative, technical, and physical safeguards designed to protect your personal and health information against unauthorized access, alteration, or disclosure.</p>
<h2>Your Rights</h2>
<p>You may request access to, correction of, or deletion of your personal information at any time by contacting us at support@hospital.com or 1 123 456 7890.</p>
<h2>Changes to This Policy</h2>
<p>We may update this Privacy Policy from time to time. Any changes will be posted on this page with an updated revision date.</p>
HTML;
    }

    private function termsConditionsContent(): string
    {
        return <<<'HTML'
<p>These Terms &amp; Conditions govern your use of the ClinicMaster website and the healthcare services booked through it. By using our website or booking an appointment, you agree to these terms.</p>
<h2>Appointments &amp; Cancellations</h2>
<p>Appointments booked online or by phone are subject to confirmation by our staff. You may reschedule or cancel an appointment free of charge up to 24 hours before your scheduled visit. Late cancellations or no-shows may be subject to a fee.</p>
<h2>Medical Disclaimer</h2>
<p>Content on this website is provided for general informational purposes only and does not constitute medical advice. Always consult a qualified healthcare professional for diagnosis and treatment of any medical condition.</p>
<h2>Billing &amp; Payments</h2>
<p>Fees for services are due at the time of treatment unless other arrangements have been made with our billing department. We accept most major insurance plans; please confirm your coverage before your visit.</p>
<h2>Website Use</h2>
<p>You agree not to misuse this website, attempt unauthorized access to our systems, or submit false information when booking an appointment or contacting our team.</p>
<h2>Limitation of Liability</h2>
<p>ClinicMaster is not liable for any indirect or consequential damages arising from your use of this website. Nothing in these terms limits our liability for matters that cannot be excluded under applicable law.</p>
<h2>Contact</h2>
<p>Questions about these Terms &amp; Conditions can be sent to support@hospital.com or 1 123 456 7890.</p>
HTML;
    }
};
