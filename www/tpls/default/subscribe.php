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
					<input type="text" class="form-control" id="ip_start" ng-model="ip_start" placeholder="000.000.000.000">
				</div>
				<span>-</span>
				<div class="form-group">
					<label class="sr-only" for="ip_finish">IP to</label>
					<input type="text" class="form-control" id="ip_finish" ng-model="ip_finish" placeholder="000.000.000.000">
				</div>
				<button type="button" class="btn btn-default" ng-click="filtereddata()">Search</button>
				<button type="button" class="btn btn-primary" ng-click="dosubscribe()">Subscribe</button>
			</form>
<?php $this->loadWareTable(); ?>
			<script src="<?php $this->printTplDir(); ?>js/subscribe.js"></script>
			</script>
		</div>
