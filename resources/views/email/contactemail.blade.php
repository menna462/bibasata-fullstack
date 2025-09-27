<!DOCTYPE html>
<html>
<head>
    <title>رسالة تواصل جديدة</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { width: 80%; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 8px; background-color: #f9f9f9; }
        h2 { color: #0056b3; }
        p { margin-bottom: 10px; }
        strong { color: #555; }
    </style>
</head>
<body>
    <div class="container">
        <h2>لقد استلمت رسالة جديدة من نموذج " ببساطه" الخاص بموقعك.</h2>
        <p><strong>الاسم:</strong> {{ $name }}</p>
        <p><strong>البريد الإلكتروني:</strong> {{ $email }}</p>
        <p><strong>رقم الهاتف:</strong> {{ $phone ?? 'غير متوفر' }}</p> {{-- لو حقل الهاتف اختياري --}}
        <p><strong>الرسالة:</strong></p>
        <p style="background-color: #e6f7ff; padding: 15px; border-left: 5px solid #007bff; border-radius: 4px;">
            {{ $userMessage }}
        </p>
        <p>تم إرسال هذه الرسالة من خلال موقعك الإلكتروني.</p>
    </div>
</body>
</html>
