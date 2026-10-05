<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$models = [
    \App\Models\GlobalSetting::class,
    \App\Models\Service::class,
    \App\Models\Doctor::class,
    \App\Models\DoctorSpecialization::class,
    \App\Models\Package::class,
    \App\Models\Slider::class,
    \App\Models\Blog::class,
    \App\Models\Testimonial::class,
    \App\Models\Award::class,
    \App\Models\Faq::class,
    \App\Models\ManagementMember::class,
    \App\Models\Page::class,
];

$missing = [];

foreach ($models as $class) {
    if (!class_exists($class)) continue;
    $items = $class::all();
    foreach ($items as $item) {
        if ($class === \App\Models\GlobalSetting::class) {
            $val = json_decode($item->getRawOriginal('value'), true);
            if (is_array($val) && isset($val['en']) && empty($val['bn'])) {
                $missing['GlobalSetting'][$item->key] = $val['en'];
            }
            continue;
        }

        if (method_exists($item, 'getTranslatableAttributes')) {
            $fields = $item->getTranslatableAttributes();
            foreach ($fields as $field) {
                $translations = $item->getTranslations($field);
                if (isset($translations['en']) && empty($translations['bn'])) {
                    $missing[class_basename($class)][] = [
                        'id' => $item->id,
                        'field' => $field,
                        'en' => $translations['en']
                    ];
                }
            }
        }
    }
}

echo json_encode($missing, JSON_PRETTY_PRINT);
