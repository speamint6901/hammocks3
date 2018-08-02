{{-- resources/views/emails/master.blade.php --}}

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta name="viewport" content="width=device-width" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>HTMLメールサンプル</title>
  <link rel="stylesheet" type="text/css" href="{{ asset('css/email.css') }}" />
  @include('emails.partial.css')
 </head>

 <body bgcolor="#EEEEEE">

  @include('emails.partial.header')

  <!-- BODY -->
  <table class="body-wrap">
   <td></td>
   <td class="container">

    <div class="content">
     @section('content')
     @show
    </div>

   </td>
   <td></td>
  </table><!-- /BODY -->


  @section('addcontents')
  @show

  @include('emails.partial.note')

  @include('emails.partial.footer')

 </body>
</html>
