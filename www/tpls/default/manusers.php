		<div class="jumbotron" ng-app="manusers" ng-controller="ManusersCtrl">
			<h1>Users</h1>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>Login</th>
						<th>Email</th>
						<th>Hash</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="user in users">
						<th scope="row">{{$index+1}}</th>
						<td>{{user.login}}</td>
						<td>{{user.email}}</td>
						<td>{{user.hash}}</td>
						<td><span class="glyphicon glyphicon-remove" ng-click="deluser(user.id,user.login,$index)"></span></td>
					</tr>
				</tbody>
			</table>
			<h2>New user</h2>
			<div class="alert alert-danger" role="alert" ng-if="adderror">{{adderror}}</div>
			<form class="form-inline">
				<div class="form-group">
					<label class="sr-only" for="user-login"></label>
					<input type="text" class="form-control" id="user-login" placeholder="Login" ng-model="login">
				</div>
				<div class="form-group">
					<label class="sr-only" for="user-email"></label>
					<input type="email" class="form-control" id="user-email" placeholder="Email" ng-model="email">
				</div>
				<div class="form-group">
					<label class="sr-only" for="user-pass"></label>
					<input type="password" class="form-control" id="user-pass" placeholder="Password" ng-model="pass">
				</div>
				<div class="form-group">
					<label class="sr-only" for="user-repass"></label>
					<input type="password" class="form-control" id="user-repass" placeholder="Re-password" ng-model="repass">
				</div>
				<button class="btn btn-default" ng-click="adduser()">Add</button>
			</form>
			<script src="<?php $this->printTplDir(); ?>js/manusers.js"></script>
		</div>