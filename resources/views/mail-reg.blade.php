<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
</head>
<body style="padding: 0; margin: 0; font-size: 12px; font-family: Arial, Verdana, sans-serif;color: #1E1E1E;">
<table style="border: none; background: #fff; max-width: 500px;">
    <thead>
        <tr>
            <th style="padding: 30px 20px 0 20px;">
                <div>
                    <img src="https://carcity.kz/_nuxt/img/carcity-logo.f866f66.png">
                </div>
                <h2>{{ $title }}</h2>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="padding: 5px 20px 10px 20px;">Здравствуйте, <b>{{ $name }}</b>!</td>
        </tr>
        <tr>
            <td style="padding: 10px 20px 10px 20px;">{!! $text !!}</td>
        </tr>
        <tr>
            <td style="padding: 20px; padding-top: 5px;">С уважением, CarCity.kz</td>
        </tr>
    </tbody>
</table>
</body>
</html>
