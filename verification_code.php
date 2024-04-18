<html>
  <head>
    <meta X-Content-Security-Policy: script-src 'self' https://www.google.com>
    <title>reCAPTCHA test</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  </head>
  <body>
    <form action="verification_code_check.php" method="POST">

    <h1>Please type in your email: </h1>
    <br><input name = 'email' type = 'text' /></br>
    <br><div class="g-recaptcha" data-sitekey="6LeIJjojAAAAAMzlQzmCEs7GcoVkeQGHFjQrV47N"></div>
    <br/>
    <input type="submit" name ="submit" value="Submit">
    </form>
  </body>
</html>