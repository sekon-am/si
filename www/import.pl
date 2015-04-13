#!/usr/bin/perl -w
die("Input file name to import please\n") if(scalar(@ARGV)<1);
my $fname = shift @ARGV;
die("Can't find $fname") if(! -f $fname);
use constant FILE_PART_SIZE => 1024*1024;
open (my $file, '<', $fname) or die ("Can't open file $fname");

use POSIX qw( strftime );
use DBI;
use constant ROWS_PER_REQUEST => 5000;

my $dbh = DBI->connect("DBI:mysql:database=test;host=localhost","root", "",{'RaiseError' => 1});
my $filesize = -s $fname;
my @rows = ();

sub insert_rows {
	$dbh->do("INSERT INTO sfp (ip,asum,routing_aggregate,country,domain,state,t,diagnostic) VALUES ".join(',',@rows));
	@rows = ();
}

while(my $row = <$file>){
	next if(substr($row,0,1) eq '#');
	insert_rows if (scalar @rows >= ROWS_PER_REQUEST);
	chomp $row;
	my @params = split(',',$row);
	splice @params, -2;
	$params[6] = strftime("%Y-%m-%d %H:%I:%S",localtime($params[6]));
	$params[7] =~ s/BOT type \d+\s*//i;
	$params[7] = substr($params[7],2) if(substr($params[7],1,1) eq '_');
	$params[7] =~ s/\s*n\/a//ig;
	$params[7] =~ s/(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\s*80)\s+\d+/$1/ig;
	push @rows, "('".join("','",map { $_ =~ s/(['"])/\\$1/ig; $_ } @params)."')";
}
insert_rows;

$dbh->disconnect();
