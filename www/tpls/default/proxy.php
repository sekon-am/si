		<div class="jumbotron" ng-app="proxy" ng-controller="ProxyCtrl">
			<h1>Proxies Feed</h1>
			<form class="form-inline">
				<div class="form-group">
					<label class="sr-only" for="ip_filter">IP address</label>
					<input type="text" class="form-control" id="ip_filter" ng-model="ip_filter" placeholder="Enter IP filter">
				</div>
				<button type="button" class="btn btn-primary" ng-click="dosearch()">Search</button>
			</form>
			<div>
				<div class="export-format-btn export-format-txt" ng-click="doexport('txt')"></div>
				<div class="export-format-btn export-format-json" ng-click="doexport('json')"></div>
				<div class="export-format-btn export-format-xml" ng-click="doexport('xml')"></div>
			</div>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>IP</th>
						<th>Port</th>
						<th>Proxy Server</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="fields in fieldset">
						<th scope="row">{{fields.num}}</th>
						<td>{{fields.ip}}</td>
						<td>{{fields.port}}</td>
						<td>{{fields.srv}}</td>
					</tr>
				</tbody>
			</table>
			<div>
				<span>Page number (1-{{pages_amount}}) 
					<input type="number" ng-model="page_num" min="1" max="{{pages_amount}}" step="1" ng-change="loaddata()">
				</span>
			</div>
			<div ng-file-drop ng-file-select ng-model="files" class="drop-box" drag-over-class="dragover" ng-multiple="true" allow-dir="true" accept="text/plain">Drop *.txt files with proxy lists here or click to upload</div>
		</div>
		<script src="<?php $this->printTplDir(); ?>js/angular-file-upload.js"></script>
		<script src="<?php $this->printTplDir(); ?>js/angular-file-upload-shim.js"></script>
		<script src="<?php $this->printTplDir(); ?>js/proxy.js"></script>
