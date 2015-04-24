			<div class="export-box">
				<div class="export-format-btn export-format-txt" ng-click="doexport('txt')"></div>
				<div class="export-format-btn export-format-json" ng-click="doexport('json')"></div>
				<div class="export-format-btn export-format-xml" ng-click="doexport('xml')"></div>
			</div>
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
						<a ng-click="loaddata(page.num)">{{page.num}}</a>
					</li>
				</ul>
			</nav>
			<script src="<?php $this->printTplDir(); ?>js/waretable.js"></script>
