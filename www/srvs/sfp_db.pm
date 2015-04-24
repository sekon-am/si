#!/usr/bin/perl -w
package sfp_db;
use strict;
use warnings;
use DBI;
use Exporter;

our @ISA= qw( Exporter );

our @EXPORT = qw( sfp_connect );

sub sfp_connect {
	#my $dbh = DBI->connect("DBI:mysql:database=si;host=localhost","si", "asdasopfjm242",{'RaiseError' => 1});
	my $dbh = DBI->connect("DBI:mysql:database=test;host=localhost","root", "",{'RaiseError' => 1});
	return $dbh;
}

1;