<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>New Appointment</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'Segoe UI', Arial, sans-serif; background: #f4f6f9; color: #1a2a3a; }
  .wrapper { max-width: 600px; margin: 32px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
  .header { background: linear-gradient(135deg, #0f2a42 0%, #1a3a5c 100%); padding: 28px 40px; }
  .header h1 { font-size: 20px; font-weight: 700; color: #fff; }
  .gold-bar { height: 3px; background: linear-gradient(90deg, #c9a47a, #e8c99a, #c9a47a); }
  .body { padding: 32px 40px; }
  .msg-box { background: #f8fafc; border: 1px solid #e0e8f0; border-left: 3px solid #c9a47a; border-radius: 0 8px 8px 0; padding: 16px 20px; margin-bottom: 20px; }
  .msg-box .row { display: flex; justify-content: space-between; font-size: 14px; color: #1a2a3a; padding: 6px 0; border-bottom: 1px solid #eef2f6; }
  .msg-box .row:last-child { border-bottom: none; }
  .msg-box .row span:first-child { color: #7a8aa0; }
  .footer { background: #f8fafc; padding: 20px 40px; text-align: center; border-top: 1px solid #e8edf3; }
  .footer p { font-size: 12px; color: #9aa8b8; }
</style>
</head>
<body>
<div class="wrapper">
  <div class="header"><h1>New Appointment Request</h1></div>
  <div class="gold-bar"></div>

  <div class="body">
    <div class="msg-box">
      <div class="row"><span>Patient</span><span>{{ $appointment->name }}</span></div>
      <div class="row"><span>Phone</span><span>{{ $appointment->phone }}</span></div>
      <div class="row"><span>Email</span><span>{{ $appointment->email ?: '—' }}</span></div>
      <div class="row"><span>Doctor</span><span>{{ $appointment->preferred_doctor }}</span></div>
      <div class="row"><span>Department</span><span>{{ $appointment->department ?: '—' }}</span></div>
      <div class="row"><span>Type</span><span>{{ $appointment->appointment_type === 'follow_up' ? 'Follow-up' : 'OPD' }}</span></div>
      <div class="row"><span>Date</span><span>{{ optional($appointment->appointment_date)->format('d M Y') }}</span></div>
      <div class="row"><span>Time</span><span>{{ $appointment->time_slot }}</span></div>
      <div class="row"><span>Serial</span><span>#{{ $appointment->serial_number }}</span></div>
      @if($appointment->symptoms)
      <div class="row"><span>Symptoms</span><span>{{ $appointment->symptoms }}</span></div>
      @endif
    </div>
    <p style="font-size:13px;color:#7a8aa0;">Review and confirm this appointment from the admin dashboard.</p>
  </div>

  <div class="footer"><p>{{ config('app.name') }} — Admin Notification</p></div>
</div>
</body>
</html>
