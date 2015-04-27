#!/usr/bin/perl -w

use POSIX qw( strftime );
use sfp_db;
use constant ROWS_PER_REQUEST => 500;

my $dbh = sfp_connect();
for( my $index = 0 ;; $index += ROWS_PER_REQUEST ) {
	print "Processed $index\n";
	my $query = $dbh->prepare("SELECT id, ip FROM sfp ORDER BY id LIMIT $index, " . ROWS_PER_REQUEST); $query->execute();
	last unless( $query->rows() );
	while( my $row = $query->fetchrow_hashref() ) {
		$dbh->do("UPDATE sfp SET ip='" . prepare_ip( $row->{'ip'} ) . "' WHERE id='" . $row->{'id'} . "'");
	}
}

$dbh->disconnect();
