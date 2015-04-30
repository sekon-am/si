#!/usr/bin/perl -w

use POSIX qw( strftime );
use sfp_db;
use constant ROWS_PER_REQUEST => 500;

my $dbh = sfp_connect();
for( my $index = 0 ;; $index += ROWS_PER_REQUEST ) {
	print "Processed $index\n";
	my $query = $dbh->prepare("SELECT * FROM sfp ORDER BY id LIMIT $index, " . ROWS_PER_REQUEST); $query->execute();
	last unless( $query->rows() );
	while( my $row = $query->fetchrow_hashref() ) {
		my ($malware,$ip1,$port) = split ' ', $row->{'diagnostic'};
		$dbh->do("UPDATE sfp SET malware='" . $malware . "', port='" . $port . "' WHERE id='" . $row->{'id'} . "'");
	}
}

$dbh->disconnect();
