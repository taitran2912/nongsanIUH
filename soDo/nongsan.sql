-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 27, 2025 at 06:53 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nongsan`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `product_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Rau củ'),
(2, 'Trái cây'),
(3, 'gia vị'),
(4, 'sản phẩm chế biến'),
(5, 'hạt'),
(6, 'nấm');

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `farmer_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_message` text NOT NULL,
  `last_sent_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `buyer_id`, `farmer_id`, `created_at`, `last_message`, `last_sent_at`) VALUES
(17, 6, 1, '2025-05-26 17:17:13', '123456', '2025-05-26 17:05:05'),
(18, 6, 3, '2025-05-26 17:17:13', 'Xin chào, tôi quan tâm đến sản phẩm của cửa hàng.', '2025-05-24 15:30:14'),
(19, 6, 2, '2025-05-26 17:28:21', 'hi', '2025-05-26 17:57:19'),
(20, 12, 1, '2025-05-27 00:57:53', 'mình đang quan tâm tới sản phẩm rau bên mình', '2025-05-27 01:43:00');

-- --------------------------------------------------------

--
-- Table structure for table `farms`
--

CREATE TABLE `farms` (
  `id` int(11) NOT NULL,
  `shopname` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `description` text NOT NULL,
  `owner_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `farms`
--

