		<div class="jumbotron" ng-app="Warelog" ng-controller="WarelogCtrl">
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
			</form>
<?php $this->loadWareTable(); ?>
			<script src="<?php $this->printTplDir(); ?>js/warelog.js"></script>
		</div>
