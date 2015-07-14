<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="<?php $this->printTplDir(); ?>favicon.ico">
		<title>Security Intelligence Feed</title>
		
		<!-- Bootstrap core CSS -->
		<link href="<?php $this->printTplDir(); ?>css/bootstrap.min.css" rel="stylesheet">
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
			<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<link href="<?php $this->printTplDir(); ?>css/flag-icon.min.css" rel="stylesheet">
		<link href="<?php $this->printTplDir(); ?>css/style.css" rel="stylesheet">
		<script src="<?php $this->printTplDir(); ?>js/angular.js"></script>
		<script src="<?php $this->printTplDir(); ?>js/bootstrap.min.js"></script>
	</head>
<body>
    <nav class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/"><img src="<?php $this->printTplDir(); ?>images/logo_s.png" alt="Ecrime" width="135"></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
<?php $this->loadMainMenu(); ?>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
	<div class="container">
<?php $this->loadMainModule(); ?>
	</div>
</body>
</html>