INSERT INTO `farms` (`id`, `shopname`, `address`, `description`, `owner_id`, `status`) VALUES
(1, 'HTX ĐÀ LẠT FARM', '66 Đan Kia, Phường 7. TP Đà Lạt', 'Cung cấp các loại rau, củ, quả\r\nAnh Sĩ 0702499445', 1, 0),
(2, 'HTX Rau an toàn Trúc Lâm', 'ấp Thanh Thọ 3, Xã Phú Lâm, Huyện Tân Phú, Đồng Nai', 'Cung cấp các loại rau ăn lá, rau quả, sản lượng 10 tấn/ngày, LH: 0919814401', 2, 0),
(3, 'HTX nông nghiệp Phương Nam', 'Gia Kiệm - Thống Nhất, Đồng Nai ', 'LH: 0933775999', 3, 0),
(5, 'HTX Nông sản Việt', 'Ấp 5, Xã Bình Hòa, Huyện Vĩnh Cửu, Đồng Nai', 'Cung cấp trái cây sạch, chất lượng cao', 7, 2),
(8, 'nong trại của tài', 'nong trại của tài', 'nong trại của tài', 12, 0);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `chat_id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `chat_id`, `sender_id`, `message`, `sent_at`, `status`) VALUES
(40, 17, 6, 'Xin chào, tôi quan tâm đến sản phẩm của cửa hàng.', '2025-05-24 15:27:47', 'read'),
(41, 17, 1, 'hi bạn mình giúp gì đc cho bạn', '2025-05-24 15:28:19', 'read'),
(42, 17, 6, 'bên bạn có bán táo ko', '2025-05-24 15:28:34', 'read'),
(43, 17, 1, 'hiện tại bên mình ko có bạn cần loại nào nếu tìm thấy mình sẽ báo', '2025-05-24 15:29:33', 'read'),
(44, 18, 6, 'Xin chào, tôi quan tâm đến sản phẩm của cửa hàng.', '2025-05-24 15:30:14', 'sent'),
(45, 17, 6, 'hi shop', '2025-05-25 16:36:21', 'read'),
(46, 17, 6, '123456', '2025-05-26 17:05:05', 'read'),
(47, 19, 2, 'Xin chào test! Cảm ơn bạn đã quan tâm đến HTX Rau an toàn Trúc Lâm. Chúng tôi có thể giúp gì cho bạn?', '2025-05-26 17:28:21', 'read'),
(48, 19, 6, 'hi', '2025-05-26 17:57:19', 'sent'),
(49, 20, 12, 'Xin chào, tôi quan tâm đến sản phẩm của cửa hàng.', '2025-05-27 00:57:53', 'read'),
(50, 20, 12, 'hi shop', '2025-05-27 01:28:32', 'read'),
(51, 20, 1, 'bạn cần mua sản phẩm gì vậy', '2025-05-27 01:42:05', 'read'),
(52, 20, 12, 'mình đang quan tâm tới sản phẩm rau bên mình', '2025-05-27 01:43:00', 'read');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `notes` text DEFAULT NULL,
  `Shipping_address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_date`, `status`, `total_amount`, `notes`, `Shipping_address`) VALUES
(101, 6, '2025-05-24 21:06:49', 2, 32000.00, 'Đơn hàng thanh toán qua SePay. Mã đơn hàng: ORD17481208093605', '12'),
(102, 1, '2025-05-24 21:09:54', 0, 31000.00, 'Đơn hàng test cho webhook. Mã đơn hàng: ORD1748120991', 'Địa chỉ test'),
(103, 1, '2025-05-24 21:10:57', 0, 31000.00, 'Đơn hàng test cho webhook. Mã đơn hàng: ORD1748121046', 'Địa chỉ test'),
(104, 1, '2025-05-24 21:11:55', 0, 31000.00, 'Đơn hàng test cho webhook. Mã đơn hàng: ORD1748121046', 'Địa chỉ test'),
(105, 1, '2025-05-24 21:32:32', 0, 31000.00, 'Đơn hàng test cho webhook. Mã đơn hàng: ORD1748122346', 'Địa chỉ test'),
(106, 6, '2025-05-24 21:36:24', 1, 32000.00, 'Đơn hàng thanh toán qua SePay. Mã đơn hàng: ORD17481225842947', '12'),
(107, 6, '2025-05-24 21:37:03', 1, 32000.00, 'Đơn hàng thanh toán qua SePay. Mã đơn hàng: ORD17481226239627', '12'),
(108, 6, '2025-05-24 21:41:17', 0, 32000.00, 'Đơn hàng thanh toán qua SePay. Mã đơn hàng: ORD17481228778460', '12'),
(109, 6, '2025-05-24 21:45:06', 0, 32000.00, 'Đơn hàng thanh toán qua SePay. Mã đơn hàng: ORD17481231061733', '12'),
(110, 6, '2025-05-24 21:45:08', 0, 32000.00, 'Đơn hàng thanh toán qua SePay. Mã đơn hàng: ORD17481231088116', '12'),
(111, 6, '2025-05-24 22:10:08', 1, 32000.00, 'Đơn hàng thanh toán qua SePay. Mã đơn hàng: ORD17481246086436', '12'),
(112, 6, '2025-05-25 10:01:55', 1, 31000.00, 'Đơn hàng thanh toán qua SePay. Mã đơn hàng: ORD17481673151665', '12'),
(113, 6, '2025-05-25 10:03:34', 1, 31000.00, 'Đơn hàng thanh toán qua SePay. Mã đơn hàng: ORD17481674148756', '12'),
(114, 6, '2025-05-25 10:05:26', 1, 31000.00, 'Đơn hàng thanh toán qua SePay. Mã đơn hàng: ORD17481675264300', '12'),
(115, 6, '2025-05-25 10:11:03', 0, 31000.00, 'Đơn hàng thanh toán qua SePay. Mã đơn hàng: ORD17481678631986', '12'),
(116, 6, '2025-05-25 10:11:07', 1, 31000.00, 'Đơn hàng thanh toán qua SePay. Mã đơn hàng: ORD17481678677861', '12'),
(117, 6, '2025-05-25 11:00:21', 1, 31000.00, 'Mã đơn hàng: ORD17481708217416', '12'),
(118, 1, '2025-05-25 11:01:23', 0, 31000.00, 'Đơn hàng test cho webhook. Mã đơn hàng: ORD1748170864', 'Địa chỉ test'),
(119, 1, '2025-05-25 11:01:27', 0, 31000.00, 'Đơn hàng test cho webhook. Mã đơn hàng: ORD1748170883', 'Địa chỉ test'),
(120, 1, '2025-05-25 11:01:44', 0, 31000.00, 'Đơn hàng test cho webhook. Mã đơn hàng: ORD1748170887', 'Địa chỉ test'),
(121, 6, '2025-05-25 11:14:59', 0, 31000.00, 'Mã đơn hàng: ORD17481716999845', '12'),
(122, 6, '2025-05-25 11:20:55', 1, 31000.00, 'ORD1748173785', '12'),
(123, 6, '2025-05-25 12:01:35', 1, 31000.00, 'Mã đơn hàng: ORD17481744953950', '12'),
(124, 6, '2025-05-25 12:03:17', 1, 31000.00, 'Mã đơn hàng: ORD17481745974188', '12'),
(125, 6, '2025-05-25 12:05:13', 1, 31000.00, 'Mã đơn hàng: ORD17481747137311', '12'),
(126, 6, '2025-05-26 11:24:43', 0, 56000.00, 'Mã đơn hàng: ORD17482586834464', '12'),
(127, 6, '2025-05-26 11:29:46', 0, 56000.00, 'Mã đơn hàng: ORD17482589864841', '12'),
(128, 6, '2025-05-26 11:42:35', 0, 116000.00, 'Mã đơn hàng: ORD17482597555869', '12'),
(129, 6, '2025-05-26 12:01:22', 0, 59000.00, 'Mã đơn hàng: ORD17482608822783', '12'),
(130, 6, '2025-05-27 00:34:59', 0, 59000.00, 'Mã đơn hàng: ORD17483060993752', '12'),
(131, 6, '2025-05-27 00:38:47', 1, 59000.00, 'Mã đơn hàng: ORD17483063272201', '12'),
(132, 6, '2025-05-27 00:44:58', 0, 31000.00, 'Mã đơn hàng: ORD17483066984339', '12'),
(133, 6, '2025-05-27 00:45:32', 1, 31000.00, 'Mã đơn hàng: ORD17483067326400', '12'),
(134, 12, '2025-05-27 01:39:20', 0, 31000.00, 'Mã đơn hàng: ORD17483099603152', 'iuh'),
(135, 12, '2025-05-27 01:40:06', 0, 32000.00, 'Mã đơn hàng: ORD17483100063995', 'iuh'),
(136, 12, '2025-05-27 01:40:18', 0, 32000.00, 'Mã đơn hàng: ORD17483100189069', 'iuh'),
(137, 12, '2025-05-27 01:40:41', 1, 31000.00, 'Mã đơn hàng: ORD17483100415552', 'iuh');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_id`, `product_id`, `quantity`) VALUES
(101, 1, 2),
(106, 1, 2),
(107, 1, 2),
(108, 1, 2),
(109, 1, 2),
(110, 1, 2),
(111, 1, 2),
(112, 1, 1),
(113, 1, 1),
(114, 1, 1),
(115, 1, 1),
(116, 1, 1),
(117, 1, 1),
(121, 1, 1),
(122, 1, 1),
(123, 1, 1),
(124, 1, 1),
(125, 1, 1),
(126, 1, 1),
(126, 2, 1),
(127, 1, 1),
(127, 2, 1),
(128, 1, 1),
(128, 2, 1),
(128, 40, 1),
(129, 1, 1),
(129, 3, 1),
(130, 1, 1),
(130, 3, 1),
(131, 1, 1),
(131, 3, 1),
(132, 1, 1),
(133, 1, 1),
(134, 1, 1),
(135, 1, 1),
(136, 1, 1),
(137, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment_logs`
--

CREATE TABLE `payment_logs` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `transaction_code` varchar(100) DEFAULT NULL,
  `event` varchar(50) NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `payload` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_logs`
--

INSERT INTO `payment_logs` (`id`, `order_id`, `transaction_code`, `event`, `amount`, `content`, `payload`, `created_at`) VALUES
(1, 106, '668ITC125144ACPP', 'success', 32000.00, '88494150668-0384902203-ORD17481225842947', '{\"gateway\":\"TPBank\",\"transactionDate\":\"2025-05-25 04:36:50\",\"accountNumber\":\"91902203843\",\"subAccount\":null,\"code\":null,\"content\":\"88494150668-0384902203-ORD17481225842947\",\"transferType\":\"in\",\"description\":\"BankAPINotify 88494150668-0384902203-ORD17481225842947\",\"transferAmount\":32000,\"referenceCode\":\"668ITC125144ACPP\",\"accumulated\":62000,\"id\":13490657}', '2025-05-24 21:36:51'),
(2, 107, '668ITC125144ACPR', 'success', 32000.00, 'ORD17481226239627', '{\"gateway\":\"TPBank\",\"transactionDate\":\"2025-05-25 04:37:25\",\"accountNumber\":\"91902203843\",\"subAccount\":null,\"code\":null,\"content\":\"ORD17481226239627\",\"transferType\":\"in\",\"description\":\"BankAPINotify ORD17481226239627\",\"transferAmount\":32000,\"referenceCode\":\"668ITC125144ACPR\",\"accumulated\":62000,\"id\":13490667}', '2025-05-24 21:37:25'),
(3, 123, '668ITC125146A382', 'success', 31000.00, '88564224086', '{\"gateway\":\"TPBank\",\"transactionDate\":\"2025-05-25 19:01:57\",\"accountNumber\":\"91902203843\",\"subAccount\":null,\"code\":null,\"content\":\"88564224086 0384902203 ORD17481744953950\",\"transferType\":\"in\",\"description\":\"BankAPINotify 88564224086 0384902203 ORD17481744953950\",\"transferAmount\":31000,\"referenceCode\":\"668ITC125146A382\",\"accumulated\":62018,\"id\":13515520}', '2025-05-25 12:02:55'),
(4, 124, '668ITC125146A396', 'success', 31000.00, '0', '{\"gateway\":\"TPBank\",\"transactionDate\":\"2025-05-25 19:03:36\",\"accountNumber\":\"91902203843\",\"subAccount\":null,\"code\":null,\"content\":\"ORD17481745974188\",\"transferType\":\"in\",\"description\":\"BankAPINotify ORD17481745974188\",\"transferAmount\":31000,\"referenceCode\":\"668ITC125146A396\",\"accumulated\":62018,\"id\":13515580}', '2025-05-25 12:03:36'),
(5, 125, '668ITC125146A3AQ', 'success', 31000.00, '0', '{\"gateway\":\"TPBank\",\"transactionDate\":\"2025-05-25 19:05:32\",\"accountNumber\":\"91902203843\",\"subAccount\":null,\"code\":null,\"content\":\"ORD17481747137311\",\"transferType\":\"in\",\"description\":\"BankAPINotify ORD17481747137311\",\"transferAmount\":31000,\"referenceCode\":\"668ITC125146A3AQ\",\"accumulated\":62018,\"id\":13515659}', '2025-05-25 12:05:32'),
(6, 131, '668ITC1251472901', 'success', 59000.00, '88711102596', '{\"gateway\":\"TPBank\",\"transactionDate\":\"2025-05-27 07:39:28\",\"accountNumber\":\"91902203843\",\"subAccount\":null,\"code\":null,\"content\":\"88711102596-0384902203-ORD17483063272201\",\"transferType\":\"in\",\"description\":\"BankAPINotify 88711102596-0384902203-ORD17483063272201\",\"transferAmount\":59000,\"referenceCode\":\"668ITC1251472901\",\"accumulated\":62018,\"id\":13585417}', '2025-05-27 00:39:28'),
(7, 133, '668ITC1251472989', 'success', 31000.00, '0', '{\"gateway\":\"TPBank\",\"transactionDate\":\"2025-05-27 07:46:06\",\"accountNumber\":\"91902203843\",\"subAccount\":null,\"code\":null,\"content\":\"ORD17483067326400\",\"transferType\":\"in\",\"description\":\"BankAPINotify ORD17483067326400\",\"transferAmount\":31000,\"referenceCode\":\"668ITC1251472989\",\"accumulated\":62018,\"id\":13585581}', '2025-05-27 00:46:07'),
(8, 137, '668ITC1251473832', 'success', 31000.00, '88716910440', '{\"gateway\":\"TPBank\",\"transactionDate\":\"2025-05-27 08:41:05\",\"accountNumber\":\"91902203843\",\"subAccount\":null,\"code\":null,\"content\":\"88716910440-0334037926-ORD17483100415552\",\"transferType\":\"in\",\"description\":\"BankAPINotify 88716910440-0334037926-ORD17483100415552\",\"transferAmount\":31000,\"referenceCode\":\"668ITC1251473832\",\"accumulated\":93018,\"id\":13587175}', '2025-05-27 01:41:05');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,0) NOT NULL,
  `quantity` int(11) NOT NULL,
  `farm_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_categories` int(11) NOT NULL,
  `unit` varchar(25) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `quantity`, `farm_id`, `created_at`, `id_categories`, `unit`, `status`) VALUES
