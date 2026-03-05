<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin: 0; padding: 0; background-color: #fef2f2; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="padding: 40px 20px;">
        <tr>
            <td align="center">
                <table width="500" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #dc2626, #991b1b); padding: 30px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px;">🎄 Amic Invisible</h1>
                            <p style="color: #fee2e2; margin: 8px 0 0; font-size: 14px;">Codi de verificació</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="color: #374151; font-size: 16px; margin: 0 0 20px;">
                                Hola <strong>{{ $user->name }}</strong>! 👋
                            </p>
                            <p style="color: #6b7280; font-size: 14px; margin: 0 0 30px;">
                                Has sol·licitat un codi per accedir a Amic Invisible. Utilitza el següent codi:
                            </p>

                            <!-- OTP Code -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="padding: 20px 0;">
                                        <div style="background-color: #fef3c7; border: 2px dashed #d97706; border-radius: 12px; padding: 20px 40px; display: inline-block;">
                                            <span style="font-size: 36px; font-weight: bold; letter-spacing: 8px; color: #92400e;">{{ $code }}</span>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <p style="color: #9ca3af; font-size: 13px; margin: 30px 0 0; text-align: center;">
                                ⏰ Aquest codi expira en 10 minuts.
                            </p>
                            <p style="color: #9ca3af; font-size: 13px; margin: 8px 0 0; text-align: center;">
                                Si no has sol·licitat aquest codi, ignora aquest correu.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #ecfdf5; padding: 20px; text-align: center;">
                            <p style="color: #059669; font-size: 13px; margin: 0;">
                                🎁 Amic Invisible — Feliç sorteig!
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
