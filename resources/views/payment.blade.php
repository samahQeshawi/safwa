
<!DOCTYPE HTML>
<html>
  <head>
      <title>Payement Gateway test</title>
    <style>
        body { background-color:white; width:720px; margin:auto;padding:10px;font-size:14px;}
        h2 { margin-top:25px;margin-bottom:10px;padding:5px;width:100%;background-color:#eee;
        border:1px solid #ccc;border-radius:6px;font-size: 16px;font-weight:normal; }
    </style>
  </head>
  <body>

    <script src="{{ $resData['script_url'] }}"></script>


    <form action="{{ $resData['shopperResultUrl'] }}" class="paymentWidgets" data-brands="VISA MASTER MADA"></form>

  {{-- <h2><input type="radio" checked="checked" /> Checkout with stored payment details</h2>
	<table>
		<tr><td width="100px">Visa</td><td width="200px">xxxx-xxxx-xxxx-1234</td><td width="200px">Dec / 2018</td></tr>
	</table>
	<div><button type="submit" name="pay" class="myButton">Pay now</button></div><br /><br />
  <h2><input type="radio" /> Checkout with new payment method</h2>
    <form action="pay.html">
      MASTER VISA AMEX CHINAUNIONPAY
    </form> --}}
  </body>



</html>
