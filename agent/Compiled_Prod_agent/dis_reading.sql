/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dis_reading`
--

-- --------------------------------------------------------

--
-- Table structure for table `error_rpt`
--

CREATE TABLE `error_rpt` (
  `error_rpt_id` double(9,0) NOT NULL,
  `factory_id` varchar(50) NOT NULL,
  `stack_id` varchar(50) NOT NULL,
  `date_from` date NOT NULL,
  `time_from` time(6) NOT NULL,
  `date_to` date NOT NULL,
  `time_to` time(6) NOT NULL,
  `report` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reading`
--

CREATE TABLE `reading` (
  `reading_id` double(9,0) NOT NULL,
  `factory_id` varchar(50) DEFAULT NULL,
  `stack_id` varchar(50) DEFAULT NULL,
  `read_date` date DEFAULT NULL,
  `read_time` time(6) DEFAULT NULL,
  `so2` double(5,2) DEFAULT NULL,
  `no2` double(5,2) DEFAULT NULL,
  `co` double(5,2) DEFAULT NULL,
  `co2` double(5,2) DEFAULT NULL,
  `hcl` double(5,2) DEFAULT NULL,
  `hf` double(5,2) DEFAULT NULL,
  `h2o` double(5,2) DEFAULT NULL,
  `o2` double(5,2) DEFAULT NULL,
  `nmvoc` double(5,2) DEFAULT NULL,
  `total_pm` double(5,2) DEFAULT NULL,
  `opacity` double(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reading_log`
--

CREATE TABLE `reading_log` (
  `reading_id` double(9,0) NOT NULL,
  `factory_id` varchar(50) DEFAULT NULL,
  `stack_id` varchar(50) DEFAULT NULL,
  `read_date` date DEFAULT NULL,
  `read_time` time(6) DEFAULT NULL,
  `so2` double(5,2) DEFAULT NULL,
  `no2` double(5,2) DEFAULT NULL,
  `co` double(5,2) DEFAULT NULL,
  `co2` double(5,2) DEFAULT NULL,
  `hcl` double(5,2) DEFAULT NULL,
  `hf` double(5,2) DEFAULT NULL,
  `h2o` double(5,2) DEFAULT NULL,
  `o2` double(5,2) DEFAULT NULL,
  `nmvoc` double(5,2) DEFAULT NULL,
  `total_pm` double(5,2) DEFAULT NULL,
  `opacity` double(5,2) DEFAULT NULL,
  `log_timeCreated` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  `log_error` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Indexes for dumped tables
--

--
-- Indexes for table `error_rpt`
--
ALTER TABLE `error_rpt`
  ADD PRIMARY KEY (`error_rpt_id`);

--
-- Indexes for table `reading`
--
ALTER TABLE `reading`
  ADD PRIMARY KEY (`reading_id`);

--
-- Indexes for table `reading_log`
--
ALTER TABLE `reading_log`
  ADD PRIMARY KEY (`reading_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reading`
--
ALTER TABLE `reading`
  MODIFY `reading_id` double(9,0) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reading_log`
--
ALTER TABLE `reading_log`
  MODIFY `reading_id` double(9,0) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
