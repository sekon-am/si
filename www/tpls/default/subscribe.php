		<div class="jumbotron" ng-app="Subscribe" ng-controller="SubscribeCtrl">
			<h1>Your hash: <span><?php echo $this->hash; ?></span></h1>
			<h1>Subscribe on databse updates</h1>
			<ul class="ip-ranges">
				<li ng-repeat="range in ranges">
					<span ng-click="setrange(range.ip_start,range.ip_finish)" class="ip-range">{{range.ip_start}}&nbsp;..&nbsp;{{range.ip_finish}}</span>
					<span class="glyphicon glyphicon-remove" ng-click="rangedel(range.id,$index)"></span>
				</li>
			</ul>
			<form class="form-inline">
				<div class="form-group">
					<label class="sr-only" for="cidr">CIDR format</label>
					<input type="text" class="form-control" id="cidr" ng-model="cidr" placeholder="000.000.000.000/32">
				</div>
				<span>or</span>
				<div class="form-group">
					<label class="sr-only" for="ip_start">IP from</label>
					<input type="text" class="form-control" id="ip_start" ng-model="ip_start" ng-change="rangechange()" placeholder="000.000.000.000">
				</div>
				<span>-</span>
				<div class="form-group">
					<label class="sr-only" for="ip_finish">IP to</label>
					<input type="text" class="form-control" id="ip_finish" ng-model="ip_finish" ng-change="rangechange()" placeholder="000.000.000.000">
				</div>
				<button type="button" class="btn btn-default" ng-click="filtereddata()">Search</button>
				<button type="button" class="btn btn-primary" ng-click="dosubscribe()">Subscribe</button>
			</form>
			<tabset>
				<tab heading="Infections Feed">
<?php $this->loadWareTable(); ?>
				</tab>
				<tab heading="Proxies Feed">
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
							<tr ng-repeat="proxy in proxies">
								<th scope="row">{{proxy.num}}</th>
								<td>{{proxy.ip}}</td>
								<td>{{proxy.port}}</td>
								<td>{{proxy.srv}}</td>
							</tr>
						</tbody>
					</table>
	<input type="number" step="1" ng-model="page_num111" min="1" max="{{pages_amount}}" ng-change="loaddata()">
					<div>
						<span>Go to (1-{{proxy_pages_amount}}) 
							<input type="number" ng-model="proxy_page_num1" min="1" max="{{proxy_pages_amount}}" step="1" ng-change="proxy_loaddata()">
						</span>
					</div>
				</tab>
			</tabset>
			<script src="<?php $this->printTplDir(); ?>js/ui-bootstrap-tpls-0.12.1.js"></script>
			<script src="<?php $this->printTplDir(); ?>js/subscribe.js"></script>
			</script>
		</div>
