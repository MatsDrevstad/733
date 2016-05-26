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
-- Struktur för tabell `733_kp`
--

CREATE TABLE IF NOT EXISTS `733_kp` (
  `distrikt` varchar(4) NOT NULL default '',
  `kategori` char(1) NOT NULL default '',
  `adress` varchar(75) NOT NULL default '',
  `postadress` mediumint(5) NOT NULL default '0',
  `ort` varchar(30) NOT NULL default '',
  `namn` varchar(50) NOT NULL default '',
  `uppringd` varchar(17) NOT NULL default '',
  `vecka` mediumint(2) NOT NULL default '0',
  `vecka2` mediumint(2) NOT NULL default '0',
  `op` char(2) NOT NULL default '',
  `telefon` varchar(15) NOT NULL default '',
  `telefontid` varchar(30) NOT NULL default '',
  `svar` char(2) NOT NULL default '',
  `kommentar` varchar(100) NOT NULL default '',
  `trycksaker` text NOT NULL,
  `synk` tinyint(4) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Data i tabell `733_kp`
--

