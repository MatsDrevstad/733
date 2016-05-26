-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Värd: localhost
-- Skapad: 30 januari 2010 kl 11:38
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
-- Struktur för tabell `733_bokning`
--

CREATE TABLE IF NOT EXISTS `733_bokning` (
  `id` mediumint(9) NOT NULL auto_increment,
  `distrikt` varchar(4) NOT NULL default '',
  `namn` varchar(50) NOT NULL default '',
  `vecka` mediumint(9) NOT NULL default '0',
  `vecka_noindex` mediumint(9) NOT NULL,
  `kommentar` text NOT NULL,
  `kommentar2` text NOT NULL,
  `kommentar3` text NOT NULL,
  `tidklar` varchar(20) NOT NULL default '',
  `nejsvar` tinyint(4) NOT NULL default '0',
  `tid` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `avisera` tinyint(4) NOT NULL default '0',
  `avtal` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `vecka` (`vecka`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46360 ;

--
-- Data i tabell `733_bokning`
--

