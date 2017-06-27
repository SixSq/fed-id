<html>

<head>
	<title>SixSq Federated Identity Portal</title>
	<link rel="shortcut icon" href="welcome-content/favicon.ico" type="image/x-icon">
	<link rel="StyleSheet" href="welcome-content/welcome.css" type="text/css">
	<script type="text/javascript" src="welcome-content/welcome.js"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  <script>
          function DropDown(el) {
              this.dd = el;
              this.initEvents();
          }
          DropDown.prototype = {
              initEvents : function() {
                  var obj = this;

                  obj.dd.on('click', function(event){
                      $(this).toggleClass('active');
                      event.stopPropagation();
                  });
              }
          }

          $(function() {
                  var dd = new DropDown( $('#dd') );
                  $(document).click(function() {
                          // all dropdowns
                          $('.wrapper-dropdown').removeClass('active');
                  });
          });
  </script>
</head>

<body>
	<div class="wrapper">
		<div class="content">
			<div class="logo"></div>
			<h1>SixSq Federated Identity Portal - Console</h1>
			<div class="nav-wrapper">
				<a href="/samlbridge" class="button-smaller">SSP SAMLbridge</a>
				<a href="/auth/admin" class="button">Master Realm</a>
				<a href="http://sixsq.com/" class="link-text medium">SixSq website</a>
				<a href="http://sixsq.com/legal/aai_privacy" class="link-text small">Privacy Policy</a>
			</div>
		</div>
	</div>
</body>

</html>
