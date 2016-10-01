<?php

class Mail{

	public static function send($email,$subject,$message){

		$header  = 'MIME-Version: 1.0' . "\r\n";
		
		$header .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
		
		$header .= "To: $email" . "\r\n"; 

		$header .= "From: ". Config::get('site/name') . "\r\n";

		if (mail($email, $subject, $message, $header)) {

			return true;
		
		} else {
			
			return false;
		
		}	
	
	} 
	
	public static function sendActivation($email, $activationCode, $name){
	
	$message = '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">

<head style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
  <meta name="viewport" content="width=device-width, initial-scale=1" style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
  <title style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">Kademiks - Activate Account</title>

  <style type="text/css" style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
    /* Take care of image borders and formatting, client hacks */
    img { max-width: 600px; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic;}
    a img { border: none; }
    table { border-collapse: collapse !important;}
    #outlook a { padding:0; }
    .ReadMsgBody { width: 100%; }
    .ExternalClass { width: 100%; }
    .backgroundTable { margin: 0 auto; padding: 0; width: 100% !important; }
    table td { border-collapse: collapse; }
    .ExternalClass * { line-height: 115%; }
    .container-for-gmail-android { min-width: 600px; }


    /* General styling */
    * {
      font-family: Helvetica, Arial, sans-serif;
    }

    body {
      -webkit-font-smoothing: antialiased;
      -webkit-text-size-adjust: none;
      width: 100% !important;
      margin: 0 !important;
      height: 100%;
      color: #676767;
    }

    td {
      font-family: Helvetica, Arial, sans-serif;
      font-size: 14px;
      color: #777777;
      text-align: center;
      line-height: 21px;
    }

    a {
      color: #676767;
      text-decoration: none !important;
    }

    .pull-left {
      text-align: left;
    }

    .pull-right {
      text-align: right;
    }

    .header-lg,
    .header-md,
    .header-sm {
      font-size: 32px;
      font-weight: 600;
      line-height: normal;
      padding: 35px 0 0;
      color: #4d4d4d;
    }

    .header-md {
      font-size: 24px;
    }

    .header-sm {
      padding: 5px 0;
      font-size: 18px;
      line-height: 1.3;
    }

    .content-padding {
      padding: 20px 0 30px;
    }

    .mobile-header-padding-right {
      width: 290px;
      text-align: right;
      padding-left: 10px;
    }

    .mobile-header-padding-left {
      width: 290px;
      text-align: left;
      padding-left: 10px;
      padding-bottom: 8px;
    }

    .free-text {
      width: 100% !important;
      padding: 10px 60px 0px;
    }

    .block-rounded {
      border-radius: 5px;
      border: 1px solid #e5e5e5;
      vertical-align: top;
    }

    .button {
      padding: 30px 0;
    }

    .info-block {
      padding: 0 20px;
      width: 260px;
    }

    .block-rounded {
      width: 260px;
    }

    .info-img {
      width: 258px;
      border-radius: 5px 5px 0 0;
    }

    .force-width-gmail {
      min-width:600px;
      height: 0px !important;
      line-height: 1px !important;
      font-size: 1px !important;
    }

    .button-width {
      width: 228px;
    }

  </style>

  <style type="text/css" media="screen" style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
    @import url(http://fonts.googleapis.com/css?family=Oxygen:400,700);
  </style>
	
   <style type="text/css" media="screen" style="font-family: \'Comfortaa\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
    @import url(https://fonts.googleapis.com/css?family=Comfortaa:400,700);
  </style>
	
  <style type="text/css" media="screen" style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
    @media screen {
      /* Thanks Outlook 2013! http://goo.gl/XLxpyl */
      * {
        font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;
      }
    }
  </style>

  <style type="text/css" media="only screen and (max-width: 480px)" style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
    /* Mobile styles */
    @media only screen and (max-width: 480px) {

      table[class*="container-for-gmail-android"] {
        min-width: 290px !important;
        width: 100% !important;
      }

      table[class="w320"] {
        width: 320px !important;
      }

      img[class="force-width-gmail"] {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
      }

      a[class="button-width"],
      a[class="button-mobile"] {
        width: 248px !important;
      }

      td[class*="mobile-header-padding-left"] {
        width: 160px !important;
        padding-left: 0 !important;
      }

      td[class*="mobile-header-padding-right"] {
        width: 160px !important;
        padding-right: 0 !important;
      }

      td[class="header-lg"] {
        font-size: 24px !important;
        padding-bottom: 5px !important;
      }

      td[class="header-md"] {
        font-size: 18px !important;
        padding-bottom: 5px !important;
      }

      td[class="content-padding"] {
        padding: 5px 0 30px !important;
      }

       td[class="button"] {
        padding: 5px !important;
      }

      td[class*="free-text"] {
        padding: 10px 18px 30px !important;
      }

      td[class="info-block"] {
        display: block !important;
        width: 280px !important;
        padding-bottom: 40px !important;
      }

      td[class="info-img"],
      img[class="info-img"] {
        width: 278px !important;
      }
    }
  </style>
</head>

<body bgcolor="#f7f7f7" style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;-webkit-font-smoothing: antialiased;-webkit-text-size-adjust: none;height: 100%;color: #676767;width: 100% !important;margin: 0 !important;">
<table align="center" cellpadding="0" cellspacing="0" class="container-for-gmail-android" width="100%" style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;min-width: 600px;border-collapse: collapse !important;">
  <tr style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
    <td align="left" valign="top" width="100%" style="background: #4a89dc;font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;font-size: 14px;color: #777777;text-align: center;line-height: 21px;border-collapse: collapse;">
      <center style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
        <table cellspacing="0" cellpadding="0" width="100%" bgcolor="#4a89dc"  style="background-color: transparent;font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;border-collapse: collapse !important;">
          <tr style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
            <td width="100%" height="80" valign="top" style="text-align: center;vertical-align: middle;font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;font-size: 14px;color: #777777;line-height: 21px;border-collapse: collapse;">
              <center style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
                <table cellpadding="0" cellspacing="0" width="600" class="w320" style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;border-collapse: collapse !important;">
                  <tr style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
                    <td class="pull-left mobile-header-padding-left" style="vertical-align: middle;font-size: 20px;color: #ffffff;font-family: \'Comfortaa\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;text-align: left;line-height: 21px;border-collapse: collapse;width: 290px;padding-left: 10px;padding-bottom: 8px;">
                      Kademiks
                    </td>
                   
                  </tr>
                </table>
              </center>
            </td>
          </tr>
        </table>
      </center>
    </td>
  </tr>
  <tr style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
    <td align="center" valign="top" width="100%" style="background-color: #f7f7f7;font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;font-size: 14px;color: #777777;text-align: center;line-height: 21px;border-collapse: collapse;padding: 20px 0 30px;" class="content-padding">
      <center style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
        <table cellspacing="0" cellpadding="0" width="600" class="w320" style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;border-collapse: collapse !important;">
          <tr style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
            <td class="header-lg" style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;font-size: 32px;color: #4d4d4d;text-align: center;line-height: normal;border-collapse: collapse;font-weight: 600;padding: 35px 0 0;">
              Welcome to Kademiks
            </td>
          </tr>
          <tr style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
            <td class="free-text" style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;font-size: 14px;color: #777777;text-align: center;line-height: 21px;border-collapse: collapse;padding: 10px 60px 0px;width: 100% !important;">
              Hi ' . $name. ', Thank you for signing up for Kademiks!. Please activate your account by clicking on the button below.
           
		
		<br style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
		
		   </td>
          </tr>
          <tr style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
            <td class="button" style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;font-size: 14px;color: #777777;text-align: center;line-height: 21px;border-collapse: collapse;padding: 30px 0;">
              <div style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;"><!--[if mso]>
                <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="http://" style="height:45px;v-text-anchor:middle;width:155px;" arcsize="15%" strokecolor="#ffffff" fillcolor="#4a89dc">
                  <w:anchorlock/>
                  <center style="color:#ffffff;font-family:Helvetica, Arial, sans-serif;font-size:14px;font-weight:regular;">My Account</center>
                </v:roundrect>
              <![endif]--><a class="button-mobile" href="' . Route::to('auth/activate/' . $activationCode ) . '" style="background-color:#4a89dc;border-radius:5px;color:#ffffff;display:inline-block;font-family:\'Cabin\', Helvetica, Arial, sans-serif;font-size:14px;font-weight:regular;line-height:45px;text-align:center;text-decoration:none;width:155px;-webkit-text-size-adjust:none;mso-hide:all;">Activate Account</a></div>
            </td>
          </tr>
        </table>
      </center>
    </td>
  </tr>
    <tr style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
    <td align="center" valign="top" width="100%" style="background-color: #f7f7f7;height: 100px;font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;font-size: 14px;color: #777777;text-align: center;line-height: 21px;border-collapse: collapse;">
      <center style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
        <table cellspacing="0" cellpadding="0" width="600" class="w320" style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;border-collapse: collapse !important;">
          <tr style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
            <td style="padding: 25px 0 25px;font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;font-size: 14px;color: #777777;text-align: center;line-height: 21px;border-collapse: collapse;">
              <strong style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">Copyright &copy;  ' . date('Y') . ' ' .Config::get('site/name') . ' <br />(Kademiks Currently in Beta Meaning Bugs May Appear So We Will Like You To Report Them In The Contact Admin Menu. All Reports Are Highly Appreciated)</strong><br />
          
            </td>
          </tr>
        </table>
      </center>
    </td>
  </tr>
 </table>
 
 <body>
</html>
	';
			
		self::send($email, Config::get('site/name'). " Account Activation ",$message);
			
	}
	
	public static function sendChangePassword($email, $newPassword, $name){
		
		$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">

<head style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
  <meta name="viewport" content="width=device-width, initial-scale=1" style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
  <title style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">Kademiks - Activate Account</title>

  <style type="text/css" style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
    /* Take care of image borders and formatting, client hacks */
    img { max-width: 600px; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic;}
    a img { border: none; }
    table { border-collapse: collapse !important;}
    #outlook a { padding:0; }
    .ReadMsgBody { width: 100%; }
    .ExternalClass { width: 100%; }
    .backgroundTable { margin: 0 auto; padding: 0; width: 100% !important; }
    table td { border-collapse: collapse; }
    .ExternalClass * { line-height: 115%; }
    .container-for-gmail-android { min-width: 600px; }


    /* General styling */
    * {
      font-family: Helvetica, Arial, sans-serif;
    }

    body {
      -webkit-font-smoothing: antialiased;
      -webkit-text-size-adjust: none;
      width: 100% !important;
      margin: 0 !important;
      height: 100%;
      color: #676767;
    }

    td {
      font-family: Helvetica, Arial, sans-serif;
      font-size: 14px;
      color: #777777;
      text-align: center;
      line-height: 21px;
    }

    a {
      color: #676767;
      text-decoration: none !important;
    }

    .pull-left {
      text-align: left;
    }

    .pull-right {
      text-align: right;
    }

    .header-lg,
    .header-md,
    .header-sm {
      font-size: 32px;
      font-weight: 600;
      line-height: normal;
      padding: 35px 0 0;
      color: #4d4d4d;
    }

    .header-md {
      font-size: 24px;
    }

    .header-sm {
      padding: 5px 0;
      font-size: 18px;
      line-height: 1.3;
    }

    .content-padding {
      padding: 20px 0 30px;
    }

    .mobile-header-padding-right {
      width: 290px;
      text-align: right;
      padding-left: 10px;
    }

    .mobile-header-padding-left {
      width: 290px;
      text-align: left;
      padding-left: 10px;
      padding-bottom: 8px;
    }

    .free-text {
      width: 100% !important;
      padding: 10px 60px 0px;
    }

    .block-rounded {
      border-radius: 5px;
      border: 1px solid #e5e5e5;
      vertical-align: top;
    }

    .button {
      padding: 30px 0;
    }

    .info-block {
      padding: 0 20px;
      width: 260px;
    }

    .block-rounded {
      width: 260px;
    }

    .info-img {
      width: 258px;
      border-radius: 5px 5px 0 0;
    }

    .force-width-gmail {
      min-width:600px;
      height: 0px !important;
      line-height: 1px !important;
      font-size: 1px !important;
    }

    .button-width {
      width: 228px;
    }

  </style>

  <style type="text/css" media="screen" style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
    @import url(http://fonts.googleapis.com/css?family=Oxygen:400,700);
  </style>

	
  <style type="text/css" media="screen" style="font-family: \'Comfortaa\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
    @import url(https://fonts.googleapis.com/css?family=Comfortaa:400,700);
  </style>

  
  <style type="text/css" media="screen" style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
    @media screen {
      /* Thanks Outlook 2013! http://goo.gl/XLxpyl */
      * {
        font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;
      }
    }
  </style>

  <style type="text/css" media="only screen and (max-width: 480px)" style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
    /* Mobile styles */
    @media only screen and (max-width: 480px) {

      table[class*="container-for-gmail-android"] {
        min-width: 290px !important;
        width: 100% !important;
      }

      table[class="w320"] {
        width: 320px !important;
      }

      img[class="force-width-gmail"] {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
      }

      a[class="button-width"],
      a[class="button-mobile"] {
        width: 248px !important;
      }

      td[class*="mobile-header-padding-left"] {
        width: 160px !important;
        padding-left: 0 !important;
      }

      td[class*="mobile-header-padding-right"] {
        width: 160px !important;
        padding-right: 0 !important;
      }

      td[class="header-lg"] {
        font-size: 24px !important;
        padding-bottom: 5px !important;
      }

      td[class="header-md"] {
        font-size: 18px !important;
        padding-bottom: 5px !important;
      }

      td[class="content-padding"] {
        padding: 5px 0 30px !important;
      }

       td[class="button"] {
        padding: 5px !important;
      }

      td[class*="free-text"] {
        padding: 10px 18px 30px !important;
      }

      td[class="info-block"] {
        display: block !important;
        width: 280px !important;
        padding-bottom: 40px !important;
      }

      td[class="info-img"],
      img[class="info-img"] {
        width: 278px !important;
      }
    }
  </style>
</head>

<body bgcolor="#f7f7f7" style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;-webkit-font-smoothing: antialiased;-webkit-text-size-adjust: none;height: 100%;color: #676767;width: 100% !important;margin: 0 !important;">
<table align="center" cellpadding="0" cellspacing="0" class="container-for-gmail-android" width="100%" style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;min-width: 600px;border-collapse: collapse !important;">
  <tr style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
    <td align="left" valign="top" width="100%" style="background: #4a89dc;font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;font-size: 14px;color: #777777;text-align: center;line-height: 21px;border-collapse: collapse;">
      <center style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
        <table cellspacing="0" cellpadding="0" width="100%" bgcolor="#4a89dc" style="background-color: transparent;font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;border-collapse: collapse !important;">
          <tr style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
            <td width="100%" height="80" valign="top" style="text-align: center;vertical-align: middle;font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;font-size: 14px;color: #777777;line-height: 21px;border-collapse: collapse;">
              <center style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
                <table cellpadding="0" cellspacing="0" width="600" class="w320" style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;border-collapse: collapse !important;">
                  <tr style="font-family: \'Comfortaa\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
                    <td class="pull-left mobile-header-padding-left" style="vertical-align: middle;font-size: 20px;color: #ffffff;font-family: \'Comfortaa\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;text-align: left;line-height: 21px;border-collapse: collapse;width: 290px;padding-left: 10px;padding-bottom: 8px;">
                      Kademiks
                    </td>
                   
                  </tr>
                </table>
              </center>
            </td>
          </tr>
        </table>
      </center>
    </td>
  </tr>
  <tr style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
    <td align="center" valign="top" width="100%" style="background-color: #f7f7f7;font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;font-size: 14px;color: #777777;text-align: center;line-height: 21px;border-collapse: collapse;padding: 20px 0 30px;" class="content-padding">
      <center style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
        <table cellspacing="0" cellpadding="0" width="600" class="w320" style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;border-collapse: collapse !important;">
          <tr style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
            <td class="header-lg" style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;font-size: 32px;color: #4d4d4d;text-align: center;line-height: normal;border-collapse: collapse;font-weight: 600;padding: 35px 0 0;">
               Password Recovery
            </td>
          </tr>
          <tr style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
            <td class="free-text" style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;font-size: 14px;color: #777777;text-align: center;line-height: 21px;border-collapse: collapse;padding: 10px 60px 0px;width: 100% !important;">
              Hi ' . $name . ', You requested for a new password. <br /> You new password is.
           
	
		
		<br style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
		
		   </td>
          </tr>
          <tr style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
            <td class="button" style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;font-size: 14px;color: #777777;text-align: center;line-height: 21px;border-collapse: collapse;padding: 30px 0;">
              <div style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;"><!--[if mso]>
                <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="http://" style="height:45px;v-text-anchor:middle;width:155px;" arcsize="15%" strokecolor="#ffffff" fillcolor="#4a89dc">
                  <w:anchorlock/>
                  <center style="color:#ffffff;font-family:Helvetica, Arial, sans-serif;font-size:14px;font-weight:regular;">My Account</center>
                </v:roundrect>
              <![endif]--><a class="button-mobile" href="javscript:void(0);" style="background-color:#4a89dc;border-radius:5px;color:#ffffff;display:inline-block;font-family:\'Cabin\', Helvetica, Arial, sans-serif;font-size:14px;font-weight:regular;line-height:45px;text-align:center;text-decoration:none;width:155px;-webkit-text-size-adjust:none;mso-hide:all;"> ' . $newPassword . '</a></div>
            </td>
          </tr>
        </table>
      </center>
    </td>
  </tr>
    <tr style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
    <td align="center" valign="top" width="100%" style="background-color: #f7f7f7;height: 100px;font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;font-size: 14px;color: #777777;text-align: center;line-height: 21px;border-collapse: collapse;">
      <center style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
        <table cellspacing="0" cellpadding="0" width="600" class="w320" style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;border-collapse: collapse !important;">
          <tr style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">
            <td style="padding: 25px 0 25px;font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;font-size: 14px;color: #777777;text-align: center;line-height: 21px;border-collapse: collapse;">
              <strong style="font-family: \'Oxygen\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;">Copyright &copy; ' . date('Y') . ' Kademiks</strong><br />
          
            </td>
          </tr>
        </table>
      </center>
    </td>
  </tr>
 </table>
 
 <body>
</html>';
		self::send($email, Config::get('site/name'). " Password Recovery ",$message);
		
	}

}

?>