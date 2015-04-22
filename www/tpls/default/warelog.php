		<div class="jumbotron" ng-app="warelog" ng-controller="DataCtrl">
			<h1>Security Intelligence Feed</h1>
			<form class="form-inline">
				<div class="form-group">
					<label class="sr-only" for="ip_filter">IP address</label>
					<input type="text" class="form-control" id="ip_filter" ng-model="ip_filter" placeholder="Enter IP">
				</div>
				<div class="form-group">
					<label class="sr-only" for="domain_filter">Domain name</label>
					<input type="text" class="form-control" id="domain_filter" ng-model="domain_filter" placeholder="Enter Domain Name">
				</div>
				<div class="form-group">
					<label class="sr-only" for="malware_filter">Malware</label>
					<input type="text" class="form-control" id="malware_filter" ng-model="malware_filter" placeholder="Enter Malware">
				</div>
				<button type="button" class="btn btn-primary" ng-click="loadpages()">Search</button>
				<div class="form-group">
				<div class="export-format-btn export-format-txt" ng-click="doexport('txt')"></div>
				<div class="export-format-btn export-format-json" ng-click="doexport('json')"></div>
				<div class="export-format-btn export-format-xml" ng-click="doexport('xml')"></div>
				</div>
			</form>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>IP</th>
						<th>Domain</th>
						<th>Country</th>
						<th>Data&amp;Time</th>
						<th>Malware</th>
						<th>Destination IP</th>
						<th>Port</th>
						<th>C&amp;C</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="fields in fieldset">
						<th scope="row">{{fields.num}}</th>
						<td>{{fields.ip}}</td>
						<td>{{fields.domain}}</td>
						<td><span class="flag-icon flag-icon-{{fields.country | lowercase}}"></span></td>
						<td>{{fields.t}}</td>
						<td>{{fields.method}}</td>
						<td>{{fields.ip1}}</td>
						<td>{{fields.port}}</td>
						<td>{{fields.ip2}}</td>
					</tr>
				</tbody>
			</table>
			<div>
				<span>Start pages from 
					<input type="number" step="1" ng-model="pagesFrom" min="1" max="{{pagesTo}}">
				</span>
				<span>Finish pages at 
					<input type="number" step="1" ng-model="pagesTo" min="{{pagesFrom}}" max="{{pages_amount}}">
				</span>
			</div>
			<nav>
				<ul class="pagination">
					<li ng-repeat="page in pages" class="{{page.clss}}">
						<a ng-click="loaddata(page.num)">{{page.num+1}}</a>
					</li>
				</ul>
			</nav>
		</div>
		<script src="<?php $this->printTplDir(); ?>js/angular.js"></script>
		<script src="<?php $this->printTplDir(); ?>js/warelog.js"></script>
