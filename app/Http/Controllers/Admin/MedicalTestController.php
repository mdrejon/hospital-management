<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\MedicalTest;
use App\Models\MedicalTestCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MedicalTestController extends Controller
{
    public function index(Request $request): Response
    {
        $search     = $request->input('search');
        $categoryId = $request->input('category_id');

        $query = MedicalTest::with('category')
            ->when($search, function ($q, $search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%");
                });
            })
            ->when($categoryId, function ($q, $categoryId) {
                $q->where('category_id', $categoryId);
            })
            ->orderBy('sort_order')
            ->orderBy('id');

        $tests = $query->paginate(15)->withQueryString();
        $categories = MedicalTestCategory::active()->get();

        return Inertia::render('Admin/MedicalTests/Index', [
            'tests'      => $tests,
            'categories' => $categories,
            'filters'    => [
                'search'      => $search,
                'category_id' => $categoryId,
            ],
            'languages'  => Language::active(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/MedicalTests/Create', [
            'categories' => MedicalTestCategory::active()->get(),
            'languages'  => Language::active(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $defaultLocale = config('app.locale', 'en');
        $validated = $request->validate([
            'category_id'              => ['required', 'exists:medical_test_categories,id'],
            'code'                     => ['required', 'string', 'max:50', 'unique:medical_tests,code'],
            'name'                     => ['required', 'array'],
            'name.' . $defaultLocale   => ['required', 'string', 'max:255'],
            'description'              => ['nullable', 'array'],
            'price'                    => ['required', 'numeric', 'min:0'],
            'discount_type'            => ['required', 'in:none,percentage,fixed'],
            'discount_amount'          => ['required', 'numeric', 'min:0'],
            'commission_rate'          => ['nullable', 'numeric', 'min:0'],
            'preparation_instructions' => ['nullable', 'array'],
            'estimated_delivery_time'  => ['nullable', 'string', 'max:100'],
            'sort_order'               => ['nullable', 'integer', 'min:0'],
            'is_active'                => ['boolean'],
        ]);

        $validated['final_price'] = MedicalTest::calculateFinalPrice(
            (float) $validated['price'],
            $validated['discount_type'],
            (float) $validated['discount_amount']
        );

        MedicalTest::create($validated);

        return redirect()->route('admin.medical-tests.index')->with('success', 'Medical test created successfully.');
    }

    public function edit(MedicalTest $medicalTest): Response
    {
        return Inertia::render('Admin/MedicalTests/Edit', [
            'test'       => $medicalTest,
            'categories' => MedicalTestCategory::active()->get(),
            'languages'  => Language::active(),
        ]);
    }

    public function update(Request $request, MedicalTest $medicalTest): RedirectResponse
    {
        $defaultLocale = config('app.locale', 'en');
        $validated = $request->validate([
            'category_id'              => ['required', 'exists:medical_test_categories,id'],
            'code'                     => ['required', 'string', 'max:50', 'unique:medical_tests,code,' . $medicalTest->id],
            'name'                     => ['required', 'array'],
            'name.' . $defaultLocale   => ['required', 'string', 'max:255'],
            'description'              => ['nullable', 'array'],
            'price'                    => ['required', 'numeric', 'min:0'],
            'discount_type'            => ['required', 'in:none,percentage,fixed'],
            'discount_amount'          => ['required', 'numeric', 'min:0'],
            'commission_rate'          => ['nullable', 'numeric', 'min:0'],
            'preparation_instructions' => ['nullable', 'array'],
            'estimated_delivery_time'  => ['nullable', 'string', 'max:100'],
            'sort_order'               => ['nullable', 'integer', 'min:0'],
            'is_active'                => ['boolean'],
        ]);

        $validated['final_price'] = MedicalTest::calculateFinalPrice(
            (float) $validated['price'],
            $validated['discount_type'],
            (float) $validated['discount_amount']
        );

        $medicalTest->update($validated);

        return redirect()->route('admin.medical-tests.index')->with('success', 'Medical test updated successfully.');
    }

    public function destroy(MedicalTest $medicalTest): RedirectResponse
    {
        $medicalTest->delete();

        return redirect()->route('admin.medical-tests.index')->with('success', 'Medical test deleted successfully.');
    }
}
