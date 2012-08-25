<php
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    
include "php_serial.class.php";

// Let's start the class
$serial = new phpSerial();

// First we must specify the device. This works on both linux and windows (if
// your linux serial device is /dev/ttyS0 for COM1, etc)
$serial->deviceSet("/dev/ttyACM0");

// We can change the baud rate, parity, length, stop bits, flow control
$serial->confBaudRate(9600);
// Then we need to open it
$serial->deviceOpen();
if(isset($_POST['temp']) && $temp=intval($_POST['temp']))
{

    if($temp>59 && $temp<91)
    {
        $serial->sendMessage(chr($temp));
        $serial->deviceClose();
        die("Sent temp $temp");
    }
    else die("Invalid temp $temp");
    
}
// To write into
if(!isset($_POST['code']) || !is_int(intval($_POST['code'])))
    die('Invalid Code');

$code=intval($_POST['code']);
if(!$code) die('0 code');
$serial->sendMessage($code);
$serial->deviceClose();
die("Sent: ".$code);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Home Automation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="/static/assets/css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="/static/assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"/static/script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="/static/assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/static/assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/static/assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/static/assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="/static/assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"/static/span>
            <span class="icon-bar"/static/span>
            <span class="icon-bar"/static/span>
          </a>
          <a class="brand" href="#">Project name</a>
          <div class="nav-collapse">
            <ul class="nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="#contact">Contact</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">

      <h1>Home Automation</h1>
    <h2>LG Upstairs</h2>
    <p><button class="btn btn-danger" href="#" id="lg-power">Cycle Power</button></p>
    <p> Temperature
  <div class="btn-group" style="margin: 9px 0;">
          <button class="btn" id="lg-up">+</button>
          <button class="btn" id="lg-down">-</button>
        </div> </p>
    <h2>Kenmore Downstairs</h2>
    <p><button class="btn btn-danger" href="#" id="kenmore-power">Cycle Power</button></p>
    <p> Temperature
  <div class="btn-group" style="margin: 9px 0;">
          <button class="btn" id="kenmore-up">+</button>
          <button class="btn" id="kenmore-down">-</button>
</div>
Set Temperature to:
<div class="input-append">
                <input class="span1" id="temp" size="16" type="number" value="60">
    <button class="btn" type="button" id="tempgo">Go!</button>
              </div>
 </p>


    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/static/assets/js/jquery.js"></script>
    <script src="/static/assets/js/bootstrap-transition.js"></script>
    <script src="/static/assets/js/bootstrap-alert.js"></script>
    <script src="/static/assets/js/bootstrap-modal.js"></script>
    <script src="/static/assets/js/bootstrap-dropdown.js"></script>
    <script src="/static/assets/js/bootstrap-scrollspy.js"></script>
    <script src="/static/assets/js/bootstrap-tab.js"></script>
    <script src="/static/assets/js/bootstrap-tooltip.js"></script>
    <script src="/static/assets/js/bootstrap-popover.js"></script>
    <script src="/static/assets/js/bootstrap-button.js"></script>
    <script src="/static/assets/js/bootstrap-collapse.js"></script>
    <script src="/static/assets/js/bootstrap-carousel.js"></script>
    <script src="/static/assets/js/bootstrap-typeahead.js"></script>
    <script>
        var codes = 
        {
            "lg-power":"1",
            "lg-up":"2",
            "lg-down":"3",
            "kenmore-power":"4",
            "kenmore-up":"5",
            "kenmore-down":"6",
            "tempgo":"tempgo",
        }
jQuery(function() {
    jQuery(".btn").click(function()
    {
        var code=codes[jQuery(this).attr('id')];
        if(code=="tempgo")
        {
            var temp=jQuery("#temp").val();
            jQuery.post("", { temp: temp }, function(data) 
            {
                var log='Message Sent:'+code+' Return:'+data;
                console.log(log);
            });    
            
            return;
        }
        jQuery.post("", { code : code }, function(data) 
        {
            var log='Message Sent:'+code+' Return:'+data;
            console.log(log);
            
        });
    });
});
    </script>
  </body>
</html>

