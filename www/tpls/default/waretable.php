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
				<span>Go to (1-{{pages_amount}})
					<input type="number" step="1" ng-model="page_num" min="1" max="{{pages_amount}}" ng-change="loaddata()">
				</span>
			</div>
			<script src="<?php $this->printTplDir(); ?>js/waretable.js"></script>
