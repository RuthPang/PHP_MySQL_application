-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2023 年 06 月 23 日 17:24
-- 伺服器版本： 10.4.28-MariaDB
-- PHP 版本： 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `108321015`
--

-- --------------------------------------------------------

--
-- 資料表結構 `member`
--

CREATE TABLE `member` (
  `ID` tinyint(3) NOT NULL,
  `Username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Sex` enum('男','女') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '男',
  `Birthday` date DEFAULT NULL,
  `Phone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Mail` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Interest` set('鉛筆畫','色鉛筆畫','油畫','水彩畫') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '鉛筆畫',
  `CourseType` enum('線上課程','實體互動') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '線上課程'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `member`
--

INSERT INTO `member` (`ID`, `Username`, `Password`, `Sex`, `Birthday`, `Phone`, `Mail`, `Interest`, `CourseType`) VALUES
(1, 'fred', '$2y$10$QIM99jxDrjgqlg9GsBCS..wedko6JMljK1OH29fmbq8tAKTFgO.Hm', '男', '0000-00-00', '', 'fred123@gmail.com', '水彩畫', '線上課程'),
(2, 'ycchen', '$2y$10$BnG5LrwdWb0BNSEhN1ZA5Oey9imur.PPW5o2kuRo/wVCZRL7d.K6q', '男', '1999-01-01', '0945678913', 'ycchen123@gmail.com', '', '實體互動'),
(3, 'www2023', '$2y$10$1RlW6Nm4o2.3jQ0nTReV1.VYIvhUschi0AmFXIyiF3dlhWZxdWzAK', '女', '2003-07-14', '0987654321', 'www2023@gmail.com', '油畫', '實體互動'),
(4, 'Teddy', '$2y$10$NnMULatUwh3YDPgDQsNcBO2MtuaCkPA1w15p.3ntzVR7vDJyDeRaO', '女', '2000-10-15', '0965498394', 'teddy@gmail.com', '鉛筆畫,油畫', '實體互動');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`ID`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `member`
--
ALTER TABLE `member`
  MODIFY `ID` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
