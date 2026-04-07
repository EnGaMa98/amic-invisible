<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; color: #333; }
        .header { text-align: center; padding: 20px 0; }
        .header h1 { color: #c0392b; margin: 0; }
        .content { background: #f9f9f9; border-radius: 8px; padding: 24px; margin: 20px 0; }
        .receiver-name { font-size: 24px; font-weight: bold; color: #c0392b; text-transform: uppercase; text-decoration: underline; }
        .budget { background: #27ae60; color: white; display: inline-block; padding: 8px 16px; border-radius: 4px; font-weight: bold; }
        .footer { text-align: center; padding: 20px 0; color: #888; font-size: 14px; }
        .gif { text-align: center; margin: 20px 0; }
        .gif img { max-width: 300px; border-radius: 8px; }
        .cta { text-align: center; margin: 24px 0; }
        .cta a { display: inline-block; background: #c0392b; color: white; text-decoration: none; padding: 14px 32px; border-radius: 8px; font-size: 16px; font-weight: bold; }
        .preferences { margin: 16px 0; padding: 16px; background: #fff; border-left: 4px solid #27ae60; border-radius: 4px; }
        .preferences-label { font-weight: bold; color: #27ae60; margin-bottom: 4px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎁 Amic Invisible</h1>
        <p>{{ $group->name }}</p>
    </div>

    <div class="content">
        <p>Hola <strong>{{ $giver->name }}</strong>!</p>

        <p>T'ha tocat fer-li un regal a:</p>

        <p class="receiver-name">{{ $receiver->name }}</p>

        @if($receiver->preferences)
            <div class="preferences">
                <p class="preferences-label">🎯 Preferències de {{ $receiver->name }}:</p>
                <p>{!! nl2br(e($receiver->preferences)) !!}</p>
            </div>
        @endif

        @if($group->email_body)
            <div style="margin: 16px 0; padding: 16px; background: #fff; border-left: 4px solid #c0392b; border-radius: 4px;">
                {!! nl2br(e($group->email_body)) !!}
            </div>
        @endif

        @if($group->budget)
            <p>Pressupost: <span class="budget">{{ number_format($group->budget, 2) }} €</span></p>
        @endif

        @if($group->event_date)
            <p>📅 Data de l'event: <strong>{{ $group->event_date->format('d/m/Y') }}</strong></p>
        @endif
    </div>

    <div class="cta">
        <a href="{{ $publicUrl }}">Veure la teva assignació</a>
        <p style="color: #888; font-size: 13px; margin-top: 8px;">Des d'aquest enllaç podràs veure el teu amic invisible i escriure les teves preferències de regal.</p>
    </div>

    <div class="gif">
        <img src="https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExM3RqOXRnaXgzdWp5aTliaTl1bnVjODZvMm5lbTY3MWk0eDc2aXRoaCZlcD12MV9naWZzX3NlYXJjaCZjdD1n/WxTG12gbrdiHb0H1Jo/giphy.gif" alt="Happy Holidays GIF" />
    </div>

    <div class="footer">
        <p><strong><em>BON NADAL! 🎄</em></strong></p>
    </div>
</body>
</html>
