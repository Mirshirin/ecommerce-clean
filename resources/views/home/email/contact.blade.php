
<!DOCTYPE html>
<html lang="en" dir="ltr" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
<meta name="format-detection" content="telephone=no, date=no, address=no, email=no, url=no">
<meta name="x-apple-disable-message-reformatting">

<title>Contact Email</title>

<style>

html,
body {
margin: 0 auto !important;
padding: 0 !important;
height: 100% !important;
width: 100% !important;
}
div[style*="margin: 16px 0"] {
margin: 0 !important;
}

</style>

</head>
<body class="body" style="margin: 0 auto !important; padding: 0 !important;word-spacing:normal;background-color: #f2f2f2;">

<h1>You have received a contact email</h1>
<p>Please, {{ $details['message']}}</p>
<p><strong>Your Name :</strong> {{ $details['userName'] }}</p>
<p><strong>Your Phone Number :</strong> {{ $details['userPhone']}}</p>
<p><strong>Your Address:</strong> {{ $details['userAddress'] }}</p>

</body>
</html>
