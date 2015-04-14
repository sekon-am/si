#!/usr/bin/perl -w
die("Input file name to import please\n") if(scalar(@ARGV)<1);
my $fname = shift @ARGV;
die("Can't find $fname") if(! -f $fname);
use constant FILE_PART_SIZE => 1024*1024;
open (my $file, '<', $fname) or die ("Can't open file $fname");

use POSIX qw( strftime );
use DBI;
use constant ROWS_PER_REQUEST => 5000;
use constant BYTES_MB => 1024*1024;

my $dbh = DBI->connect("DBI:mysql:database=si;host=localhost","si", "asdasopfjm242",{'RaiseError' => 1});
#my $dbh = DBI->connect("DBI:mysql:database=test;host=localhost","root", "",{'RaiseError' => 1});
my $filesize = -s $fname;
my $size = 0;
my @rows = ();

sub insert_rows {
	$dbh->do("INSERT INTO sfp (ip,asum,routing_aggregate,country,domain,state,t,diagnostic) VALUES ".join(',',@rows));
	@rows = ();
}

while(my $row = <$file>){
	$size += length $row;
#	print "\rProcessed "
#		.sprintf("%.1f", $size/BYTES_MB)." Mb / "
#		.sprintf("%.1f", $filesize/BYTES_MB)." MB";
	next if(substr($row,0,1) eq '#');
	insert_rows if (scalar @rows >= ROWS_PER_REQUEST);
	chomp $row;
	my @params = split(',',$row);
	splice @params, -2;
	$params[6] = strftime("%Y-%m-%d %H:%I:%S",localtime($params[6]));
	$params[7] =~ s/BOT type \d+\s*//i;
	$params[7] = substr($params[7],2) if(substr($params[7],1,1) eq '_');
	$params[7] =~ s/\s*n\/a//ig;
	$params[7] =~ s/(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\s+\d+)\s+\d+/$1/ig;
	if($params[7] =~ /^[\w\d_\-]+\s+(((\d{1,3}\.){3}\d{1,3})|(([\w\d_\-]+\.)+\w{3,5}))\s+\d+(\s+(((\d{1,3}\.){3}\d{1,3})|(([\w\d_\-]+\.)+\w{3,5}))){0,1}$/i){
print $params[7]."\n";
		push @rows, "('".join("','",map { $_ =~ s/(['"])/\\$1/ig; $_ } @params)."')";
	}
}
insert_rows;

$dbh->disconnect();
