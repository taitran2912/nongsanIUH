-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 06, 2025 lúc 07:08 AM
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
-- Cơ sở dữ liệu: `nongsan`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `farmer_id` int(11) NOT NULL,
  `last_message` text NOT NULL,
  `last_sent_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `farms`
--

CREATE TABLE `farms` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `description` text NOT NULL,
  `owner_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `farms`
--

INSERT INTO `farms` (`id`, `name`, `address`, `description`, `owner_id`) VALUES
(1, 'HTX ĐÀ LẠT FARM', '66 Đan Kia, Phường 7. TP Đà Lạt', 'Cung cấp các loại rau, củ, quả\r\nAnh Sĩ 0702499445', 1),
(2, 'HTX Rau an toàn Trúc Lâm', 'ấp Thanh Thọ 3, Xã Phú Lâm, Huyện Tân Phú, Đồng Nai', 'Cung cấp các loại rau ăn lá, rau quả, sản lượng 10 tấn/ngày, LH: 0919814401', 2),
(3, 'HTX nông nghiệp Phương Nam', 'Gia Kiệm - Thống Nhất, Đồng Nai ', 'LH: 0933775999', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `chat_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `farm_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `quantity`, `farm_id`, `created_at`) VALUES
(1, 'Bắp cải trái tim', 'Bắp cải tim hay còn gọi là bắp sú tim là một loại bắp cải nhưng có hình trái tim lạ mắt. Đây là loại bắp cải được nhiều người ưa thích bởi hình dáng đặc biệt, kích thước vừa phải không quá to như bắp cải thông thường. Loại bắp cải này có nguồn gốc từ Địa Trung Hải, thích hợp trồng ở những vùng có khí hậu ôn đới.', 20000.00, 1000, 1, '2025-05-05 14:10:32'),
(2, 'Bí đỏ non', 'Bí đỏ non là một loại bí có hình tròn, kích thước khá nhỏ, chỉ khoảng 1 nắm tay. Vỏ có màu xanh đậm, mềm, có thể ăn được cả vỏ. Phần thịt bên trong có màu vàng nhạt, vị ngọt thanh, béo nhẹ. Bí đỏ non có thể chế biến thành nhiều món ăn hấp dẫn như các món canh, luộc, xào, làm bánh, nấu chè...', 25000.00, 1000, 1, '2025-05-05 14:12:20'),
(3, 'Bó xôi', 'Rau bó xôi (spinach) được trồng theo phương pháp hữu cơ, không sử dụng thuốc trừ sâu và phân bón hóa học. Lá xanh đậm, dày, giàu chất sắt và vitamin A, rất tốt cho người thiếu máu và trẻ em đang phát triển.', 28000.00, 500, 1, '2025-05-05 14:17:31'),
(4, 'Cà chua beef', 'Cà chua beef canh tác tự nhiên, không thuốc kích thích. Trái to, thịt dày, ít hạt, giàu lycopene giúp chống oxy hóa và làm đẹp da. Thích hợp làm salad, sốt cà, hoặc ăn sống.', 30000.00, 600, 1, '2025-05-05 14:17:31'),
(5, 'Cà chua cherry', 'Cà chua cherry sạch trồng trong nhà màng, trái nhỏ, ngọt thanh, chứa nhiều vitamin C. Được kiểm định chất lượng định kỳ để đảm bảo an toàn tuyệt đối cho người tiêu dùng.', 35000.00, 400, 1, '2025-05-05 14:17:31'),
(6, 'Cải cầu vồng', 'Cải cầu vồng canh tác bằng kỹ thuật thủy canh hiện đại, không hóa chất. Lá giòn, màu sắc bắt mắt, chứa nhiều chất xơ và khoáng chất, giúp tăng cường đề kháng và hỗ trợ tiêu hóa.', 32000.00, 300, 1, '2025-05-05 14:17:31'),
(7, 'Cải Kale', 'Rau cải Kale được mệnh danh là “vua rau xanh”, giàu chất chống oxy hóa, vitamin K và canxi. Sản phẩm được trồng sạch theo quy trình đạt chuẩn VietGAP, đảm bảo không tồn dư hóa chất.', 45000.00, 200, 1, '2025-05-05 14:17:31'),
(8, 'Cải ngồng', 'Cải ngồng sạch, thu hoạch từ nông trại canh tác hữu cơ. Cọng non giòn, vị ngọt tự nhiên. Thích hợp xào tỏi, luộc hoặc làm món ăn chay thanh đạm.', 26000.00, 550, 1, '2025-05-05 14:17:31'),
(9, 'Cải ngọt', 'Cải ngọt được trồng bằng phân hữu cơ vi sinh, lá xanh mướt, vị ngọt nhẹ tự nhiên. Rất phù hợp nấu canh, xào thịt bò hoặc luộc ăn kèm nước mắm chua ngọt.', 24000.00, 700, 1, '2025-05-05 14:17:31'),
(10, 'Cải thìa', 'Cải thìa hữu cơ, lá dày, thân trắng mập, có vị thanh mát. Trồng bằng công nghệ thủy canh tuần hoàn, không thuốc trừ sâu, phù hợp cho bé ăn dặm và người lớn tuổi.', 27000.00, 450, 1, '2025-05-05 14:17:31'),
(11, 'Cà rốt hữu cơ', 'Cà rốt trồng từ giống sạch, tưới nước giếng khoan tự nhiên, giàu beta-carotene, giúp sáng mắt và tốt cho hệ miễn dịch. Không dùng thuốc trừ sâu trong suốt quá trình canh tác.', 30000.00, 800, 1, '2025-05-05 14:17:31'),
(12, 'Củ cải đỏ', 'Củ cải đỏ canh tác theo hướng hữu cơ, củ nhỏ, vỏ mịn, giàu anthocyanin – chất chống oxy hóa mạnh. Có thể ăn sống, muối chua hoặc nấu súp.', 29000.00, 400, 1, '2025-05-05 14:17:31'),
(13, 'Củ cải trắng', 'Củ cải trắng sạch, trồng bằng phân vi sinh, không hóa chất. Vị ngọt dịu, giúp thanh nhiệt, giải độc gan và hỗ trợ tiêu hóa rất tốt.', 27000.00, 650, 1, '2025-05-05 14:17:31'),
(14, 'Đậu bắp', 'Đậu bắp canh tác an toàn, quả non, ít nhớt, giàu chất xơ và acid folic. Phù hợp cho bà bầu và người ăn kiêng. Cam kết không dư lượng thuốc bảo vệ thực vật.', 25000.00, 500, 1, '2025-05-05 14:17:31'),
(15, 'Dưa leo bao tử', 'Dưa leo bao tử nhỏ gọn, da mỏng, giòn ngọt. Trồng trong nhà kính theo tiêu chuẩn GlobalGAP, đảm bảo độ sạch và độ giòn tự nhiên.', 32000.00, 300, 1, '2025-05-05 14:17:31'),
(16, 'Dưa leo Nhật', 'Dưa leo Nhật hữu cơ, trái dài, ít hạt, vỏ xanh bóng. Trồng theo phương pháp tưới nhỏ giọt tiết kiệm nước, bảo vệ môi trường và cho chất lượng trái đồng đều.', 35000.00, 200, 1, '2025-05-05 14:17:31'),
(17, 'Khoai lang mật', 'Khoai lang mật được trồng trên đất đỏ bazan màu mỡ, không thuốc hóa học. Khi nướng lên có vị ngọt đậm, dẻo và rất thơm, giàu tinh bột tốt cho sức khỏe.', 28000.00, 800, 1, '2025-05-05 14:17:31'),
(18, 'Khoai môn', 'Khoai môn sạch, củ chắc, ít xơ, trồng hoàn toàn bằng phân bón hữu cơ. Khi nấu có vị bùi béo tự nhiên, không ngậm hóa chất.', 27000.00, 300, 1, '2025-05-05 14:17:31'),
(19, 'Khoai sọ', 'Khoai sọ được trồng tại vùng cao, dùng phân chuồng ủ hoai mục. Củ nhỏ, nhiều tinh bột, dẻo, bùi, thích hợp nấu canh cua hoặc kho thịt.', 26000.00, 400, 1, '2025-05-05 14:17:31'),
(20, 'Mồng tơi baby', 'Mồng tơi baby lá nhỏ, mềm, trồng bằng kỹ thuật an toàn sinh học. Rất giàu vitamin và chất nhầy, tốt cho tiêu hóa và thanh nhiệt cơ thể.', 22000.00, 600, 1, '2025-05-05 14:17:31'),
(21, 'Rau dền baby', 'Rau dền baby sạch, không thuốc trừ sâu, lá non và mềm. Chứa nhiều sắt, giúp bổ máu, hỗ trợ hệ tuần hoàn và được khuyên dùng cho phụ nữ sau sinh.', 23000.00, 500, 1, '2025-05-05 14:17:31'),
(22, 'Su hào xanh', 'Su hào xanh từ nông trại sạch, củ giòn, nhiều nước, không chất tăng trưởng. Dễ chế biến trong món xào, nấu canh, hoặc làm nộm.', 25000.00, 350, 1, '2025-05-05 14:17:31'),
(23, 'Súp lơ xanh baby', 'Súp lơ xanh baby có hoa nhỏ, non, màu xanh đậm. Canh tác theo mô hình nông nghiệp tuần hoàn, chứa nhiều vitamin C, E và chất xơ.', 30000.00, 250, 1, '2025-05-05 14:17:31'),
(24, 'Xà lách lolo thủy canh', 'Xà lách lolo trồng theo mô hình thủy canh kín, lá mềm, vị mát, không có dư lượng kim loại nặng. An toàn tuyệt đối cho người ăn sống.', 27000.00, 450, 1, '2025-05-05 14:17:31'),
(25, 'Bưởi hoàng lâu năm', 'Bưởi được thu hoạch từ những cây lâu năm trồng theo hướng hữu cơ. Trái to, vỏ mỏng, tép mọng nước, vị ngọt thanh. Giàu vitamin C và chất xơ, rất tốt cho hệ miễn dịch.', 48000.00, 150, 2, '2025-05-05 14:28:31'),
(26, 'Cam sành hữu cơ', 'Cam sành được trồng không phân bón hóa học, vỏ mỏng, ngọt đậm, có mùi thơm đặc trưng. Cam kết không dư lượng thuốc trừ sâu, an toàn cho sức khỏe gia đình.', 35000.00, 200, 2, '2025-05-05 14:28:31'),
(27, 'Chuối laba', 'Chuối Laba trồng theo tiêu chuẩn hữu cơ, trái dài, vỏ mỏng, ngọt dẻo. Là giống chuối quý của Đà Lạt, phù hợp ăn tươi hoặc làm món tráng miệng.', 28000.00, 250, 2, '2025-05-05 14:28:31'),
(28, 'Dưa hấu không hạt', 'Dưa hấu không hạt được trồng tự nhiên, không thuốc tăng trưởng. Thịt đỏ đậm, ngọt mát, mọng nước. Là lựa chọn tuyệt vời cho mùa hè.', 18000.00, 300, 2, '2025-05-05 14:28:31'),
(29, 'Kiwi vàng', 'Kiwi vàng nhập giống từ New Zealand, trồng tại nông trại sạch, không thuốc trừ sâu. Vị ngọt chua nhẹ, giàu vitamin C, hỗ trợ làm đẹp da và tiêu hóa.', 52000.00, 100, 2, '2025-05-05 14:28:31'),
(30, 'Na bà đen', 'Na Bà Đen canh tác hữu cơ tại vùng núi Tây Ninh, trái to, mắt mịn, ngọt thanh. Rất giàu năng lượng và vitamin B6, phù hợp cho người ăn chay.', 45000.00, 120, 2, '2025-05-05 14:28:31'),
(31, 'Ớt chỉ thiên', 'Ớt chỉ thiên sạch, cay nồng tự nhiên, trồng trong điều kiện không hóa chất. Thích hợp làm gia vị, kích thích tiêu hóa và chống oxy hóa tốt.', 22000.00, 90, 2, '2025-05-05 14:28:31'),
(32, 'Ớt chuông đỏ', 'Ớt chuông đỏ được trồng trong nhà màng, không sử dụng hóa chất độc hại. Thịt dày, vị ngọt, giàu vitamin A và C. Phù hợp cho món salad và nướng.', 32000.00, 80, 2, '2025-05-05 14:28:31'),
(33, 'Ớt chuông vàng', 'Ớt chuông vàng sạch, trái to, vỏ bóng, giàu chất chống oxy hóa và chất xơ. Trồng bằng công nghệ tưới nhỏ giọt tiết kiệm nước và không thuốc trừ sâu.', 32000.00, 80, 2, '2025-05-05 14:28:31'),
(34, 'Táo envy', 'Táo Envy được nhập giống và trồng trong điều kiện hữu cơ tại cao nguyên. Vỏ đỏ bóng, giòn ngọt, không wax, an toàn tuyệt đối cho trẻ nhỏ.', 68000.00, 150, 2, '2025-05-05 14:28:31'),
(35, 'Thanh long ruột đỏ', 'Thanh long ruột đỏ sạch, vỏ mỏng, ruột ngọt và mọng nước. Canh tác không hóa chất, rất giàu chất xơ và chất chống oxy hóa tự nhiên.', 29000.00, 220, 2, '2025-05-05 14:28:31'),
(36, 'Thơm', 'Thơm (dứa) canh tác không thuốc trừ sâu, mắt nhỏ, vỏ mỏng, thịt vàng, ngọt dịu. Thơm giàu enzym bromelain hỗ trợ tiêu hóa và kháng viêm.', 18000.00, 240, 2, '2025-05-05 14:28:31'),
(37, 'Xoài cát Hòa Lộc', 'Xoài cát Hòa Lộc được canh tác theo tiêu chuẩn VietGAP, trái to, vỏ mỏng, ngọt đậm đà. Không sử dụng thuốc ép chín, giữ được hương vị truyền thống.', 42000.00, 260, 2, '2025-05-05 14:28:31'),
(38, 'Bún gạo', 'Bún gạo truyền thống được làm từ 100% gạo sạch không pha trộn phụ gia, không chất tẩy trắng. Sợi bún dai, thơm, thích hợp dùng cho món bún xào, bún nước hoặc salad.', 30000.00, 200, 3, '2025-05-05 14:31:45'),
(39, 'Gạo nếp cẩm ĐSTB', 'Gạo nếp cẩm Đồng bằng Sông Tiền được trồng theo phương pháp hữu cơ, không thuốc diệt cỏ. Hạt nếp đen tím tự nhiên, dẻo mềm, giàu chất chống oxy hóa và tốt cho tim mạch.', 42000.00, 180, 3, '2025-05-05 14:31:45'),
(40, 'Hạt sen tươi', 'Hạt sen thu hoạch tại vườn sen sạch, không sử dụng thuốc bảo vệ thực vật. Hạt tròn, chắc, ngọt bùi, rất tốt cho giấc ngủ và hệ thần kinh.', 60000.00, 100, 3, '2025-05-05 14:31:45'),
(41, 'Mật dừa nước', 'Mật dừa nước là sản phẩm lên men tự nhiên từ cây dừa nước miền Tây, không đường hóa học, không chất bảo quản. Vị ngọt dịu, tốt cho người tiểu đường và hỗ trợ tiêu hóa.', 75000.00, 80, 3, '2025-05-05 14:31:45'),
(42, 'Miến dong Kim Bội', 'Miến dong Kim Bội được làm từ củ dong nguyên chất, không phẩm màu, không chất tẩy trắng. Sợi dai, mềm, thơm, không bị nát khi nấu. Đạt chứng nhận an toàn thực phẩm.', 45000.00, 120, 3, '2025-05-05 14:31:45'),
(43, 'Mì trứng', 'Mì trứng tươi được làm từ trứng gà sạch và bột mì nguyên chất. Không chất bảo quản, không màu nhân tạo. Sợi mì vàng ươm, mềm dai, thơm béo tự nhiên.', 38000.00, 150, 3, '2025-05-05 14:31:45'),
(44, 'Nấm bào ngư', 'Nấm bào ngư sạch trồng trong môi trường kiểm soát nghiêm ngặt, không hóa chất. Nấm trắng mịn, ngọt tự nhiên, giàu đạm thực vật và vitamin nhóm B.', 32000.00, 130, 3, '2025-05-05 14:31:45'),
(45, 'Nấm đùi gà', 'Nấm đùi gà canh tác trong nhà lạnh, không sử dụng thuốc tăng trưởng. Thân to, giòn, ngọt, có thể chế biến nhiều món ăn bổ dưỡng và thanh đạm.', 38000.00, 110, 3, '2025-05-05 14:31:45'),
(46, 'Nấm linh chi', 'Nấm linh chi đỏ tự nhiên, nuôi trồng theo phương pháp hữu cơ. Có công dụng tăng cường miễn dịch, hỗ trợ gan, thanh lọc cơ thể, chống lão hóa.', 98000.00, 60, 3, '2025-05-05 14:31:45'),
(47, 'Nấm mỡ', 'Nấm mỡ được thu hái trong hệ thống nhà trồng đạt chuẩn VietGAP. Thịt nấm mềm, vị béo nhẹ, có lợi cho tim mạch và hệ tiêu hóa.', 35000.00, 90, 3, '2025-05-05 14:31:45'),
(48, 'Tiêu Tiên Phước', 'Tiêu đen Tiên Phước được phơi nắng tự nhiên, không sấy hóa chất, không tẩm màu. Hạt chắc, thơm nồng, cay đậm vị, giúp tăng cường đề kháng.', 55000.00, 140, 3, '2025-05-05 14:31:45');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `img` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `img`) VALUES
(1, 1, 'bapcaitraitim.jpg'),
(2, 2, 'bidonon.jpg'),
(3, 3, 'boxoi.jpg'),
(4, 4, 'cachuabeef.jpg'),
(5, 5, 'cachuacherry.jpeg'),
(6, 6, 'caicauvong.jpg'),
(7, 7, 'caikale.jpeg'),
(8, 8, 'caingong.png'),
(9, 9, 'caingot.png'),
(10, 10, 'caithia.jpg'),
(11, 11, 'carothuuco.webp'),
(12, 12, 'cucaido.jpeg'),
(13, 13, 'cucaitrang.jpeg'),
(14, 14, 'daubap.jpg'),
(15, 15, 'dualeobaotu.png'),
(16, 16, 'dualeonhat.jpg'),
(17, 17, 'khoailangmat.jpg'),
(18, 18, 'khoaimon.jpg'),
(19, 19, 'khoaiso.jpg'),
(20, 20, 'mongtoibaby.png'),
(21, 21, 'raudenbaby.jpg'),
(22, 22, 'suhaoxanh.jpg'),
(23, 23, 'suploxanhbaby.jpg'),
(24, 24, 'xalachlolothuycanh.jpg'),
(25, 25, 'buoihoanglaunam.webp'),
(26, 26, 'camsanhhuuco.jpg'),
(27, 27, 'chuoilaba.jpg'),
(28, 28, 'duahaukhonghat.jpg'),
(29, 29, 'kiwivang.jpg'),
(30, 30, 'nabaden.jpg'),
(31, 31, 'otchithien.jpeg'),
(32, 32, 'otchuongdo.png'),
(33, 33, 'otchuongvang.jpg'),
(34, 34, 'taoenvy.jpg'),
(35, 35, 'thanhlongruotdo.jpg'),
(36, 36, 'thom.jpg'),
(37, 37, 'xoaicathoaloc.jpg'),
(38, 38, 'bungao.jpg'),
(39, 39, 'gaonepcamdstb.webp'),
(40, 40, 'hatsentuoi.jpg'),
(41, 41, 'matduanuoc.jpg'),
(42, 42, 'miendongkimboi.jpg'),
(43, 43, 'mitrung.png'),
(44, 44, 'nambaongu.jpg'),
(45, 45, 'namduiga.jpg'),
(46, 46, 'namlinhchi.jpg'),
(47, 47, 'nammo.jpg'),
(48, 48, 'tieutienphuoc.jpeg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reply`
--

CREATE TABLE `reply` (
  `id` int(11) NOT NULL,
  `id_review` int(11) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `reviewed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `method` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` varchar(50) NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `address`, `role`) VALUES
(1, 'Nguyen Van A', 'vana@example.com', 'e10adc3949ba59abbe56e057f20f883e', '0901234567', '123 Le Loi, District 1, HCMC', 1),
(2, 'Tran Thi B', 'thib@example.com', 'e10adc3949ba59abbe56e057f20f883e', '0902234567', '456 Nguyen Trai, District 5, HCMC', 1),
(3, 'Le Van C', 'vanc@example.com', 'e10adc3949ba59abbe56e057f20f883e', '0903234567', '789 Cach Mang Thang 8, District 3, HCMC', 1),
(4, 'Pham Thi D', 'thid@example.com', 'e10adc3949ba59abbe56e057f20f883e', '0904234567', '12 Tran Hung Dao, District 1, HCMC', 2),
(5, 'Hoang Van E', 'vane@example.com', 'e10adc3949ba59abbe56e057f20f883e', '0905234567', '98 Ly Thuong Kiet, District 10, HCMC', 2),
(6, 'test', 'test@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '0334037926', '12', 1);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buyer_id` (`buyer_id`),
  ADD KEY `farmer_id` (`farmer_id`);

--
-- Chỉ mục cho bảng `farms`
--
ALTER TABLE `farms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Chỉ mục cho bảng `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_id` (`chat_id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buyer_id` (`buyer_id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `farm_id` (`farm_id`);

--
-- Chỉ mục cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `reply`
--
ALTER TABLE `reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reply review` (`id_review`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `buyer_id` (`buyer_id`);

--
-- Chỉ mục cho bảng `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `farms`
--
ALTER TABLE `farms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT cho bảng `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT cho bảng `reply`
--
ALTER TABLE `reply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chats_ibfk_2` FOREIGN KEY (`farmer_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `farms`
--
ALTER TABLE `farms`
  ADD CONSTRAINT `farms_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`farm_id`) REFERENCES `farms` (`id`);

--
-- Các ràng buộc cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `reply`
--
ALTER TABLE `reply`
  ADD CONSTRAINT `reply review` FOREIGN KEY (`id_review`) REFERENCES `reviews` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
