<?php

namespace Tests\Feature;

use App\Models\AgentCommission;
use App\Models\AgentProfile;
use App\Models\AgentWalletTransaction;
use App\Models\MedicalTest;
use App\Models\MedicalTestBooking;
use App\Models\MedicalTestBookingItem;
use App\Models\MedicalTestCategory;
use App\Models\User;
use App\Services\CommissionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AgentCommissionDiscountDeductionTest extends TestCase
{
    use RefreshDatabase;

    protected User $agentUser;
    protected AgentProfile $agentProfile;
    protected MedicalTestCategory $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->agentUser = User::factory()->create([
            'is_active' => true,
        ]);

        $this->agentProfile = AgentProfile::create([
            'user_id'                => $this->agentUser->id,
            'agent_code'             => 'AG-TEST01',
            'phone'                  => '01700000000',
            'commission_type'        => 'percentage',
            'test_commission_rate'   => 15.00,
            'doctor_commission_rate' => 10.00,
            'status'                 => AgentProfile::STATUS_ACTIVE,
            'wallet_balance'         => 0.00,
        ]);

        $this->category = MedicalTestCategory::create([
            'name'      => ['en' => 'Pathology'],
            'slug'      => 'pathology',
            'is_active' => true,
        ]);
    }

    public function test_multi_test_booking_with_equal_prices_and_different_commission_rates()
    {
        // Test 1: CBC - 1000 Tk, 10% commission rate
        $cbc = MedicalTest::create([
            'category_id'     => $this->category->id,
            'code'            => 'CBC-01',
            'name'            => ['en' => 'Complete Blood Count'],
            'price'           => 1000.00,
            'discount_type'   => 'none',
            'discount_amount' => 0.00,
            'final_price'     => 1000.00,
            'commission_rate' => 10.00,
            'is_active'       => true,
        ]);

        // Test 2: X-Ray - 1000 Tk, 30% commission rate
        $xray = MedicalTest::create([
            'category_id'     => $this->category->id,
            'code'            => 'XRAY-01',
            'name'            => ['en' => 'Chest X-Ray'],
            'price'           => 1000.00,
            'discount_type'   => 'none',
            'discount_amount' => 0.00,
            'final_price'     => 1000.00,
            'commission_rate' => 30.00,
            'is_active'       => true,
        ]);

        // Agent gives 5% discount (100 Tk discount on 2000 Tk total)
        $agentDiscountTotal = 100.00; // 5% of 2000

        $booking = MedicalTestBooking::create([
            'booking_number'        => MedicalTestBooking::generateNumber(),
            'agent_id'              => $this->agentProfile->id,
            'patient_name'          => 'Test Patient',
            'phone'                 => '01800000000',
            'gender'                => 'male',
            'booking_date'          => now()->toDateString(),
            'subtotal_amount'       => 2000.00,
            'discount_amount'       => 0.00,
            'agent_discount_amount' => $agentDiscountTotal,
            'agent_discount_type'   => 'percentage',
            'agent_discount_value'  => 5.00,
            'total_amount'          => 1900.00,
            'paid_amount'           => 1900.00,
            'due_amount'            => 0.00,
            'payment_status'        => MedicalTestBooking::PAYMENT_PAID,
            'status'                => MedicalTestBooking::STATUS_COMPLETED,
        ]);

        $itemCbc = MedicalTestBookingItem::create([
            'medical_test_booking_id' => $booking->id,
            'medical_test_id'         => $cbc->id,
            'test_name'               => 'Complete Blood Count',
            'test_code'               => 'CBC-01',
            'unit_price'              => 1000.00,
            'discount_amount'         => 0.00,
            'final_price'             => 1000.00,
            'status'                  => MedicalTestBookingItem::STATUS_PENDING,
        ]);

        $itemXray = MedicalTestBookingItem::create([
            'medical_test_booking_id' => $booking->id,
            'medical_test_id'         => $xray->id,
            'test_name'               => 'Chest X-Ray',
            'test_code'               => 'XRAY-01',
            'unit_price'              => 1000.00,
            'discount_amount'         => 0.00,
            'final_price'             => 1000.00,
            'status'                  => MedicalTestBookingItem::STATUS_PENDING,
        ]);

        $commission = CommissionService::handleMedicalTestCommission($booking, $agentDiscountTotal);

        $itemCbc->refresh();
        $itemXray->refresh();
        $booking->refresh();
        $this->agentProfile->refresh();

        // Verification of CBC:
        // Gross Commission = 1000 * 10% = 100 Tk
        // Discount Allocated = 50 Tk (5%)
        // Net Commission = 100 - 50 = 50 Tk (exactly 5% net rate)
        $this->assertEquals(100.00, (float) $itemCbc->gross_commission_amount);
        $this->assertEquals(50.00, (float) $itemCbc->agent_discount_amount);
        $this->assertEquals(50.00, (float) $itemCbc->commission_amount);

        // Verification of X-Ray:
        // Gross Commission = 1000 * 30% = 300 Tk
        // Discount Allocated = 50 Tk (5%)
        // Net Commission = 300 - 50 = 250 Tk (exactly 25% net rate)
        $this->assertEquals(300.00, (float) $itemXray->gross_commission_amount);
        $this->assertEquals(50.00, (float) $itemXray->agent_discount_amount);
        $this->assertEquals(250.00, (float) $itemXray->commission_amount);

        // Verification of Booking totals:
        $this->assertEquals(400.00, (float) $booking->agent_gross_commission_amount);
        $this->assertEquals(300.00, (float) $booking->agent_commission_amount);

        // Verification of Agent Commission record & Wallet Credit:
        $this->assertEquals(300.00, (float) $commission->amount);
        $this->assertEquals(300.00, (float) $this->agentProfile->wallet_balance);

        // Verification of Hospital net retention:
        // Total collected from patient = 1900 Tk.
        // Paid to agent = 300 Tk.
        // Hospital retains = 1600 Tk.
        // (Without discount: 2000 - 400 = 1600 Tk. Hospital retained exactly the same 1600 Tk!).
        $hospitalNet = (float) $booking->total_amount - (float) $booking->agent_commission_amount;
        $this->assertEquals(1600.00, $hospitalNet);
    }

    public function test_multi_test_booking_with_different_prices_and_rates()
    {
        // Test 1: CBC - 400 Tk @ 10% commission = 40 Tk gross
        $cbc = MedicalTest::create([
            'category_id'     => $this->category->id,
            'code'            => 'CBC-02',
            'name'            => ['en' => 'CBC Test'],
            'price'           => 400.00,
            'discount_type'   => 'none',
            'discount_amount' => 0.00,
            'final_price'     => 400.00,
            'commission_rate' => 10.00,
            'is_active'       => true,
        ]);

        // Test 2: X-Ray - 1600 Tk @ 30% commission = 480 Tk gross
        $xray = MedicalTest::create([
            'category_id'     => $this->category->id,
            'code'            => 'XRAY-02',
            'name'            => ['en' => 'X-Ray Test'],
            'price'           => 1600.00,
            'discount_type'   => 'none',
            'discount_amount' => 0.00,
            'final_price'     => 1600.00,
            'commission_rate' => 30.00,
            'is_active'       => true,
        ]);

        // 5% discount across 2000 Tk = 100 Tk
        $agentDiscountTotal = 100.00;

        $booking = MedicalTestBooking::create([
            'booking_number'        => MedicalTestBooking::generateNumber(),
            'agent_id'              => $this->agentProfile->id,
            'patient_name'          => 'Test Patient 2',
            'phone'                 => '01811111111',
            'gender'                => 'female',
            'booking_date'          => now()->toDateString(),
            'subtotal_amount'       => 2000.00,
            'discount_amount'       => 0.00,
            'agent_discount_amount' => $agentDiscountTotal,
            'agent_discount_type'   => 'percentage',
            'agent_discount_value'  => 5.00,
            'total_amount'          => 1900.00,
            'paid_amount'           => 1900.00,
            'due_amount'            => 0.00,
            'payment_status'        => MedicalTestBooking::PAYMENT_PAID,
            'status'                => MedicalTestBooking::STATUS_COMPLETED,
        ]);

        $itemCbc = MedicalTestBookingItem::create([
            'medical_test_booking_id' => $booking->id,
            'medical_test_id'         => $cbc->id,
            'test_name'               => 'CBC Test',
            'test_code'               => 'CBC-02',
            'unit_price'              => 400.00,
            'discount_amount'         => 0.00,
            'final_price'             => 400.00,
            'status'                  => MedicalTestBookingItem::STATUS_PENDING,
        ]);

        $itemXray = MedicalTestBookingItem::create([
            'medical_test_booking_id' => $booking->id,
            'medical_test_id'         => $xray->id,
            'test_name'               => 'X-Ray Test',
            'test_code'               => 'XRAY-02',
            'unit_price'              => 1600.00,
            'discount_amount'         => 0.00,
            'final_price'             => 1600.00,
            'status'                  => MedicalTestBookingItem::STATUS_PENDING,
        ]);

        CommissionService::handleMedicalTestCommission($booking, $agentDiscountTotal);

        $itemCbc->refresh();
        $itemXray->refresh();
        $booking->refresh();

        // CBC: Price 400 Tk (20% of 2000 Tk)
        // Proportional Discount = 100 * (400 / 2000) = 20 Tk
        // Gross Comm = 400 * 10% = 40 Tk
        // Net Comm = 40 - 20 = 20 Tk
        $this->assertEquals(40.00, (float) $itemCbc->gross_commission_amount);
        $this->assertEquals(20.00, (float) $itemCbc->agent_discount_amount);
        $this->assertEquals(20.00, (float) $itemCbc->commission_amount);

        // X-Ray: Price 1600 Tk (80% of 2000 Tk)
        // Proportional Discount = 100 * (1600 / 2000) = 80 Tk
        // Gross Comm = 1600 * 30% = 480 Tk
        // Net Comm = 480 - 80 = 400 Tk
        $this->assertEquals(480.00, (float) $itemXray->gross_commission_amount);
        $this->assertEquals(80.00, (float) $itemXray->agent_discount_amount);
        $this->assertEquals(400.00, (float) $itemXray->commission_amount);

        // Total Gross = 520 Tk. Total Net = 420 Tk. Total Discount = 100 Tk.
        $this->assertEquals(520.00, (float) $booking->agent_gross_commission_amount);
        $this->assertEquals(420.00, (float) $booking->agent_commission_amount);

        // Hospital retention:
        // Collected 1900 Tk - 420 Tk commission = 1480 Tk.
        // (Without discount: 2000 - 520 = 1480 Tk. Full protection!).
        $hospitalNet = (float) $booking->total_amount - (float) $booking->agent_commission_amount;
        $this->assertEquals(1480.00, $hospitalNet);
    }

    public function test_custom_item_discounts_deducted_per_item()
    {
        $cbc = MedicalTest::create([
            'category_id'     => $this->category->id,
            'code'            => 'CBC-03',
            'name'            => ['en' => 'CBC Test 3'],
            'price'           => 1000.00,
            'discount_type'   => 'none',
            'discount_amount' => 0.00,
            'final_price'     => 1000.00,
            'commission_rate' => 10.00,
            'is_active'       => true,
        ]);

        $xray = MedicalTest::create([
            'category_id'     => $this->category->id,
            'code'            => 'XRAY-03',
            'name'            => ['en' => 'X-Ray Test 3'],
            'price'           => 1000.00,
            'discount_type'   => 'none',
            'discount_amount' => 0.00,
            'final_price'     => 1000.00,
            'commission_rate' => 30.00,
            'is_active'       => true,
        ]);

        // Agent gives 0 discount on CBC, but 100 Tk discount on X-Ray
        $booking = MedicalTestBooking::create([
            'booking_number'        => MedicalTestBooking::generateNumber(),
            'agent_id'              => $this->agentProfile->id,
            'patient_name'          => 'Test Patient 3',
            'phone'                 => '01822222222',
            'gender'                => 'male',
            'booking_date'          => now()->toDateString(),
            'subtotal_amount'       => 2000.00,
            'discount_amount'       => 0.00,
            'agent_discount_amount' => 100.00,
            'agent_discount_type'   => 'fixed',
            'agent_discount_value'  => 100.00,
            'total_amount'          => 1900.00,
            'paid_amount'           => 1900.00,
            'due_amount'            => 0.00,
            'payment_status'        => MedicalTestBooking::PAYMENT_PAID,
            'status'                => MedicalTestBooking::STATUS_COMPLETED,
        ]);

        $itemCbc = MedicalTestBookingItem::create([
            'medical_test_booking_id' => $booking->id,
            'medical_test_id'         => $cbc->id,
            'test_name'               => 'CBC Test 3',
            'test_code'               => 'CBC-03',
            'unit_price'              => 1000.00,
            'discount_amount'         => 0.00,
            'final_price'             => 1000.00,
            'agent_discount_amount'   => 0.00,
            'status'                  => MedicalTestBookingItem::STATUS_PENDING,
        ]);

        $itemXray = MedicalTestBookingItem::create([
            'medical_test_booking_id' => $booking->id,
            'medical_test_id'         => $xray->id,
            'test_name'               => 'X-Ray Test 3',
            'test_code'               => 'XRAY-03',
            'unit_price'              => 1000.00,
            'discount_amount'         => 0.00,
            'final_price'             => 1000.00,
            'agent_discount_amount'   => 100.00,
            'status'                  => MedicalTestBookingItem::STATUS_PENDING,
        ]);

        CommissionService::handleMedicalTestCommission($booking, 100.00);

        $itemCbc->refresh();
        $itemXray->refresh();
        $booking->refresh();

        // CBC has 0 discount -> keeps full 100 Tk commission
        $this->assertEquals(100.00, (float) $itemCbc->gross_commission_amount);
        $this->assertEquals(0.00, (float) $itemCbc->agent_discount_amount);
        $this->assertEquals(100.00, (float) $itemCbc->commission_amount);

        // X-Ray has 100 discount -> 300 - 100 = 200 Tk net commission
        $this->assertEquals(300.00, (float) $itemXray->gross_commission_amount);
        $this->assertEquals(100.00, (float) $itemXray->agent_discount_amount);
        $this->assertEquals(200.00, (float) $itemXray->commission_amount);

        // Total Net Commission = 300 Tk
        $this->assertEquals(300.00, (float) $booking->agent_commission_amount);
    }

    public function test_discount_cannot_cause_negative_commission()
    {
        $cbc = MedicalTest::create([
            'category_id'     => $this->category->id,
            'code'            => 'CBC-04',
            'name'            => ['en' => 'CBC Test 4'],
            'price'           => 1000.00,
            'discount_type'   => 'none',
            'discount_amount' => 0.00,
            'final_price'     => 1000.00,
            'commission_rate' => 10.00, // 100 Tk gross
            'is_active'       => true,
        ]);

        // Excessive discount of 150 Tk on a test with 100 Tk gross commission
        $booking = MedicalTestBooking::create([
            'booking_number'        => MedicalTestBooking::generateNumber(),
            'agent_id'              => $this->agentProfile->id,
            'patient_name'          => 'Test Patient 4',
            'phone'                 => '01833333333',
            'gender'                => 'male',
            'booking_date'          => now()->toDateString(),
            'subtotal_amount'       => 1000.00,
            'discount_amount'       => 0.00,
            'agent_discount_amount' => 150.00,
            'agent_discount_type'   => 'fixed',
            'agent_discount_value'  => 150.00,
            'total_amount'          => 850.00,
            'paid_amount'           => 850.00,
            'due_amount'            => 0.00,
            'payment_status'        => MedicalTestBooking::PAYMENT_PAID,
            'status'                => MedicalTestBooking::STATUS_COMPLETED,
        ]);

        $itemCbc = MedicalTestBookingItem::create([
            'medical_test_booking_id' => $booking->id,
            'medical_test_id'         => $cbc->id,
            'test_name'               => 'CBC Test 4',
            'test_code'               => 'CBC-04',
            'unit_price'              => 1000.00,
            'discount_amount'         => 0.00,
            'final_price'             => 1000.00,
            'status'                  => MedicalTestBookingItem::STATUS_PENDING,
        ]);

        CommissionService::handleMedicalTestCommission($booking, 150.00);

        $itemCbc->refresh();
        $booking->refresh();

        // Gross is 100, Discount is 150 -> Net commission must floor at 0.00 (NOT negative!)
        $this->assertEquals(100.00, (float) $itemCbc->gross_commission_amount);
        $this->assertEquals(0.00, (float) $itemCbc->commission_amount);
        $this->assertEquals(0.00, (float) $booking->agent_commission_amount);
    }
}
