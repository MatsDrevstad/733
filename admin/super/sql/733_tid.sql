-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Värd: localhost
-- Skapad: 30 januari 2010 kl 11:40
-- Serverversion: 5.0.87
-- PHP-version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `quicotse_bill`
--

-- --------------------------------------------------------

--
-- Struktur för tabell `733_tid`
--

CREATE TABLE IF NOT EXISTS `733_tid` (
  `id` int(11) NOT NULL auto_increment,
  `op` char(2) NOT NULL default '',
  `start1` datetime NOT NULL default '0000-00-00 00:00:00',
  `start2` datetime NOT NULL default '0000-00-00 00:00:00',
  `stopp1` datetime NOT NULL default '0000-00-00 00:00:00',
  `stopp2` datetime NOT NULL default '0000-00-00 00:00:00',
  `forsok` smallint(6) NOT NULL default '0',
  `svar` smallint(6) NOT NULL default '0',
  `forsoktid` decimal(3,2) NOT NULL default '0.00',
  `svartid` decimal(3,2) NOT NULL default '0.00',
  `forsok10h` smallint(6) NOT NULL default '0',
  `svar10h` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1529 ;

--
-- Data i tabell `733_tid`
--

