<?php
class StatsModel extends Model {
	public function hosts() {
		return $this->queryRow("SELECT COUNT(*) as `amount` FROM sfp")->amount;
	}
	public function hostsBy($field) {
		return $this->query("SELECT {$field},COUNT({$field}) as `amount` FROM sfp GROUP BY {$field}");
	}
	public function hostsByCountry() {
		$stats = $this->hostsBy('country');
		foreach( $stats as $stat ){
			$stat->country = strtolower( $stat->country );
		}
		return $stats;
	}
}