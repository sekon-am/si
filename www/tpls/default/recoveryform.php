		<div class="jumbotron" ng-app="recovery" ng-controller="RecCtrl" id='login-form'>
		<form class="form-signin container">
			<h3>Password reminder</h3>
			<div class="alert alert-success" role="alert" ng-if="success">{{success}}</div>
			<div class="alert alert-danger" role="alert" ng-if="error">{{error}}</div>
			<label for="inputLogin" class="sr-only">Login</label>
			<input type="text" id="inputLogin" class="form-control" placeholder="Login" autofocus ng-model="login">
			<span>or</span>
			<label for="inputPass" class="sr-only">Password</label>
			<input type="email" id="inputEmail" class="form-control" placeholder="Email" autofocus ng-model="email">
			<button class="btn btn-lg btn-primary" ng-click="dorecovery()">Recovery</button>
		</form>
		</div>
		<script src="<?php $this->printTplDir(); ?>js/recovery.js"></script>
