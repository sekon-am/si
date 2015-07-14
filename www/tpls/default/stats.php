		<div class="jumbotron stats">
			<h1>Our Statistic</h1>
			<h4>Host in the database: <span class="stat-value"><?php echo $this->hosts; ?></span></h4>
			<h4>Hosts by country</h4>
			<ul class="hosts-by-country">
<?php foreach( $this->byCountry as $stat ): ?>
<?php if( strpos( $stat->country, '?' ) === FALSE && trim($stat->country)){ ?>
				<li>
                                    <a href="index.php?ctrl=warelog&country=<?php echo $stat->country; ?>">
                                        <span class="flag-icon flag-icon-<?php echo $stat->country; ?>"></span>&nbsp;
                                        <span><?php echo $stat->countryName; ?></span>
                                    </a>
                                    <span class="host-amount">(<?php echo $stat->amount; ?>)</span>
				</li>
<?php } ?>
<?php endforeach; ?>
			</ul>
			<h4>Hosts by port</h4>
			<ul class="hosts-by-any">
<?php foreach( $this->byPort as $stat ): ?>
				<li>
					<span class="host-field"><?php echo $stat->port; ?></span>
					<span class="host-amount">(<?php echo $stat->amount; ?>)</span>
				</li>
<?php endforeach; ?>
			</ul>
			<h4>Hosts by malware</h4>
			<ul class="hosts-by-any">
<?php foreach( $this->byMalware as $stat ): ?>
				<li>
					<span class="host-field"><?php echo $stat->malware; ?></span>
					<span class="host-amount">(<?php echo $stat->amount; ?>)</span>
				</li>
<?php endforeach; ?>
			</ul>
		</div>
		