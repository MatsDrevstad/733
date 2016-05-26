-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Värd: localhost
-- Skapad: 30 januari 2010 kl 11:39
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
-- Struktur för tabell `733_distrikt`
--

CREATE TABLE IF NOT EXISTS `733_distrikt` (
  `id` smallint(6) NOT NULL auto_increment,
  `distrikt` varchar(4) default NULL,
  `op` char(2) NOT NULL default '',
  `maxsvar` tinyint(4) NOT NULL default '0',
  `jasvar` tinyint(4) NOT NULL default '0',
  `nejsvar_1` tinyint(4) NOT NULL default '0',
  `nejsvar_2` tinyint(4) NOT NULL default '0',
  `kontroll` tinyint(4) NOT NULL default '0',
  `kommentar` text NOT NULL,
  `uppdrag` text NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `distrikt` (`distrikt`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=287 ;

--
-- Data i tabell `733_distrikt`
--

