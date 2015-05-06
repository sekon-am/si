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
		for( $i=0; $i<count($stats); $i++ ){
			$stat = $stats[$i];
			$stat->country = strtolower( $stat->country );
			if( !preg_match('~\w+~i', $stat->country) || !file_exists('./tpls/'.Config::$default['tpl'].'/flags/4x3/'.$stat->country.'.svg') ){
				array_splice( $stats, $i, 1 );
				$i--;
			}
		}
		return $stats;
	}
}