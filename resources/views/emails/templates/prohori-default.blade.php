<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Prohori</title>
    <style>
        @font-face {
            font-family: 'Myriad Pro';
            src: url('fonts/MyriadPro-Regular.eot');
            src: url('fonts/MyriadPro-Regular.eot?#iefix') format('embedded-opentype'), url('fonts/MyriadPro-Regular.woff') format('woff'), url('fonts/MyriadPro-Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body {
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            -webkit-text-size-adjust: 100% !important;
            -ms-text-size-adjust: 100% !important;
            -webkit-font-smoothing: antialiased !important;
        }
    </style>
</head>
<body style="padding-top: 0; padding-bottom: 0; padding-top: 0; padding-bottom: 0;  width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased;"
      offset="0" toppadding="0" leftpadding="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableContent bgBody" style='font-family:Helvetica, Arial,serif;   '>
    <tr>
        <td>
            <table width="800" border="0" cellspacing="0" cellpadding="0"style=" padding:20px;">
                <tr>
                    <td valign='top' class='movableContentContainer' style="padding-left:10px; padding-right:10px;">
                        <div class='movableContent'>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" style=" padding:20px 0;">
                                <tr>
                                    <td style="font-family:Arial, Helvetica, sans-serif; color:#000; line-height:23px; ">
                                        <h3 style="margin:0px 0 40px 0; padding:0px; font-weight:normal;  font-size:20px; line-height:normal">
                                            @section('email-content-header')
                                                {{-- head section --}}
                                            @show
                                        </h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        @section('email-content')
                                        @show
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top:40px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000; line-height:23px; text-decoration:none;  text-align:center;">
                                        <a href="http://www.euro-vigil.com.bd"
                                           style="text-decoration:none; display:inline-block; margin:0 5px"
                                           target="_blank"><img
                                                    src={{asset("prohori/images/logo-ev.png")}} alt="prohori"
                                                    height="24" style=" border:none"> </a>
                                        <a href="https://www.facebook.com/eurovigilpvtltd/"
                                           style="text-decoration:none; display:inline-block; margin:0 5px"
                                           target="_blank"><img
                                                    src={{asset("prohori/images/facebook.png")}} alt="Facebook"
                                                    height="24" style=" border:none"> </a>
                                        <a href="https://www.linkedin.com/company/eurovigilpvtltd/about/"
                                           style="text-decoration:none; display:inline-block; margin:0 5px"
                                           target="_blank"><img
                                                    src={{asset("prohori/images/linkdin.png")}} alt="Linkedin"
                                                    height="24" style=" border:none"> </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top:40px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000; line-height:23px; text-decoration:none;  text-align:center;">
                                        If you receive this email by mistake or in error, delete it or get in contact
                                        with us at
                                        <a style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000; text-decoration:none;">info@euro-vigil.com.bd</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table width="800" border="0" cellspacing="0" cellpadding="0"
                   style="background-color:#000;  ">
                <tr>
                    <td style="font-family: proxima_nova, 'Open Sans', 'Lucida Grande', 'Segoe UI', Arial, Verdana, 'Lucida Sans Unicode', Tahoma, 'Sans Serif'; font-size:13px; color:#ccc; line-height:normal; text-align:right; padding:10px 15px ">
                        © {{date('Y')}} Prohori
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
