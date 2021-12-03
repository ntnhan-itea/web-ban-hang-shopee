-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 11, 2021 at 02:35 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quanlydathang`
--
CREATE DATABASE IF NOT EXISTS `quanlydathang` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `quanlydathang`;

-- --------------------------------------------------------

--
-- Table structure for table `account_admin`
--

CREATE TABLE `account_admin` (
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `MSNV` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `account_admin`
--

INSERT INTO `account_admin` (`username`, `password`, `MSNV`) VALUES
('admin', '123', 1),
('nv1', '123', 2),
('nv2', '123', 3);

-- --------------------------------------------------------

--
-- Table structure for table `account_user`
--

CREATE TABLE `account_user` (
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `MSKH` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `account_user`
--

INSERT INTO `account_user` (`username`, `password`, `MSKH`) VALUES
('kh2', '123', 2),
('kh3', '123', 3),
('user', '123', 1);

-- --------------------------------------------------------

--
-- Table structure for table `chitietdathang`
--

CREATE TABLE `chitietdathang` (
  `SoDonDH` int(11) NOT NULL,
  `MSHH` int(11) NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `GiaDatHang` int(11) NOT NULL,
  `GiamGia` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chitietdathang`
--

INSERT INTO `chitietdathang` (`SoDonDH`, `MSHH`, `SoLuong`, `GiaDatHang`, `GiamGia`) VALUES
(1, 1, 2, 400000, 0),
(1, 2, 1, 3000000, 0),
(1, 3, 1, 6000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `dathang`
--

CREATE TABLE `dathang` (
  `SoDonDH` int(11) NOT NULL,
  `MSKH` int(11) NOT NULL,
  `MSNV` int(11) NOT NULL,
  `NgayDH` date DEFAULT NULL,
  `NgayGH` date DEFAULT NULL,
  `TrangThaiDH` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dathang`
--

INSERT INTO `dathang` (`SoDonDH`, `MSKH`, `MSNV`, `NgayDH`, `NgayGH`, `TrangThaiDH`) VALUES
(1, 1, 1, '2021-10-09', '2021-10-12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `diachikh`
--

CREATE TABLE `diachikh` (
  `MaDC` int(11) NOT NULL,
  `DiaChi` varchar(250) NOT NULL,
  `MSKH` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `diachikh`
--

INSERT INTO `diachikh` (`MaDC`, `DiaChi`, `MSKH`) VALUES
(1, 'so 5 Li Tu Trong 23', 1),
(2, 'so 12 Tran Phu', 1),
(3, 'so 173 Duong 30/4', 2),
(4, 'Hem 12 Le Binh', 2),
(5, 'Hem 278 Tam Vu', 3);

-- --------------------------------------------------------

--
-- Table structure for table `hanghoa`
--

CREATE TABLE `hanghoa` (
  `MSHH` int(11) NOT NULL,
  `TenHH` varchar(200) NOT NULL,
  `QuyCach` varchar(2000) NOT NULL,
  `Gia` float NOT NULL,
  `SoLuongHang` int(11) NOT NULL,
  `MaLoaiHang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hanghoa`
--

INSERT INTO `hanghoa` (`MSHH`, `TenHH`, `QuyCach`, `Gia`, `SoLuongHang`, `MaLoaiHang`) VALUES
(1, 'Camera Webcam HD 720P,1080P Kèm Mic Dùng Cho Máy Tính / Skype MSN ( CÓ SẲN ) TK81', 'Lưu ý: Camera dùng đầu ghi hình - K dùng thẻ nhớ. Khách hàng vui lòng đọc kỹ thông tin trước khi đặt hàng,\r\nShop k hỗ trợ trả hàng khi khách mua nhầm. Xin cảm ơn!\r\n\r\nCamera Hiviz HZA-B02E2L-A2 - Chính hãng - BẢO HÀNH 24 THÁNG\r\n*  HZA-D02E2L-I2\r\nCamera Dome AHD/CVI/TVI/CVBS 2MP\r\n+ Độ phân giải 2.0Megapixel cảm biến hình ảnh 1/3.2\" CMOS Sensor\r\n+ Hình ảnh thời gian thực 1080P, độ phân giải cao, màu sắc trung thực\r\n+ Độ nhạy sáng tối thiểu 0 Lux IR on\r\n+ Chế độ ngày đêm (ICR), OSD, tự động cân bằng trắng (AWB), tự động bù tín hiệu ảnh (AGC), bù sáng (BLC), chống nhiễu (DNR), chống ngược sáng số DWDR\r\n+ Hồng ngoại thông minh, tầm xa 20-25m\r\n+ Ống kính cố định 3.6mm\r\n+ Điện áp DC12V±10%\r\n+ Vỏ nhựa. IP66', 200000, 20, 2),
(2, 'Head Phone', 'Tai nghe bluetooth không dây Gutek J950 chụp tai chống ồn có micro đàm thoại âm bass sống động\r\n\r\nTÍNH NĂNG NỔI BẬT CỦA TAI NGHE BLUETOOTH CHỤP TAI KHÔNG DÂY GUTEK J950 EXTRA BASS  \r\n- Thiết kế kiểu dáng chụp tai thời trang, màu sắc sang trọng \r\n- Kết nối thông qua bluetooth mới nhất, nhanh chóng, dễ dàng \r\n- Hỗ trợ công nghệ giảm tiếng ồn tối đa \r\n- Âm thanh cực sống động, chuẩn từng nốt nhạc \r\n- Có thể nghe nhạc thông qua dây AUX 3.5mm tiện lợi \r\n- Hỗ trợ micro đàm thoại dễ dàng\r\nTai nghe bluetooth Gutek J950 extra bass tương thích hoàn hảo với điện thoại thông minh, Vẫn giữ liên lạc khi đang nghe nhạc. \r\nNút bấm điều khiển tai nghe J950 cho phép bạn nhận cuộc gọi rảnh tay cũng như bỏ qua một bản nhạc hay là điều chỉnh âm lượng. \r\nGutek J950 có kiểu dáng nhỏ gọn thời trang siêu đẹp, khả năng chống ồn cực tốt, giúp bạn không bị mất tập trung bởi những âm thanh bên ngoài.', 3000000, 15, 2),
(3, 'MacBook đỉnh cao công nghệ', 'Tính năng nổi bật \r\n•       Chip M1 do Apple thiết kế tạo ra một cú nhảy vọt về hiệu năng máy học, CPU và GPU \r\n•       Tăng thời gian sử dụng với thời lượng pin lên đến 18 giờ (1) \r\n•       CPU 8 lõi cho tốc độ nhanh hơn đến 3.5x, xử lý công việc nhanh chóng hơn bao giờ hết (2)  \r\n•       GPU lên đến 7 lõi với tốc độ xử lý đồ họa nhanh hơn đến 5x cho các ứng dụng và game đồ họa khủng (2)  \r\n•       Neural Engine 16 lõi cho công nghệ máy học hiện đại \r\n•       Bộ nhớ thống nhất 8GB giúp bạn làm việc gì cũng nhanh chóng và trôi chảy  \r\n•       Ổ lưu trữ SSD siêu nhanh giúp mở các ứng dụng và tập tin chỉ trong tích tắc \r\n•       Thiết kế không quạt giảm tối đa tiếng ồn khi sử dụng  \r\n•       Màn hình Retina 13.3 inch với dải màu rộng P3 cho hình ảnh sống động và chi tiết ấn tượng (3)\r\n•       Camera FaceTime HD với bộ xử lý tín hiệu hình ảnh tiên tiến cho các cuộc gọi video đẹp hình, rõ tiếng hơn \r\n•       Bộ ba micro phối hợp tập trung thu giọng nói của bạn, không thu tạp âm môi trường ', 31000000, 50, 2),
(4, 'Iphone 13', 'iPhone 13\r\nHệ thống camera kép tiên tiến nhất từng có trên iPhone. Chip A15 Bionic thần tốc. Bước nhảy vọt về\r\nthời lượng pin. Thiết kế bền bỉ. Mạng 5G siêu nhanh.1 Cùng với màn hình Super Retina XDR sáng hơn.\r\n\r\nTính năng nổi bật\r\n• Màn hình Super Retina XDR 6.1 inch2\r\n• Chế độ Điện Ảnh làm tăng thêm độ sâu trường ảnh nông và tự động thay đổi tiêu cự trong video\r\n• Hệ thống camera kép tiên tiến với camera Wide và Ultra Wide 12MP; Phong Cách Nhiếp Ảnh, HDR thông\r\nminh thế hệ 4, chế độ Ban Đêm, khả năng quay video HDR Dolby Vision 4K\r\n• Camera trước TrueDepth 12MP với chế độ Ban Đêm và khả năng quay video HDR Dolby Vision 4K\r\n• Chip A15 Bionic cho hiệu năng thần tốc\r\n• Thời gian xem video lên đến 19 giờ3\r\n• Thiết kế bền bỉ với Ceramic Shield\r\n• Khả năng chống nước đạt chuẩn IP68 đứng đầu thị trường4\r\n• Mạng 5G cho tốc độ tải xuống siêu nhanh, xem video và nghe nhạc trực tuyến chất lượng cao1\r\n• iOS 15 tích hợp nhiều tính năng mới cho phép bạn làm được nhiều việc hơn bao giờ hết với iPhone5', 6000, 4, 2),
(5, 'AIRPODS ', 'THÔNG SỐ KỸ THUẬT:\r\nThời gian sử dụng: 4.5 giờ\r\nThời gian sạc đầy: 2 giờ\r\nCổng sạc: Lightning, Sạc không dây\r\nCông nghệ âm thanh: Active Noise Cancellation, Adaptive EQ\r\nTương thích: Android, iOS (iPhone)\r\nTiện ích: Chống ồn,Chống nước, Mic đàm thoại\r\nKết nối cùng lúc: 1 thiết bị\r\nHỗ trợ kết nối: 10m (Bluetooth 5.0)\r\nĐiều khiển: Cảm ứng chạm\r\n\r\nMô tả sản phẩm:\r\nThiết kế in-ear hoàn toàn mới và độc đáo.\r\nTích hợp công nghệ chống ồn chủ động (Active Noise Cancellation).\r\nChip H1 mạnh mẽ, xử lý âm thanh kỹ thuật số với độ trễ gần như bằng không.\r\nNghe nhạc đến 4.5 giờ khi bật chống ồn, 5 giờ khi tắt chống ồn.\r\nSử dụng song song với hộp sạc có thể dùng được đến 24 giờ nghe nhạc.\r\nKết nối nhanh và ổn định với công nghệ Bluetooth 5.0.\r\nHỗ trợ sạc nhanh, cho thời gian sử dụng đến 1 giờ chỉ với 5 phút sạc.\r\nHộp sạc hỗ trợ sạc không dây chuẩn Qi, tiện lợi khi sạc lại.\r\nTrang bị chuẩn chống nước IPX4, bảo vệ tai nghe an toàn dưới mưa nhỏ và mồ hôi.\r\nSản phẩm chính hãng Apple, nguyên seal 100%.', 6000, 12, 2),
(6, 'Apple', 'Tính năng nổi bật\r\n•	Xem nhanh thông tin quan trọng trên màn hình Retina\r\n•	Theo dõi nhịp tim bất cứ lúc nào với ứng dụng Nhịp Tim\r\n•	Nhận thông báo về nhịp tim nhanh và chậm\r\n•	Nhận cuộc gọi và trả lời tin nhắn ngay từ cổ tay\r\n•	Đồng bộ nhạc và podcast yêu thích\r\n•	Theo dõi hoạt động hàng ngày của bạn trên Apple Watch và xem xu hướng của bạn trong ứng dụng Thể Dục trên iPhone\r\n•	Đo lường các hoạt động thể dục của bạn như chạy, đi bộ, đạp xe, tập yoga, bơi lội và khiêu vũ\r\n•	Thiết kế chống thấm nước khi bơi lội (1)\r\n•	SOS Khẩn Cấp giúp bạn gọi xin trợ giúp ngay từ cổ tay (2)\r\n•	S3 có bộ xử lý lõi kép\r\n•	watchOS 7 sở hữu tính năng theo dõi giấc ngủ, chỉ đường khi đi xe đạp và mặt đồng hồ có thể tùy chỉnh mới\r\n•	Vỏ nhôm hiện có hai màu', 6000, 18, 2),
(7, 'Áo vest nam thời trang hàng cao cấp chuẩn form ôm dáng đẹp chuẩn từng đường kim mũi chỉ', 'AO VEST NAM MÀU ĐEN XANH THAN, XANH SÁNG, XÁM, ĐỎ MẬN , GHI SANG đẹp bắt mắt.\r\n----------------------------------------------\r\n. Thông tin sản phẩm\r\nAO VEST được may chất liệu vải tuyết cao cấp dáng đứng, có lớp lót mềm.\r\n.Độ co dãn vừa phải làm người dùng cảm thấy thoải mái nhất có thể khi sử dụng Độ co dãn vừa phải làm người dùng cảm thấy thoải mái nhất có thể khi sử dụng\r\n. Chất liệu: Vải tuyết cao cấp \r\n. Xuất xứ: Việt Nam \r\n----------------------------------------------\r\n.CÁCH CHỌN SIZE ÁO\r\n. Chọn Size Áo\r\nSIZE S:46-52 \r\nSize M:53-58kg\r\nSize L:58-68kg\r\nSize Xl: 69-74kg\r\nsize 2xl: 75-78kg\r\nsize 3xl: 78-83kg\r\nsize 4xl:83-90kg\r\n--------------------------------------------\r\n. CAM KẾT CỦA SHOP:  \r\n.Cam kết chất lượng và mẫu mã giống hình ảnh\r\n.Hoàn tiền nếu sản phẩm không giống với mô tả\r\n. Cam kết được đổi trong vòng 3 ngày. \r\n--------------------------------------------------------------\r\n#vest #vestxanh #áovest #vestnam #nam  #than  #caocấp #comple #suit #bộ #bovest #vestxanhthan #vestcuoi \r\n#vestden #vestre #vestdep #vesttuyetmua #vestadam #adam\r\n cảm ơn quý khách luôn tin tưởng ủng hộ, chúc quý khách ngày luôn vui vẻ.', 269000, 25, 1),
(8, 'Quần âu nam Trendyman thời trang nam vải lụa co giãn nhẹ quần tây nam công sở đi làm đi chơi đi học', 'Xuất xứ\r\nViệt Nam\r\nChất liệu\r\nSợi dệt, lụa\r\nKiểu dáng quần\r\nĐứng\r\nChiều dài quần\r\nCắt gấu\r\nMẫu\r\nTrơn\r\nPhong cách\r\nCơ bản, Hàn Quốc, Công sở\r\nBản eo\r\nGiữa eo\r\nLoại khóa\r\nKhóa kéo\r\nTall Fit\r\nCó\r\nKho hàng\r\n22650\r\nGửi từ\r\nQuận Thanh Xuân, Hà Nội\r\nMÔ TẢ SẢN PHẨM\r\nĐiểm Xả Hàng Giá Xưởng Trendyman\r\nShop xin phép giới thiệu đến các bạn mẫu sản phẩm mới: Quần âu nam Trendyman quần vải đi học chất lụa co giãn nhẹ quần tây nam công sở dáng đứng\r\n------------------------------------------\r\n * THÔNG TIN SẢN PHẨM:\r\n- Quần âu nam ống côn sẽ giúp các chàng trông chuẩn soái ca.\r\n- Trong tủ có e này thì cực dễ phối đồ: sơmi, thun, vest đều đẹp\r\n- Chất Liệu: Vải lụa co giãn nhẹ, mềm mịn\r\n- Chất vải đảm bảo không nhăn nhàu, lên form đứng dáng\r\n- Form Chuẩn, khoá giữa, có túi  dễ mặc và cực tiện dụng.\r\nQuần âu nam ống côn đủ size từ 28 đến 35 cho khách từ 45-80 kg mặc vừa:\r\nSize 28 : Dưới 48kg, dưới 1m58 / Chiều dài quần 90 cm, vòng bụng 74cm, ống 15 cm\r\nSize 29 : Cân nặng 49 - 53kg, cao 1m55 - 1m62 / Chiều dài quần 91cm, vòng bụng 76cm, ống 15,5 cm\r\nSize 30 : Cân nặng 54 - 57kg, cao 1m60 - 1m67 / Chiều dài quần 92cm, vòng bụng 78cm, ống côn 16 cm\r\nSize 31 : Cân nặng 57 - 63kg, cao 1m65 - 1m72 / Chiều dài quần 93cm, vòng bụng 80cm, ống côn 16,5 cm\r\nSize 32 : Cân nặng 63 - 67kg, cao 1m70 - 1m75 / Chiều dài quần 94cm, vòng bụng 82cm, ống côn 17  cm\r\nSize 33 : Cân nặng 68 - 72kg, cao 1m72 - 1m77 / Chiều dài quần 95cm, vòng bụng 84cm, ống côn 17,5 cn\r\nSize 34 : Cân nặng 72 - 75kg, cao 1m72 - 1m80 / Chiều dài quần 96 cm, vòng bụng 86cm, ống côn 18 cm\r\nSize 35 : Cân nặng 75 - 78kg, cao 1m75 - 1m85 / Chiều dài quần 98 cm, vòng bụng 88cm, ống côn 18,5 cm\r\n- Có 4 màu cơ bản: Đen, Xanh than, Ghi tối và', 78000, 43, 1),
(9, 'Giày Thể Thao Sneaker Thời Trang Nam Hot Trend 2021', '❌❌❌ LƯU Ý: KHÔNG SO SÁNH VỚI HÀNG 50 - 90K Ạ (Tiền nào của nấy) ❌❌❌\r\n\r\nGIỚI THIỆU GIÀY THỂ THAO NAM SNEAKER THỜI TRANG NAM\r\n✅ Giày được thiết kế trẻ trung, là một thiết kế dành cho phái mạnh, giày chú trọng phom dáng với từng đừng nét mạnh mẽ, làm toát lên vẻ trẻ trung, thanh lịch. Đường may tỉ mỉ và đường keo dán chắc chắn và bền bỉ trong thời gian dài.\r\n✅ Giày có kiểu dáng thể thao với mũi tròn và form ôm sát, bảo vệ chân tốt hơn đồng thời tôn lên vẻ năng động, khỏe khoắn, êm ái, giúp đôi chân dễ chịu.\r\n\r\n????[HÌNH ẢNH và MÔ TẢ]\r\n✅ Màu sắc: Trắng, Đen. \r\n✅ Chất liệu: Da PU cao cấp, Vải Canvas.\r\n✅ Đế cao su dẻo dai, độ bền cao, được sản xuất theo công nghệ mới.\r\n✅ Thiết kế dây buộc, tối giản chi tiết.\r\n✅ Đế giày được ép nhiệt kết hợp keo dán Su-Bond chắc chắn.\r\n✅ 100% ảnh thật được chúng tôi chụp bằng điện thoại cá nhân\r\n✅ Giày bền đẹp, giá phải chăng phù hợp với các bạn học sinh, sinh viên, những người đang đi làm.\r\n✅ Thích hợp đi chơi, du lịch, chạy bộ, gym, đi học, đi làm.\r\n✅ Dễ phối đồ, có thể kết hợp với, jeans, sooc,... phù hợp với mọi thời tiết từ đông sang hè.\r\n\r\n???? CAM KẾT: \r\n✅ Hoàn tiền 100% nếu nhận sản phẩm không giống hình. Tất cả các sản phẩm đăng bán đều được shop chụp hình bằng điện thoại để các bạn xem rõ chất liệu giày trước khi đặt mua (100% ảnh thật)\r\n✅ Đổi ngay hàng mới nếu nhận hàng bị lỗi, hỏng từ phía nhà sản xuất. Hỗ trợ đổi size nếu các bạn đi không vừa. \r\nLưu ý: Liên lạc ngay với chúng tôi ngay sau khi nhận hàng.\r\nTham khảo thêm các mẫu giày cực hot trên shop nhé!!\r\n-------------------------------------------------', 128000, 23, 1),
(10, 'Thước Vẽ Hình Học Đa Năng - Thước Parabol, Dụng Cụ Học Tập Toán Học Hình Học, Cho Học Sinh, Sinh Viên', '????Thước Vẽ Hình Học Đa Năng - Thước Vẽ Đa Chức Năng Toán Học Hình Học, Cho Học Sinh, Sinh Viên????\r\n\r\n\r\n✅ĐA NĂNG: Bạn có thể dùng thước đo góc để vẽ hình mong muốn, cũng có thể vẽ đường cong cung, đường song song ngang, đường thẳng song song.\r\n✅DỄ DÀNG SỬ DỤNG: Mỗi cm có một lỗ tròn để vẽ hình tròn và hình elip. Và nó có tỷ lệ rõ ràng, dễ trượt và quan sát, không dễ bị lệch.\r\n✅TIỆN ÍCH: Cho dù bạn là nghệ sĩ, sinh viên, nhà sản xuất hoa văn hay nhà thiết kế, thì chiếc thước cuộn đo này là một trợ thủ đắc lực cho công việc hay học tập của bạn.\r\n✅PHÁT TRIỂN KĨ NĂNG: Nó có thể giúp học sinh phát triển các kỹ năng thủ công cũng như trí tưởng tượng của họ để vẽ các bức tranh thiết kế khác nhau.\r\n\r\n✅Thông số kỹ thuật:\r\n      -Chất liệu: Nhựa\r\n      -Các tính năng: Đa chức năng, Quy mô rõ ràng, Dễ dàng trượt\r\n      -Kích thước: 11cm x 11cm / 4,33 \"x 4,33\" (Xấp xỉ)\r\n\r\n\r\n☪ Ghi chú:\r\nDo sự khác biệt về cài đặt ánh sáng và màn hình, màu sắc của mặt hàng có thể hơi khác so với hình ảnh.\r\nVui lòng cho phép sự khác biệt kích thước nhỏ do đo lường thủ công khác nhau.', 24000, 123, 3),
(11, 'Bộ Dụng Cụ Học Tập Thước Kẻ, Compa, Eke, Tẩy Học Toán Đầy Đủ Tiện Dụng Cho Học Sinh - Smarthome GG', '????Bộ Dụng Cụ Thước Ke, Compa, Eke, Tẩy Học Toán  Đầy Đủ Tiện Dụng Cho Học Sinh????\r\n\r\n✅NHỎ GỌN: Kích thước nhỏ gọn và trọng lượng nhẹ, dễ dàng mang theo.\r\n✅CÓ HỘP ĐỰNG: 8 phụ kiện văn phòng phẩm trong một hộp, dễ bảo quản.\r\n✅TIỆN LỢI: Công cụ văn phòng phẩm dùng để vẽ hoặc soạn thảo chuyên nghiệp hoàn hảo.\r\n✅ĐA NĂNG: Có 4 hình dạng khác nhau của thước kẻ để đáp ứng các nhu cầu khác nhau của bạn.\r\n✅Là món quà độc đáo và vô cùng hữu ích cho các bạn học sinh, sinh viên\r\n\r\n---Chi tiết sản phẩm---\r\nTên sản phẩm: Bộ thước kẻ\r\nChất liệu: Nhựa\r\nKích thước: khoảng 17.5x7.5cm / 6.89x2.95in\r\nMàu sắc: Như hình ảnh hiển thị', 60000, 21, 3),
(12, 'Bộ Hộp Bút 7 món hình Nhân vật Hoạt Hình. Dụng cụ học tập đáng yêu cho bé.', 'Bộ Hộp Bút gồm 7 món dụng cụ học tập  hình Nhân vật Hoạt Hình siêu đáng yêu dành cho bé\r\n\r\n-Bộ dụng cụ gồm: 1 hộp bút, 2 bút chì, 1 thước, 1 gọt bút chì, 1 tẩy, 1 hộp 6 màu sáp.\r\n\r\n- Kích thước: 23 x 20 x 2,5\r\n\r\n- Trọng lượng: 300g\r\n\r\n- Phân loại: Doraemon, Frozen, Happy Day, Hello Kity, Hộp nhạc hồng, Hộp nhạc xanh, McQueen Tia Chớp, Merry Chirstmas, Mickey Mouse, Minion, Pony, Princess, Spider-Man, Tsum Tsum, Unicorn.\r\n\r\n- Với thiết kế hình các nhân vật hoạt hình gần gũi với bé, màu sắt bắt mắt, giúp bé thích thú với việc học tập hơn.Bộ hộp bút  gồm các vật dụng học tập cần thiết cho bé , được thiết kế từ chất liệu tốt, bền, có thể sử dụng lâu dài. Các mẹ cũng có thể dùng sản phẩm này để làm quà sinh nhật hay các ngày lễ khác cho bé.', 52200, 56, 3),
(13, 'Balo Đẹp Nam Nữ , BaLô Công Sở, Laptop, Chống Sốc, Chống Thấm Nước, Đi Chơi, Du Lịch', 'Balo Đẹp Nam Nữ , BaLô Công Sở, Laptop, Chống Sốc, Chống Thấm Nước, Đi Chơi, Du Lịch\r\n\r\n???? Chất liệu: Vải Viscose cao cấp\r\n???? Kích thước balo: C42 x N30 x R18 cm\r\n???? Màu sắc: Đen/Xanh/Xám/Xám Đậm\r\nMã SP : BLN001\r\n\r\n✔️ Thiết kế thuận tiện và nhỏ gọn, hợp thời trang\r\n✔️ Kích thước laptop phù hợp: Máy tính 12 - 15,6inch - 16inch\r\n✔️ Thiết kế phù hợp với đường cột sống, cơ chế chống gù hiệu quả\r\n✔️ Balo có ngăn riêng biệt chống sốc laptop cực tốt\r\n✔️ Nhiều ngăn lớn nhỏ cho các tiện ích khác nhau\r\n✔️ Có thể gắn lên thanh kéo Vali\r\n✔️ Có ngăn đựng thẻ trên dây đeo vai. Dây đeo thiết kế đệm tổ ong êm ái, thoáng khí, luôn tạo cảm giác an toàn, thoải mái nhất khi đeo\r\n✔️ Thích hợp đi công tác, đi chơi, du lịch,...\r\n\r\n* THÔNG TIN THƯƠNG HIỆU:\r\n- VENLICE - Một thương hiệu hàng đầu Việt Nam về Ba Lô, Túi Xách. Chúng mình chuyên sản xuất và cung cấp những sản phẩm chất lượng cao. Nguyên liệu được nhập khẩu trực tiếp từ Đài Loan, với quy trình kiểm định, lựa chọn, thiết kế chặt chẽ. Chúng mình tự tin mang đến cho bạn sự hài lòng đối với các dòng sản phẩm của VENLICE.', 269000, 123, 4),
(14, 'BALO ULZZANG BASIC ( chống nước ) ( kèm sticker cài balo)', 'Balo ULZZANG laptop du lịch đi học mini nữ đẹp \r\n\r\nBALO ULZZANG LAPTOP ĐẸP\r\n\r\n♥️ Kích thước: 41x28x12\r\n\r\n♥️ Chất liệu: Oxford\r\n\r\n♥️ Màu sắc có màu Đen\r\n\r\n♥️ Style: Korea \r\n\r\nBALO ULZZANG NỮ không những đi học mà còn đi chơi, đi du lịch được\r\n\r\nHãy chọn cho mình 1 màu phù hợp nhé...\r\n\r\nTrong thế giới thời trang của phái đẹp BALO DU LỊCH luôn chiếm một vị trí quan trọn\r\n\r\nTừ những cô nàng bình thường nhất cho tới những ngôi sao hàng đầu, tất cả đều chia sẻ một tình yêu vĩ đại với những chiếc balo\r\n\r\nChiếc BALO ĐI HỌC hợp dáng người, hợp màu sắc làm tăng vẻ đẹp của trang phục bạn mặc và khẳng định ấn tượng của bạn trong mắt người đối diện.\r\n\r\nTuy nhiên, không phải ai cũng biết chọn một chiếc balo thực sự phù hợp với phom cơ thể của mình.\r\n\r\nMang tới cho các cô nàng sự thoải mái khi đi dạo phố hoặc hẹn hò bè bạn vì không phải cầm mang những vật dụng linh tinh, balo đã trở thành người bạn không thể thiếu các nàng.\r\n\r\nChúng có sự đa dạng từ kiểu cách tới màu sắc, size…tùy theo nhu cầu của mình mà các nàng lựa chọn một sản phẩm thích hợp.\r\n\r\nVà nếu bạn cũng đang đi tìm một balo thể thể hiện được cá tính của bản thân một cách rõ nét nhất và đang... lạc lối, thì hãy cùng khám phá và cảm nhận những nét đẹp và quyến rũ của', 159000, 33, 4);

-- --------------------------------------------------------

--
-- Table structure for table `hinhhanghoa`
--

CREATE TABLE `hinhhanghoa` (
  `MaHinh` int(11) NOT NULL,
  `TenHinh` varchar(200) NOT NULL,
  `MSHH` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hinhhanghoa`
--

INSERT INTO `hinhhanghoa` (`MaHinh`, `TenHinh`, `MSHH`) VALUES
(1, 'assets/img/product/camera.jpg', 1),
(2, 'assets/img/product/iheadPhone.png', 2),
(3, 'assets/img/product/imacbook.png', 3),
(4, 'assets/img/product/iphone-12.png', 4),
(5, 'assets/img/product/ipod.png', 5),
(6, 'assets/img/product/iwatch.png', 6),
(7, 'assets/img/product/vest.jpg', 7),
(8, 'assets/img/product/quan_tay.jpg', 8),
(9, 'assets/img/product/giay.jpg', 9),
(10, 'assets/img/product/thuoc_ke.jpg', 10),
(11, 'assets/img/product/2028ab5ce17f8155c5313475218aa021.jpg', 11),
(12, 'assets/img/product/63af5b8422a0f8e03ba9698e24206cf3.jpg', 12),
(13, 'assets/img/product/84bff14cc3483ee5f7b28f2a61ef21be.jpg', 13),
(14, 'assets/img/product/2295c66147ec9e1d187bf345fe26adfa.jpg', 14);

-- --------------------------------------------------------

--
-- Table structure for table `khachhang`
--

CREATE TABLE `khachhang` (
  `MSKH` int(11) NOT NULL,
  `HoTenKH` varchar(50) NOT NULL,
  `TenCongTy` varchar(200) NOT NULL,
  `SoDienThoai` varchar(12) NOT NULL,
  `SoFax` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `khachhang`
--

INSERT INTO `khachhang` (`MSKH`, `HoTenKH`, `TenCongTy`, `SoDienThoai`, `SoFax`) VALUES
(1, 'Tao Tung Thieu', 'Mobifone', '84931234541', '84931234540'),
(2, 'Van Ong Trong', 'PepSy', '84931234500', '84931234500'),
(3, 'Trương Vô Kỵ', 'Vitaco', '84931234501', '84931234501');

-- --------------------------------------------------------

--
-- Table structure for table `loaihanghoa`
--

CREATE TABLE `loaihanghoa` (
  `MaLoaiHang` int(11) NOT NULL,
  `TenLoaiHang` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `loaihanghoa`
--

INSERT INTO `loaihanghoa` (`MaLoaiHang`, `TenLoaiHang`) VALUES
(1, 'Thời Trang'),
(2, 'Thiết bị điện tử'),
(3, 'Dụng cụ học tập'),
(4, 'Khác');

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

CREATE TABLE `nhanvien` (
  `MSNV` int(11) NOT NULL,
  `HoTenNV` varchar(50) NOT NULL,
  `ChucVu` varchar(50) NOT NULL,
  `DiaChi` varchar(200) NOT NULL,
  `SoDienThoai` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nhanvien`
--

INSERT INTO `nhanvien` (`MSNV`, `HoTenNV`, `ChucVu`, `DiaChi`, `SoDienThoai`) VALUES
(1, 'admin', 'admin', '', ''),
(2, 'Nguyen Nhan Vien', 'Nhan Vien', 'Cai Rang', '012345214'),
(3, 'Tran Lam Thue', 'Nhan Vien Kiem Hang', 'O Min', '0787450184');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_admin`
--
ALTER TABLE `account_admin`
  ADD PRIMARY KEY (`username`),
  ADD KEY `MSNV` (`MSNV`);

--
-- Indexes for table `account_user`
--
ALTER TABLE `account_user`
  ADD PRIMARY KEY (`username`),
  ADD KEY `MSKH` (`MSKH`);

--
-- Indexes for table `chitietdathang`
--
ALTER TABLE `chitietdathang`
  ADD PRIMARY KEY (`SoDonDH`,`MSHH`),
  ADD KEY `MSHH` (`MSHH`);

--
-- Indexes for table `dathang`
--
ALTER TABLE `dathang`
  ADD PRIMARY KEY (`SoDonDH`),
  ADD KEY `MSKH` (`MSKH`),
  ADD KEY `MSNV` (`MSNV`);

--
-- Indexes for table `diachikh`
--
ALTER TABLE `diachikh`
  ADD PRIMARY KEY (`MaDC`),
  ADD KEY `MSKH` (`MSKH`);

--
-- Indexes for table `hanghoa`
--
ALTER TABLE `hanghoa`
  ADD PRIMARY KEY (`MSHH`),
  ADD KEY `MaLoaiHang` (`MaLoaiHang`);

--
-- Indexes for table `hinhhanghoa`
--
ALTER TABLE `hinhhanghoa`
  ADD PRIMARY KEY (`MaHinh`),
  ADD KEY `MSHH` (`MSHH`);

--
-- Indexes for table `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`MSKH`);

--
-- Indexes for table `loaihanghoa`
--
ALTER TABLE `loaihanghoa`
  ADD PRIMARY KEY (`MaLoaiHang`);

--
-- Indexes for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`MSNV`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dathang`
--
ALTER TABLE `dathang`
  MODIFY `SoDonDH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `diachikh`
--
ALTER TABLE `diachikh`
  MODIFY `MaDC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `hanghoa`
--
ALTER TABLE `hanghoa`
  MODIFY `MSHH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `hinhhanghoa`
--
ALTER TABLE `hinhhanghoa`
  MODIFY `MaHinh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `MSKH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `loaihanghoa`
--
ALTER TABLE `loaihanghoa`
  MODIFY `MaLoaiHang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `MSNV` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_admin`
--
ALTER TABLE `account_admin`
  ADD CONSTRAINT `account_admin_ibfk_1` FOREIGN KEY (`MSNV`) REFERENCES `nhanvien` (`MSNV`);

--
-- Constraints for table `account_user`
--
ALTER TABLE `account_user`
  ADD CONSTRAINT `account_user_ibfk_1` FOREIGN KEY (`MSKH`) REFERENCES `khachhang` (`MSKH`);

--
-- Constraints for table `chitietdathang`
--
ALTER TABLE `chitietdathang`
  ADD CONSTRAINT `chitietdathang_ibfk_1` FOREIGN KEY (`MSHH`) REFERENCES `hanghoa` (`MSHH`),
  ADD CONSTRAINT `chitietdathang_ibfk_2` FOREIGN KEY (`SoDonDH`) REFERENCES `dathang` (`SoDonDH`);

--
-- Constraints for table `dathang`
--
ALTER TABLE `dathang`
  ADD CONSTRAINT `dathang_ibfk_1` FOREIGN KEY (`MSKH`) REFERENCES `khachhang` (`MSKH`),
  ADD CONSTRAINT `dathang_ibfk_2` FOREIGN KEY (`MSNV`) REFERENCES `nhanvien` (`MSNV`);

--
-- Constraints for table `diachikh`
--
ALTER TABLE `diachikh`
  ADD CONSTRAINT `diachikh_ibfk_1` FOREIGN KEY (`MSKH`) REFERENCES `khachhang` (`MSKH`);

--
-- Constraints for table `hanghoa`
--
ALTER TABLE `hanghoa`
  ADD CONSTRAINT `hanghoa_ibfk_1` FOREIGN KEY (`MaLoaiHang`) REFERENCES `loaihanghoa` (`MaLoaiHang`);

--
-- Constraints for table `hinhhanghoa`
--
ALTER TABLE `hinhhanghoa`
  ADD CONSTRAINT `hinhhanghoa_ibfk_1` FOREIGN KEY (`MSHH`) REFERENCES `hanghoa` (`MSHH`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
