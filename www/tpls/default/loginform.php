		<div class="jumbotron" ng-app="log_in" ng-controller="LoginCtrl" id='login-form'>
		<form class="form-signin container">
			<h3>Authorize please</h3>
			<div class="bg-danger">{{error}}</div>
			<label for="inputLogin" class="sr-only">Login</label>
			<input type="text" id="inputLogin" class="form-control" placeholder="Login" required autofocus ng-model="login">
			<label for="inputPass" class="sr-only">Password</label>
			<input type="password" id="inputPass" class="form-control" placeholder="Password" required autofocus ng-model="pass">
<?php if(!($this->isadmin)):?>
			<a href="?ctrl=auth&action=recoveryform">Forgot password?</a>
<?php endif; ?>
			<button class="btn btn-lg btn-primary" ng-click="dologin()">Enter</button>
		</form>
		</div>
		<script src="<?php $this->printTplDir(); ?>js/<?php echo $this->loginJs; ?>.js"></script>
