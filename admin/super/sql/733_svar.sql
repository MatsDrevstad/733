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
-- Struktur för tabell `733_svar`
--

CREATE TABLE IF NOT EXISTS `733_svar` (
  `id` int(11) NOT NULL auto_increment,
  `telefon` varchar(15) NOT NULL default '',
  `telefonip` varchar(15) NOT NULL,
  `vecka` mediumint(9) NOT NULL default '0',
  `op` char(2) default NULL,
  `svar` char(1) default NULL,
  `lp` char(1) default NULL,
  `nt` char(1) default NULL,
  `ad` char(1) default NULL,
  `sp` char(1) default NULL,
  `tid` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `tidip` timestamp NOT NULL default '0000-00-00 00:00:00',
  `varaktip` varchar(5) NOT NULL,
  `ipanvandare` varchar(30) NOT NULL,
  `optid` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `vecka` (`vecka`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40856 ;

--
-- Data i tabell `733_svar`
--

