--
-- Table structure for table `models`
--

CREATE TABLE `models` (
  `id` int(11) NOT NULL,
  `disabled` tinyint(4) NOT NULL,
  `ps_child_name` varchar(255) DEFAULT NULL,
  `base_name` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `length` int(11) DEFAULT NULL,
  `directory_name` varchar(500) DEFAULT NULL,
  `directory` varchar(500) DEFAULT NULL,
  `full_name` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `models`
--

INSERT INTO `models` (`id`, `disabled`, `ps_child_name`, `base_name`, `name`, `length`, `directory_name`, `directory`, `full_name`) VALUES
(1, 0, NULL, 'b_betulaHumilis_1s', NULL, NULL, 'plants', 'bush', 'DZ|plants|bush|b_betulahumilis_1s.p3d'),
(2, 0, NULL, 'b_corylusAvellana_1f', NULL, NULL, 'plants', 'bush', 'DZ|plants|bush|b_corylusavellana_1f.p3d'),
(5823, 0, NULL, 'school_interior_1', NULL, NULL, 'structures_sakhal', 'residential', 'DZ|structures_sakhal|residential|schools|proxy|school_interior.p3d');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`id`),
  ADD KEY `base_name` (`base_name`),
  ADD KEY `full_name` (`full_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `models`
--
ALTER TABLE `models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5824;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