(1, 'Bắp cải trái tim', 'Bắp cải tim hay còn gọi là bắp sú tim là một loại bắp cải nhưng có hình trái tim lạ mắt. Đây là loại bắp cải được nhiều người ưa thích bởi hình dáng đặc biệt, kích thước vừa phải không quá to như bắp cải thông thường. Loại bắp cải này có nguồn gốc từ Địa Trung Hải, thích hợp trồng ở những vùng có khí hậu ôn đới.', 1000, 7, 1, '2025-05-05 14:10:32', 1, 'kg', 0),
(2, 'Bí đỏ non', 'Bí đỏ non là một loại bí có hình tròn, kích thước khá nhỏ, chỉ khoảng 1 nắm tay. Vỏ có màu xanh đậm, mềm, có thể ăn được cả vỏ. Phần thịt bên trong có màu vàng nhạt, vị ngọt thanh, béo nhẹ. Bí đỏ non có thể chế biến thành nhiều món ăn hấp dẫn như các món canh, luộc, xào, làm bánh, nấu chè...', 25000, 1000, 1, '2025-05-05 14:12:20', 1, 'kg', 0),
(3, 'Bó xôi', 'Rau bó xôi (spinach) được trồng theo phương pháp hữu cơ, không sử dụng thuốc trừ sâu và phân bón hóa học. Lá xanh đậm, dày, giàu chất sắt và vitamin A, rất tốt cho người thiếu máu và trẻ em đang phát triển.', 28000, 50, 1, '2025-05-05 14:17:31', 1, 'kg', 0),
(4, 'Cà chua beef', 'Cà chua beef canh tác tự nhiên, không thuốc kích thích. Trái to, thịt dày, ít hạt, giàu lycopene giúp chống oxy hóa và làm đẹp da. Thích hợp làm salad, sốt cà, hoặc ăn sống.', 30000, 600, 1, '2025-05-05 14:17:31', 2, 'kg', 0),
(5, 'Cà chua cherry', 'Cà chua cherry sạch trồng trong nhà màng, trái nhỏ, ngọt thanh, chứa nhiều vitamin C. Được kiểm định chất lượng định kỳ để đảm bảo an toàn tuyệt đối cho người tiêu dùng.', 35000, 400, 1, '2025-05-05 14:17:31', 2, 'kg', 0),
(6, 'Cải cầu vồng', 'Cải cầu vồng canh tác bằng kỹ thuật thủy canh hiện đại, không hóa chất. Lá giòn, màu sắc bắt mắt, chứa nhiều chất xơ và khoáng chất, giúp tăng cường đề kháng và hỗ trợ tiêu hóa.', 32000, 300, 1, '2025-05-05 14:17:31', 1, 'kg', 0),
(7, 'Cải Kale', 'Rau cải Kale được mệnh danh là “vua rau xanh”, giàu chất chống oxy hóa, vitamin K và canxi. Sản phẩm được trồng sạch theo quy trình đạt chuẩn VietGAP, đảm bảo không tồn dư hóa chất.', 45000, 200, 1, '2025-05-05 14:17:31', 1, 'kg', 0),
(8, 'Cải ngồng', 'Cải ngồng sạch, thu hoạch từ nông trại canh tác hữu cơ. Cọng non giòn, vị ngọt tự nhiên. Thích hợp xào tỏi, luộc hoặc làm món ăn chay thanh đạm.', 26000, 43, 1, '2025-05-05 14:17:31', 1, 'kg', 0),
(9, 'Cải ngọt', 'Cải ngọt được trồng bằng phân hữu cơ vi sinh, lá xanh mướt, vị ngọt nhẹ tự nhiên. Rất phù hợp nấu canh, xào thịt bò hoặc luộc ăn kèm nước mắm chua ngọt.', 24000, 700, 1, '2025-05-05 14:17:31', 1, 'kg', 0),
(10, 'Cải thìa', 'Cải thìa hữu cơ, lá dày, thân trắng mập, có vị thanh mát. Trồng bằng công nghệ thủy canh tuần hoàn, không thuốc trừ sâu, phù hợp cho bé ăn dặm và người lớn tuổi.', 27000, 450, 1, '2025-05-05 14:17:31', 1, 'kg', 0),
(11, 'Cà rốt hữu cơ', 'Cà rốt trồng từ giống sạch, tưới nước giếng khoan tự nhiên, giàu beta-carotene, giúp sáng mắt và tốt cho hệ miễn dịch. Không dùng thuốc trừ sâu trong suốt quá trình canh tác.', 30000, 28, 1, '2025-05-05 14:17:31', 1, 'kg', 0),
(12, 'Củ cải đỏ', 'Củ cải đỏ canh tác theo hướng hữu cơ, củ nhỏ, vỏ mịn, giàu anthocyanin – chất chống oxy hóa mạnh. Có thể ăn sống, muối chua hoặc nấu súp.', 29000, 400, 1, '2025-05-05 14:17:31', 1, 'kg', 0),
(13, 'Củ cải trắng', 'Củ cải trắng sạch, trồng bằng phân vi sinh, không hóa chất. Vị ngọt dịu, giúp thanh nhiệt, giải độc gan và hỗ trợ tiêu hóa rất tốt.', 27000, 650, 1, '2025-05-05 14:17:31', 1, 'kg', 0),
(14, 'Đậu bắp', 'Đậu bắp canh tác an toàn, quả non, ít nhớt, giàu chất xơ và acid folic. Phù hợp cho bà bầu và người ăn kiêng. Cam kết không dư lượng thuốc bảo vệ thực vật.', 25000, 49, 1, '2025-05-05 14:17:31', 1, 'kg', 0),
(15, 'Dưa leo bao tử', 'Dưa leo bao tử nhỏ gọn, da mỏng, giòn ngọt. Trồng trong nhà kính theo tiêu chuẩn GlobalGAP, đảm bảo độ sạch và độ giòn tự nhiên.', 32000, 300, 1, '2025-05-05 14:17:31', 1, 'kg', 0),
(16, 'Dưa leo Nhật', 'Dưa leo Nhật hữu cơ, trái dài, ít hạt, vỏ xanh bóng. Trồng theo phương pháp tưới nhỏ giọt tiết kiệm nước, bảo vệ môi trường và cho chất lượng trái đồng đều.', 35000, 200, 1, '2025-05-05 14:17:31', 1, 'kg', 0),
(17, 'Khoai lang mật', 'Khoai lang mật được trồng trên đất đỏ bazan màu mỡ, không thuốc hóa học. Khi nướng lên có vị ngọt đậm, dẻo và rất thơm, giàu tinh bột tốt cho sức khỏe.', 28000, 80, 1, '2025-05-05 14:17:31', 1, 'kg', 0),
(18, 'Khoai môn', 'Khoai môn sạch, củ chắc, ít xơ, trồng hoàn toàn bằng phân bón hữu cơ. Khi nấu có vị bùi béo tự nhiên, không ngậm hóa chất.', 27000, 300, 1, '2025-05-05 14:17:31', 1, 'kg', 0),
(19, 'Khoai sọ', 'Khoai sọ được trồng tại vùng cao, dùng phân chuồng ủ hoai mục. Củ nhỏ, nhiều tinh bột, dẻo, bùi, thích hợp nấu canh cua hoặc kho thịt.', 26000, 400, 1, '2025-05-05 14:17:31', 1, 'kg', 0),
(20, 'Mồng tơi baby', 'Mồng tơi baby lá nhỏ, mềm, trồng bằng kỹ thuật an toàn sinh học. Rất giàu vitamin và chất nhầy, tốt cho tiêu hóa và thanh nhiệt cơ thể.', 22000, 600, 1, '2025-05-05 14:17:31', 1, 'kg', 0),
(21, 'Rau dền baby', 'Rau dền baby sạch, không thuốc trừ sâu, lá non và mềm. Chứa nhiều sắt, giúp bổ máu, hỗ trợ hệ tuần hoàn và được khuyên dùng cho phụ nữ sau sinh.', 23000, 500, 1, '2025-05-05 14:17:31', 1, 'kg', 0),
(22, 'Su hào xanh', 'Su hào xanh từ nông trại sạch, củ giòn, nhiều nước, không chất tăng trưởng. Dễ chế biến trong món xào, nấu canh, hoặc làm nộm.', 25000, 350, 1, '2025-05-05 14:17:31', 1, 'kg', 0),
(23, 'Súp lơ xanh baby', 'Súp lơ xanh baby có hoa nhỏ, non, màu xanh đậm. Canh tác theo mô hình nông nghiệp tuần hoàn, chứa nhiều vitamin C, E và chất xơ.', 30000, 250, 1, '2025-05-05 14:17:31', 1, 'kg', 0),
(24, 'Xà lách lolo thủy canh', 'Xà lách lolo trồng theo mô hình thủy canh kín, lá mềm, vị mát, không có dư lượng kim loại nặng. An toàn tuyệt đối cho người ăn sống.', 27000, 450, 1, '2025-05-05 14:17:31', 1, 'kg', 0),
(25, 'Bưởi', 'Bưởi được thu hoạch từ những cây lâu năm trồng theo hướng hữu cơ. Trái to, vỏ mỏng, tép mọng nước, vị ngọt thanh. Giàu vitamin C và chất xơ, rất tốt cho hệ miễn dịch.', 48000, 141, 2, '2025-05-05 14:28:31', 2, 'kg', 0),
(26, 'Cam sành hữu cơ', 'Cam sành được trồng không phân bón hóa học, vỏ mỏng, ngọt đậm, có mùi thơm đặc trưng. Cam kết không dư lượng thuốc trừ sâu, an toàn cho sức khỏe gia đình.', 35000, 200, 2, '2025-05-05 14:28:31', 2, 'kg', 0),
(27, 'Chuối laba', 'Chuối Laba trồng theo tiêu chuẩn hữu cơ, trái dài, vỏ mỏng, ngọt dẻo. Là giống chuối quý của Đà Lạt, phù hợp ăn tươi hoặc làm món tráng miệng.', 28000, 250, 2, '2025-05-05 14:28:31', 2, 'kg', 0),
(28, 'Dưa hấu không hạt', 'Dưa hấu không hạt được trồng tự nhiên, không thuốc tăng trưởng. Thịt đỏ đậm, ngọt mát, mọng nước. Là lựa chọn tuyệt vời cho mùa hè.', 18000, 300, 2, '2025-05-05 14:28:31', 2, 'kg', 0),
(29, 'Kiwi vàng', 'Kiwi vàng nhập giống từ New Zealand, trồng tại nông trại sạch, không thuốc trừ sâu. Vị ngọt chua nhẹ, giàu vitamin C, hỗ trợ làm đẹp da và tiêu hóa.', 52000, 100, 2, '2025-05-05 14:28:31', 2, 'kg', 0),
(30, 'Na bà đen', 'Na Bà Đen canh tác hữu cơ tại vùng núi Tây Ninh, trái to, mắt mịn, ngọt thanh. Rất giàu năng lượng và vitamin B6, phù hợp cho người ăn chay.', 45000, 120, 2, '2025-05-05 14:28:31', 2, 'kg', 0),
(31, 'Ớt chỉ thiên', 'Ớt chỉ thiên sạch, cay nồng tự nhiên, trồng trong điều kiện không hóa chất. Thích hợp làm gia vị, kích thích tiêu hóa và chống oxy hóa tốt.', 22000, 90, 2, '2025-05-05 14:28:31', 3, 'kg', 0),
(32, 'Ớt chuông đỏ', 'Ớt chuông đỏ được trồng trong nhà màng, không sử dụng hóa chất độc hại. Thịt dày, vị ngọt, giàu vitamin A và C. Phù hợp cho món salad và nướng.', 32000, 80, 2, '2025-05-05 14:28:31', 2, 'kg', 0),
(33, 'Ớt chuông vàng', 'Ớt chuông vàng sạch, trái to, vỏ bóng, giàu chất chống oxy hóa và chất xơ. Trồng bằng công nghệ tưới nhỏ giọt tiết kiệm nước và không thuốc trừ sâu.', 32000, 80, 2, '2025-05-05 14:28:31', 2, 'kg', 0),
(34, 'Táo envy', 'Táo Envy được nhập giống và trồng trong điều kiện hữu cơ tại cao nguyên. Vỏ đỏ bóng, giòn ngọt, không wax, an toàn tuyệt đối cho trẻ nhỏ.', 68000, 150, 2, '2025-05-05 14:28:31', 2, 'kg', 0),
(35, 'Thanh long ruột đỏ', 'Thanh long ruột đỏ sạch, vỏ mỏng, ruột ngọt và mọng nước. Canh tác không hóa chất, rất giàu chất xơ và chất chống oxy hóa tự nhiên.', 29000, 215, 2, '2025-05-05 14:28:31', 2, 'kg', 0),
(36, 'Thơm', 'Thơm (dứa) canh tác không thuốc trừ sâu, mắt nhỏ, vỏ mỏng, thịt vàng, ngọt dịu. Thơm giàu enzym bromelain hỗ trợ tiêu hóa và kháng viêm.', 18000, 240, 2, '2025-05-05 14:28:31', 2, 'kg', 0),
(37, 'Xoài cát Hòa Lộc', 'Xoài cát Hòa Lộc được canh tác theo tiêu chuẩn VietGAP, trái to, vỏ mỏng, ngọt đậm đà. Không sử dụng thuốc ép chín, giữ được hương vị truyền thống.', 42000, 260, 2, '2025-05-05 14:28:31', 2, 'kg', 0),
(38, 'Bún gạo', 'Bún gạo truyền thống được làm từ 100% gạo sạch không pha trộn phụ gia, không chất tẩy trắng. Sợi bún dai, thơm, thích hợp dùng cho món bún xào, bún nước hoặc salad.', 30000, 200, 3, '2025-05-05 14:31:45', 4, 'kg', 0),
(39, 'Gạo nếp cẩm ĐSTB', 'Gạo nếp cẩm Đồng bằng Sông Tiền được trồng theo phương pháp hữu cơ, không thuốc diệt cỏ. Hạt nếp đen tím tự nhiên, dẻo mềm, giàu chất chống oxy hóa và tốt cho tim mạch.', 42000, 180, 3, '2025-05-05 14:31:45', 4, 'kg', 0),
(40, 'Hạt sen tươi', 'Hạt sen thu hoạch tại vườn sen sạch, không sử dụng thuốc bảo vệ thực vật. Hạt tròn, chắc, ngọt bùi, rất tốt cho giấc ngủ và hệ thần kinh.', 60000, 100, 3, '2025-05-05 14:31:45', 5, 'kg', 0),
(41, 'Mật dừa nước', 'Mật dừa nước là sản phẩm lên men tự nhiên từ cây dừa nước miền Tây, không đường hóa học, không chất bảo quản. Vị ngọt dịu, tốt cho người tiểu đường và hỗ trợ tiêu hóa.', 75000, 80, 3, '2025-05-05 14:31:45', 4, 'kg', 0),
(42, 'Miến dong Kim Bội', 'Miến dong Kim Bội được làm từ củ dong nguyên chất, không phẩm màu, không chất tẩy trắng. Sợi dai, mềm, thơm, không bị nát khi nấu. Đạt chứng nhận an toàn thực phẩm.', 45000, 120, 3, '2025-05-05 14:31:45', 4, 'kg', 0),
(43, 'Mì trứng', 'Mì trứng tươi được làm từ trứng gà sạch và bột mì nguyên chất. Không chất bảo quản, không màu nhân tạo. Sợi mì vàng ươm, mềm dai, thơm béo tự nhiên.', 38000, 150, 3, '2025-05-05 14:31:45', 4, 'kg', 0),
(44, 'Nấm bào ngư', 'Nấm bào ngư sạch trồng trong môi trường kiểm soát nghiêm ngặt, không hóa chất. Nấm trắng mịn, ngọt tự nhiên, giàu đạm thực vật và vitamin nhóm B.', 32000, 130, 3, '2025-05-05 14:31:45', 6, 'kg', 0),
(45, 'Nấm đùi gà', 'Nấm đùi gà canh tác trong nhà lạnh, không sử dụng thuốc tăng trưởng. Thân to, giòn, ngọt, có thể chế biến nhiều món ăn bổ dưỡng và thanh đạm.', 38000, 110, 3, '2025-05-05 14:31:45', 6, 'kg', 0),
(46, 'Nấm linh chi', 'Nấm linh chi đỏ tự nhiên, nuôi trồng theo phương pháp hữu cơ. Có công dụng tăng cường miễn dịch, hỗ trợ gan, thanh lọc cơ thể, chống lão hóa.', 98000, 40, 3, '2025-05-05 14:31:45', 6, 'kg', 0),
(47, 'Nấm mỡ', 'Nấm mỡ được thu hái trong hệ thống nhà trồng đạt chuẩn VietGAP. Thịt nấm mềm, vị béo nhẹ, có lợi cho tim mạch và hệ tiêu hóa.', 35000, 90, 3, '2025-05-05 14:31:45', 6, 'kg', 0),
(48, 'Tiêu Tiên Phước', 'Tiêu đen Tiên Phước được phơi nắng tự nhiên, không sấy hóa chất, không tẩm màu. Hạt chắc, thơm nồng, cay đậm vị, giúp tăng cường đề kháng.', 55000, 140, 3, '2025-05-05 14:31:45', 3, 'kg', 0),
(68, 'test', 'sdfbnm', 1000, 12, 1, '2025-05-20 08:37:09', 1, 'kg', 4);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `img` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
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
(48, 48, 'tieutienphuoc.jpeg'),
(49, 68, '682c3f35710f2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reply`
--

CREATE TABLE `reply` (
  `id` int(11) NOT NULL,
  `id_review` int(11) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
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
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `method` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` varchar(50) NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `order_id`, `method`, `amount`, `status`, `transaction_date`) VALUES
(55, 101, 'SePay', 32000.00, 'pending', '2025-05-24 21:06:49'),
(56, 106, 'SePay', 32000.00, 'paid', '2025-05-24 21:36:50'),
(57, 107, 'SePay', 32000.00, 'paid', '2025-05-24 21:37:25'),
(58, 108, 'SePay', 32000.00, 'pending', '2025-05-24 21:41:17'),
(59, 109, 'SePay', 32000.00, 'pending', '2025-05-24 21:45:06'),
(60, 110, 'SePay', 32000.00, 'pending', '2025-05-24 21:45:08'),
(61, 111, 'SePay', 32000.00, 'pending', '2025-05-24 22:10:08'),
(62, 112, 'SePay', 31000.00, 'pending', '2025-05-25 10:01:55'),
(63, 113, 'SePay', 31000.00, 'pending', '2025-05-25 10:03:34'),
(64, 114, 'SePay', 31000.00, 'pending', '2025-05-25 10:05:26'),
(65, 115, 'SePay', 31000.00, 'pending', '2025-05-25 10:11:03'),
(66, 116, 'SePay', 31000.00, 'pending', '2025-05-25 10:11:07'),
(67, 116, 'SePay', 12000.00, 'pending', '2025-05-25 10:45:32'),
(68, 117, 'SePay', 31000.00, 'pending', '2025-05-25 11:00:21'),
(69, 121, 'SePay', 31000.00, 'pending', '2025-05-25 11:14:59'),
(70, 122, 'SePay', 31000.00, 'pending', '2025-05-25 11:20:55'),
(71, 123, 'SePay', 31000.00, 'completed', '2025-05-25 12:01:35'),
(72, 124, 'SePay', 31000.00, 'completed', '2025-05-25 12:03:17'),
(73, 125, 'SePay', 31000.00, 'completed', '2025-05-25 12:05:13'),
(74, 126, 'SePay', 56000.00, 'pending', '2025-05-26 11:24:43'),
(75, 127, 'SePay', 56000.00, 'pending', '2025-05-26 11:29:46'),
(76, 128, 'SePay', 116000.00, 'pending', '2025-05-26 11:42:35'),
(77, 129, 'SePay', 59000.00, 'pending', '2025-05-26 12:01:22'),
(78, 130, 'SePay', 59000.00, 'pending', '2025-05-27 00:34:59'),
(79, 131, 'SePay', 59000.00, 'completed', '2025-05-27 00:38:47'),
(80, 132, 'SePay', 31000.00, 'pending', '2025-05-27 00:44:58'),
(81, 133, 'SePay', 31000.00, 'completed', '2025-05-27 00:45:32'),
(82, 134, 'SePay', 31000.00, 'pending', '2025-05-27 01:39:20'),
(83, 137, 'SePay', 31000.00, 'completed', '2025-05-27 01:40:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
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
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `address`, `role`) VALUES
(1, 'tai', 'tai@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '0901234567', 'dia chi 1\r\n', 1),
(2, 'Tran Thi B', 'thib@example.com', 'e10adc3949ba59abbe56e057f20f883e', '0902234567', '456 Nguyen Trai, District 5, HCMC', 1),
(3, 'Tran Tan ', 'vanc@example.com', 'e80b5017098950fc58aad83c8c14978e', '0384902233', '789 Cach Mang Thang 8, District 3, HCMC', 1),
(4, 'Pham Thi D', 'thid@example.com', 'e10adc3949ba59abbe56e057f20f883e', '0904234567', '12 Tran Hung Dao, District 1, HCMC', 2),
(5, 'Hoang Van E', 'vane@example.com', 'e10adc3949ba59abbe56e057f20f883e', '0905234567', '98 Ly Thuong Kiet, District 10, HCMC', 2),
(6, 'test', 'test@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '0334037926', '12', 1),
(7, 'Nguyen Van F', 'vanf@example.com', 'e10adc3949ba59abbe56e057f20f883e', '0912345678', '25 Nguyen Hue, District 1, HCMC', 1),
(8, 'Tran Thi G', 'thig@example.com', 'e10adc3949ba59abbe56e057f20f883e', '0922345678', '31 Tran Phu, District 5, HCMC', 1),
(12, 'Trần Tấn Tài', 'trantantai@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '0384902233', 'iuh', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buyer_id` (`buyer_id`),
  ADD KEY `farmer_id` (`farmer_id`);

--
-- Indexes for table `farms`
--
ALTER TABLE `farms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_id` (`chat_id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buyer_id` (`user_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payment_logs`
--
ALTER TABLE `payment_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `transaction_code` (`transaction_code`),
  ADD KEY `event` (`event`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `farm_id` (`farm_id`),
  ADD KEY `loai sp` (`id_categories`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `reply`
--
ALTER TABLE `reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reply review` (`id_review`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `buyer_id` (`buyer_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `farms`
--
ALTER TABLE `farms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `payment_logs`
--
ALTER TABLE `payment_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `reply`
--
ALTER TABLE `reply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chats_ibfk_2` FOREIGN KEY (`farmer_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `farms`
--
ALTER TABLE `farms`
  ADD CONSTRAINT `fk_farms_owner` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `payment_logs`
--
ALTER TABLE `payment_logs`
  ADD CONSTRAINT `payment_logs_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `loai sp` FOREIGN KEY (`id_categories`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`farm_id`) REFERENCES `farms` (`id`);

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `reply`
--
ALTER TABLE `reply`
  ADD CONSTRAINT `reply review` FOREIGN KEY (`id_review`) REFERENCES `reviews` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
