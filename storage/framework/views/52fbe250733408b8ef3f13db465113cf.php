<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Appointment Received</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'Segoe UI', Arial, sans-serif; background: #f4f6f9; color: #1a2a3a; }
  .wrapper { max-width: 600px; margin: 32px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
  .header { background: linear-gradient(135deg, #0f2a42 0%, #1a3a5c 100%); padding: 36px 40px; text-align: center; }
  .logo-text { font-size: 11px; font-weight: 700; letter-spacing: 3px; color: rgba(255,255,255,0.5); text-transform: uppercase; margin-bottom: 10px; }
  .header h1 { font-size: 24px; font-weight: 700; color: #fff; }
  .gold-bar { height: 3px; background: linear-gradient(90deg, #c9a47a, #e8c99a, #c9a47a); }
  .body { padding: 36px 40px; }
  .greeting { font-size: 15px; margin-bottom: 16px; }
  .intro { font-size: 14px; color: #4a5a6a; line-height: 1.7; margin-bottom: 24px; }
  .msg-box { background: #f8fafc; border: 1px solid #e0e8f0; border-left: 3px solid #c9a47a; border-radius: 0 8px 8px 0; padding: 16px 20px; margin-bottom: 24px; }
  .msg-box .row { display: flex; justify-content: space-between; font-size: 14px; color: #1a2a3a; padding: 6px 0; }
  .msg-box .row span:first-child { color: #7a8aa0; }
  .notice { background: #fffbf0; border: 1.5px solid #f5e0a0; border-radius: 10px; padding: 14px 18px; font-size: 13.5px; color: #7a5a10; line-height: 1.6; margin-bottom: 24px; }
  .footer { background: #f8fafc; padding: 24px 40px; text-align: center; border-top: 1px solid #e8edf3; }
  .footer p { font-size: 12px; color: #9aa8b8; line-height: 1.7; }
</style>
</head>
<body>
<div class="wrapper">
  <div class="header">
    <p class="logo-text"><?php echo e(config('app.name')); ?></p>
    <h1>Appointment Request Received</h1>
  </div>
  <div class="gold-bar"></div>

  <div class="body">
    <p class="greeting">Dear <strong><?php echo e($appointment->name); ?></strong>,</p>
    <p class="intro">
      Thank you for booking an appointment with <?php echo e(config('app.name')); ?>. Here are your details:
    </p>

    <div class="msg-box">
      <div class="row"><span>Serial Number</span><span><strong>#<?php echo e($appointment->serial_number); ?></strong></span></div>
      <div class="row"><span>Doctor</span><span><?php echo e($appointment->preferred_doctor); ?></span></div>
      <div class="row"><span>Date</span><span><?php echo e(optional($appointment->appointment_date)->format('d M Y')); ?></span></div>
      <div class="row"><span>Time</span><span><?php echo e($appointment->time_slot); ?></span></div>
      <?php if($appointment->fee): ?>
      <div class="row"><span>Consultation Fee</span><span><?php echo e(number_format($appointment->fee, 2)); ?></span></div>
      <?php endif; ?>
    </div>

    <div class="notice">
      <strong>Status: Pending Confirmation.</strong> Our team will review and confirm your appointment shortly. Please arrive 10 minutes early with your serial number.
    </div>
  </div>

  <div class="footer">
    <p>
      <strong><?php echo e(config('app.name')); ?></strong><br>
      <a href="mailto:<?php echo e(config('mail.from.address')); ?>"><?php echo e(config('mail.from.address')); ?></a>
    </p>
    <p style="margin-top:10px;">&copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>. All rights reserved.</p>
  </div>
</div>
</body>
</html>
<?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views\emails\appointment-confirmation.blade.php ENDPATH**/ ?>