		<div class="jumbotron proxy-list" ng-app="proxy" ng-controller="ProxyCtrl">
			<div class="">
				<h1>Proxies Feed</h1>
				<form class="form-inline">
                                        <div class="form-group">
                                                <label class="sr-only" for="cidr">CIDR IP range</label>
                                                <input type="text" class="form-control" id="cidr" ng-model="cidr" placeholder="Enter 000.000.000.000/32">
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
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="fields in fieldset">
							<th scope="row">{{fields.num}}</th>
							<td>{{fields.ip}}</td>
							<td>{{fields.port}}</td>
						</tr>
					</tbody>
				</table>
				<div>
					<span>Go to (1-{{pages_amount}}) 
						<input type="number" ng-model="page_num" min="1" max="{{pages_amount}}" step="1" ng-change="loaddata()">
					</span>
				</div>
				<div ng-file-drop ng-file-select ng-model="files" class="drop-box" drag-over-class="dragover" ng-multiple="true" allow-dir="true" accept="text/plain">Drop *.txt files with proxy lists here or click to upload</div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width:{{uploadProgress}}%">
                                        <span class="progress-hint">{{uploadProgress}}%</span>
                                    </div>
                                </div>
			</div>
		</div>
		<script src="<?php $this->printTplDir(); ?>js/angular-file-upload.js"></script>
		<script src="<?php $this->printTplDir(); ?>js/angular-file-upload-shim.js"></script>
		<script src="<?php $this->printTplDir(); ?>js/proxy.js"></script>
