-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Mar 11 Décembre 2012 à 11:48
-- Version du serveur: 5.1.30
-- Version de PHP: 5.2.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `qlsv`
--

-- --------------------------------------------------------

--
-- Structure de la table `ketqua`
--

CREATE TABLE IF NOT EXISTS `ketqua` (
  `p_id` double unsigned NOT NULL AUTO_INCREMENT,
  `tensv` varchar(100) NOT NULL,
  `mnh` varchar(100) NOT NULL,
  `tenmonhoc` varchar(100) NOT NULL,
  `lanthi` int(100) NOT NULL,
  `diem` int(10) NOT NULL,
  `p_check` tinyint(3) unsigned zerofill NOT NULL,
  `p_del` tinyint(3) unsigned zerofill NOT NULL,
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `ketqua`
--

INSERT INTO `ketqua` (`p_id`, `tensv`, `mnh`, `tenmonhoc`, `lanthi`, `diem`, `p_check`, `p_del`) VALUES
(12, 'Tráº§n XuÃ¢n Tuáº¥n', 'LTWB', 'Láº­p trÃ¬nh website', 1, 8, 000, 000),
(13, 'LÃª Thu Trang', 'KTCN', 'Káº¿ toÃ¡n chuyÃªn ngÃ nh', 1, 9, 000, 000);

-- --------------------------------------------------------

--
-- Structure de la table `khoa`
--

CREATE TABLE IF NOT EXISTS `khoa` (
  `p_id` double unsigned NOT NULL AUTO_INCREMENT,
  `makhoa` varchar(100) NOT NULL,
  `tenkhoa` varchar(100) NOT NULL,
  `p_check` tinyint(3) unsigned zerofill NOT NULL,
  `p_del` tinyint(3) unsigned zerofill NOT NULL,
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `khoa`
--

INSERT INTO `khoa` (`p_id`, `makhoa`, `tenkhoa`, `p_check`, `p_del`) VALUES
(6, 'TH', 'CÃ´ng nghá»‡ thÃ´ng tin', 000, 000),
(7, 'KT', 'Káº¿ toÃ¡n', 000, 000),
(8, '', '', 000, 001),
(9, 'CDT', 'CÆ¡ Ä‘iá»‡n tá»­', 000, 000);

-- --------------------------------------------------------

--
-- Structure de la table `lop`
--

CREATE TABLE IF NOT EXISTS `lop` (
  `p_id` double unsigned NOT NULL AUTO_INCREMENT,
  `malop` varchar(10) NOT NULL,
  `tenlop` varchar(50) NOT NULL,
  `khoa` varchar(100) NOT NULL,
  `p_check` tinyint(3) unsigned zerofill NOT NULL,
  `p_del` tinyint(3) unsigned zerofill NOT NULL,
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Contenu de la table `lop`
--

INSERT INTO `lop` (`p_id`, `malop`, `tenlop`, `khoa`, `p_check`, `p_del`) VALUES
(10, 'C17A-K13', 'Tin há»c K13', 'CÃ´ng nghá»‡ thÃ´ng tin', 000, 000),
(11, 'C17A-K14', 'Tin há»c K14', 'CÃ´ng nghá»‡ thÃ´ng tin', 000, 000),
(12, 'C15E - K13', 'Káº¿ ToÃ¡n E K13', 'Káº¿ toÃ¡n', 000, 000),
(13, 'C15A - K14', 'Káº¿ ToÃ¡n A K14', 'Káº¿ toÃ¡n', 000, 000),
(14, '', '', 'CÃ´ng nghá»‡ thÃ´ng tin', 000, 001);

-- --------------------------------------------------------

--
-- Structure de la table `monhoc`
--

CREATE TABLE IF NOT EXISTS `monhoc` (
  `p_id` double unsigned NOT NULL AUTO_INCREMENT,
  `tensv` varchar(100) NOT NULL,
  `p_mnh` varchar(100) NOT NULL,
  `tenmonhoc` varchar(100) NOT NULL,
  `sotiet` int(11) NOT NULL,
  `p_check` tinyint(4) NOT NULL,
  `p_del` tinyint(11) unsigned zerofill NOT NULL,
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4169 ;

--
-- Contenu de la table `monhoc`
--

INSERT INTO `monhoc` (`p_id`, `tensv`, `p_mnh`, `tenmonhoc`, `sotiet`, `p_check`, `p_del`) VALUES
(4167, 'Tráº§n XuÃ¢n Tuáº¥n', 'LTWB', 'Láº­p trÃ¬nh website', 120, 0, 00000000000),
(4168, 'LÃª Thu Trang', 'KTCN', 'Káº¿ toÃ¡n chuyÃªn ngÃ nh', 120, 0, 00000000000);

-- --------------------------------------------------------

--
-- Structure de la table `sinhvien`
--

CREATE TABLE IF NOT EXISTS `sinhvien` (
  `p_id` double unsigned NOT NULL AUTO_INCREMENT,
  `masv` varchar(100) NOT NULL,
  `tensv` varchar(100) NOT NULL,
  `ngaysinh` varchar(100) NOT NULL,
  `gioitinh` varchar(10) NOT NULL,
  `quequan` varchar(100) NOT NULL,
  `lop` varchar(100) NOT NULL,
  `khoa` varchar(100) NOT NULL,
  `p_check` tinyint(3) unsigned zerofill NOT NULL,
  `p_del` tinyint(3) unsigned zerofill NOT NULL,
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `sinhvien`
--

INSERT INTO `sinhvien` (`p_id`, `masv`, `tensv`, `ngaysinh`, `gioitinh`, `quequan`, `lop`, `khoa`, `p_check`, `p_del`) VALUES
(8, 'C17AK13T', 'Tráº§n XuÃ¢n Tuáº¥n', '26-11-1991', 'Nam', 'Tam Äiá»‡p - Ninh BÃ¬nh', 'Tin há»c K13', 'CÃ´ng nghá»‡ thÃ´ng tin', 000, 000),
(9, 'C15EK13T', 'LÃª Thu Trang', '10-04-1994', 'Ná»¯ ', 'Tam Äiá»‡p - Ninh BÃ¬nh', 'Káº¿ ToÃ¡n E K13', 'Káº¿ toÃ¡n', 000, 000),
(10, '', '', '', '', '', 'Tin há»c K13', 'CÃ´ng nghá»‡ thÃ´ng tin', 000, 001);
