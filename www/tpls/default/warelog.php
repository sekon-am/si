		<div class="jumbotron" ng-app="Warelog" ng-controller="WarelogCtrl">
			<h1>Security Intelligence Feed</h1>
			<form class="form-inline">
				<div class="form-group">
					<label class="sr-only" for="cidr">CIDR IP range</label>
					<input type="text" class="form-control" id="cidr" ng-model="cidr" placeholder="Enter 000.000.000.000/32">
				</div>
				<div class="form-group">
					<label class="sr-only" for="domain_filter">Domain name</label>
					<input type="text" class="form-control" id="domain_filter" ng-model="domain_filter" placeholder="Enter Domain Name">
				</div>
				<div class="form-group">
					<div angucomplete-alt id="malware_autocomplete" placeholder="Enter malware" 
                                             selected-object="malware_autocomplete" local-data="malwares" search-fields="name" title-field="name" 
                                             minlength="1" input-class="form-control form-control-small" match-class="highlight"></div>
				</div>
				<button type="button" class="btn btn-primary" ng-click="filterdata()">Search</button>
			</form>
<?php $this->loadWareFeeds(); ?>
<?php $this->loadWareTable(); ?>
			<script src="<?php $this->printTplDir(); ?>js/angular-touch.min.js"></script>
			<script src="<?php $this->printTplDir(); ?>js/angucomplete-alt.min.js"></script>
			<script src="<?php $this->printTplDir(); ?>js/warelog.js"></script>
                        <link href="<?php $this->printTplDir(); ?>css/angucomplete-alt.css" rel="stylesheet">
		</div>
