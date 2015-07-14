<?php
class StatsModel extends Model {
	public function hosts() {
		return $this->queryRow("SELECT COUNT(*) as `amount` FROM sfp")->amount;
	}
	public function hostsBy($field) {
		return $this->query("SELECT {$field},COUNT({$field}) as `amount` FROM sfp GROUP BY {$field}");
	}
	public function hostsByCountry() {
                $countries = require(__DIR__ . '/../data/countries.php');
		$stats = $this->hostsBy('country');
		for( $i=0; $i<count($stats); $i++ ){
			$stat = $stats[$i];
                        $stat->countryName = ucfirst(strtolower($countries[$stat->country]));
			$stat->country = strtolower( $stat->country );
			if( !preg_match('~\w+~i', $stat->country) || !file_exists('./tpls/'.Config::$default['tpl'].'/flags/4x3/'.$stat->country.'.svg') ){
				array_splice( $stats, $i, 1 );
				$i--;
			}
		}
                $ctrs = array();
                foreach($stats as $key => $stat){
                    $ctrs[$key] = $stat->countryName;
                }
                array_multisort($ctrs, SORT_ASC, $stats);
		return $stats;
	}
}