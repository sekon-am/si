#!/usr/bin/perl -w
package sfp_db;
use strict;
use warnings;
use DBI;
use Exporter;

our @ISA= qw( Exporter );

our @EXPORT = qw( sfp_connect prepare_ip );

sub sfp_connect {
	#my $dbh = DBI->connect("DBI:mysql:database=si;host=localhost","si", "asdasopfjm242",{'RaiseError' => 1});
	my $dbh = DBI->connect("DBI:mysql:database=test;host=localhost","root", "",{'RaiseError' => 1});
	return $dbh;
}
sub prepare_ip { 
	return join ('.', map { substr( '000'.$_, -3 ) } split( /\./, shift(@_) ) ); 
}

1;
