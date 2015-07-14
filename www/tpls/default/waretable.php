			<table class="table table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>IP</th>
						<th>Domain</th>
						<th>Country</th>
						<th>Data &amp; Time</th>
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
						<td class="bline">
                                                    <span class="flag-icon flag-icon-{{fields.country | lowercase}}"></span>&nbsp;<span>{{fields.countryName}}</span>
                                                </td>
						<td>{{fields.t}}</td>
						<td>{{fields.method}}</td>
						<td>{{fields.ip1}}</td>
						<td>{{fields.port}}</td>
						<td>{{fields.ip2}}</td>
					</tr>
				</tbody>
			</table>
			<div class="pagination">
<!--				<span>Go to (1-{{pages_amount}})
					<input type="number" step="1" ng-model="page_num" min="1" max="{{pages_amount}}" ng-change="loaddata()">
				</span>-->
                            <span class="pagination-item" ng-if="page_num>1" ng-click="goto(page_num-1)">&lt;</span>&nbsp;
                            <span class="pagination-item" ng-if="page_num>1" ng-click="goto(1)">1</span>&nbsp;
                            <span ng-if="page_num>2">...</span>&nbsp;
                            <span class="pagination-item" ng-if="page_num>2" ng-click="goto(page_num-1)">{{page_num-1}}</span>&nbsp;
                            <span class="pagination-item active">{{page_num}}</span>&nbsp;
                            <span class="pagination-item" ng-if="page_num<pages_amount-1" ng-click="goto(page_num+1)">{{page_num+1}}</span>&nbsp;
                            <span ng-if="page_num<pages_amount-1">...</span>
                            <span class="pagination-item" ng-if="page_num<pages_amount" ng-click="goto(pages_amount)">{{pages_amount}}</span>
                            <span class="pagination-item" ng-if="page_num<pages_amount" ng-click="goto(page_num+1)">&gt;</span>
			</div>
                        <input type="hidden" id="country" value="<?php echo $this->country; ?>"/>
			<script src="<?php $this->printTplDir(); ?>js/waretable.js"></script>
