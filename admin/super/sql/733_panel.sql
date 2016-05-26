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
-- Struktur för tabell `733_panel`
--

CREATE TABLE IF NOT EXISTS `733_panel` (
  `distrikt` varchar(4) NOT NULL default '',
  `vecka` mediumint(2) NOT NULL default '0',
  `telefon` varchar(15) NOT NULL default '',
  `adress` varchar(75) NOT NULL default '',
  `postadress` mediumint(5) NOT NULL default '0',
  `ort` varchar(30) NOT NULL default '',
  `kategori` char(1) NOT NULL default '',
  `namn` varchar(50) NOT NULL default '',
  `kommentar` text NOT NULL,
  `opinnan` char(2) NOT NULL default '',
  `op` char(2) NOT NULL default '',
  `vop` char(2) NOT NULL default '',
  `trycksaker` text NOT NULL,
  `uppdrag` text NOT NULL,
  `medlem` varchar(5) NOT NULL default 'E',
  `ejsvar` tinyint(4) NOT NULL default '0',
  `svar` char(1) NOT NULL default '',
  `lp` tinyint(4) NOT NULL default '0',
  `ad` tinyint(4) NOT NULL default '0',
  `nt` mediumint(9) NOT NULL default '0',
  `tid` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `dag` tinyint(4) NOT NULL default '0',
  `maxsvar` tinyint(4) NOT NULL default '0',
  `jasvar` tinyint(4) NOT NULL default '0',
  `nejsvar_1` tinyint(4) NOT NULL default '0',
  `nejsvar_2` tinyint(4) NOT NULL default '0',
  `kontroll` tinyint(4) NOT NULL default '0',
  `rapporterad` tinyint(4) NOT NULL default '0',
  `synk` tinyint(4) NOT NULL default '0',
  UNIQUE KEY `telefon2` (`telefon`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Data i tabell `733_panel`
--

