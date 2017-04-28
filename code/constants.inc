<?php

// /home/jerrys914/public_html/jerry

/*
const BASEPATH = '/home/jerrys914/';	

const SITEPATH = '/home/jerrys914/public_html/';

const GAMESPATH = '/home/jerrys914/games/';

const ACCOUNTSPATH = '/home/jerrys914/accounts/';

const STATSPATH = '/home/jerrys914/stats/';

const CODEPATH = '/home/jerrys914/code/';

const SITEBASEURL = 'http://www.footballstatkeeper.com';

const BASEPATH = 'C:/xampp/htdocs/xampp/gamestats/';	

const SITEPATH = 'C:/xampp/htdocs/xampp/gamestats/www/';

const GAMESPATH = 'C:/xampp/htdocs/xampp/gamestats/games/';

const ACCOUNTSPATH = 'C:/xampp/htdocs/xampp/gamestats/accounts/';

const STATSPATH = 'C:/xampp/htdocs/xampp/gamestats/stats/';

const CODEPATH = 'C:/xampp/htdocs/xampp/gamestats/code/';

const SITEBASEURL = 'http://localhost/xampp/gamestats/www';
*/
const BASEPATH = '/Applications/XAMPP/xamppfiles/htdocs/xampp/gamestats.';  

const SITEPATH = '/Applications/XAMPP/xamppfiles/htdocs/xampp/gamestats/www/';

const GAMESPATH = '/Applications/XAMPP/xamppfiles/htdocs/xampp/gamestats/games/';

const ACCOUNTSPATH = '/Applications/XAMPP/xamppfiles/htdocs/xampp/gamestats/accounts/';

const STATSPATH = '/Applications/XAMPP/xamppfiles/htdocs/xampp/gamestats/stats/';

const CODEPATH = '/Applications/XAMPP/xamppfiles/htdocs/xampp/gamestats/code/';

const SITEBASEURL = 'http://localhost/xampp/gamestats/www';

const UsernameMaxLength = 15;

const UsernameMinLength = 5;

const StartingSeason = 2015;
const CurrentSeason = 2015;

$inviteCodes = array('MFL');

$adminUsers = array('admin');

$statsList = array();

$statsList[] = array('QB TD', 'ptd', 11);
$statsList[] = array('QB Int', 'pInt', 11);
$statsList[] = array('Rush TD', 'rush_td', 11);
$statsList[] = array('Receptions', 'rec', 30);
$statsList[] = array('Receiving TD', 'rec_td', 11);
$statsList[] = array('Fumbles Lost', 'fl', 11);
$statsList[] = array('Tackles', 'tackles', 30);
$statsList[] = array('Sacks', 'sacks', 11);
$statsList[] = array('Interceptions', 'int', 11);
$statsList[] = array('Pick 6', 'int_td', 11);
$statsList[] = array('Forced Fumbles', 'ff', 11);
$statsList[] = array('Fumble Recover', 'fr', 11);
$statsList[] = array('Fumble Recover TD', 'fr_td', 11);

//These are fields from the statsList array that count towards total score
$ScoringPlayFields = array('ptd','rush_td','int_td','fr_td');

$teams = array();

$teams['2015'] = array('John\'s Team', 'Quazi\'s Team', 'Tony\'s Team', 'Angelo\'s Team', 'Mit\'s Team');

$inviteCodes = array('MFL');
?>