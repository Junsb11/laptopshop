-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 18, 2024 lúc 06:24 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `laptop`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bao_hanh`
--

CREATE TABLE `bao_hanh` (
  `MaBH` int(11) NOT NULL,
  `TenDangNhap` varchar(50) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `LyDo` varchar(255) NOT NULL,
  `NgayYeuCau` date DEFAULT curdate(),
  `TrangThai` int(11) DEFAULT NULL,
  `GhiChu` varchar(255) DEFAULT NULL,
  `NgayHen` datetime DEFAULT NULL,
  `NgayHoanThanh` date DEFAULT NULL,
  `MaNV` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chat_history`
--

CREATE TABLE `chat_history` (
  `id` int(11) NOT NULL,
  `user_message` text NOT NULL,
  `bot_response` text NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chi_tiet_bao_hanh`
--

CREATE TABLE `chi_tiet_bao_hanh` (
  `MaCT_BH` int(11) NOT NULL,
  `MaBH` int(11) NOT NULL,
  `MoTaLChiTiet` text DEFAULT NULL,
  `SoLuongMua` int(11) DEFAULT NULL,
  `DonGia` decimal(11,2) DEFAULT NULL,
  `MaHD` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chi_tiet_hoa_don`
--

CREATE TABLE `chi_tiet_hoa_don` (
  `MaCT_HD` int(11) NOT NULL,
  `MaHD` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `TenKH` varchar(50) DEFAULT NULL,
  `GiaGoc` double DEFAULT NULL,
  `TyLeKM` double DEFAULT NULL,
  `SoLuongMua` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chi_tiet_hoa_don`
--

INSERT INTO `chi_tiet_hoa_don` (`MaCT_HD`, `MaHD`, `MaSP`, `TenKH`, `GiaGoc`, `TyLeKM`, `SoLuongMua`) VALUES
(1, 1, 83, 'Lê Trang', 40190000, 0, 1),
(2, 2, 83, 'Lê Trang', 40190000, 0, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chi_tiet_khuyen_mai`
--

CREATE TABLE `chi_tiet_khuyen_mai` (
  `MaCTKM` int(11) NOT NULL,
  `MaKM` int(11) NOT NULL,
  `MaCode` varchar(50) NOT NULL,
  `TyLeKM` double NOT NULL,
  `GhiChu` varchar(50) DEFAULT NULL,
  `SoLuong` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhgia`
--

CREATE TABLE `danhgia` (
  `MaDG` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `TenDangNhap` varchar(50) DEFAULT NULL,
  `SoSao` int(11) DEFAULT NULL,
  `NoiDung` varchar(50) DEFAULT NULL,
  `NgayDG` date DEFAULT NULL,
  `TrangThai` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danh_muc`
--

CREATE TABLE `danh_muc` (
  `MaDM` int(11) NOT NULL,
  `TenDM` varchar(50) DEFAULT NULL,
  `TrangThai` bit(1) DEFAULT NULL,
  `MaThue` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `danh_muc`
--

INSERT INTO `danh_muc` (`MaDM`, `TenDM`, `TrangThai`, `MaThue`) VALUES
(1, 'Gaming', b'1', 1),
(18, 'MacBook', b'1', NULL),
(23, 'Học tập, Văn phòng', b'1', NULL),
(24, 'Đồ họa, Kỹ thuật', b'1', NULL),
(26, 'Cao cấp, sang trọng', b'1', NULL),
(27, 'Cũ', b'1', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoa_don`
--

CREATE TABLE `hoa_don` (
  `MaHD` int(11) NOT NULL,
  `TenDangNhap` varchar(50) DEFAULT NULL,
  `NgayHD` date DEFAULT NULL,
  `SDT` varchar(15) DEFAULT NULL,
  `DiaChi` varchar(255) DEFAULT NULL,
  `HoTenNN` varchar(100) DEFAULT NULL,
  `GhiChu` varchar(100) DEFAULT NULL,
  `TrangThai` int(4) DEFAULT 0,
  `MaNV` int(11) NOT NULL,
  `NgayDuyet` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `hoa_don`
--

INSERT INTO `hoa_don` (`MaHD`, `TenDangNhap`, `NgayHD`, `SDT`, `DiaChi`, `HoTenNN`, `GhiChu`, `TrangThai`, `MaNV`, `NgayDuyet`) VALUES
(1, 'trang', '2024-12-16', '0777478157', 'Đà Nẵng', 'Lê Trang', '', 0, 0, NULL),
(2, 'trang', '2024-12-17', '0777478157', 'Đà Nẵng', 'Lê Trang', '', 0, 0, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoa_don_online`
--

CREATE TABLE `hoa_don_online` (
  `MaHD` int(11) NOT NULL,
  `TenKH` varchar(255) NOT NULL,
  `SoDienThoai` varchar(15) NOT NULL,
  `DiaChi` text NOT NULL,
  `GhiChu` text DEFAULT NULL,
  `TenChuTaiKhoan` varchar(255) NOT NULL,
  `SoTaiKhoan` varchar(50) NOT NULL,
  `NoiDungChuyenKhoan` text NOT NULL,
  `LoaiChuyenKhoan` varchar(50) NOT NULL,
  `NgayHD` date NOT NULL,
  `TongTien` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khuyen_mai`
--

CREATE TABLE `khuyen_mai` (
  `MaKM` int(11) NOT NULL,
  `TenKM` varchar(50) NOT NULL,
  `TuNgay` datetime DEFAULT NULL,
  `DenNgay` datetime DEFAULT NULL,
  `TrangThai` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `khuyen_mai`
--

INSERT INTO `khuyen_mai` (`MaKM`, `TenKM`, `TuNgay`, `DenNgay`, `TrangThai`) VALUES
(1, 'giảm 5%', '2024-12-15 00:00:00', '2024-12-20 00:00:00', b'1'),
(2, 'giảm 10%', '0000-00-00 00:00:00', '0000-00-00 00:00:00', b'1'),
(3, 'giảm 15%', '2024-12-15 00:00:00', '2024-12-20 00:00:00', b'1'),
(4, 'giảm 20%', '2024-12-15 00:00:00', '2024-12-20 00:00:00', b'1'),
(5, 'giảm 25%', '2024-12-15 00:00:00', '2024-12-20 00:00:00', b'1'),
(6, 'giảm 30%', '2024-12-15 00:00:00', '2024-12-20 00:00:00', b'1'),
(7, 'giảm 35%', '2024-12-15 00:00:00', '2024-12-20 00:00:00', b'1'),
(8, 'giảm 40%', '2024-12-15 00:00:00', '2024-12-20 00:00:00', b'1'),
(9, 'Giảm 45%', '2024-12-15 00:00:00', '2024-12-20 00:00:00', b'1'),
(10, 'Khách Hàng Mới', '2024-12-15 00:00:00', '2024-12-31 00:00:00', b'1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loai_tk`
--

CREATE TABLE `loai_tk` (
  `MaLoai` int(11) NOT NULL,
  `TenLoai` varchar(50) DEFAULT NULL,
  `TrangThai` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `loai_tk`
--

INSERT INTO `loai_tk` (`MaLoai`, `TenLoai`, `TrangThai`) VALUES
(1, 'user', b'1'),
(2, 'admin', b'1'),
(3, 'quanly', b'1'),
(4, 'kythuat', b'1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `log_khuyen_mai`
--

CREATE TABLE `log_khuyen_mai` (
  `LogID` int(11) NOT NULL,
  `MaKM` int(11) DEFAULT NULL,
  `TenDangNhap` varchar(50) DEFAULT NULL,
  `Action` varchar(50) DEFAULT NULL,
  `ActionTime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhan_vien`
--

CREATE TABLE `nhan_vien` (
  `MaNV` int(11) NOT NULL,
  `HoTen` varchar(50) NOT NULL,
  `NgaySinh` date DEFAULT NULL,
  `DiaChi` varchar(100) DEFAULT NULL,
  `NgayVaoLam` date NOT NULL,
  `LuongCB` decimal(10,2) DEFAULT NULL,
  `VaiTro` enum('Quản lý','Kỹ Thuật','Kho') NOT NULL,
  `SDT` varchar(15) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `TrangThai` bit(1) DEFAULT NULL,
  `GhiChu` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nhan_vien`
--

INSERT INTO `nhan_vien` (`MaNV`, `HoTen`, `NgaySinh`, `DiaChi`, `NgayVaoLam`, `LuongCB`, `VaiTro`, `SDT`, `Email`, `TrangThai`, `GhiChu`) VALUES
(1, 'Lê Trang', '1999-12-25', 'Đà Nẵng', '2024-10-28', 10000000.00, 'Quản lý', '0777478157', 'lt25121999@gmail.com', b'1', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhap_xuat`
--

CREATE TABLE `nhap_xuat` (
  `MaNhapXuat` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `GiaNhap` double DEFAULT NULL,
  `GiaXuat` double DEFAULT NULL,
  `NgayApDung` date DEFAULT NULL,
  `SoLuong` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `thanh_vien` varchar(100) NOT NULL COMMENT 'thành viên thanh toán',
  `money` float NOT NULL COMMENT 'số tiền thanh toán',
  `note` varchar(255) DEFAULT NULL COMMENT 'ghi chú thanh toán',
  `vnp_response_code` varchar(255) NOT NULL COMMENT 'mã phản hồi',
  `code_vnpay` varchar(255) NOT NULL COMMENT 'mã giao dịch vnpay',
  `code_bank` varchar(255) NOT NULL COMMENT 'mã ngân hàng',
  `time` datetime NOT NULL COMMENT 'thời gian chuyển khoản'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `san_pham`
--

CREATE TABLE `san_pham` (
  `MaSP` int(11) NOT NULL,
  `TenSP` varchar(50) DEFAULT NULL,
  `DonGia` double DEFAULT NULL,
  `HinhAnh` varchar(50) DEFAULT NULL,
  `MaDM` int(11) DEFAULT NULL,
  `TrangThai` bit(1) DEFAULT NULL,
  `MoTa` varchar(2000) DEFAULT NULL,
  `so_luong` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `san_pham`
--

INSERT INTO `san_pham` (`MaSP`, `TenSP`, `DonGia`, `HinhAnh`, `MaDM`, `TrangThai`, `MoTa`, `so_luong`) VALUES
(50, 'Laptop Asus TUF Gaming FX506LHB i5 10300H/8GB/512G', 20990000, 'upload/gm1.jpg', 1, b'1', '<p>Nếu bạn đang t&igrave;m kiếm một chiếc laptop gaming nhưng vẫn sở hữu một mức gi&aacute; phải chăng th&igrave; laptop <strong>Asus TUF Gaming FX506LHB i5 (HN188W)</strong> sẽ l&agrave; sự lựa chọn đ&aacute;ng c&acirc;n nhắc với card đồ họa rời NVIDIA GeForce GTX mạnh mẽ c&ugrave;ng phong c&aacute;ch thiết kế cứng c&aacute;p, độc đ&aacute;o.</p>\r\n<p>&bull; Chạy mượt m&agrave; c&aacute;c ứng dụng văn ph&ograve;ng tr&ecirc;n Word, Excel, PowerPoint,... đến chiến những con game đ&igrave;nh đ&aacute;m nhờ bộ vi xử l&yacute; Intel Core i5 10300H kết hợp với card đồ họa rời NVIDIA GeForce GTX 1650 4 GB mạnh mẽ.</p>\r\n<p>&bull; Laptop Asus đa nhiệm mượt m&agrave; tr&ecirc;n nhiều cửa sổ Chrome c&ugrave;ng l&uacute;c nhờ bộ nhớ RAM 8 GB, b&ecirc;n cạnh đ&oacute; c&ograve;n mang đến tốc độ khởi động m&aacute;y v&agrave; ứng dụng nhanh ch&oacute;ng với ổ cứng SSD 512 GB.&nbsp;&nbsp;</p>\r\n<p>&bull; Laptop c&oacute; k&iacute;ch thước m&agrave;n h&igrave;nh 15.6 inch c&ugrave;ng tần số qu&eacute;t 144 Hz mang đến những trải nghiệm chiến game cực đỉnh, kh&ocirc;ng bị giật lag hay x&eacute; h&igrave;nh khi chơi những tựa game c&oacute; tốc độ cao.</p>\r\n<p>&bull; Laptop Asus TUF Gaming được bao bọc bởi lớp vỏ nhựa m&agrave;u đen huyền b&iacute;, khối lượng 2.3 kg cho ph&eacute;p bạn chiến game ở mọi kh&ocirc;ng gian.</p>\r\n<p>&bull; M&aacute;y được trang bị đ&egrave;n b&agrave;n ph&iacute;m chuyển m&agrave;u RGB độc đ&aacute;o, tăng độ hăng h&aacute;i cho game thủ mỗi khi chiến game.</p>', 100),
(51, 'Laptop Lenovo Ideapad Gaming 3 15IAH7 i5 12500H/8G', 23190000, 'upload/gm2.jpg', 1, b'1', '<p>Laptop <strong>Lenovo Ideapad Gaming 3 15IAH7 i5 (82S9007TVN)</strong> thuộc d&ograve;ng laptop gaming mang vẻ đẹp ấn tượng, cuốn h&uacute;t nhưng kh&ocirc;ng k&eacute;m phần mạnh mẽ nhờ v&agrave;o CPU Intel Gen 12, sẵn s&agrave;ng đồng h&agrave;nh c&ugrave;ng bạn tr&ecirc;n mọi đấu trường game hiện nay.</p>\r\n<p><strong>Thiết kế hầm hố, c&aacute; t&iacute;nh với gam m&agrave;u trắng cuốn h&uacute;t</strong></p>\r\n<p>Lenovo IdeaPad Gaming 3 sở hữu một thiết kế g&oacute;c cạnh c&ugrave;ng gam m&agrave;u trắng pha lẫn c&aacute;c chi tiết xanh tạo n&ecirc;n một tổng thể v&ocirc; c&ugrave;ng mạnh mẽ, hầm hố nhưng kh&ocirc;ng k&eacute;m phần sang trọng. Tuy c&oacute; lớp vỏ từ nhựa nhưng cảm gi&aacute;c cầm nắm, x&aacute;ch l&ecirc;n di chuyển rất chắc chắn v&agrave; kh&ocirc;ng ọp ẹp.</p>\r\n<p><strong>Cấu h&igrave;nh mạnh mẽ, chiến game v&ocirc; tư c&ugrave;ng bạn</strong></p>\r\n<p>Laptop Lenovo Ideapad Gaming trang bị bộ vi xử l&yacute; Intel Core i5 Alder Lake 12500H, với sự kết hợp giữa nh&acirc;n hiệu năng mạnh P-core v&agrave; nh&acirc;n tiết kiệm E-core gi&uacute;p hiệu suất hoạt động của CPU cao hơn đ&aacute;ng kể so với c&aacute;c thế hệ đi trước, từ đ&oacute; c&oacute; thể giải quyết c&aacute;c t&aacute;c vụ l&agrave;m việc, chơi game của bạn một c&aacute;ch nhẹ nh&agrave;ng v&agrave; nhanh ch&oacute;ng. C&aacute;c th&ocirc;ng số thu được khi m&igrave;nh sử dụng phần mềm Cinebench R23 lần lượt l&agrave; 1597 ở đơn nh&acirc;n v&agrave; 10461 ở đa nh&acirc;n. Một số điểm tương đối cao so với d&ograve;ng laptop gaming c&oacute; mức gi&aacute; phổ th&ocirc;ng.</p>\r\n<p>Card đồ họa rời NVIDIA GeForce RTX 3050 4 GB c&oacute; thể c&acirc;n tốt cho bạn c&aacute;c tựa game thịnh h&agrave;nh hiện nay như Li&ecirc;n Minh Huyền Thoại, CS:GO, GTA V,... hơn hết bạn c&oacute; thể thỏa sức s&aacute;ng tạo với c&aacute;c phần mềm thiết kế của Adobe: Photoshop, Illustrator, Premiere,... một c&aacute;ch mượt m&agrave; v&agrave; nhẹ nh&agrave;ng.</p>', 100),
(52, 'Laptop Asus TUF Gaming FX517ZC i5 12450H/8GB/512GB', 28990000, 'upload/gm3.jpg', 1, b'1', '<p>Sở hữu ngoại h&igrave;nh ấn tượng thu h&uacute;t mọi &aacute;nh nh&igrave;n c&ugrave;ng hiệu năng mạnh mẽ đến từ laptop CPU thế hệ 12 mới nhất, <strong>Asus TUF Gaming FX517ZC i5 12450H (HN077W)</strong> l&agrave; lựa chọn xứng tầm cho mọi nhu cầu chiến game giải tr&iacute; hay đồ hoạ - kỹ thuật của người d&ugrave;ng.</p>\r\n<p>&bull; Laptop Asus TUF mang hiệu năng vượt trội cho khả năng giải quyết trơn tru c&aacute;c t&aacute;c vụ phức tạp như thiết kế h&igrave;nh ảnh, render video,... tr&ecirc;n c&aacute;c ứng dụng nh&agrave; Adobe hay thoả sức chiến c&aacute;c tựa game hot như CS:GO, GTA V,... nhờ trang bị chip Intel Core i5 Alder Lake 12450H c&ugrave;ng card rời NVIDIA RTX 3050, 4 GB.</p>\r\n<p>&bull; RAM 8 GB chuẩn DDR5 ti&ecirc;n tiến, mang đến khả năng đa nhiệm mượt m&agrave;. SSD 512 GB hỗ trợ truy xuất dữ liệu nhanh, r&uacute;t ngắn thời gian chờ. Ngo&agrave;i ra, m&aacute;y n&agrave;y cũng hỗ trợ n&acirc;ng cấp để gia tăng năng suất l&agrave;m việc của bạn.</p>\r\n<p>&bull; M&agrave;n h&igrave;nh 15.6 inch phủ tấm nền IPS c&oacute; khả năng t&aacute;i tạo m&agrave;u tốt, mở rộng g&oacute;c nh&igrave;n l&ecirc;n đến 178 độ. C&ocirc;ng nghệ Anti Glare hỗ trợ chống ch&oacute;i, lo&aacute; mờ tr&ecirc;n m&agrave;n h&igrave;nh, bảo vệ thị gi&aacute;c người d&ugrave;ng.</p>\r\n<p>&bull; L&agrave;m chủ mọi trận game, giảm độ trễ nhờ tần số qu&eacute;t 144 Hz kết hợp c&ocirc;ng nghệ Adaptive-Sync tr&ecirc;n laptop Asus gi&uacute;p loại bỏ những vấn đề như giật, x&eacute; h&igrave;nh mang lại cho bạn trải nghiệm giải tr&iacute;, chơi game ổn định hơn bao giờ hết.</p>\r\n<p>&bull; Được chế t&aacute;c từ vỏ nhựa cứng c&aacute;p đi k&egrave;m l&agrave; sắc x&aacute;m hiện đại với những đường cắt tinh xảo, khơi nguồn cảm hứng chiến game. Khối lượng chỉ 2 kg sẵn s&agrave;ng b&ecirc;n cạnh phục vụ bạn mọi l&uacute;c, tr&ecirc;n mọi chiến trường ảo.</p>\r\n<p>&bull; HD Webcam hỗ trợ c&aacute;c cuộc gọi video hay học trực tuyến dễ d&agrave;ng hơn nhờ chất lượng h&igrave;nh ảnh ổn đ', 100),
(53, 'Laptop MSI Gaming Alpha 15 B5EEK R7 5800H/16GB/512', 32490000, 'upload/gm4.jpg', 1, b'1', '<p>Một si&ecirc;u phẩm xứng đ&aacute;ng được c&aacute;c game thủ mong đợi ch&iacute;nh l&agrave; chiếc laptop <strong>MSI Gaming Alpha 15 B5EEK R7 (218VN)</strong> khi sở hữu nguồn sức mạnh bộc ph&aacute; đến từ bộ vi xử l&yacute; AMD 5800H c&ugrave;ng card đồ họa rời RX 6600M 8 GB, lu&ocirc;n sẵn s&agrave;ng c&ugrave;ng m&igrave;nh khuấy động mọi chiến trường ảo.</p>\r\n<p><strong>Chinh phục mọi chiến trường ảo</strong></p>\r\n<p>Laptop MSI Gaming Alpha được trang bị bộ vi xử l&yacute; AMD Ryzen 7 5800H mạnh mẽ, m&igrave;nh đ&atilde; thử đo hiệu năng bằng c&ocirc;ng cụ Cinebench R23 th&igrave; kh&ocirc;ng ch&ecirc;nh lệch nhiều so với d&ograve;ng AMD Ryzen 7 6800H do c&oacute; c&ugrave;ng cấu tr&uacute;c 8 nh&acirc;n v&agrave; 16 luồng, so về mặt tổng thể chỉ hơn khoảng 6% đến 8%.</p>\r\n<p><strong>Kh&ocirc;ng gian hiển thị lớn, chuyển động h&igrave;nh ảnh mượt m&agrave;</strong></p>\r\n<p>Kh&ocirc;ng gian m&agrave;n h&igrave;nh lớn 15.6 inch cho m&igrave;nh trải nghiệm chiến game cực đ&atilde;, độ ph&acirc;n giải Full HD (1920 x 1080) đảm bảo lu&ocirc;n hiển thị h&igrave;nh ảnh với độ chi tiết cao, m&agrave;u sắc cũng được t&aacute;i tạo sống động, nịnh mắt khi chơi game hay xem những bộ phim h&agrave;nh động.</p>\r\n<p>Nhờ c&oacute; tấm nền IPS v&agrave; c&ocirc;ng nghệ chống ch&oacute;i Anti Glare gi&uacute;p n&acirc;ng cao g&oacute;c nh&igrave;n, hạn chế t&igrave;nh trạng hắt s&aacute;ng n&ecirc;n m&igrave;nh c&oacute; thể tự tin x&aacute;ch m&aacute;y ra những nơi c&oacute; &aacute;nh s&aacute;ng cao như qu&aacute;n c&agrave; ph&ecirc; để chiến game c&ugrave;ng bạn b&egrave;.</p>', 99),
(54, 'Laptop MSI Creator Z16P B12UGST i7 12700H/32GB/2TB', 78990000, 'upload/gm5.jpg', 1, b'1', '<p>Tuyệt t&aacute;c của sự ho&agrave;n mỹ trong thiết kế c&ugrave;ng cấu h&igrave;nh cực mạnh từ laptop CPU thế hệ 12 tạo n&ecirc;n chiếc laptop <strong>MSI Creator Z16P B12UGST (050VN).</strong> Sản phẩm l&agrave; sự lựa chọn ho&agrave;n hảo cho người l&agrave;m s&aacute;ng tạo nghệ thuật, thiết kế đồ hoạ.</p>\r\n<p>&bull; Laptop MSI Creator mang trong m&igrave;nh cấu h&igrave;nh mạnh mẽ vượt trội của CPU Intel Core i7 12700H tiết kiệm điện năng hơn thế hệ cũ, kết hợp card m&agrave;n h&igrave;nh rời NVIDIA RTX 3070Ti Max-Q 8 GB gi&uacute;p xử l&yacute; tr&ocirc;i chảy c&aacute;c t&aacute;c vụ trong thời gian ngắn, sẵn s&agrave;ng chinh phục mọi thử th&aacute;ch s&aacute;ng tạo, ho&agrave; m&igrave;nh v&agrave;o kh&ocirc;ng gian l&agrave;m việc thăng hoa nhất.</p>\r\n<p>&bull; Laptop MSI được trang bị 32 GB RAM với d&ograve;ng DDR5 thế hệ mới cho khả năng đa nhiệm thoải m&aacute;i, hiệu suất ấn tượng, l&agrave;m việc chuy&ecirc;n nghiệp kh&ocirc;ng sợ t&igrave;nh trạng giật lag xảy ra. Bộ nhớ trong SSD 2 TB đem lại kh&ocirc;ng gian lưu trữ rộng r&atilde;i, tốc độ truy xuất dữ liệu hay khởi động ứng dụng, laptop đều cực nhanh.</p>\r\n<p>&bull; Laptop m&agrave;n h&igrave;nh cảm ứng 16 inch với độ ph&acirc;n giải QHD+ (2560 x 1600), tần số qu&eacute;t 165 Hz, 100% DCI-P3 mang lại chất lượng hiển thị sắc n&eacute;t, m&agrave;u sắc chuẩn x&aacute;c phục vụ cho nhu cầu l&agrave;m đồ hoạ n&acirc;ng cao. Tấm nền IPS mở rộng g&oacute;c nh&igrave;n người d&ugrave;ng l&ecirc;n đến 178 độ.</p>\r\n<p>&bull; Được ho&agrave;n thiện từ vỏ kim loại sang trọng, đẳng cấp tạo n&ecirc;n một sức h&uacute;t m&atilde;nh liệt. Chiếc m&aacute;y c&oacute; khối lượng 2.39 kg, độ mỏng 19 mm vừa vặn trong chiếc balo để mang theo b&ecirc;n người.</p>', 100),
(56, 'Laptop MSI Gaming GS66 Stealth 11UG i7 11800H/32GB', 64990000, 'upload/gm7.jpg', 1, b'1', '<p>Xứng danh tay chơi cự ph&aacute;ch nơi đ&ocirc; thị sầm uất, laptop <strong>MSI Gaming GS66 Stealth 11UG i7 11800H (219VN)</strong> với vẻ ngo&agrave;i đầy mạnh mẽ c&ugrave;ng sức mạnh tuyệt hảo, ph&aacute;t huy hiệu suất tối ưu v&agrave; khả năng chiến game cực đ&atilde; c&ugrave;ng đồng đội.</p>\r\n<p><strong>Ấn tượng với vẻ ngo&agrave;i sắc sảo, ph&aacute; vỡ mọi giới hạn</strong></p>\r\n<p>Sở hữu kiểu d&aacute;ng cơ động với thiết kế đen nh&aacute;m mang phong c&aacute;ch ch&acirc;n phương, c&ugrave;ng lớp vỏ kim loại được gia cường cứng c&aacute;p, đ&atilde; mang đến một phi&ecirc;n bản laptop đầy mạnh mẽ, sẵn s&agrave;ng trở th&agrave;nh người cộng sự đ&aacute;ng tin cậy, đ&aacute;p ứng tốt mọi nhu cầu của bạn.</p>\r\n<p>Laptop MSI Gaming vẫn l&agrave; một chiếc laptop di động, linh hoạt trong ph&acirc;n kh&uacute;c gaming với khối lượng chỉ 2.1 kg v&agrave; độ d&agrave;y 19.8 mm, đồng h&agrave;nh c&ugrave;ng bạn đến bất cứ đ&acirc;u, phục vụ tốt cho c&aacute;c nhu cầu chơi game giải tr&iacute; lẫn l&agrave;m việc đầy chuy&ecirc;n nghiệp.</p>\r\n<p><strong>Đột ph&aacute; với sức mạnh hiệu năng đến từ bộ vi xử l&yacute; Intel Gen 11</strong></p>\r\n<p>Đ&aacute;p ứng mọi t&aacute;c vụ c&ocirc;ng việc hay thỏa sức tận hưởng những trận game một c&aacute;ch mượt m&agrave; nhờ chip Intel Core i7 Tiger Lake 11800H với cấu tr&uacute;c 8 nh&acirc;n 16 luồng, tốc độ xung nhịp trung b&igrave;nh 2.30 GHz v&agrave; đạt tối đa l&ecirc;n đến 4.6 GHz nhờ Turbo Boost.</p>', 100),
(57, 'Laptop Apple MacBook Air M1 2020 8GB/256GB/7-core ', 27490000, 'upload/mb1.jpg', 18, b'1', '<p>Laptop <strong>Apple MacBook Air M1 2020</strong> thuộc d&ograve;ng laptop cao cấp sang trọng c&oacute; cấu h&igrave;nh mạnh mẽ, chinh phục được c&aacute;c t&iacute;nh năng văn ph&ograve;ng lẫn đồ hoạ m&agrave; bạn mong muốn, thời lượng pin d&agrave;i, thiết kế mỏng nhẹ sẽ đ&aacute;p ứng tốt c&aacute;c nhu cầu l&agrave;m việc của bạn.</p>\r\n<p><strong>Chip Apple M1 tốc độ xử l&yacute; nhanh gấp 3.5 lần thế hệ trước</strong></p>\r\n<p>Chiếc MacBook n&agrave;y được trang bị con chip Apple M1 được sản xuất độc quyền bởi Nh&agrave; T&aacute;o tr&ecirc;n tiến tr&igrave;nh 5 nm, 8 l&otilde;i bao gồm 4 l&otilde;i tiết kiệm điện v&agrave; 4 l&otilde;i hiệu suất cao, mang đến một hiệu năng kinh ngạc, xử l&yacute; mọi t&aacute;c vụ văn ph&ograve;ng một c&aacute;ch mượt m&agrave; như Word, Excel, Powerpoint,... thực hiện tốt c&aacute;c nhiệm vụ chỉnh sửa h&igrave;nh ảnh, kết xuất 2D tr&ecirc;n c&aacute;c phần mềm Photoshop, AI,... m&aacute;y c&ograve;n hỗ trợ tiết kiệm được điện năng cao.</p>\r\n<p><strong>Thiết kế sang trọng, tinh tế</strong></p>\r\n<p>MacBook Air M1 256GB 2020 kh&ocirc;ng những thừa hưởng thiết kế mỏng nhẹ, hiện đại của c&aacute;c thế hệ trước m&agrave; c&ograve;n học hỏi th&ecirc;m phong c&aacute;ch hiện đại của c&aacute;c d&ograve;ng Macbook Pro. Khối lượng m&aacute;y chỉ vỏn vẹn 1.29 kg v&agrave; mỏng của th&acirc;n m&aacute;y l&agrave; 16.1 mm c&oacute; t&iacute;nh cơ động cao, dễ đem theo xử l&yacute; c&ocirc;ng việc.</p>\r\n<p>Vỏ m&aacute;y được thiết kế nguy&ecirc;n khối từ nguy&ecirc;n liệu nh&ocirc;m t&aacute;i chế 100% vừa g&oacute;p phần bảo vệ m&ocirc;i trường vừa cho độ bền cao, chịu va đập tốt bảo vệ c&aacute;c linh kiện b&ecirc;n trong an to&agrave;n nếu c&oacute; xảy ra va chạm mạnh.</p>', 100),
(58, 'Laptop Dell Gaming Alienware m15 R6 i7 11800H/32GB', 59990000, 'upload/gm8.jpg', 1, b'1', '<p>Nhắc đến d&ograve;ng laptop gaming, nh&agrave; Dell cũng đ&atilde; sở hữu cho m&igrave;nh một si&ecirc;u phẩm kh&ocirc;ng thể bỏ qua l&agrave; chiếc laptop <strong>Dell Alienware m15 R6 i7 (P109F001DBL)</strong> với card đồ hoạ RTX 3060 6 GB mạnh mẽ sẵn s&agrave;ng c&ugrave;ng bạn chinh phục mọi thử th&aacute;ch chiến game.</p>\r\n<p><strong>Thiết kế đậm chất gaming nhưng v&ocirc; c&ugrave;ng đẳng cấp, sang trọng</strong></p>\r\n<p>Laptop Dell Alienware m15 R6 c&oacute; một thiết kế bo tr&ograve;n cứng c&aacute;p, d&ugrave; l&agrave; laptop gaming nhưng với sự bo tr&ograve;n ở g&oacute;c cạnh cũng như c&aacute;c chi tiết ở cổng giao tiếp tăng th&ecirc;m phần mềm mại cho tổng thể. Chiếc m&aacute;y được chế t&aacute;c từ lớp vỏ kim loại đem đến một diện mạo thời thượng cho d&ograve;ng laptop gaming Alienware. B&ecirc;n cạnh đ&oacute;, chiếc m&aacute;y d&agrave;y 19.2 mm v&agrave; nặng 2.69 kg, theo cảm nhận của m&igrave;nh th&igrave; chiếc m&aacute;y kh&ocirc;ng qu&aacute; cồng kềnh, cầm nắm chắc chắn, gọn g&agrave;ng dễ d&agrave;ng mang theo b&ecirc;n m&igrave;nh.</p>\r\n<p><strong>Hiệu năng vượt trội, đ&uacute;ng nghĩa chiếc laptop gaming d&agrave;nh cho bạn</strong></p>\r\n<p>Vi xử l&yacute; Intel Core i7 Gen 11 kết hợp c&ugrave;ng card m&agrave;n h&igrave;nh rời NVIDIA RTX 3060 6 GB phục vụ tốt cho m&igrave;nh từ c&ocirc;ng việc đến giải tr&iacute;. T&aacute;c vụ xử l&yacute; đồ họa nặng Adobe từ thiết kế chỉnh sửa Photoshop, Illustrator,... render video Premiere, After Effect,... được chạy hết c&ocirc;ng suất khi m&aacute;y tận dụng tốt điểm mạnh l&agrave; RAM 32 GB, thoải m&aacute;i đa nhiệm, tạo nhiều layer m&agrave; kh&ocirc;ng lo bị thiếu dung lượng RAM.</p>', 100),
(59, 'Laptop MacBook Pro 14 M1 Pro 2021 8-core CPU/16GB/', 42990000, 'upload/mb2.jpg', 18, b'1', '<p>Apple đ&atilde; giới thiệu <strong>MacBook Pro 14 inch</strong> v&agrave;o th&aacute;ng 10/2021, mang một diện mạo mới c&ugrave;ng bộ vi xử l&yacute; do h&atilde;ng tự ph&aacute;t triển, kh&ocirc;ng chỉ cho hiệu năng vượt trội m&agrave; c&ograve;n sở hữu m&agrave;n h&igrave;nh với khả năng hiển thị thực sự ấn tượng, khiến m&igrave;nh m&ecirc; mẩn khi cầm tr&ecirc;n tay trải nghiệm.</p>\r\n<p><strong>Sức mạnh hiệu năng đỉnh cao hơn bao giờ hết</strong></p>\r\n<p>MacBook Pro 14 inch mang trong m&igrave;nh bộ vi xử l&yacute; M1 Pro được sản xuất bằng tiến tr&igrave;nh 5 nm hiện đại, t&iacute;ch hợp 8 l&otilde;i CPU với 6 l&otilde;i hiệu suất cao v&agrave; 2 l&otilde;i tiết kiệm điện năng, hứa hẹn khả năng xử l&yacute; nhanh hơn tới 70% so với CPU của M1, đồng thời giảm điện năng ti&ecirc;u thụ đ&aacute;ng kể để k&eacute;o d&agrave;i thời lượng pin.</p>\r\n<p><strong>C&aacute;c c&ocirc;ng nghệ m&agrave;n h&igrave;nh cho chất lượng giải tr&iacute; tr&ecirc;n cả tuyệt vời</strong></p>\r\n<p>Mang t&ecirc;n gọi MacBook Pro 14 inch nhưng thực tế m&aacute;y sở hữu m&agrave;n h&igrave;nh 14.2 inch với độ ph&acirc;n giải gốc 3024 x 1964, khoảng 254 pixel mỗi inch, sử dụng c&ocirc;ng nghệ mini-LED với độ s&aacute;ng tối đa l&ecirc;n đến 1.600 nits khi ph&aacute;t nội dung XDR, một con số kỷ lục khi n&oacute;i đến m&agrave;n h&igrave;nh m&aacute;y t&iacute;nh nhưng th&ocirc;ng thường con số đ&oacute; chỉ dừng lại ở mức 500 nits cho c&aacute;c t&aacute;c vụ th&ocirc;ng thường.</p>\r\n<p>M&agrave;n h&igrave;nh của chiếc MacBook Pro hỗ trợ c&ocirc;ng nghệ ProMotion cho tốc độ l&agrave;m mới th&iacute;ch ứng từ 24 Hz đến 120 Hz dựa theo nội dung hiển thị. Khi xem trang web tĩnh kh&ocirc;ng y&ecirc;u cầu tốc độ l&agrave;m mới cao, m&agrave;n h&igrave;nh sẽ tối ưu tốc độ l&agrave;m mới thấp hơn để k&eacute;o d&agrave;i tuổi thọ pin, nhưng khi chơi game hay thực hiện cuộn, tốc độ l&agrave;m mới sẽ được đẩy l&ecirc;n cao hơn, cho m&igrave;nh trải nghiệm thực sự mượt m&agrave;.</p>', 100),
(60, 'Laptop Apple MacBook Pro 16 M1 Pro 2021 10 core-CP', 53490000, 'upload/mb3.jpg', 18, b'1', '<p><strong>MacBook Pro 16 M1 Pro 2021</strong> kh&ocirc;ng chỉ sở hữu thiết kế mới tr&ocirc;ng vu&ocirc;ng vức hơn m&agrave; c&ograve;n mang trong m&igrave;nh sức mạnh hiệu năng vượt trội đến từ bộ vi xử l&yacute; M1 Pro, cho m&igrave;nh trải nghiệm sử dụng mượt m&agrave; v&agrave; ấn tượng như một d&acirc;n chuy&ecirc;n đ&uacute;ng nghĩa.</p>\r\n<p><strong>Hiệu năng vượt trội, chinh phục mọi t&aacute;c vụ</strong></p>\r\n<p>MacBook Pro 16 inch sở hữu sức mạnh từ bộ vi xử l&yacute; M1 Pro ti&ecirc;n tiến được trang bị 10 nh&acirc;n CPU (8 nh&acirc;n hiệu suất cao + 2 nh&acirc;n tiết kiệm điện) mang đến hiệu suất nhanh hơn tới 70% so với M1, cho khả năng xử l&yacute; mượt m&agrave; mọi t&aacute;c vụ từ cơ bản đến khắt khe nhất như chỉnh sửa h&igrave;nh ảnh, dựng video độ ph&acirc;n giải cao,... Kh&ocirc;ng những c&oacute; thời gian phản hồi nhanh m&agrave; c&ograve;n tối ưu tiết kiệm được đ&aacute;ng kể điện năng.</p>\r\n<p><strong>H&igrave;nh ảnh hiển thị sắc n&eacute;t, m&agrave;u sắc rực rỡ</strong></p>\r\n<p>MacBook Pro 16 inch được trang bị m&agrave;n h&igrave;nh Liquid Retina XDR 16.2 inch, sử dụng c&ocirc;ng nghệ LED mini cho chất lượng hiển thị đẹp miễn ch&ecirc;. Apple cho biết m&agrave;n h&igrave;nh c&oacute; độ s&aacute;ng l&ecirc;n đến 1600 nits khi hiển thị nội dung HDR, nhưng tr&ecirc;n thực tế con số n&agrave;y chỉ dừng lại ở mức 500 nits đối với c&aacute;c t&aacute;c vụ sử dụng th&ocirc;ng thường, vẫn đảm bảo nội dung lu&ocirc;n được thể hiện sắc n&eacute;t kể cả khi m&igrave;nh sử dụng ở những nơi c&oacute; &aacute;nh s&aacute;ng mạnh như qu&aacute;n c&agrave; ph&ecirc; ngo&agrave;i trời v&agrave; gần cửa sổ.</p>\r\n<p>Th&ecirc;m một t&iacute;nh năng nữa m&agrave; m&igrave;nh rất th&iacute;ch đ&oacute; l&agrave; ProMotion với khả năng tự điều chỉnh tần số qu&eacute;t từ 24 Hz đến 120 Hz dựa theo nội dung hiển thị. Khi sử dụng Safari để xem những th&ocirc;ng tin tĩnh, m&agrave;n h&igrave;nh sẽ giảm tần số qu&eacute;t xuống để tiết kiệm pin, nhưng khi m&igrave;n', 100),
(61, 'Laptop Apple MacBook Pro M2 2022 8GB/256GB/10-core', 35990000, 'upload/mb4.jpg', 18, b'1', '<p>Sở hữu thiết kế thanh lịch, sang trọng c&ugrave;ng hiệu năng vượt trội đến từ bộ vi xử l&yacute; Apple M2 t&acirc;n tiến, <strong>Macbook Pro M2</strong> hứa hẹn sẽ đ&aacute;p ứng ho&agrave;n hảo cho người d&ugrave;ng s&aacute;ng tạo, phục vụ tốt cho c&aacute;c nhu cầu thiết kế đồ họa n&acirc;ng cao.</p>\r\n<p><strong>Hiệu năng vượt trội của chip M2 thế hệ mới</strong></p>\r\n<p>MacBook Pro 13 inch l&agrave; thiết bị đầu ti&ecirc;n được trang bị bộ vi xử l&yacute; M2 ho&agrave;n to&agrave;n mới của Apple. Mặc d&ugrave; c&ocirc;ng ty cho biết M1 Pro v&agrave; M1 Max vẫn sẽ c&oacute; lợi thế hơn về hiệu suất nhờ c&oacute; th&ecirc;m l&otilde;i nhưng M2 thể hiện một bước tiến kh&aacute; lớn so với M1.</p>\r\n<p><strong>M&agrave;n h&igrave;nh Retina sống động, l&ocirc;i cuốn</strong></p>\r\n<p>Macbook sở hữu m&agrave;n h&igrave;nh 13.3 inch c&ugrave;ng độ ph&acirc;n giải Retina (2560 x 1600) sắc n&eacute;t, cho m&agrave;u sắc trung thực. Độ tương phản cao nhờ độ s&aacute;ng 500 nits, c&ocirc;ng nghệ True tone tự động điều chỉnh mức độ s&aacute;ng để lu&ocirc;n đảm bảo hiển thị r&otilde; r&agrave;ng d&ugrave; m&igrave;nh sử dụng ở bất k&igrave; đ&acirc;u.</p>\r\n<p><strong>Thiết kế quyến rũ, biểu tượng cho sự ho&agrave;n mỹ thu h&uacute;t mọi &aacute;nh nh&igrave;n</strong></p>\r\n<p>Ấn tượng trong thiết kế của Apple lu&ocirc;n l&agrave; logo t&aacute;o khuyết được đặt ch&iacute;nh giữa mặt lưng, tạo n&ecirc;n sự nhận diện thương hiệu m&agrave; ai ai cũng phải ngước nh&igrave;n mỗi khi m&igrave;nh cầm tr&ecirc;n tay hay l&agrave;m việc ngo&agrave;i qu&aacute;n c&agrave; ph&ecirc;. Khối lượng m&aacute;y chỉ 1.4 kg v&agrave; mỏng 15.6 mm đem đến sự cơ động, dễ d&agrave;ng bỏ v&agrave;o balo để mang theo b&ecirc;n m&igrave;nh.</p>', 100),
(62, 'Laptop Apple MacBook Air M2 2022 16GB/512GB/10-cor', 46990000, 'upload/mb5.jpg', 18, b'1', '<p><strong>MacBook Air M2 2022</strong> một lần nữa đ&atilde; khẳng định vị thế h&agrave;ng đầu của Apple trong ph&acirc;n kh&uacute;c laptop cao cấp - sang trọng v&agrave;o giữa năm 2022 khi sở hữu phong c&aacute;ch thiết kế thời thượng, đẳng cấp c&ugrave;ng sức mạnh bộc ph&aacute; đến từ bộ vi xử l&yacute; Apple M2 mạnh mẽ.</p>\r\n<p><strong>Kh&aacute;m ph&aacute; nguồn sức mạnh từ d&ograve;ng chip thế hệ mới</strong></p>\r\n<p>Chip Apple M2 vẫn được sản xuất ở tiến tr&igrave;nh 5 nm với 4 nh&acirc;n hiệu năng cao v&agrave; 4 nh&acirc;n tiết kiệm kiệm như d&ograve;ng M1 nhưng tốc độ băng th&ocirc;ng đ&atilde; được cải tiến vượt trội l&ecirc;n đến 100GB/s, c&ugrave;ng với đ&oacute; l&agrave; sự trợ gi&uacute;p của 20 ngh&igrave;n tỷ b&oacute;ng b&aacute;n dẫn gi&uacute;p hiệu suất hoạt động được n&acirc;ng cao hơn 18% so với phi&ecirc;n bản tiền nhiệm, đảm bảo vận h&agrave;nh trơn tru mọi t&aacute;c vụ học tập, l&agrave;m việc từ cơ bản đến n&acirc;ng cao.</p>\r\n<p><strong>Ngoại h&igrave;nh thời thượng, biểu tượng cho sự ho&agrave;n mỹ</strong></p>\r\n<p>Chiếc MacBook Air năm nay đ&atilde; kho&aacute;c l&ecirc;n m&igrave;nh một diện mạo ho&agrave;n to&agrave;n mới với xu hướng thiết kế c&oacute; phần tương tự như MacBook Pro, lớp vỏ kim loại sang trọng, cứng c&aacute;p với khối lượng chỉ vỏn vẹn 1.24 kg lu&ocirc;n l&agrave; trợ thủ đắc lực cho mọi cuộc h&agrave;nh tr&igrave;nh của người d&ugrave;ng d&ugrave; l&agrave; trong kh&ocirc;ng gian văn ph&ograve;ng hay những chuyến c&ocirc;ng t&aacute;c xa.</p>\r\n<p><strong>M&agrave;n h&igrave;nh Retina sắc n&eacute;t cho mọi trải nghiệm ho&agrave;n hảo</strong></p>\r\n<p>K&iacute;ch thước m&agrave;n h&igrave;nh 13.6 inch c&oacute; độ ph&acirc;n giải Liquid Retina (2560 x 1664) c&ugrave;ng 1 tỷ m&agrave;u mang đến cho chiếc MacBook những khung ảnh si&ecirc;u sắc n&eacute;t với những gam m&agrave;u chuẩn x&aacute;c, cực kỳ th&iacute;ch hợp cho người d&ugrave;ng khi thực hiện c&aacute;c t&aacute;c vụ chỉnh sửa h&igrave;nh ảnh, video,.', 100),
(63, 'Laptop MacBook Pro 16 M1 Pro 2021 10-core CPU/16GB', 57490000, 'upload/mb6.jpg', 18, b'1', '<p>Kh&ocirc;ng c&ograve;n qu&aacute; xa lạ với sự đẳng cấp đến từ c&aacute;c sản phẩm của nh&agrave; Apple bởi lối thiết kế dẫn đầu xu hướng sang trọng, thời thượng v&agrave; sức mạnh cấu h&igrave;nh ngo&agrave;i mong đợi, nhưng c&ograve;n đặc biệt hơn khi chiếc <strong>laptop MacBook Pro 16 M1 Pro 2021</strong> n&agrave;y sẽ l&agrave; phi&ecirc;n bản n&acirc;ng cấp với con chip Apple M1 Pro mạnh mẽ, xử l&yacute; ấn tượng c&aacute;c t&aacute;c vụ chuy&ecirc;n s&acirc;u.</p>\r\n<p><strong>Sức mạnh bộc ph&aacute; với CPU phi&ecirc;n bản n&acirc;ng cấp vượt trội</strong></p>\r\n<p>MacBook M1 Pro l&agrave; phi&ecirc;n bản n&acirc;ng cấp vượt trội với tốc độ xử l&yacute; tăng 70% v&agrave; hiệu năng gấp 1.7 lần so với d&ograve;ng M1 tiền nhiệm, sở hữu 200 GB/s memory bandwidth chinh phục mọi t&aacute;c vụ từ cơ bản đến chuy&ecirc;n s&acirc;u với hiệu năng đỉnh cao dẫn đầu so với c&aacute;c d&ograve;ng sản phẩm c&ugrave;ng ph&acirc;n kh&uacute;c đồng thời k&eacute;o d&agrave;i thời lượng pin nhờ 10 nh&acirc;n CPU gồm 8 nh&acirc;n hiệu suất cao v&agrave; 2 nh&acirc;n tiết kiệm điện ấn tượng c&ugrave;ng 33.7 tỷ b&oacute;ng b&aacute;n dẫn.</p>\r\n<p><strong>Phong c&aacute;ch, thời trang tr&ecirc;n từng đường n&eacute;t m&aacute;y</strong></p>\r\n<p>Apple MacBook vẫn lu&ocirc;n l&agrave; tượng đ&agrave;i thiết kế ghi điểm trong mắt người d&ugrave;ng với phong c&aacute;ch tối giản nhưng kh&ocirc;ng k&eacute;m phần sang trọng, gam m&agrave;u hiện đại c&ugrave;ng chiếc logo tr&aacute;i t&aacute;o khuyết đặc trưng của nh&agrave; Apple đ&atilde; l&agrave;m cho chủ nh&acirc;n sở hữu n&oacute; h&atilde;nh diện giữa những nơi đ&ocirc;ng người.</p>\r\n<p><strong>M&atilde;n nh&atilde;n thị gi&aacute;c người xem với m&agrave;n h&igrave;nh Retina sắc n&eacute;t</strong></p>\r\n<p>Kh&ocirc;ng gian rộng lớn với m&agrave;n h&igrave;nh viền mỏng c&oacute; k&iacute;ch thước 16.2 inch v&agrave; độ ph&acirc;n giải Liquid Retina XDR display (3456 x 2234), đảm bảo c&aacute;c nội dung hiển thị ch&acirc;n thực', 100),
(64, 'Laptop Acer TravelMate B3 TMB311 31 C2HB N4020/4GB', 4990000, 'upload/vp1.jpg', 23, b'1', '<p><strong>Laptop Acer TravelMate B3 TMB311 31 C2HB (NX.VNFSV.006)</strong> nhắm đến ph&acirc;n kh&uacute;c laptop học tập - văn ph&ograve;ng, phục vụ cho c&aacute;c nhu cầu cơ bản tr&ecirc;n laptop, với k&iacute;ch thước nhỏ gọn v&agrave; hiệu năng đủ d&ugrave;ng, l&agrave; sự lựa chọn tốt cho học sinh, sinh vi&ecirc;n.</p>\r\n<p><strong>Thiết kế nhỏ gọn, t&iacute;nh di động cao</strong></p>\r\n<p>Acer TravelMate B3 c&oacute; khối lượng m&aacute;y chỉ 1.4 kg, độ d&agrave;y 20.99 mm, thiết kế thanh lịch, đẹp mắt với lớp vỏ nhựa m&agrave;u đen đơn giản k&egrave;m logo h&atilde;ng tinh tế ở g&oacute;c tr&aacute;i tr&ecirc;n mặt lưng, dễ d&agrave;ng c&ugrave;ng bạn xuất hiện ở mọi nơi.</p>\r\n<p><strong>Cấu h&igrave;nh đ&aacute;p ứng tốt c&aacute;c t&aacute;c vụ cơ bản</strong></p>\r\n<p>Nhắm tới nhu cầu sử dụng laptop để học tập v&agrave; l&agrave;m việc văn ph&ograve;ng cơ bản, Acer trang bị cho chiếc laptop d&ograve;ng chip Intel Celeron N4020 c&oacute; hiệu năng đủ d&ugrave;ng với xung nhịp cơ bản 1.1 GHz v&agrave; tối đa 2.8 GHz khi &eacute;p xung, được sự hỗ trợ của card t&iacute;ch hợp Intel UHD Graphics 600 để giải quyết nhẹ nh&agrave;ng, nhanh mượt c&aacute;c thao t&aacute;c soạn thảo b&agrave;i tập tr&ecirc;n Word, t&iacute;nh to&aacute;n, nhập liệu qua Excel, soạn bản thuyết tr&igrave;nh b&agrave;i học tr&ecirc;n PowerPoint,&hellip; hay duyệt web, t&igrave;m kiếm th&ocirc;ng tin tr&ecirc;n Chrome.</p>', 100),
(65, 'Laptop Lenovo Ideapad 3 15IAU7 i3 1215U/8GB/256GB/', 11990000, 'upload/vp2.jpg', 23, b'1', '<p><strong>Laptop Lenovo Ideapad 3 15IAU7 i3 (82RK005LVN)</strong> sẽ l&agrave; một người bạn đồng h&agrave;nh đắc lực cho c&aacute;c bạn học sinh, sinh vi&ecirc;n hay d&acirc;n văn ph&ograve;ng với ngoại h&igrave;nh thanh lịch, hiện đại c&ugrave;ng hiệu năng mạnh mẽ đến từ con chip Intel Gen 12 t&acirc;n tiến.</p>\r\n<p>&bull; Laptop Lenovo Ideapad giải quyết tốt mọi t&aacute;c vụ của một chiếc laptop học tập - văn ph&ograve;ng từ cơ bản đến n&acirc;ng cao nhờ sự kết hợp của bộ vi xử l&yacute; Intel Core i3 1215U c&ugrave;ng card đồ họa Intel UHD Graphics.</p>\r\n<p>&bull; Vừa chạy file Excel nặng vừa xem phim giải tr&iacute; đa nhiệm vẫn rất mượt m&agrave; nhờ bộ nhớ RAM 8 GB. Kh&ocirc;ng gian lưu trữ rộng r&atilde;i nhờ ổ cứng SSD 256 GB c&oacute; thể lắp thanh kh&aacute;c tối đa 1 TB.</p>\r\n<p>&bull; Sắc x&aacute;m đơn giản nhưng kh&ocirc;ng k&eacute;m phần hiện đại, tao nh&atilde; gi&uacute;p chủ nh&acirc;n sở hữu n&oacute; nổi bật ở khắp mọi nơi. Laptop c&oacute; b&agrave;n ph&iacute;m số gi&uacute;p bạn dễ d&agrave;ng nhập liệu hơn.</p>\r\n<p>&bull; Mở kh&oacute;a nhanh ch&oacute;ng, thanh to&aacute;n online dễ d&agrave;ng chỉ với một chạm nhờ t&iacute;nh năng bảo mật v&acirc;n tay hiện đại. Laptop Lenovo c&ograve;n được trang bị chip TPM 2.0 c&ugrave;ng c&ocirc;ng tắc kh&oacute;a camera tăng cường khả năng bảo mật dữ liệu cho m&aacute;y.</p>\r\n<p>&bull; Đa dạng c&aacute;c cổng kết nối được trang bị tr&ecirc;n laptop bao gồm USB 2.0, USB Type-C, Jack tai nghe 3.5 mm, USB 3.2 v&agrave; HDMI.</p>\r\n<p>&bull; K&iacute;ch thước m&agrave;n h&igrave;nh 15.6 inch c&oacute; độ ph&acirc;n giải Full HD gi&uacute;p c&aacute;c chi tiết hiển thị tr&ecirc;n m&agrave;n h&igrave;nh được r&otilde; r&agrave;ng, sắc n&eacute;t. Tấm nền TN cho tốc độ phản hồi nhanh ch&oacute;ng hơn, đồng thời hạn chế tối đa hiện tượng nhức mỏi mắt nhờ m&agrave;n h&igrave;nh Anti Glare.</p>\r\n<p>&nbsp;</p>', 100),
(66, 'Laptop itel ABLE 1S N4020/4GB/256GB/Win11 (7100630', 6090000, 'upload/vp3.jpg', 23, b'1', '<p><strong>Itel Able 1S N4020 (71006300027)</strong> l&agrave; laptop học tập - văn ph&ograve;ng sử dụng hiệu quả cho c&aacute;c t&aacute;c vụ cơ bản, thiết kế thanh lịch, gọn nhẹ, đ&aacute;p ứng nhu cầu về hiệu năng v&agrave; gi&aacute; th&agrave;nh cho c&aacute;c kh&aacute;ch h&agrave;ng trong ph&acirc;n kh&uacute;c.</p>\r\n<p><strong>Thiết kế thanh lịch, t&iacute;nh di động cao</strong></p>\r\n<p>Laptop Itel Able sở hữu lớp vỏ nhựa m&agrave;u đen thanh lịch, thiết kế đơn giản ph&ugrave; hợp cho mọi kh&ocirc;ng gian d&ugrave;ng, khối lượng m&aacute;y chỉ 1.4 kg v&agrave; độ d&agrave;y 19.9 mm dễ d&agrave;ng để bạn mang theo khi di chuyển.</p>\r\n<p><strong>Hiệu năng đủ d&ugrave;ng</strong></p>\r\n<p>Trang bị chip Intel Celeron N4020 c&oacute; xung nhịp cơ bản 1.1 GHz v&agrave; tối đa l&ecirc;n tới 2.8 GHz ở chế độ Turbo Boost, laptop xử l&yacute; mượt m&agrave; c&aacute;c t&aacute;c vụ cơ bản như l&agrave;m b&agrave;i tập, b&agrave;i luận tr&ecirc;n Word, t&iacute;nh to&aacute;n hay thống k&ecirc; qua Excel, tạo bản thuyết tr&igrave;nh với PowerPoint,... Kết hợp c&ugrave;ng card t&iacute;ch hợp Intel UHD Graphics 600 n&acirc;ng cao chất lượng h&igrave;nh ảnh, hỗ trợ bạn duyệt web, xem phim hay giải tr&iacute; với những khung h&igrave;nh mướt hơn, h&igrave;nh ảnh r&otilde; r&agrave;ng hơn.</p>\r\n<p><strong>M&agrave;n h&igrave;nh r&otilde; n&eacute;t &acirc;m thanh sống động</strong></p>\r\n<p>Laptop Itel c&oacute; k&iacute;ch thước m&agrave;n h&igrave;nh 14 inch với độ ph&acirc;n giải đạt chuẩn HD (1366 x 768), độ s&aacute;ng m&agrave;n h&igrave;nh 220 nits mang đến khung h&igrave;nh r&otilde; n&eacute;t, tương phản tốt, đủ mang lại trải nghiệm xem thoải m&aacute;i khi tiếp cận m&agrave;n h&igrave;nh.</p>\r\n<p>&nbsp;</p>', 100),
(67, 'Laptop HP 15s fq5078TU i5 1235U/8GB/512GB/Win11 (6', 18190000, 'upload/vp4.jpg', 23, b'1', '<p>Thiết kế thanh lịch, tao nh&atilde; tạo n&ecirc;n vẻ đẹp quyến rũ của chiếc laptop <strong>HP 15s fq5078TTU i5 (6K798PA)</strong>, sở hữu d&ograve;ng chip Intel thế hệ 12 sẵn s&agrave;ng c&acirc;n đối mọi t&aacute;c vụ của laptop học tập - văn ph&ograve;ng ph&ugrave; hợp với sinh vi&ecirc;n, học sinh, nh&acirc;n vi&ecirc;n văn ph&ograve;ng.</p>\r\n<p><strong>Mượt m&agrave; đa t&aacute;c vụ với chip Gen 12 t&acirc;n tiến</strong></p>\r\n<p>Laptop HP được trang bị bộ vi xử l&yacute; Intel Core i5 1235U cho ph&eacute;p người d&ugrave;ng ho&agrave;n th&agrave;nh c&ocirc;ng việc với hiệu suất cao nhưng vẫn tiết kiệm được năng lượng. Qua đo đạc bằng c&ocirc;ng cụ Cinebench R23 m&aacute;y đạt được 4867 điểm đa nh&acirc;n v&agrave; 1369 điểm đơn nh&acirc;n, con số ổn &aacute;p cho một chiếc laptop phục vụ cho mục đ&iacute;ch học tập, văn ph&ograve;ng.</p>\r\n<p><strong>Ngoại h&igrave;nh nh&atilde; nhặn, thanh lịch</strong></p>\r\n<p>HP 15s sở hữu ng&ocirc;n ngữ thiết kế đẹp mắt với những n&eacute;t đặc trưng mang thương hiệu ri&ecirc;ng của HP, lớp vỏ nhựa c&ugrave;ng m&agrave;u bạc nh&atilde; nhặn tạo n&ecirc;n vẻ ngo&agrave;i đơn giản v&agrave; hiện đại. M&aacute;y c&oacute; khối lượng 1.69 kg v&agrave; d&agrave;y 17.9 mm, sẽ hơi nặng một ch&uacute;t so với c&aacute;c bạn nữ nhưng vẫn c&oacute; thể bỏ v&agrave;o balo đi theo bạn bất cứ đ&acirc;u, trong cả c&ocirc;ng việc hay học tập.</p>\r\n<p>Tổng kết lại, HP 15s fq5078TTU i5 (6K798PA) sẽ l&agrave; một ứng cử vi&ecirc;n s&aacute;ng gi&aacute; trong ph&acirc;n kh&uacute;c học tập - văn ph&ograve;ng c&oacute; mức gi&aacute; nằm trong khoảng 18 triệu đồng m&agrave; bạn đang t&igrave;m kiếm. Laptop sở hữu phong c&aacute;ch thiết kế hiện đại c&ugrave;ng bộ vi xử l&yacute; Intel Gen 12 đầy mạnh mẽ.</p>', 100),
(68, 'Laptop Dell Vostro 3510 i5 1135G7/8GB/512GB/2GB MX', 19990000, 'upload/vp5.jpg', 23, b'1', '<p><strong>Laptop Dell Vostro 3510 i5 (P112F002BBL)</strong> sở hữu cấu h&igrave;nh mạnh mẽ, đa nhiệm mượt m&agrave; tr&ecirc;n sức mạnh của bộ vi xử l&yacute; Intel thế hệ 11, c&ugrave;ng một thiết kế đơn giản m&agrave; sang đẹp, sẽ l&agrave; lựa chọn đắt gi&aacute; đ&aacute;p ứng nhu cầu học tập, l&agrave;m việc hay giải tr&iacute; của bạn.</p>\r\n<p><strong>Hiệu năng mạnh mẽ, ổn định</strong></p>\r\n<p>Được trang bị d&ograve;ng chip Intel Core i5 Tiger Lake 1135G7 mạnh mẽ, hoạt động tr&ecirc;n xung nhịp cơ bản 2.4 GHz v&agrave; &eacute;p xung l&ecirc;n đến 4.2 GHz ở chế độ Turbo Boost, Dell Vostro 3510 dễ d&agrave;ng giải quyết mượt m&agrave; c&aacute;c t&aacute;c vụ như soạn thảo hợp đồng tr&ecirc;n Word, nhập liệu v&agrave; thống k&ecirc; qua Excel, tạo bảng thuyết tr&igrave;nh c&ugrave;ng PowerPoint,... hay thiết kế đồ hoạ cơ bản tr&ecirc;n c&aacute;c ứng dụng nh&agrave; Adobe cũng hiệu quả kh&ocirc;ng k&eacute;m.</p>\r\n<p><strong>Thiết kế thanh lịch, sang đẹp</strong></p>\r\n<p>Laptop Dell Vostro c&oacute; lớp vỏ ngo&agrave;i bằng nhựa m&agrave;u đen hiện đại, tổng thể thiết kế to&aacute;t l&ecirc;n sự chắc chắn, sang trọng m&agrave; rất thanh lịch, c&aacute;c chi tiết tinh tế, đẹp mắt. M&aacute;y c&oacute; khối lượng 1.69 kg, độ d&agrave;y 18.9 mm dễ d&agrave;ng để mang theo trong h&agrave;nh trang thường nhật cho học tập, l&agrave;m việc.</p>\r\n<p><strong>M&agrave;n h&igrave;nh sắc n&eacute;t với g&oacute;c nh&igrave;n rộng, &acirc;m thanh giải tr&iacute; sống động</strong></p>\r\n<p>Laptop m&agrave;n h&igrave;nh 15.6 inch kết hợp với c&ocirc;ng nghệ g&oacute;c nh&igrave;n rộng Wide Viewing Angle (WVA) mang đến trải nghiệm xem đ&atilde; mắt hơn tr&ecirc;n m&agrave;n h&igrave;nh, chất lượng h&igrave;nh ảnh sắc n&eacute;t chuẩn Full HD (1920 x 1080), m&agrave;u sắc tương phản tốt, chi tiết ch&acirc;n thật.</p>', 100),
(69, 'Laptop Lenovo ThinkBook 14 G3 ACL R5 5500U/8GB/512', 13990000, 'upload/vp6.jpg', 23, b'1', '<p>Laptop <strong>Lenovo ThinkBook 14 G3 ACL R5 (21A200CPVN)</strong> kh&ocirc;ng chỉ c&oacute; vẻ ngo&agrave;i cuốn h&uacute;t với thiết kế hai t&ocirc;ng m&agrave;u lạ mắt m&agrave; c&ograve;n sở hữu cấu h&igrave;nh mạnh mẽ đ&aacute;p ứng đa nhu cầu sử dụng của c&aacute;c bạn học sinh, sinh vi&ecirc;n v&agrave; nh&acirc;n vi&ecirc;n văn ph&ograve;ng.</p>\r\n<p><strong>Cấu h&igrave;nh mượt m&agrave; đa t&aacute;c vụ văn ph&ograve;ng</strong></p>\r\n<p>Laptop Lenovo ThinkBook được trang bị bộ vi xử l&yacute; AMD Ryzen 5 5500U sở hữu cấu tr&uacute;c 6 nh&acirc;n 12 luồng thay v&igrave; 6 nh&acirc;n 6 luồng so với bản 4500U trước đ&oacute;, cải thiện đ&aacute;ng kể về hiệu suất để hỗ trợ người d&ugrave;ng xử l&yacute; mọi t&aacute;c vụ mượt m&agrave; từ văn ph&ograve;ng với Word, Excel, PowerPoint,... cho đến s&aacute;ng tạo tr&ecirc;n c&aacute;c phần mềm đồ họa cơ bản hoặc b&aacute;n chuy&ecirc;n với Photoshop, Lightroom,... cũng như chiến một v&agrave;i tựa game thịnh h&agrave;nh với mức cấu h&igrave;nh trung b&igrave;nh nhờ card t&iacute;ch hợp AMD Radeon.</p>\r\n<p><strong>Ngoại h&igrave;nh cao cấp, sang trọng</strong></p>\r\n<p>To&agrave;n bộ lớp vỏ b&ecirc;n ngo&agrave;i của em m&aacute;y được l&agrave;m từ chất liệu nh&ocirc;m nguy&ecirc;n khối với thiết kế nắp lưng hai t&ocirc;ng m&agrave;u bạc v&agrave; x&aacute;m cắt ngang tạo n&ecirc;n sự độc đ&aacute;o trong lối thiết kế, logo &ldquo;ThinkBook&rdquo; v&agrave; &ldquo;Lenovo&rdquo; cũng được l&agrave;m tinh tế, khi nh&igrave;n v&agrave;o rất lạ mắt nhưng cũng kh&ocirc;ng k&eacute;m phần sang trọng, hiện đại. V&igrave; được l&agrave;m bằng kim loại n&ecirc;n khi sờ tay v&agrave;o rất m&aacute;t v&agrave; th&iacute;ch, nhưng cũng v&igrave; thế m&agrave; dễ b&aacute;m dấu v&acirc;n tay v&agrave; mồ h&ocirc;i, kh&ocirc;ng qu&aacute; r&otilde; nhưng m&igrave;nh khuy&ecirc;n c&aacute;c bạn n&ecirc;n thường xuy&ecirc;n lau ch&ugrave;i để giữ cho em m&aacute;y một vẻ ngo&agrave;i tươm tất nhất.</p>', 100),
(70, 'Laptop Asus VivoBook 15X OLED A1503ZA i5 12500H/8G', 19590000, 'upload/vp7.jpg', 23, b'1', '<p>Laptop <strong>Asus VivoBook 15X OLED A1503ZA i5 (L1290W)</strong> l&agrave; phi&ecirc;n bản laptop cao cấp - sang trọng kh&ocirc;ng chỉ giải quyết triệt để c&aacute;c t&aacute;c vụ học tập, văn ph&ograve;ng nhờ sức mạnh b&ugrave;ng nổ đến từ bộ vi xử l&yacute; Intel thế hệ 12 m&agrave; c&ograve;n mang đến kh&ocirc;ng gian giải tr&iacute; trọn vẹn khi sở hữu những th&ocirc;ng số m&agrave;n h&igrave;nh ấn tượng.</p>\r\n<p><strong>Thiết kế thời thượng, t&ocirc;ng xanh say đắm</strong></p>\r\n<p>Sở hữu m&agrave;n h&igrave;nh 15.6 inch nhưng laptop Asus VivoBook lại được thiết kế một c&aacute;ch kh&aacute; gọn g&agrave;ng với khung vỏ nhựa phủ m&agrave;u xanh thời thượng. Mặc d&ugrave; được ho&agrave;n thiện bằng chất liệu nhựa nhưng m&aacute;y tỏ ra kh&aacute; chắc chắn, kh&ocirc;ng bị biến dạng khi m&igrave;nh t&aacute;c động một lực mạnh v&agrave;o c&aacute;c khu vực yếu như nắp m&aacute;y v&agrave; b&agrave;n ph&iacute;m.</p>\r\n<p><strong>B&ugrave;ng nổ sức mạnh c&ugrave;ng vi xử l&yacute; Intel thế hệ 12&nbsp; </strong></p>\r\n<p>Nhờ bộ vi xử l&yacute; Intel Core i5 12500H hỗ trợ m&igrave;nh giải quyết nhanh gọn h&agrave;ng loạt t&aacute;c vụ văn ph&ograve;ng Word, Excel,... M&aacute;y được trang bị card đồ họa Intel UHD Graphics với khả năng xử l&yacute; đồ họa tốt, bạn c&oacute; thể lắp th&ecirc;m thanh RAM kh&aacute;c v&agrave; k&iacute;ch hoạt Dual-Channel để n&acirc;ng cấp th&agrave;nh card Intel Iris Xe Graphics, gi&uacute;p giải quyết được khối lượng c&ocirc;ng việc nhiều hơn.&nbsp;</p>\r\n<p>Nh&igrave;n chung Asus VivoBook 15X OLED A1503ZA i5 (L1290W) kh&ocirc;ng chỉ l&agrave; một chiếc laptop cao cấp - sang trọng sở hữu thiết kế bắt mắt m&agrave; c&ograve;n được trang bị m&agrave;n h&igrave;nh đẹp c&ugrave;ng bộ vi xử l&yacute; Intel d&ograve;ng H hiệu năng cao, đ&aacute;p ứng được mọi nhu cầu về cả học tập v&agrave; l&agrave;m việc của m&igrave;nh.</p>', 100),
(71, 'Laptop HP 15s fq2662TU i3 1115G4/4GB/256GB/Win11 (', 10310000, 'upload/vp8.jpg', 23, b'1', '<p><strong>Laptop HP 15s fq2662TU i3 (6K795PA)</strong> sẽ l&agrave; sự lựa chọn ph&ugrave; hợp cho học sinh, sinh vi&ecirc;n muốn t&igrave;m kiếm một chiếc laptop học tập - văn ph&ograve;ng sở hữu cấu h&igrave;nh ổn định, đ&aacute;p ứng tốt mọi nhu cầu cơ bản c&ugrave;ng một mức gi&aacute; l&yacute; tưởng, dễ d&agrave;ng tiếp cận.</p>\r\n<p>&bull; Laptop HP cơ bản được bao bọc bởi lớp vỏ nhựa m&agrave;u bạc, mang đến vẻ đẹp tối giản nhưng cũng kh&ocirc;ng k&eacute;m phần thanh lịch, tao nh&atilde;. Khối lượng 1.7 kg hỗ trợ bạn bỏ v&agrave;o balo dễ d&agrave;ng v&agrave; mang đến khắp mọi nơi để học tập, l&agrave;m việc.</p>\r\n<p>&bull; C&aacute;c cổng kết nối như USB Type-C, USB A, HDMI, khe đọc thẻ nhớ SD v&agrave; Jack tai nghe 3.5 mm được trang bị xung quanh laptop cho ph&eacute;p bạn kết nối với c&aacute;c thiết bị ngoại vi kh&aacute;c như loa, chuột, m&aacute;y chiếu,... nhanh ch&oacute;ng hơn m&agrave; kh&ocirc;ng cần đến d&acirc;y c&aacute;p rườm r&agrave;.</p>\r\n<p>&bull; Laptop HP trang bị bộ vi xử l&yacute; Intel Core i3 1115G4 v&agrave; card Intel UHD Graphics giải quyết nhẹ nh&agrave;ng c&aacute;c t&aacute;c vụ học tập, l&agrave;m việc tr&ecirc;n Word, Excel, PowerPoint,... hay chỉnh sửa ảnh, thiết kế cơ bản tr&ecirc;n Figma, Canva,... một c&aacute;ch mượt m&agrave;.</p>\r\n<p>&bull; RAM 4 GB cho ph&eacute;p bạn vừa soạn thảo văn bản tr&ecirc;n Word vừa nghe nhạc giải tr&iacute; m&agrave; vẫn trơn tru, su&ocirc;n sẻ. Kh&ocirc;ng gian lưu trữ ổn định nhờ ổ cứng SSD 256 GB, n&oacute; c&oacute; thể th&aacute;o ra v&agrave; lắp thanh kh&aacute;c tối đa 1 TB.</p>', 100),
(72, 'Laptop MacBook Pro 14 M1 Pro 2021 8-core CPU/16GB/', 42990000, 'upload/dh1.jpg', 24, b'1', '<p>Apple đ&atilde; giới thiệu <strong>MacBook Pro</strong> 14 inch v&agrave;o th&aacute;ng 10/2021, mang một diện mạo mới c&ugrave;ng bộ vi xử l&yacute; do h&atilde;ng tự ph&aacute;t triển, kh&ocirc;ng chỉ cho hiệu năng vượt trội m&agrave; c&ograve;n sở hữu m&agrave;n h&igrave;nh với khả năng hiển thị thực sự ấn tượng, khiến m&igrave;nh m&ecirc; mẩn khi cầm tr&ecirc;n tay trải nghiệm.</p>\r\n<p><strong>Sức mạnh hiệu năng đỉnh cao hơn bao giờ hết</strong></p>\r\n<p>MacBook Pro 14 inch mang trong m&igrave;nh bộ vi xử l&yacute; M1 Pro được sản xuất bằng tiến tr&igrave;nh 5 nm hiện đại, t&iacute;ch hợp 8 l&otilde;i CPU với 6 l&otilde;i hiệu suất cao v&agrave; 2 l&otilde;i tiết kiệm điện năng, hứa hẹn khả năng xử l&yacute; nhanh hơn tới 70% so với CPU của M1, đồng thời giảm điện năng ti&ecirc;u thụ đ&aacute;ng kể để k&eacute;o d&agrave;i thời lượng pin.</p>\r\n<p><strong>C&aacute;c c&ocirc;ng nghệ m&agrave;n h&igrave;nh cho chất lượng giải tr&iacute; tr&ecirc;n cả tuyệt vời</strong></p>\r\n<p>Mang t&ecirc;n gọi MacBook Pro 14 inch nhưng thực tế m&aacute;y sở hữu m&agrave;n h&igrave;nh 14.2 inch với độ ph&acirc;n giải gốc 3024 x 1964, khoảng 254 pixel mỗi inch, sử dụng c&ocirc;ng nghệ mini-LED với độ s&aacute;ng tối đa l&ecirc;n đến 1.600 nits khi ph&aacute;t nội dung XDR, một con số kỷ lục khi n&oacute;i đến m&agrave;n h&igrave;nh m&aacute;y t&iacute;nh nhưng th&ocirc;ng thường con số đ&oacute; chỉ dừng lại ở mức 500 nits cho c&aacute;c t&aacute;c vụ th&ocirc;ng thường.</p>\r\n<p>Với những th&ocirc;ng số kỹ thuật mạnh mẽ v&agrave; dẫn đầu xu hướng thiết kế thời thượng, sang trọng, MacBook Pro 14 inch xứng đ&aacute;ng nằm trong top c&aacute;c mẫu laptop sang trọng - cao cấp, đ&aacute;p ứng tốt mọi t&aacute;c vụ cần thiết cho nhiều đối tượng kể cả những doanh nh&acirc;n kỹ t&iacute;nh nhất.</p>', 100),
(73, 'Laptop Dell Gaming G15 5515 R5 5600H/8GB/256GB/4GB', 19990000, 'upload/dh2.jpg', 24, b'1', '<p>Mức gi&aacute; dễ tiếp cận, thiết kế năng động, trẻ trung c&ugrave;ng hiệu năng mạnh mẽ đủ sức chiến c&aacute;c tựa game phổ biến l&agrave; điều m&agrave; game thủ cần ở một chiếc laptop gaming, <strong>laptop Dell Gaming G15 5515 R5 (P105F004CGR)</strong> ho&agrave;n to&agrave;n c&oacute; thể đ&aacute;p ứng được những điều đ&oacute;.</p>\r\n<p><strong>Chơi game mượt m&agrave; c&ugrave;ng chip AMD</strong></p>\r\n<p>Laptop Dell sở hữu CPU AMD Ryzen 5 5600H kết hợp với card đồ họa NVIDIA RTX 3050 4 GB gi&uacute;p khả năng chơi game trơn tru. Trong l&uacute;c trải nghiệm, hầu hết khi chiến c&aacute;c tựa game trực tuyến như Li&ecirc;n Minh Huyền Thoại, CS:GO,... t&igrave;nh trạng giật lag thường xảy ra ở c&aacute;c d&ograve;ng laptop gaming gi&aacute; rẻ do m&aacute;y thu bắt s&oacute;ng internet yếu, tuy nhi&ecirc;n chiếc m&aacute;y n&agrave;y đ&atilde; vượt qua v&agrave; chạy tốt, kh&ocirc;ng ảnh hưởng đến trải nghiệm chơi game nhờ c&ocirc;ng nghệ Wi-Fi 6 (802.11ax).</p>\r\n<p><strong>Kh&ocirc;ng gian chiến game phấn kh&iacute;ch</strong></p>\r\n<p>M&agrave;n h&igrave;nh laptop Dell Gaming G-Series c&oacute; k&iacute;ch thước 15.6 inch c&ugrave;ng độ ph&acirc;n giải Full HD (1920 x 1080) sắc n&eacute;t. Độ s&aacute;ng 250 nits cho độ tương phản cao, tần số qu&eacute;t 120 Hz tăng cường độ ổn định cho khung h&igrave;nh khi chơi game, LED Backlit gi&uacute;p m&aacute;y ti&ecirc;u thụ &iacute;t điện năng hơn, c&ocirc;ng nghệ WVA cho g&oacute;c nh&igrave;n rộng cũng như Anti Glare hạn chế t&igrave;nh trạng b&oacute;ng gương xuất hiện. Tất cả c&ocirc;ng nghệ được t&iacute;ch hợp với nhau tạo cho m&igrave;nh cảm gi&aacute;c chơi game đ&atilde;, nịnh mắt v&agrave; phấn kh&iacute;ch hơn.</p>\r\n<p>Tổng kết lại, Dell Gaming G15 5515 R5 (P105F004CGR) đem lại sự h&agrave;i l&ograve;ng về hiệu năng chiến game cũng như c&oacute; một thiết kế trẻ trung, đẹp mắt, ph&ugrave; hợp với học sinh, sinh vi&ecirc;n hay nh&acirc;n vi&ecirc;n văn ph&ograve;ng cần chiếc m&aacute;y vừa c&acirc;n bằn', 100),
(74, 'Laptop HP VICTUS 16 d0292TX i5 11400H/8GB/512GB/4G', 26590000, 'upload/dh3.jpg', 24, b'1', '<p>Laptop <strong>HP VICTUS 16 d0292TX i5 (5Z9R3PA)</strong> sẽ l&agrave; một người bạn đồng h&agrave;nh đắc lực tr&ecirc;n mọi chiến trường ảo của game thủ nhờ ngoại h&igrave;nh sang trọng, hiện đại c&ugrave;ng những th&ocirc;ng số kỹ thuật mạnh mẽ.</p>\r\n<p>&bull; Trang bị chip Intel Core i5 11400H c&ugrave;ng card rời NVIDIA GeForce RTX 3050Ti 4 GB, laptop HP Victus sẵn s&agrave;ng c&ugrave;ng bạn chiến mọi tựa game đ&igrave;nh đ&aacute;m như LOL, PUBG, CS:GO,... hay thỏa m&atilde;n đam m&ecirc; s&aacute;ng tạo với c&aacute;c ứng dụng đồ họa của nh&agrave; Adobe.</p>\r\n<p>&bull; Vừa chiến game vừa nghe nhạc giải tr&iacute; vẫn rất mượt m&agrave;, kh&ocirc;ng giật lag nhờ bộ nhớ RAM 8 GB, ổ cứng 512 GB SSD (c&oacute; thể th&aacute;o v&agrave; lắp thanh kh&aacute;c tối đa 1 TB) mang đến kh&ocirc;ng gian lưu trữ ổn định c&ugrave;ng tốc độ mở m&aacute;y nhanh ch&oacute;ng hơn.&nbsp;</p>\r\n<p>&bull; Quan s&aacute;t di chuyển của đối thủ ở mọi g&oacute;c cạnh nhờ k&iacute;ch thước m&agrave;n h&igrave;nh 16.1 inch c&ugrave;ng tấm nền IPS tạo g&oacute;c nh&igrave;n rộng r&atilde;i, độ ph&acirc;n giải Full HD c&ugrave;ng c&ocirc;ng nghệ Wled-backlit mang đến những khung ảnh chất lượng, sắc n&eacute;t hơn.</p>\r\n<p>&bull; Tần số qu&eacute;t 144 Hz cho mọi chuyển động c&oacute; tốc độ nhanh được mượt m&agrave; hơn đ&aacute;ng kể, đồng thời vẫn bảo vệ thị gi&aacute;c của người d&ugrave;ng trước &aacute;nh s&aacute;ng xanh của m&aacute;y nhờ m&agrave;n h&igrave;nh chống ch&oacute;i Anti Glare.</p>\r\n<p>&bull; C&ocirc;ng nghệ Audio by B&amp;O kết hợp với Realtek High Definition Audio đắm ch&igrave;m người d&ugrave;ng v&agrave;o ch&iacute;nh khung cảnh của trận chiến với chất &acirc;m sống động, ch&acirc;n thực.</p>', 100),
(75, 'Laptop Asus Gaming ROG Flow Z13 GZ301Z i7 12700H/1', 52990000, 'upload/dh4.jpg', 24, b'1', '<p>M&igrave;nh quyết định chọn laptop <strong>Asus Gaming ROG Flow Z13 GZ301Z i7 (LD110W)</strong> l&agrave; một trong những si&ecirc;u phẩm đ&aacute;ng mua trong tầm gi&aacute; bởi n&oacute; l&agrave; sự kết hợp ho&agrave;n hảo giữa chiếc laptop gaming mỏng nhẹ, di động nhất v&agrave; tablet Windows mạnh mẽ nhất.</p>\r\n<p><strong>Ngoại h&igrave;nh cơ động, đậm chất viễn tưởng</strong></p>\r\n<p>Thoạt nh&igrave;n, tưởng chừng như Asus ROG mang một diện mạo tựa như c&aacute;c d&ograve;ng laptop Surface Pro của nh&agrave; Microsoft nhưng khi cầm em m&aacute;y tr&ecirc;n tay để ngắm ngh&iacute;a th&igrave; n&oacute; lại sở hữu một kh&iacute; chất rất ri&ecirc;ng, phong th&aacute;i ki&ecirc;u kỳ pha t&iacute; hầm hố gaming kh&ocirc;ng lẫn v&agrave;o đ&acirc;u của Asus, điều đ&oacute; l&agrave;m cho Asus rất th&agrave;nh c&ocirc;ng trong việc thu h&uacute;t &aacute;nh nh&igrave;n của người kh&aacute;c mỗi khi m&igrave;nh mang em m&aacute;y n&agrave;y theo b&ecirc;n người.</p>\r\n<p><strong>Ph&aacute; vỡ mọi giới hạn với sức mạnh đến từ con chip Gen 12 </strong></p>\r\n<p>B&ecirc;n trong một chiếc laptop gaming tưởng chừng l&agrave; mỏng gọn, nhỏ b&eacute; như n&agrave;y nhưng lại ẩn chứa một con hổ dũng m&atilde;nh đến từ bộ vi xử l&yacute; Intel Core i7 Alder Lake 12700H, cho hiệu suất hoạt động cao hơn phi&ecirc;n bản tiền nhiệm đồng thời giảm thiểu lượng điện năng ti&ecirc;u thụ đ&aacute;ng kể. M&igrave;nh đ&atilde; l&agrave;m một v&agrave;i b&agrave;i test CPU th&ocirc;ng qua phần mềm Cinebench R23 với 2 chế độ Turbo v&agrave; Silent.</p>\r\n<p>Tổng kết lại, chiếc laptop Asus Gaming ROG Flow Z13 GZ301Z i7 (LD110W) ho&agrave;n to&agrave;n xứng đ&aacute;ng trong tầm gi&aacute; bởi những lợi &iacute;ch m&agrave; n&oacute; mang lại từ thiết kế di động gọn nhẹ đến sức mạnh bộc ph&aacute; của con chip Intel Gen 12 mạnh mẽ, kh&ocirc;ng hề l&agrave; dư thừa đối với những người d&ugrave;ng đang t&igrave;m kiếm một phi&ecirc;n bản n&acirc;ng cấp ho&agrave;n hảo của d&ograve;ng Surface ', 100);
INSERT INTO `san_pham` (`MaSP`, `TenSP`, `DonGia`, `HinhAnh`, `MaDM`, `TrangThai`, `MoTa`, `so_luong`) VALUES
(76, 'Laptop Acer Nitro 5 Tiger AN515 58 773Y i7 12700H/', 31990000, 'upload/dh5.jpg', 24, b'1', '<p>Đ&aacute;nh bật nhiều đối thủ trong c&ugrave;ng ph&acirc;n kh&uacute;c laptop gaming với sự xuất hiện của con chip Intel Gen 12 đầy mạnh mẽ, laptop <strong>Acer Nitro 5 Tiger AN515 58 773Y i7 (NH.QFKSV.001)</strong> hứa hẹn sẽ l&agrave; c&aacute;nh tay phải đắc lực cho c&aacute;c game thủ oanh tạc tr&ecirc;n mọi chiến trường.</p>\r\n<p>&bull; L&agrave; một trong những t&acirc;n binh được thừa hưởng sức mạnh đến từ bộ vi xử l&yacute; Intel Core i7 Alder Lake 12700H, laptop Acer sở hữu hiệu năng vượt trội, gi&uacute;p bạn thỏa sức tung ho&agrave;nh trong mọi thử th&aacute;ch.</p>\r\n<p>&bull; Đi k&egrave;m theo đ&oacute; l&agrave; card đồ họa NVIDIA GeForce RTX 3050Ti 4 GB, khẳng định nguồn sức mạnh v&ocirc; tận kh&ocirc;ng chỉ đ&aacute;p ứng tốt nhu cầu chiến game m&agrave; c&ograve;n ho&agrave;n th&agrave;nh xuất sắc nhiệm vụ của một chiếc laptop đồ họa - kỹ thuật.</p>\r\n<p>&bull; Vừa chiến game vừa nghe nhạc m&agrave; vẫn kh&ocirc;ng xảy ra t&igrave;nh trạng giật lag nhờ bộ nhớ RAM 8 GB. Laptop SSD 512 GB cho tốc độ đọc ghi nhanh ch&oacute;ng, bạn vẫn c&oacute; thể mở rộng kh&ocirc;ng gian lưu trữ nhờ khe cắm hỗ trợ SSD M.2 PCIe mở rộng.</p>\r\n<p>&bull; K&iacute;ch thước 15.6 inch c&ugrave;ng tấm nền IPS mang đến kh&ocirc;ng gian hiển thị h&igrave;nh ảnh rộng lớn. M&agrave;n h&igrave;nh TFT cho khả năng truyền dẫn &aacute;nh s&aacute;ng tốt, c&ocirc;ng nghệ Acer ComfyView hạn chế hiện tượng &aacute;nh s&aacute;ng xanh, bảo vệ thị lực người d&ugrave;ng.</p>\r\n<p>&bull; Tần số qu&eacute;t 144 Hz cho c&aacute;c chuyển động ảnh sắc n&eacute;t, m&agrave;u sắc chuẩn x&aacute;c, ch&acirc;n thật tr&ecirc;n từng chi tiết, hạn chế tối đa hiện tượng bị x&eacute; h&igrave;nh khi chơi c&aacute;c tựa game c&oacute; tốc độ nhanh.</p>\r\n<p>&bull; Cho cảm gi&aacute;c chơi game sống động v&agrave; hấp dẫn hơn bao giờ hết với chất lượng &acirc;m thanh to r&otilde;, dải &acirc;m rộng, độ khuếch t&aacute;n cao c&ugrave;ng khả năng t&aacute;i tạo &acirc;m thanh gần giống thực tế nhờ sự kết h', 100),
(77, 'Laptop Apple MacBook Pro M2 2022 8GB/256GB/10-core', 35990000, 'upload/dh6.jpg', 24, b'1', '<p>Sở hữu thiết kế thanh lịch, sang trọng c&ugrave;ng hiệu năng vượt trội đến từ bộ vi xử l&yacute; Apple M2 t&acirc;n tiến, <strong>Macbook Pro M2</strong> hứa hẹn sẽ đ&aacute;p ứng ho&agrave;n hảo cho người d&ugrave;ng s&aacute;ng tạo, phục vụ tốt cho c&aacute;c nhu cầu thiết kế đồ họa n&acirc;ng cao.</p>\r\n<p><strong>Hiệu năng vượt trội của chip M2 thế hệ mới</strong></p>\r\n<p>MacBook Pro 13 inch l&agrave; thiết bị đầu ti&ecirc;n được trang bị bộ vi xử l&yacute; M2 ho&agrave;n to&agrave;n mới của Apple. Mặc d&ugrave; c&ocirc;ng ty cho biết M1 Pro v&agrave; M1 Max vẫn sẽ c&oacute; lợi thế hơn về hiệu suất nhờ c&oacute; th&ecirc;m l&otilde;i nhưng M2 thể hiện một bước tiến kh&aacute; lớn so với M1.</p>\r\n<p><strong>M&agrave;n h&igrave;nh Retina sống động, l&ocirc;i cuốn</strong></p>\r\n<p>Macbook sở hữu m&agrave;n h&igrave;nh 13.3 inch c&ugrave;ng độ ph&acirc;n giải Retina (2560 x 1600) sắc n&eacute;t, cho m&agrave;u sắc trung thực. Độ tương phản cao nhờ độ s&aacute;ng 500 nits, c&ocirc;ng nghệ True tone tự động điều chỉnh mức độ s&aacute;ng để lu&ocirc;n đảm bảo hiển thị r&otilde; r&agrave;ng d&ugrave; m&igrave;nh sử dụng ở bất k&igrave; đ&acirc;u.</p>\r\n<p><strong>Thiết kế quyến rũ, biểu tượng cho sự ho&agrave;n mỹ thu h&uacute;t mọi &aacute;nh nh&igrave;n</strong></p>\r\n<p>Ấn tượng trong thiết kế của Apple lu&ocirc;n l&agrave; logo t&aacute;o khuyết được đặt ch&iacute;nh giữa mặt lưng, tạo n&ecirc;n sự nhận diện thương hiệu m&agrave; ai ai cũng phải ngước nh&igrave;n mỗi khi m&igrave;nh cầm tr&ecirc;n tay hay l&agrave;m việc ngo&agrave;i qu&aacute;n c&agrave; ph&ecirc;. Khối lượng m&aacute;y chỉ 1.4 kg v&agrave; mỏng 15.6 mm đem đến sự cơ động, dễ d&agrave;ng bỏ v&agrave;o balo để mang theo b&ecirc;n m&igrave;nh.</p>', 100),
(78, 'Laptop Apple MacBook Pro 16 M1 Max 2021 10 core-CP', 92990000, 'upload/cc1.jpg', 26, b'1', '<p>Thật ấn tượng với <strong>Apple MacBook Pro 16 M1 Max 2021</strong> mang tr&ecirc;n m&igrave;nh \"bộ &aacute;o mới\" độc đ&aacute;o, cuốn h&uacute;t mọi &aacute;nh nh&igrave;n c&ugrave;ng m&agrave;n h&igrave;nh tai thỏ lần đầu ti&ecirc;n xuất hiện ở d&ograve;ng Mac v&agrave; ẩn b&ecirc;n trong l&agrave; bộ cấu h&igrave;nh mạnh mẽ tuyệt vời đến từ con chip M1 Max t&acirc;n tiến.</p>\r\n<p>Hiệu năng vượt trội, đỉnh cao, c&acirc;n mọi t&aacute;c vụ</p>\r\n<p>MacBook Pro 16 inch với những cải tiến vượt bậc về mặt hiệu năng, hứa hẹn gi&uacute;p người d&ugrave;ng c&oacute; trải nghiệm mượt m&agrave; trong c&aacute;c t&aacute;c vụ nặng như chỉnh sửa h&igrave;nh ảnh phức tạp, render video,... hướng đến đối tượng người d&ugrave;ng c&oacute; nhu cầu sản xuất, s&aacute;ng tạo nội dung, kỹ thuật, c&ocirc;ng nghệ chuy&ecirc;n nghiệp.</p>\r\n<p>Con chip Apple M1 Max mang một sức mạnh si&ecirc;u cấp với cấu tr&uacute;c 10 nh&acirc;n v&agrave; tốc độ băng trong l&ecirc;n đến 400 GB/s memory bandwidth cho hiệu suất của Apple nhanh hơn khoảng 70% so với thế hệ tiền nhiệm Apple M1, từ đ&oacute; mang lại cho bạn một tốc độ xử l&yacute; đ&aacute;ng kinh ngạc gi&uacute;p giải quyết tốt từ c&aacute;c c&ocirc;ng việc văn ph&ograve;ng cơ bản đến phức tạp tr&ecirc;n c&aacute;c phần mềm Office 365 cũng như đồ họa chuy&ecirc;n nghiệp tr&ecirc;n Figma, Photoshop, AI, Pr, AutoCAD,...</p>\r\n<p>T&iacute;ch hợp với bộ CPU hiện đại tr&ecirc;n l&agrave; card đồ họa GPU 32 nh&acirc;n cho hiệu suất nhanh hơn gấp 4 lần so với M1, năng cao khả năng xử l&yacute; đồ họa, thoả m&atilde;n niềm đam m&ecirc; s&aacute;ng tạo cho bạn, thiết kế 2D, 3D hiệu quả, render video tuyệt vời, đồng thời tiết kiệm điện năng đ&aacute;ng kể, thấp hơn 70% so với chip 8 nh&acirc;n của PC/laptop.</p>\r\n<p>Bộ nhớ RAM 32 GB đa nhiệm cực mượt m&agrave;, tăng tốc độ truy xuất dữ liệu, giảm thời gian chờ, mọi thao t&aacute;c được phản hồi tức thời, bạn c&oacute; thể dễ d&agrave;ng mở nhiều phần mềm thiết kế để chỉnh sửa nhiều tệp h&igrave;', 100),
(79, 'Laptop MacBook Pro 14 M1 Max 2021 10-core CPU/32GB', 71900000, 'upload/cc2.jpg', 26, b'1', '<p>Kho&aacute;c l&ecirc;n m&igrave;nh vẻ ngo&agrave;i mới lạ so với c&aacute;c d&ograve;ng Mac trước đ&oacute;, thiết kế m&agrave;n h&igrave;nh tai thỏ ấn tượng, bắt mắt c&ugrave;ng bộ hiệu năng đỉnh cao M1 Max mạnh mẽ, <strong>MacBook Pro 14 inch M1 Max 2021</strong> xứng tầm l&agrave; chiếc laptop cao cấp chuy&ecirc;n dụng d&agrave;nh cho d&acirc;n kỹ thuật - đồ họa, s&aacute;ng tạo nội dung.</p>\r\n<p>Sức mạnh hiệu năng si&ecirc;u cấp, đỉnh cao đến từ MacBook M1 Max mang cấu tr&uacute;c 10 nh&acirc;n cho tốc độ băng trong l&ecirc;n đến 400 GB/s memory bandwidth nhanh hơn khoảng 70% so với thế hệ tiền nhiệm Apple M1, cung cấp tốc độ xử l&yacute; đ&aacute;ng kinh ngạc, giải quyết tối ưu mọi c&ocirc;ng việc văn ph&ograve;ng như soạn thảo hợp đồng, văn bản tr&ecirc;n c&aacute;c phần mềm Word, nhập liệu hay thống kế tr&ecirc;n Excel,... đến thiết kế đồ họa, posters, banners, s&aacute;ng tạo nội dung chuy&ecirc;n nghiệp bằng c&aacute;c c&ocirc;ng cụ Figma, Photoshop, AI, Pr, AutoCAD,...</p>\r\n<p>Card đồ họa t&iacute;ch hợp GPU 24 nh&acirc;n được trang bị trong chiếc Macbook Pro n&acirc;ng cao hiệu suất đồ họa gấp 4 lần so với M1, cho bạn tự do thiết kế c&aacute;c t&aacute;c phẩm t&acirc;m đắc, thoả sức s&aacute;ng tạo với những nội dung mới, dựng clip, render video cũng ấn tượng kh&ocirc;ng k&eacute;m m&agrave; vẫn tiết kiệm điện năng đ&aacute;ng kể.</p>\r\n<p>Laptop RAM 32 GB tăng tốc độ độc ghi, truy xuất dữ liệu, mọi thao t&aacute;c được phản hồi tức thời, khả năng đa nhiệm cực mượt m&agrave; cho bạn dễ d&agrave;ng vừa l&agrave;m việc hiệu quả tr&ecirc;n c&aacute;c phần mềm thiết kế để chỉnh sửa h&igrave;nh ảnh, render video c&ugrave;ng l&uacute;c.</p>', 100),
(80, 'Laptop Asus Gaming ROG Flow Z13 GZ301Z i7 12700H/1', 52990000, 'upload/cc3.jpg', 26, b'1', '<p>M&igrave;nh quyết định chọn laptop <strong>Asus Gaming ROG Flow Z13 GZ301Z i7 (LD110W)</strong> l&agrave; một trong những si&ecirc;u phẩm đ&aacute;ng mua trong tầm gi&aacute; bởi n&oacute; l&agrave; sự kết hợp ho&agrave;n hảo giữa chiếc laptop gaming mỏng nhẹ, di động nhất v&agrave; tablet Windows mạnh mẽ nhất.</p>\r\n<p><strong>Ngoại h&igrave;nh cơ động, đậm chất viễn tưởng</strong></p>\r\n<p>Thoạt nh&igrave;n, tưởng chừng như Asus ROG mang một diện mạo tựa như c&aacute;c d&ograve;ng laptop Surface Pro của nh&agrave; Microsoft nhưng khi cầm em m&aacute;y tr&ecirc;n tay để ngắm ngh&iacute;a th&igrave; n&oacute; lại sở hữu một kh&iacute; chất rất ri&ecirc;ng, phong th&aacute;i ki&ecirc;u kỳ pha t&iacute; hầm hố gaming kh&ocirc;ng lẫn v&agrave;o đ&acirc;u của Asus, điều đ&oacute; l&agrave;m cho Asus rất th&agrave;nh c&ocirc;ng trong việc thu h&uacute;t &aacute;nh nh&igrave;n của người kh&aacute;c mỗi khi m&igrave;nh mang em m&aacute;y n&agrave;y theo b&ecirc;n người.</p>\r\n<p><strong>Ph&aacute; vỡ mọi giới hạn với sức mạnh đến từ con chip Gen 12 </strong></p>\r\n<p>B&ecirc;n trong một chiếc laptop gaming tưởng chừng l&agrave; mỏng gọn, nhỏ b&eacute; như n&agrave;y nhưng lại ẩn chứa một con hổ dũng m&atilde;nh đến từ bộ vi xử l&yacute; Intel Core i7 Alder Lake 12700H, cho hiệu suất hoạt động cao hơn phi&ecirc;n bản tiền nhiệm đồng thời giảm thiểu lượng điện năng ti&ecirc;u thụ đ&aacute;ng kể. M&igrave;nh đ&atilde; l&agrave;m một v&agrave;i b&agrave;i test CPU th&ocirc;ng qua phần mềm Cinebench R23 với 2 chế độ Turbo v&agrave; Silent.</p>', 100),
(81, 'Laptop Asus Zenbook 14X OLED Space Edition UX5401Z', 36490000, 'upload/cc4.jpg', 26, b'1', '<p>Một chiếc laptop đến từ nh&agrave; Asus mang trong m&igrave;nh những t&iacute;nh năng vượt trội, thiết kế sang trọng nhưng kh&ocirc;ng k&eacute;m phần hầm hố. Sở hữu con chip mới nhất đến từ intel thế hệ thứ 12 v&ocirc; c&ugrave;ng mạnh mẽ, mang lại một hiệu năng ấn tượng đ&aacute;p ứng mượt m&agrave; c&aacute;c nhu cầu c&ocirc;ng việc hằng ng&agrave;y. Những t&iacute;nh năng độc đ&aacute;o đ&oacute; đều được trang bị tr&ecirc;n chiếc laptop <strong>Asus Zenbook 14X OLED Space Edition UX5401ZAS i7 (KN070W).</strong></p>\r\n<p><strong>Ng&ocirc;n ngữ thiết kế sang trọng, hiện đại</strong></p>\r\n<p>Laptop Asus Zenbook sở hữu vỏ kim loại được chế t&aacute;c ho&agrave;n thiện khi phủ l&ecirc;n m&igrave;nh m&agrave;u sơn Zero-G Titanium độc quyền. Chưa dừng lại ở đ&oacute;, Asus Zenbook 14X OLED Space Edition được trang bị th&ecirc;m m&agrave;n h&igrave;nh OLED ZenVision cao cấp với k&iacute;ch thước nhỏ gọn chỉ 3.5 inch ph&iacute;a sau mặt lưng m&aacute;y, nhưng lại thể hiện được đầy đủ th&ocirc;ng tin gi&uacute;p bạn dễ d&agrave;ng xem được những th&ocirc;ng b&aacute;o quan trọng, nhưng vẫn tạo được cảm gi&aacute;c liền lạc với tổng thể m&aacute;y.</p>\r\n<p><strong>Hiệu năng đ&aacute;ng kinh ngạc tr&ecirc;n con Chip Intel Core i7 Alder Lake Gen 12</strong></p>\r\n<p>Khơi nguồn sức mạnh tiềm năng từ laptop Intel Core i7 Alder Lake-12700H 14 nh&acirc;n v&agrave; 20 luồng tốc độ tối đa l&ecirc;n đến 4.7 GHz theo đ&oacute; l&agrave; card t&iacute;ch hợp Intel Iris Xe Graphics một con số vượt trội so với thế hệ trước, vận h&agrave;nh ho&agrave;n hảo mọi t&aacute;c vụ văn ph&ograve;ng từ cơ bản đến n&acirc;ng cao, đồng thời chạy mượt m&agrave; những t&aacute;c vụ chỉnh ảnh, thiết kế tr&ecirc;n những ứng dụng Adobe.</p>', 100),
(82, 'Laptop Apple MacBook Pro M1 2020 16GB/512GB (Z11C)', 45590000, 'upload/cc5.jpg', 26, b'1', '<p><strong>Macbook Pro M1 2020</strong> được n&acirc;ng cấp với bộ vi xử l&yacute; mới cực kỳ mạnh mẽ, chiếc laptop n&agrave;y sẽ phục vụ tốt cho c&ocirc;ng việc của bạn, đặc biệt cho lĩnh vực đồ họa, kỹ thuật.</p>\r\n<p><strong>Tăng cường kh&ocirc;ng gian lưu trữ, tốc độ xử l&yacute;</strong></p>\r\n<p>Chip Apple M1 l&agrave; một bộ vi xử l&yacute; mạnh mẽ, được ra mắt lần đầu ti&ecirc;n tr&ecirc;n m&aacute;y Mac. Đ&acirc;y l&agrave; con chip sản xuất tr&ecirc;n tiến tr&igrave;nh 5 nm, t&iacute;ch hợp CPU 8 l&otilde;i với 4 l&otilde;i CPU tốc độ v&agrave; v&agrave; 4 l&otilde;i tiết kiệm năng lượng. Nhờ vậy, thời lượng pin của laptop được k&eacute;o d&agrave;i đến tận 10 tiếng đồng hồ, gi&uacute;p cho bạn thoải m&aacute;i l&agrave;m việc với một hiệu suất cực kỳ cao.</p>\r\n<p><strong>Kiểu d&aacute;ng thời trang, mỏng nhẹ</strong></p>\r\n<p>Chiếc laptop phi&ecirc;n bản thời thượng với vỏ kim loại nguy&ecirc;n khối cực kỳ sang trọng, nhỏ gọn v&agrave; thời trang. Bạn cũng c&oacute; thể dễ d&agrave;ng cho Macbook Pro 2020 v&agrave;o cặp x&aacute;ch hay balo, cầm tr&ecirc;n tay nhẹ nh&agrave;ng để di chuyển bất cứ nơi đ&acirc;u chỉ với khối lượng 1.4 kg v&agrave; mỏng 15.6 mm.</p>\r\n<p><strong>H&igrave;nh ảnh ch&acirc;n thật đến từng chi tiết</strong></p>\r\n<p>Với độ ph&acirc;n giải 2560 x 1600 v&ocirc; c&ugrave;ng sắc n&eacute;t, m&agrave;n h&igrave;nh Retina 13.3 inch hiển thị l&yacute; tưởng mọi nội dung bạn cần theo d&otilde;i, từ trang web, văn bản r&otilde; r&agrave;ng cho đến những đoạn phim sống động.</p>', 100),
(83, 'Laptop Apple MacBook Pro M1 2020 8GB/512GB (MYD92S', 40190000, 'upload/cc6.jpg', 26, b'1', '<p><strong>Apple Macbook Pro M1 2020</strong> với hiệu năng cực kỳ mạnh mẽ t&iacute;ch hợp chip Apple M1 lần đầu xuất hiện tr&ecirc;n d&ograve;ng Mac, con laptop n&agrave;y hứa hẹn sẽ mang đến cho bạn một sản phẩm &ldquo;Pro&rdquo; chưa từng thấy.</p>\r\n<p><strong>Sức mạnh kinh ngạc đến từ con chip M1 độc quyền của Apple</strong></p>\r\n<p>Với sự ra mắt lần đầu t&iacute;ch hợp tr&ecirc;n MacBook, chip Apple M1 mang đến lợi &iacute;ch nhiều hơn r&otilde; r&agrave;ng so với chip Intel. Sở hữu thiết kế phần cứng nhỏ gọn v&agrave; đẹp mắt cộng với CPU 8 l&otilde;i đem lại tốc độ xử l&yacute; nhanh gấp 2.8 lần so với thế hệ trước v&agrave; k&eacute;o d&agrave;i thời lượng pin l&ecirc;n đến 10 giờ đồng hồ.</p>\r\n<p>Card đồ họa t&iacute;ch hợp 8 nh&acirc;n GPU đem lại năng suất cao, tốc độ thao t&aacute;c thiết kế đồ họa gấp 5 lần c&aacute;c thế hệ trước đ&oacute;, gi&uacute;p bạn thao t&aacute;c mượt m&agrave; c&aacute;c t&aacute;c vụ văn ph&ograve;ng Word, Excel, Power Point,... cũng như chỉnh sửa ảnh 3D bằng Photoshop, AI,... hay render video bằng Pr.</p>\r\n<p><strong>Trải nghiệm h&igrave;nh ảnh sắc n&eacute;t, sống động</strong></p>\r\n<p>Bạn sẽ được tận hưởng m&agrave;n h&igrave;nh Retina 13.3 inch tuyệt đẹp với độ ph&acirc;n giải 2560 x 1600, độ s&aacute;ng m&agrave;n h&igrave;nh l&ecirc;n đến 500 nits gi&uacute;p bạn dễ d&agrave;ng l&agrave;m việc với độ s&aacute;ng vừa phải v&agrave; h&igrave;nh ảnh cực kỳ ch&acirc;n thực, sắc n&eacute;t.</p>\r\n<p>&nbsp;</p>', 97);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tai_khoan`
--

CREATE TABLE `tai_khoan` (
  `TenDangNhap` varchar(50) NOT NULL,
  `MatKhau` varchar(50) DEFAULT NULL,
  `HoTen` varchar(50) DEFAULT NULL,
  `GioiTinh` bit(1) DEFAULT NULL,
  `SDT` varchar(10) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `DiaChi` varchar(100) DEFAULT NULL,
  `MaLoai` int(11) DEFAULT NULL,
  `TrangThai` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tai_khoan`
--

INSERT INTO `tai_khoan` (`TenDangNhap`, `MatKhau`, `HoTen`, `GioiTinh`, `SDT`, `Email`, `DiaChi`, `MaLoai`, `TrangThai`) VALUES
('trang', 'Jun$123456789', 'Lê Trang', b'1', '0777478157', 'trang@gmail.com', 'Đà Nẵng', 1, b'1');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bao_hanh`
--
ALTER TABLE `bao_hanh`
  ADD PRIMARY KEY (`MaBH`);

--
-- Chỉ mục cho bảng `chat_history`
--
ALTER TABLE `chat_history`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `chi_tiet_bao_hanh`
--
ALTER TABLE `chi_tiet_bao_hanh`
  ADD PRIMARY KEY (`MaCT_BH`),
  ADD KEY `MaBH` (`MaBH`),
  ADD KEY `fk_mahd` (`MaHD`);

--
-- Chỉ mục cho bảng `chi_tiet_hoa_don`
--
ALTER TABLE `chi_tiet_hoa_don`
  ADD PRIMARY KEY (`MaCT_HD`),
  ADD KEY `idx_MaHD` (`MaHD`),
  ADD KEY `idx_MaSP` (`MaSP`);

--
-- Chỉ mục cho bảng `chi_tiet_khuyen_mai`
--
ALTER TABLE `chi_tiet_khuyen_mai`
  ADD PRIMARY KEY (`MaCTKM`);

--
-- Chỉ mục cho bảng `danhgia`
--
ALTER TABLE `danhgia`
  ADD PRIMARY KEY (`MaDG`,`MaSP`),
  ADD KEY `MaSP` (`MaSP`),
  ADD KEY `TenDangNhap` (`TenDangNhap`);

--
-- Chỉ mục cho bảng `danh_muc`
--
ALTER TABLE `danh_muc`
  ADD PRIMARY KEY (`MaDM`),
  ADD KEY `MaThue` (`MaThue`);

--
-- Chỉ mục cho bảng `hoa_don`
--
ALTER TABLE `hoa_don`
  ADD PRIMARY KEY (`MaHD`);

--
-- Chỉ mục cho bảng `hoa_don_online`
--
ALTER TABLE `hoa_don_online`
  ADD PRIMARY KEY (`MaHD`);

--
-- Chỉ mục cho bảng `khuyen_mai`
--
ALTER TABLE `khuyen_mai`
  ADD PRIMARY KEY (`MaKM`);

--
-- Chỉ mục cho bảng `loai_tk`
--
ALTER TABLE `loai_tk`
  ADD PRIMARY KEY (`MaLoai`);

--
-- Chỉ mục cho bảng `log_khuyen_mai`
--
ALTER TABLE `log_khuyen_mai`
  ADD PRIMARY KEY (`LogID`),
  ADD KEY `MaKM` (`MaKM`),
  ADD KEY `TenDangNhap` (`TenDangNhap`);

--
-- Chỉ mục cho bảng `nhan_vien`
--
ALTER TABLE `nhan_vien`
  ADD PRIMARY KEY (`MaNV`);

--
-- Chỉ mục cho bảng `nhap_xuat`
--
ALTER TABLE `nhap_xuat`
  ADD PRIMARY KEY (`MaNhapXuat`,`MaSP`),
  ADD KEY `MaSP` (`MaSP`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `san_pham`
--
ALTER TABLE `san_pham`
  ADD PRIMARY KEY (`MaSP`),
  ADD KEY `MaDM` (`MaDM`);

--
-- Chỉ mục cho bảng `tai_khoan`
--
ALTER TABLE `tai_khoan`
  ADD PRIMARY KEY (`TenDangNhap`),
  ADD KEY `MaLoai` (`MaLoai`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bao_hanh`
--
ALTER TABLE `bao_hanh`
  MODIFY `MaBH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `chat_history`
--
ALTER TABLE `chat_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `chi_tiet_bao_hanh`
--
ALTER TABLE `chi_tiet_bao_hanh`
  MODIFY `MaCT_BH` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `chi_tiet_hoa_don`
--
ALTER TABLE `chi_tiet_hoa_don`
  MODIFY `MaCT_HD` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `chi_tiet_khuyen_mai`
--
ALTER TABLE `chi_tiet_khuyen_mai`
  MODIFY `MaCTKM` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `danhgia`
--
ALTER TABLE `danhgia`
  MODIFY `MaDG` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `hoa_don`
--
ALTER TABLE `hoa_don`
  MODIFY `MaHD` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `khuyen_mai`
--
ALTER TABLE `khuyen_mai`
  MODIFY `MaKM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `log_khuyen_mai`
--
ALTER TABLE `log_khuyen_mai`
  MODIFY `LogID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `nhan_vien`
--
ALTER TABLE `nhan_vien`
  MODIFY `MaNV` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chi_tiet_hoa_don`
--
ALTER TABLE `chi_tiet_hoa_don`
  ADD CONSTRAINT `fk_MaHD` FOREIGN KEY (`MaHD`) REFERENCES `hoa_don` (`MaHD`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_MaSP` FOREIGN KEY (`MaSP`) REFERENCES `san_pham` (`MaSP`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `log_khuyen_mai`
--
ALTER TABLE `log_khuyen_mai`
  ADD CONSTRAINT `log_khuyen_mai_ibfk_1` FOREIGN KEY (`MaKM`) REFERENCES `khuyen_mai` (`MaKM`),
  ADD CONSTRAINT `log_khuyen_mai_ibfk_2` FOREIGN KEY (`TenDangNhap`) REFERENCES `tai_khoan` (`TenDangNhap`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
