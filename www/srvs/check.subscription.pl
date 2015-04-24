#!/usr/bin/perl -w
use strict;
use warnings;

open (my $file, '<subscription.tpl') or die ("Can't open file with subscription email template");
my @tpl = <$file>;
close $file;
sub mail_body {
	my ($login,$logs) = @_;
	my $loglist = join "\n", map $_->{'amount'}.' matches for the range '.$_->{'range'}, @{$logs};
	my $body = join "\n", @tpl;
	$body =~ s/%LOGIN%/$login/g;
	$body =~ s/%LOGLIST%/$loglist/g;
	return $body;
}

use constant {
	FROM => 'your_email@si.intelcrawler.com',
	TITLE => 'Attention! Your IP was found in out database',
};
use sfp_db;

my $dbh = sfp_connect();
my @rows = ();

my $quser = $dbh->prepare("SELECT * FROM users");
$quser->execute();
while( my $user = $quser->fetchrow_hashref() ){
	print 'Checking ' . $user->{'login'} . "\n";
	my @logs = ();
	my $qsubscr = $dbh->prepare("SELECT * FROM subscription WHERE user_id='".$user->{'id'}."'");
	$qsubscr->execute();
	while(my $subscr = $qsubscr->fetchrow_hashref()){
		my $qlogs = $dbh->prepare("SELECT COUNT(*) as amount FROM sfp WHERE ('".$subscr->{'ip_start'}."'<=ip) AND (ip<='".$subscr->{'ip_finish'}."')");
		$qlogs->execute();
		if(my $log = $qlogs->fetchrow_hashref()){
			if(my $cnt = $log->{'amount'}){
				my $range = $subscr->{'ip_start'} . "-" . $subscr->{'ip_finish'};
				push @logs, { 'range' => $range, 'amount' => $cnt };
				print "\t" . $cnt . ' matches for the range ' . $range . "\n";
			}
		}
	}
	if(scalar @logs){
		open(MAIL, "|/usr/sbin/sendmail -t");
		print MAIL "To: ".$user->{'email'}."\n";
		print MAIL "From: ".FROM."\n";
		print MAIL "Subject: ".TITLE."\n\n";
		print MAIL mail_body($user->{'login'},\@logs);
		close(MAIL);
	}
}

$dbh->disconnect();
