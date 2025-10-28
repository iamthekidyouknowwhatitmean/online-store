<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    /* Минимально: инлайн-стили предпочтительнее в production, но базовые стили тут для удобства */
    body { margin:0; padding:0; background:#f4f6f8; font-family: Arial, sans-serif; -webkit-text-size-adjust:100%; }
    .email-wrapper { width:100%; background:#f4f6f8; padding:20px 0; }
    .email-content { width:100%; max-width:600px; margin:0 auto; background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.06); }
    .header { background: linear-gradient(90deg,#4b6cb7,#182848); color:#ffffff; padding:24px; text-align:center; }
    .preheader { display:none !important; visibility:hidden; opacity:0; height:0; width:0; overflow:hidden; font-size:1px; line-height:1px; color:#fff; }
    .body { padding:28px; color:#333333; line-height:1.5; }
    .greeting { font-size:20px; font-weight:600; margin-bottom:8px; }
    .lead { font-size:16px; margin-bottom:18px; color:#555555; }
    .btn { display:inline-block; padding:12px 20px; border-radius:6px; text-decoration:none; font-weight:600; }
    .btn-primary { background:#1a73e8; color:#ffffff; }
    .small { font-size:13px; color:#888888; }
    .footer { padding:20px; text-align:center; font-size:13px; color:#999999; }
    @media only screen and (max-width:480px){
      .body { padding:18px; }
      .header { padding:18px; }
    }
  </style>
</head>
<body>
  <!-- Preheader: короткий текст, который виден в превью письма у многих почтовых клиентов -->
  <div class="preheader">Спасибо за регистрацию на Tactical Pro — добро пожаловать!</div>

  <table class="email-wrapper" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
      <td align="center">
        <table class="email-content" cellpadding="0" cellspacing="0" role="presentation">
          <!-- Header -->
          <tr>
            <td class="header">
              <h1 style="margin:0; font-size:22px;">Добро пожаловать в Tactical Pro 👋</h1>
            </td>
          </tr>

          <!-- Body -->
          <tr>
            <td class="body">
              <p class="greeting">Привет, {{$name}}!</p>

              <p class="lead">
                Спасибо, что зарегистрировались на <strong>Tactical Pro</strong>. Ваш аккаунт успешно создан — рады видеть вас в нашем сообществе.
              </p>

              <p>
                Чтобы войти в свою учётную запись и начать, нажмите кнопку ниже:
              </p>

              <p style="text-align:center; margin:22px 0;">
                <a href="https://gentle-apples-jam.loca.lt/login" class="btn btn-primary" target="_blank" rel="noopener">Войти в аккаунт</a>
              </p>

              <p class="small">
                Если кнопка не работает, скопируйте и вставьте в браузер ссылку: <br>
                <a href="https://gentle-apples-jam.loca.lt/login" target="_blank" rel="noopener" style="color:#1a73e8;">https://gentle-apples-jam.loca.lt/login</a>
              </p>

              <hr style="border:none; border-top:1px solid #eeeeee; margin:22px 0;">

              <p style="margin-top:12px;" class="small">
                Это автоматическое сообщение — не отвечайте на него.
              </p>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td class="footer">
              <div>© <span id="year">2025</span> Tactical Pro. Все права защищены.</div>
              <div style="margin-top:8px;">Если вы не регистрировались на Tactical Pro, проигнорируйте это письмо или свяжитесь с поддержкой.</div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>

  <script>
    // Подставляем текущий год (работает в клиентах, где разрешён JS; не критично)
    (function(){ try{ var y = new Date().getFullYear(); document.getElementById('year').textContent = y; }catch(e){} })();
  </script>
</body>
</html>
