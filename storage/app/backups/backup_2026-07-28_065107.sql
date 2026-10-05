-- Database backup of `hospital-management`
-- Generated at 2026-07-28 06:51:07 by Hospital Website admin

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS=0;

--
-- Table: `app_notifications`
--
DROP TABLE IF EXISTS `app_notifications`;
CREATE TABLE `app_notifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `type` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci,
  `data` json DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_notifications_user_id_read_at_index` (`user_id`,`read_at`),
  CONSTRAINT `app_notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Table: `appointments`
--
DROP TABLE IF EXISTS `appointments`;
CREATE TABLE `appointments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` bigint(20) unsigned DEFAULT NULL,
  `doctor_id` bigint(20) unsigned DEFAULT NULL,
  `booked_by_user_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `appointment_type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preferred_doctor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preferred_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `appointment_date` date DEFAULT NULL,
  `time_slot` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_number` int(10) unsigned DEFAULT NULL,
  `fee` decimal(10,2) DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `symptoms` text COLLATE utf8mb4_unicode_ci,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `documents` json DEFAULT NULL,
  `prescription_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','confirmed','checked_in','in_consultation','completed','follow_up_required','cancelled','no_show') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `source` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'appointment_page',
  `is_manual` tinyint(1) NOT NULL DEFAULT '0',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `appointments_patient_id_foreign` (`patient_id`),
  KEY `appointments_doctor_id_foreign` (`doctor_id`),
  KEY `appointments_booked_by_user_id_foreign` (`booked_by_user_id`),
  CONSTRAINT `appointments_booked_by_user_id_foreign` FOREIGN KEY (`booked_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `appointments_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE SET NULL,
  CONSTRAINT `appointments_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `appointments` (`id`, `patient_id`, `doctor_id`, `booked_by_user_id`, `name`, `email`, `phone`, `department`, `appointment_type`, `preferred_doctor`, `preferred_date`, `appointment_date`, `time_slot`, `serial_number`, `fee`, `message`, `symptoms`, `document`, `documents`, `prescription_file`, `status`, `source`, `is_manual`, `notes`, `created_at`, `updated_at`) VALUES
(3, NULL, NULL, NULL, 'Warren Russell', 'povibefex@mailinator.com', '+1 (737) 777-8439', 'Pediatrics', NULL, 'Dr. Laron Metar', '07-Oct-2011', NULL, NULL, NULL, NULL, 'Sequi nisi laudantiu', NULL, NULL, NULL, NULL, 'pending', 'appointment_page', 0, NULL, '2026-07-18 07:05:47', '2026-07-18 07:05:47');

--
-- Table: `awards`
--
DROP TABLE IF EXISTS `awards`;
CREATE TABLE `awards` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` json NOT NULL,
  `subtitle` json DEFAULT NULL,
  `link_text` json DEFAULT NULL,
  `link_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seal_variant` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `awards` (`id`, `title`, `subtitle`, `link_text`, `link_url`, `seal_variant`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '{\"bn\": \"১২+ বছরের সেবা\", \"en\": \"12+ Years of Service\"}', '{\"bn\": \"২০১৩ সাল থেকে সীতাকুণ্ডবাসীর সেবায়\", \"en\": \"Serving Sitakund since 2013\"}', '{\"bn\": \"নিরবচ্ছিন্ন কমিউনিটি স্বাস্থ্যসেবা\", \"en\": \"Continuous Community Healthcare\"}', '/history', 1, 1, 1, '2026-07-27 15:11:08', '2026-07-27 15:11:08'),
(2, '{\"bn\": \"ফ্রি মেডিকেল ক্যাম্প\", \"en\": \"Free Medical Camps\"}', '{\"bn\": \"ইউনিয়ন ভিত্তিক মাসিক ফ্রি মেডিকেল ক্যাম্প\", \"en\": \"Monthly union-based free medical camps\"}', '{\"bn\": \"২৩,০০০+ রোগীকে বিনামূল্যে সেবা প্রদান\", \"en\": \"Over 23,000+ Patients Served Free\"}', '/achievements', 2, 2, 1, '2026-07-27 15:11:08', '2026-07-27 15:11:08'),
(3, '{\"bn\": \"২৪ ঘন্টা জরুরী সেবা\", \"en\": \"24-Hour Emergency Care\"}', '{\"bn\": \"সার্বক্ষণিক জরুরী বিভাগ, ফার্মেসী ও এম্বুলেন্স\", \"en\": \"Round-the-clock emergency, pharmacy & ambulance\"}', '{\"bn\": \"সবসময় প্রস্তুত\", \"en\": \"Always Open, Always Ready\"}', '/services', 3, 3, 1, '2026-07-27 15:11:08', '2026-07-27 15:11:08');

--
-- Table: `blog_categories`
--
DROP TABLE IF EXISTS `blog_categories`;
CREATE TABLE `blog_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` json NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` smallint(5) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `blog_categories` (`id`, `name`, `slug`, `description`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, '{\"bn\": \"স্বাস্থ্য পরামর্শ\", \"en\": \"Health Tips\"}', 'health-tips', '{\"bn\": \"প্রতিদিনের সুস্বাস্থ্য বজায় রাখার ব্যবহারিক পরামর্শ।\", \"en\": \"Practical tips for staying healthy every day.\"}', 1, 1, '2026-07-27 15:11:09', '2026-07-27 15:11:09'),
(2, '{\"bn\": \"মা ও শিশু স্বাস্থ্য\", \"en\": \"Maternal & Child Care\"}', 'maternal-child-care', '{\"bn\": \"গর্ভবতী মা ও নবজাতকের যত্নের জন্য দিকনির্দেশনা।\", \"en\": \"Guidance for expecting mothers and newborn care.\"}', 1, 2, '2026-07-27 15:11:09', '2026-07-27 15:11:09'),
(3, '{\"bn\": \"হাসপাতালের খবর\", \"en\": \"Hospital News\"}', 'hospital-news', '{\"bn\": \"সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ এর সর্বশেষ খবর ও আপডেট।\", \"en\": \"Updates, events and news from Sitakund Modern Hospital Ltd.\"}', 1, 3, '2026-07-27 15:11:09', '2026-07-27 15:11:09');

--
-- Table: `blog_comments`
--
DROP TABLE IF EXISTS `blog_comments`;
CREATE TABLE `blog_comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `blog_id` bigint(20) unsigned NOT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `blog_comments_blog_id_foreign` (`blog_id`),
  KEY `blog_comments_parent_id_foreign` (`parent_id`),
  CONSTRAINT `blog_comments_blog_id_foreign` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `blog_comments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `blog_comments` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Table: `blogs`
--
DROP TABLE IF EXISTS `blogs`;
CREATE TABLE `blogs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned DEFAULT NULL,
  `title` json NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` json DEFAULT NULL,
  `content` json DEFAULT NULL,
  `feature_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `og_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` json DEFAULT NULL,
  `author_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_bio` text COLLATE utf8mb4_unicode_ci,
  `author_avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','published') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `meta_title` json DEFAULT NULL,
  `meta_description` json DEFAULT NULL,
  `meta_keywords` json DEFAULT NULL,
  `view_count` int(10) unsigned NOT NULL DEFAULT '0',
  `sort_order` smallint(5) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blogs_slug_unique` (`slug`),
  KEY `blogs_category_id_foreign` (`category_id`),
  CONSTRAINT `blogs_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `blog_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `blogs` (`id`, `category_id`, `title`, `slug`, `excerpt`, `content`, `feature_image`, `og_image`, `tags`, `author_name`, `author_bio`, `author_avatar`, `status`, `published_at`, `is_featured`, `meta_title`, `meta_description`, `meta_keywords`, `view_count`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, '{\"bn\": \"সুস্থ জীবনের জন্য ৫টি দৈনন্দিন অভ্যাস\", \"en\": \"5 Everyday Habits for a Healthier Life\"}', '5-everyday-habits-for-a-healthier-life', '{\"bn\": \"সহজ কিছু অভ্যাস যা আপনার ও আপনার পরিবারের সারা বছর সুস্থ থাকতে সাহায্য করবে।\", \"en\": \"Simple, practical habits that can help you and your family stay healthy year-round.\"}', '{\"bn\": \"<p>সুস্বাস্থ্যের শুরু হয় ছোট ছোট নিয়মিত অভ্যাস থেকে। প্রতিদিন পর্যাপ্ত পানি পান করুন, সুষম খাবার ও প্রচুর শাকসবজি খান, প্রতিদিন অন্তত ৩০ মিনিট শারীরিক পরিশ্রম করুন, রাতে ৭-৮ ঘন্টা ঘুমান এবং নিয়মিত স্বাস্থ্য পরীক্ষা করান।</p><p>সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ এ আমাদের বিশেষজ্ঞ ডাক্তারগণ প্রতিদিন পরামর্শের জন্য উপস্থিত থাকেন, যা আপনাকে একটি স্বাস্থ্যকর রুটিন তৈরি করতে সাহায্য করবে।</p>\", \"en\": \"<p>Good health starts with small, consistent habits. Drink enough water every day, eat a balanced diet with plenty of vegetables, get at least 30 minutes of physical activity, sleep 7-8 hours a night, and schedule regular health checkups.</p><p>At Sitakund Modern Hospital Ltd., our specialist doctors are available every day for consultations to help you build a healthier routine.</p>\"}', NULL, NULL, '[\"health tips\", \"wellness\"]', 'Sitakund Modern Hospital', NULL, NULL, 'published', '2026-07-07 15:11:09', 1, NULL, NULL, NULL, 1, 1, '2026-07-27 15:11:09', '2026-07-27 15:22:23'),
(2, 2, '{\"bn\": \"গর্ভাবস্থায় প্রসবপূর্ব পরিচর্যার নির্দেশিকা\", \"en\": \"A Guide to Antenatal Care During Pregnancy\"}', 'a-guide-to-antenatal-care-during-pregnancy', '{\"bn\": \"গর্ভাবস্থায় নিয়মিত চেকআপ ও পরিচর্যা সম্পর্কে প্রত্যেক গর্ভবতী মায়ের যা জানা প্রয়োজন।\", \"en\": \"What every expecting mother should know about regular checkups and care during pregnancy.\"}', '{\"bn\": \"<p>নিয়মিত প্রসবপূর্ব চেকআপ জটিলতা আগেভাগে শনাক্ত ও প্রতিরোধ করতে সাহায্য করে। আমাদের স্ত্রীরোগ ও ধাত্রীবিদ্যা বিভাগে অভিজ্ঞ সার্জনদের মাধ্যমে সম্পূর্ণ গর্ভকালীন সেবা, নরমাল ডেলিভারী ও সিজার সেবা প্রদান করা হয়।</p><p>পরামর্শের জন্য শুক্রবার থেকে বুধবার সকাল ১১টা থেকে বিকাল ৫টা পর্যন্ত আমাদের গাইনী চেম্বারে আসুন।</p>\", \"en\": \"<p>Regular antenatal checkups help detect and prevent complications early. Our Gynecology & Obstetrics department offers full antenatal care, normal delivery and caesarean section services with experienced surgeons.</p><p>Visit our Gynecology chamber from Friday to Wednesday, 11:00 AM to 5:00 PM, for a consultation.</p>\"}', NULL, NULL, '[\"pregnancy\", \"maternal care\"]', 'Sitakund Modern Hospital', NULL, NULL, 'published', '2026-07-12 15:11:09', 1, NULL, NULL, NULL, 0, 2, '2026-07-27 15:11:09', '2026-07-27 15:11:09'),
(3, 1, '{\"bn\": \"ডায়াবেটিস সম্পর্কে জানুন: প্রতিরোধ ও ব্যবস্থাপনা\", \"en\": \"Understanding Diabetes: Prevention and Management\"}', 'understanding-diabetes-prevention-and-management', '{\"bn\": \"ডায়াবেটিস সম্পর্কে গুরুত্বপূর্ণ তথ্য এবং আমাদের ডায়াবেটিক সেন্টার কীভাবে সাহায্য করতে পারে।\", \"en\": \"Key facts about diabetes and how our Diabetic Center can help you manage it.\"}', '{\"bn\": \"<p>ডায়াবেটিস এখন সব বয়সের মানুষের মধ্যে একটি সাধারণ সমস্যা হয়ে দাঁড়িয়েছে। নিয়মিত রক্তে সুগার পরীক্ষা ও জীবনযাত্রার পরিবর্তনের মাধ্যমে গুরুতর জটিলতা প্রতিরোধ করা সম্ভব।</p><p>আমাদের ডায়াবেটিক সেন্টারে মেডিকেল টেকনোলজিস্টদের মাধ্যমে মাসিক ডায়াবেটিস চেকআপ এবং সার্টিফাইড ডায়াবেটোলজিস্টের পরামর্শ সেবা প্রদান করা হয়।</p>\", \"en\": \"<p>Diabetes has become a common condition affecting people of all ages. Early detection through regular blood sugar checkups and lifestyle changes can prevent serious complications.</p><p>Our Diabetic Center offers monthly diabetes checkups by our medical technologists, along with consultations from certified diabetologists.</p>\"}', NULL, NULL, '[\"diabetes\", \"health tips\"]', 'Sitakund Modern Hospital', NULL, NULL, 'published', '2026-07-17 15:11:09', 0, NULL, NULL, NULL, 0, 3, '2026-07-27 15:11:09', '2026-07-27 15:11:09'),
(4, 3, '{\"bn\": \"সীতাকুণ্ড মডার্ণ হসপিটালের ১২ বছরের কমিউনিটি সেবা\", \"en\": \"Sitakund Modern Hospital Marks 12 Years of Community Service\"}', 'sitakund-modern-hospital-marks-12-years-of-community-service', '{\"bn\": \"সততা ও সাশ্রয়ী মূল্যে সীতাকুণ্ডবাসীর সেবায় এক দশকেরও বেশি সময়ের পথচলা নিয়ে একটি ফিরে দেখা।\", \"en\": \"A look back at over a decade of serving the people of Sitakund with honest, affordable healthcare.\"}', '{\"bn\": \"<p>২০১৩ সালের জানুয়ারিতে যাত্রা শুরুর পর থেকে সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ ২৪,২৯৩ জন রোগীকে ইনডোর স্বাস্থ্যসেবা এবং ১,৮৭,২০০ এরও বেশি রোগীকে আউটডোর সেবা প্রদান করেছে, যেখানে ৬৪ জন কর্মী ২৪ ঘন্টা নিরলসভাবে কাজ করে যাচ্ছেন।</p><p>আমরা সীতাকুণ্ড ও পার্শ্ববর্তী উপজেলার মানুষদের আরও ভালো সেবা দিতে একটি নার্সিং কলেজ ও একটি বড় পরিসরের আধুনিক হাসপাতাল ভবন নির্মাণের পরিকল্পনা নিয়ে এগিয়ে যাচ্ছি।</p>\", \"en\": \"<p>Since opening in January 2013, Sitakund Modern Hospital Ltd. has provided indoor healthcare to over 24,000 patients and outdoor care to more than 1,87,200 patients, supported by a dedicated team of 64 staff working around the clock.</p><p>We remain committed to expanding our facilities, including a planned nursing college and a larger, modern hospital building, to better serve Sitakund and neighbouring upazilas.</p>\"}', NULL, NULL, '[\"hospital news\", \"community\"]', 'Sitakund Modern Hospital', NULL, NULL, 'published', '2026-07-22 15:11:09', 0, NULL, NULL, NULL, 0, 4, '2026-07-27 15:11:09', '2026-07-27 15:11:09');

--
-- Table: `doctor_availabilities`
--
DROP TABLE IF EXISTS `doctor_availabilities`;
CREATE TABLE `doctor_availabilities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `doctor_id` bigint(20) unsigned NOT NULL,
  `weekday` tinyint(3) unsigned NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `slot_duration_minutes` smallint(5) unsigned NOT NULL DEFAULT '15',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `doctor_availabilities_doctor_id_weekday_unique` (`doctor_id`,`weekday`),
  CONSTRAINT `doctor_availabilities_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Table: `doctor_chambers`
--
DROP TABLE IF EXISTS `doctor_chambers`;
CREATE TABLE `doctor_chambers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `doctor_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hospital_branch` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `floor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `room_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_map_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_own_hospital` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `doctor_chambers_doctor_id_foreign` (`doctor_id`),
  CONSTRAINT `doctor_chambers_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Table: `doctor_leaves`
--
DROP TABLE IF EXISTS `doctor_leaves`;
CREATE TABLE `doctor_leaves` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `doctor_id` bigint(20) unsigned NOT NULL,
  `date` date NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `doctor_leaves_doctor_id_date_unique` (`doctor_id`,`date`),
  CONSTRAINT `doctor_leaves_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Table: `doctor_service`
--
DROP TABLE IF EXISTS `doctor_service`;
CREATE TABLE `doctor_service` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `doctor_id` bigint(20) unsigned NOT NULL,
  `service_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `doctor_service_doctor_id_service_id_unique` (`doctor_id`,`service_id`),
  KEY `doctor_service_service_id_foreign` (`service_id`),
  CONSTRAINT `doctor_service_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE,
  CONSTRAINT `doctor_service_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Table: `doctors`
--
DROP TABLE IF EXISTS `doctors`;
CREATE TABLE `doctors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` json DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `specialty` json DEFAULT NULL,
  `degrees` json DEFAULT NULL,
  `experience` json DEFAULT NULL,
  `consultation_fee` decimal(10,2) DEFAULT NULL,
  `awards` json DEFAULT NULL,
  `bio` json DEFAULT NULL,
  `skills` json DEFAULT NULL,
  `schedule` json DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `seo_title` json DEFAULT NULL,
  `seo_description` json DEFAULT NULL,
  `seo_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_og_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `doctors_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `doctors` (`id`, `name`, `slug`, `role`, `photo`, `specialty`, `degrees`, `experience`, `consultation_fee`, `awards`, `bio`, `skills`, `schedule`, `address`, `phone`, `email`, `facebook_url`, `twitter_url`, `instagram_url`, `linkedin_url`, `youtube_url`, `is_featured`, `sort_order`, `is_active`, `seo_title`, `seo_description`, `seo_keywords`, `seo_og_image`, `created_at`, `updated_at`) VALUES
(1, 'Dr. Afroza Talukder', 'dr-afroza-talukder', '{\"bn\": \"স্ত্রীরোগ ও ধাত্রীবিদ্যায় অভিজ্ঞ সার্জন\", \"en\": \"Gynecology & Obstetrics Surgeon\"}', NULL, '{\"bn\": \"স্ত্রীরোগ ও ধাত্রীবিদ্যা\", \"en\": \"Gynecology & Obstetrics\"}', '{\"bn\": \"এম.বি.বি.এস, পিজিটি (অবস্ এন্ড গাইনী)\", \"en\": \"MBBS, PGT (Obs & Gynae)\"}', '{\"bn\": \"এক্স মেডিকেল অফিসার, সারাত আবিদা জেনারেল হাসপাতাল, সৌদি আরব। এক্স রেসিডেন্ট ডক্টর, জহুরুল ইসলাম মেডিকেল কলেজ হাসপাতাল, বাজিতপুর, কিশোরগঞ্জ। বিএমডিসি রেজি: নং- এ ২৮২১৪\", \"en\": \"Ex-Medical Officer, Sarat Abida General Hospital, Saudi Arabia. Ex-Resident Doctor, Zahurul Islam Medical College Hospital, Bajitpur, Kishoreganj. BMDC Reg. No. A-28214\"}', NULL, NULL, '{\"bn\": \"সকল প্রকার গাইনী রোগের চিকিৎসা, গর্ভবতী নারীদের গর্ভকালীন চিকিৎসা, অনিয়মিত ঋতুস্রাব, তলপেটে ব্যাথা, নরমাল ডেলিভারী, সিজার, বন্ধ্যাত্বের চিকিৎসা ও অপারেশন সেবা।\", \"en\": \"Treatment of all gynecological diseases, antenatal care for pregnant women, irregular menstruation, lower abdominal pain, normal delivery, caesarean section, and infertility treatment & surgical care.\"}', '[{\"bn\": \"নরমাল ডেলিভারী\", \"en\": \"Normal Delivery\"}, {\"bn\": \"সিজার\", \"en\": \"Caesarean Section\"}, {\"bn\": \"বন্ধ্যাত্বের চিকিৎসা\", \"en\": \"Infertility Treatment\"}]', '[{\"day\": \"Friday - Wednesday\", \"time\": \"11:00 AM - 5:00 PM\"}]', 'Amirabad (Sitakund South Bypass) 07, Sitakund Municipality, Sitakund, Chattogram', '01849-727858', 'sitakundmodernhospital@gmail.com', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, '2026-07-27 14:42:55', '2026-07-27 15:11:08'),
(2, 'Dr. Bijoy Talukder', 'dr-bijoy-talukder', '{\"bn\": \"নবজাতক ও শিশুরোগ বিশেষজ্ঞ\", \"en\": \"Neonatal & Pediatric Specialist\"}', NULL, '{\"bn\": \"নবজাতক ও শিশুরোগ\", \"en\": \"Neonatal & Pediatrics\"}', '{\"bn\": \"এম.বি.বি.এস, এম.ডি (শিশু স্বাস্থ্য), বঙ্গবন্ধু শেখ মুজিব মেডিকেল বিশ্ববিদ্যালয়\", \"en\": \"MBBS, MD (Child Health), Bangabandhu Sheikh Mujib Medical University\"}', '{\"bn\": \"কনসালটেন্ট (এন.আই.সি.ইউ এবং পি.আই.সি.ইউ), মেডিকেল সেন্টার হাসপাতাল, চট্টগ্রাম। চট্টগ্রাম মা ও শিশু জেনারেল হাসপাতাল, চট্টগ্রাম (এক্স)। বিএমডিসি রেজি: নং- এ-৫৭১৮৮\", \"en\": \"Consultant (NICU & PICU), Medical Centre Hospital, Chattogram. Ex-Consultant, Chattogram Mother & Child General Hospital, Chattogram. BMDC Reg. No. A-57188\"}', NULL, NULL, '{\"bn\": \"জ্বর ও খিঁচুনী, খাবারে অনিহা, সর্দি ও কাশি, গলা ব্যাথা ও টনসিল, শ্বাসকষ্ট, বদহজম, বমি, ডায়রিয়া, প্রস্রাবে সমস্যা, পেটে ব্যাথা, হাম চিকেন পক্স, নিউমোনিয়া, এলার্জি ও খোসপাঁচড়া।\", \"en\": \"Fever & convulsion, loss of appetite, cold & cough, sore throat & tonsillitis, breathing difficulty, indigestion, vomiting, diarrhea, urinary problems, abdominal pain, measles & chicken pox, pneumonia, allergy and scabies.\"}', '[{\"bn\": \"এন.আই.সি.ইউ ও পি.আই.সি.ইউ\", \"en\": \"NICU & PICU Care\"}, {\"bn\": \"নবজাতকের যত্ন\", \"en\": \"Newborn Care\"}]', '[{\"day\": \"Daily (Closed on Thursday)\", \"time\": \"4:00 PM - 6:00 PM\"}]', 'Amirabad (Sitakund South Bypass) 07, Sitakund Municipality, Sitakund, Chattogram', '01849-727858', 'sitakundmodernhospital@gmail.com', NULL, NULL, NULL, NULL, NULL, 1, 2, 1, NULL, NULL, NULL, NULL, '2026-07-27 14:42:55', '2026-07-27 15:11:08'),
(3, 'Dr. Mohammad Omor Faruk Tuhin', 'dr-mohammad-omor-faruk-tuhin', '{\"bn\": \"জেনারেল ল্যাপারোস্কপিক ও কলোরেক্টাল সার্জন\", \"en\": \"General Laparoscopic & Colorectal Surgeon\"}', NULL, '{\"bn\": \"ল্যাপারোস্কপিক ও কলোরেক্টাল সার্জারী\", \"en\": \"Laparoscopic & Colorectal Surgery\"}', '{\"bn\": \"এমবিবিএস, বিসিএস (স্বাস্থ্য), এফসিপিএস (সার্জারী)\", \"en\": \"MBBS, BCS (Health), FCPS (Surgery)\"}', '{\"bn\": \"সহকারী অধ্যাপক, চট্টগ্রাম মেডিকেল কলেজ হাসপাতাল।\", \"en\": \"Assistant Professor, Chattogram Medical College Hospital.\"}', NULL, '{\"bn\": null}', '{\"bn\": \"<p>ল্যাপারোস্কপিক মেশিনের মাধ্যমে পিত্তথলির পাথর অপারেশন, অ্যাপেন্ডিসাইটিস, হার্নিয়া, পাকস্থলীর ছিদ্র, কোলোরেক্টাল সার্জারী, ক্ষুদ্রান্ত/বৃহদান্তের প্রতিবন্ধকতার চিকিৎসা, ক্ষুদ্রান্ত/বৃহদন্ত্রের টিউমার বা ক্যান্সার অপারেশন, লেজার অপারেশন-পাইলস, ফিস্টুলা/এনাল ফিশার/হেমোরয়েড অপারেশন, স্তনের টিউমার/ক্যান্সারসহ অন্যান্য রোগের শল্য চিকিৎসা।</p>\", \"en\": \"<p>Laparoscopic gallbladder stone removal, appendicitis, hernia, stomach perforation, colorectal surgery for intestinal obstruction, intestinal tumor/cancer surgery, laser surgery for piles, fistula/anal fissure/hemorrhoid surgery, breast tumor/cancer and other surgical care.</p>\"}', '[{\"bn\": \"ল্যাপারোস্কপিক সার্জারী\", \"en\": \"Laparoscopic Surgery\"}, {\"bn\": \"কোলোরেক্টাল সার্জারী\", \"en\": \"Colorectal Surgery\"}]', '[{\"day\": \"Monday & Thursday\", \"time\": \"3:00 PM - 5:00 PM\"}]', 'Amirabad (Sitakund South Bypass) 07, Sitakund Municipality, Sitakund, Chattogram', '01849-727858', 'sitakundmodernhospital@gmail.com', NULL, NULL, NULL, NULL, NULL, 1, 3, 1, '{\"bn\": null}', '{\"bn\": \"ল্যাপারোস্কপিক ও কলোরেক্টাল সার্জারী\", \"en\": \"Laparoscopic & Colorectal Surgery\"}', 'mohammad, omor, faruk, tuhin', NULL, '2026-07-27 14:42:55', '2026-07-27 17:24:43'),
(4, 'Dr. Md. S.S. Talukder', 'dr-md-ss-talukder', '{\"bn\": \"অর্থোপেডিক সার্জন ও বিকলাঙ্গ রোগে অভিজ্ঞ\", \"en\": \"Orthopedic Surgeon & Disability Specialist\"}', NULL, '{\"bn\": \"অর্থোপেডিক্স\", \"en\": \"Orthopedics\"}', '{\"bn\": \"এমবিবিএস (আরইউ), পিজিটি (অর্থো), এমএস (অর্থোপেডিক্স) কোর্স, বঙ্গবন্ধু শেখ মুজিব মেডিকেল বিশ্ববিদ্যালয়\", \"en\": \"MBBS (RU), PGT (Ortho), MS (Orthopedics) Course, Bangabandhu Sheikh Mujib Medical University\"}', '{\"bn\": \"বিএমডিসি রেজি: নং এ-৯৬৩৫২\", \"en\": \"BMDC Reg. No. A-96352\"}', NULL, '{\"bn\": null}', '{\"bn\": \"ফ্র্যাকচার (হাড় জোড় ভাঙ্গা), ট্রমা (এক্সিডেন্ট)-ম্যানেজমেন্ট, টোটাল হিপ রিপ্লেসমেন্ট, টোটাল নী (হাঁটু) রিপ্লেসমেন্ট, লিগামেন্ট (রগ) রিপেয়ার/রিকনস্ট্রাকশন, স্পাইন ইনজুরীর চিকিৎসা, পঙ্গু ও পক্ষাঘাত চিকিৎসা, নার্ভ ও স্নায়ু রোগের চিকিৎসা।\", \"en\": \"Fracture (bone joint break), trauma (accident) management, total hip replacement, total knee replacement, ligament repair/reconstruction, spine injury treatment, paralysis treatment, and nerve related disease treatment.\"}', '[{\"bn\": \"টোটাল হিপ রিপ্লেসমেন্ট\", \"en\": \"Total Hip Replacement\"}, {\"bn\": \"টোটাল নী রিপ্লেসমেন্ট\", \"en\": \"Total Knee Replacement\"}]', '[{\"day\": \"Every Saturday & Tuesday\", \"time\": \"3:00 PM - 6:00 PM\"}]', 'Amirabad (Sitakund South Bypass) 07, Sitakund Municipality, Sitakund, Chattogram', '01849-727858', 'sitakundmodernhospital@gmail.com', NULL, NULL, NULL, NULL, NULL, 1, 4, 1, '{\"bn\": null}', '{\"bn\": null}', 'talukder', NULL, '2026-07-27 14:42:55', '2026-07-27 17:25:00'),
(5, 'Dr. Shuvo Das Gupta', 'dr-shuvo-das-gupta', '{\"bn\": \"মেডিসিন বিশেষজ্ঞ\", \"en\": \"Medicine Specialist\"}', NULL, '{\"bn\": \"মেডিসিন\", \"en\": \"Medicine\"}', '{\"bn\": \"এমবিবিএস; সি.সি.ডি (বারডেম), পি.জি.টি (মেডিসিন), পি.জি.টি (সার্জারি), চট্টগ্রাম মেডিকেল কলেজ হাসপাতাল\", \"en\": \"MBBS; CCD (BIRDEM), PGT (Medicine), PGT (Surgery), Chattogram Medical College Hospital\"}', '{\"bn\": \"বি.এম.ডি.সি. রেজি: এ-১১৬৪৭৫\", \"en\": \"BMDC Reg. No. A-116475\"}', NULL, '{\"bn\": null}', '{\"bn\": \"মেডিসিন, চর্মরোগ, শিশুরোগ, হাড়ভাঙ্গা জোড়া, বাত ব্যাথা, এ্যাজমা, ডায়াবেটিস ও হৃদরোগে অভিজ্ঞ।\", \"en\": \"Medicine, dermatology, pediatric diseases, bone fractures, arthritis pain, asthma, diabetes and heart disease.\"}', '[{\"bn\": \"ডায়াবেটিস ব্যবস্থাপনা\", \"en\": \"Diabetes Management\"}, {\"bn\": \"জেনারেল মেডিসিন\", \"en\": \"General Medicine\"}]', '[{\"day\": \"Wednesday - Sunday\", \"time\": \"9:00 AM - 2:00 PM & 4:00 PM - 9:00 PM\"}, {\"day\": \"Emergency\", \"time\": \"Available 24/7\"}]', 'Amirabad (Sitakund South Bypass) 07, Sitakund Municipality, Sitakund, Chattogram', '01849-727858', 'sitakundmodernhospital@gmail.com', NULL, NULL, NULL, NULL, NULL, 1, 5, 1, '{\"bn\": null}', '{\"bn\": null}', 'shuvo, gupta', NULL, '2026-07-27 14:42:55', '2026-07-27 17:25:14'),
(6, 'Dr. Md. Jobayer Hossen Tarek', 'dr-md-jobayer-hossen-tarek', '{\"bn\": \"মেডিসিন বিশেষজ্ঞ\", \"en\": \"Medicine Specialist\"}', NULL, '{\"bn\": \"মেডিসিন\", \"en\": \"Medicine\"}', '{\"bn\": \"এমবিবিএস, বিসিএস (স্বাস্থ্য), এমডি (মেডিসিন), বাংলাদেশ মেডিকেল বিশ্ববিদ্যালয় (এক্স-পিজি হাসপাতাল), ঢাকা। সার্টিফাইড ডায়াবেটোলজিস্ট (বারডেম)\", \"en\": \"MBBS, BCS (Health), MD (Medicine), Bangladesh Medical University (Ex-PG Hospital), Dhaka. Certified Diabetologist (BIRDEM)\"}', '{\"bn\": \"বি এম ডি সি রেজি. নং- এ-৬৭৬০২\", \"en\": \"BMDC Reg. No. A-67602\"}', NULL, '{\"bn\": null}', '{\"bn\": \"জেনারেল মেডিসিন ও সার্টিফাইড ডায়াবেটিস চিকিৎসা।\", \"en\": \"General medicine and certified diabetes care.\"}', '[{\"bn\": \"ডায়াবেটোলজি\", \"en\": \"Diabetology\"}]', '[{\"day\": \"Every Friday\", \"time\": \"10:00 AM - 1:00 PM\"}]', 'Amirabad (Sitakund South Bypass) 07, Sitakund Municipality, Sitakund, Chattogram', '01849-727858', 'sitakundmodernhospital@gmail.com', NULL, NULL, NULL, NULL, NULL, 1, 6, 1, '{\"bn\": null}', '{\"bn\": null}', 'jobayer, hossen, tarek', NULL, '2026-07-27 14:42:55', '2026-07-27 17:25:52');

--
-- Table: `failed_jobs`
--
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Table: `faqs`
--
DROP TABLE IF EXISTS `faqs`;
CREATE TABLE `faqs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `page` enum('home','about','faq') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'home',
  `badge` json NOT NULL,
  `title` json DEFAULT NULL,
  `description` json DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_alt` json DEFAULT NULL,
  `items` json NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `faqs_page_index` (`page`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `faqs` (`id`, `page`, `badge`, `title`, `description`, `image`, `image_alt`, `items`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'home', '{\"bn\": \"সাধারণ জিজ্ঞাসা\", \"en\": \"FAQ\"}', '{\"bn\": \"সচরাচর জিজ্ঞাসিত প্রশ্ন\", \"en\": \"Frequently Asked Questions\"}', '{\"bn\": \"আমাদের হাসপাতাল, সেবা ও অ্যাপয়েন্টমেন্ট সম্পর্কিত সাধারণ প্রশ্নের উত্তর।\", \"en\": \"Answers to common questions about our hospital, services and appointments.\"}', NULL, NULL, '[{\"answer\": {\"bn\": \"হ্যাঁ, আমাদের জরুরী বিভাগ, ফার্মেসী ও এম্বুলেন্স সার্ভিস প্রতিদিন ২৪ ঘন্টা খোলা থাকে।\", \"en\": \"Yes, our emergency department, pharmacy and ambulance service are open 24 hours a day, every day.\"}, \"question\": {\"bn\": \"জরুরী বিভাগ কি ২৪ ঘন্টা খোলা থাকে?\", \"en\": \"Is the emergency department open 24 hours?\"}}, {\"answer\": {\"bn\": \"আমাদের অ্যাপয়েন্টমেন্ট পেজ থেকে অনলাইনে বুক করতে পারেন অথবা ০১৮৪৯-৭২৭৮৫৮ / ০১৯৭৪-৩০০৮২১ নম্বরে কল করতে পারেন।\", \"en\": \"You can book an appointment online through our Appointment page or call us at 01849-727858 / 01974-300824.\"}, \"question\": {\"bn\": \"কীভাবে ডাক্তারের সাথে অ্যাপয়েন্টমেন্ট নেব?\", \"en\": \"How can I book an appointment with a doctor?\"}}, {\"answer\": {\"bn\": \"আমাদের এখানে ডিজিটাল ৪-ডি কালার আল্ট্রাসোনোগ্রাফী, ইকো, প্যাথলজি, ডিজিটাল এক্স-রে, ই.সি.জি, বায়োকেমিস্ট্রি, মাইক্রোবায়োলজী, সেরোলজী ও হরমোন পরীক্ষা করা হয়।\", \"en\": \"We offer digital 4-D color ultrasonography, ECHO, pathology, digital X-ray, ECG, biochemistry, microbiology, serology and hormone tests.\"}, \"question\": {\"bn\": \"কী কী ডায়াগনস্টিক পরীক্ষা করা যায়?\", \"en\": \"What diagnostic tests are available?\"}}, {\"answer\": {\"bn\": \"হ্যাঁ, আমাদের ফার্মেসীতে সকলের জন্য ওষুধে ১০% ছাড় দেওয়া হয়, এবং নিবন্ধিত শেয়ার হোল্ডারদের জন্য অতিরিক্ত ছাড় রয়েছে।\", \"en\": \"Yes, our pharmacy offers a 10% discount on medicines for all customers, and additional discounts for registered shareholders.\"}, \"question\": {\"bn\": \"ওষুধে কি ছাড় দেওয়া হয়?\", \"en\": \"Do you provide medicine discounts?\"}}]', 0, 1, '2026-07-27 15:11:09', '2026-07-27 15:11:09'),
(2, 'about', '{\"bn\": \"সাধারণ জিজ্ঞাসা\", \"en\": \"FAQ\"}', '{\"bn\": \"আমাদের সম্পর্কে — সাধারণ জিজ্ঞাসা\", \"en\": \"About Us — FAQ\"}', '{\"bn\": \"সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ এর ইতিহাস, লক্ষ্য ও টিম সম্পর্কে আরও জানুন।\", \"en\": \"Learn more about our history, mission and the team behind Sitakund Modern Hospital Ltd.\"}', NULL, NULL, '[{\"answer\": {\"bn\": \"সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ ২০১৩ সালের জানুয়ারিতে সীতাকুণ্ডবাসীর জন্য আধুনিক স্বাস্থ্যসেবা নিশ্চিত করতে প্রতিষ্ঠিত হয়।\", \"en\": \"Sitakund Modern Hospital Ltd. was established in January 2013 to ensure modern healthcare for the people of Sitakund.\"}, \"question\": {\"bn\": \"হাসপাতালটি কবে প্রতিষ্ঠিত হয়েছে?\", \"en\": \"When was the hospital established?\"}}, {\"answer\": {\"bn\": \"হ্যাঁ, সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ একটি জয়েন্টস্টক কোম্পানীর নিবন্ধিত লিমিটেড কোম্পানী, যাতে পরিচালক আছেন ১২ জন।\", \"en\": \"Yes, Sitakund Modern Hospital Ltd. is a registered joint-stock limited company with 12 directors.\"}, \"question\": {\"bn\": \"হাসপাতালটি কি একটি নিবন্ধিত প্রতিষ্ঠান?\", \"en\": \"Is the hospital a registered company?\"}}, {\"answer\": {\"bn\": \"আমরা নতুন জায়গায় নিজস্ব ভবনে একটি আধুনিক হাসপাতাল, ডায়াগনস্টিক সেন্টার ও নার্সিং কলেজ গড়ে তোলার কাজ করছি।\", \"en\": \"We are working on establishing our own modern hospital, diagnostic center and nursing college building on newly acquired land.\"}, \"question\": {\"bn\": \"হাসপাতালের ভবিষ্যৎ পরিকল্পনা কী?\", \"en\": \"What are the future plans of the hospital?\"}}]', 0, 1, '2026-07-27 15:11:09', '2026-07-27 15:11:09'),
(3, 'faq', '{\"bn\": \"হেল্প সেন্টার\", \"en\": \"Help Center\"}', '{\"bn\": \"সচরাচর জিজ্ঞাসিত প্রশ্ন\", \"en\": \"Frequently Asked Questions\"}', '{\"bn\": \"হাসপাতালে আসা, চিকিৎসা ও আমাদের সুবিধা সম্পর্কে যা জানা প্রয়োজন সবকিছু।\", \"en\": \"Everything you need to know about visiting, treatment and our facilities.\"}', NULL, NULL, '[{\"answer\": {\"bn\": \"আমিরাবাদ (সীতাকুণ্ড দক্ষিণ বাইপাস) ০৭, সীতাকুণ্ড পৌরসভা, সীতাকুণ্ড, চট্টগ্রাম।\", \"en\": \"Amirabad (Sitakund South Bypass) 07, Sitakund Municipality, Sitakund, Chattogram.\"}, \"question\": {\"bn\": \"হাসপাতালটি কোথায় অবস্থিত?\", \"en\": \"Where is the hospital located?\"}}, {\"answer\": {\"bn\": \"হ্যাঁ, আমরা প্রতি মাসে সীতাকুণ্ডের বিভিন্ন ইউনিয়নে ফ্রি মেডিকেল ক্যাম্প পরিচালনা করি, পাশাপাশি শিক্ষার্থীদের জন্য ফ্রি রক্তের গ্রুপ ও ডায়াবেটিস চেকআপের ব্যবস্থাও রয়েছে।\", \"en\": \"Yes, we organize monthly free medical camps in different unions of Sitakund, along with free blood group and diabetes checkups for students.\"}, \"question\": {\"bn\": \"ফ্রি মেডিকেল ক্যাম্পের সুবিধা আছে কি?\", \"en\": \"Do you offer free medical camps?\"}}, {\"answer\": {\"bn\": \"হ্যাঁ, আমাদের ২৪ ঘন্টা এম্বুলেন্স সার্ভিস রোগী নিয়ে আসতে পারে, এবং হাসপাতাল প্রাঙ্গণে পার্কিং সুবিধা রয়েছে।\", \"en\": \"Yes, our 24-hour ambulance service can pick up patients, and parking is available on hospital premises.\"}, \"question\": {\"bn\": \"পার্কিং ও এম্বুলেন্স পিকআপ সুবিধা আছে কি?\", \"en\": \"Is there parking and ambulance pickup available?\"}}]', 0, 1, '2026-07-27 15:11:09', '2026-07-27 15:11:09');

--
-- Table: `gallery_images`
--
DROP TABLE IF EXISTS `gallery_images`;
CREATE TABLE `gallery_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt` json DEFAULT NULL,
  `sub_title` json DEFAULT NULL,
  `caption` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `gallery_images` (`id`, `image`, `alt`, `sub_title`, `caption`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'gallery/8FMsArbV9vtHJznpNYvYFUg9haR9MvqYL4DjJfGo.jpg', '{\"bn\": \"\", \"en\": \"\"}', '{\"bn\": \"\", \"en\": \"\"}', '{\"bn\": \"\", \"en\": \"\"}', 1, 0, '2026-07-17 16:02:10', '2026-07-17 16:20:46'),
(2, 'gallery/Sl27aDrjCUBY5FoIq854mZgU1uM6bgd0qCME7HDp.png', '{\"bn\": \"\", \"en\": \"\"}', '{\"bn\": \"\", \"en\": \"\"}', '{\"bn\": \"\", \"en\": \"\"}', 1, 1, '2026-07-17 16:33:23', '2026-07-17 16:33:23'),
(3, 'gallery/kBNWUtmRAcbBC8YX9rnxYKyEOxgXYOUN9HMm7p5y.png', '{\"bn\": \"\", \"en\": \"\"}', '{\"bn\": \"\", \"en\": \"\"}', '{\"bn\": \"\", \"en\": \"\"}', 1, 2, '2026-07-17 16:33:23', '2026-07-17 16:33:23'),
(4, 'gallery/gallery-1.jpg', '{\"bn\": \"সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ রিসেপশন\", \"en\": \"Sitakund Modern Hospital Ltd. reception\"}', '{\"bn\": \"রিসেপশন\", \"en\": \"Reception\"}', '{\"bn\": \"সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ\", \"en\": \"Sitakund Modern Hospital Ltd.\"}', 1, 1, '2026-07-27 15:11:09', '2026-07-27 15:11:09'),
(5, 'gallery/gallery-2.jpg', '{\"bn\": \"অপারেশন থিয়েটার\", \"en\": \"Operation theatre\"}', '{\"bn\": \"অপারেশন থিয়েটার\", \"en\": \"Operation Theatre\"}', '{\"bn\": \"সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ\", \"en\": \"Sitakund Modern Hospital Ltd.\"}', 1, 2, '2026-07-27 15:11:09', '2026-07-27 15:11:09'),
(6, 'gallery/gallery-3.jpg', '{\"bn\": \"নার্সিং কলেজের শ্রেণীকক্ষ\", \"en\": \"Nursing college classroom\"}', '{\"bn\": \"নার্সিং কলেজ\", \"en\": \"Nursing College\"}', '{\"bn\": \"সীতাকুণ্ড মডার্ণ নার্সিং কলেজ\", \"en\": \"Sitakund Modern Nursing College\"}', 1, 3, '2026-07-27 15:11:09', '2026-07-27 15:11:09'),
(7, 'gallery/gallery-4.jpg', '{\"bn\": \"রোগী ওয়ার্ড\", \"en\": \"Patient ward\"}', '{\"bn\": \"রোগী ওয়ার্ড\", \"en\": \"Patient Ward\"}', '{\"bn\": \"সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ\", \"en\": \"Sitakund Modern Hospital Ltd.\"}', 1, 4, '2026-07-27 15:11:09', '2026-07-27 15:11:09'),
(8, 'gallery/gallery-5.jpg', '{\"bn\": \"ডায়াগনস্টিক ল্যাবরেটরি\", \"en\": \"Diagnostic laboratory\"}', '{\"bn\": \"ডায়াগনস্টিক ল্যাব\", \"en\": \"Diagnostic Lab\"}', '{\"bn\": \"সীতাকুণ্ড মডার্ণ হসপিটাল ল্যাব\", \"en\": \"Sitakund Modern Hospital Lab\"}', 1, 5, '2026-07-27 15:11:09', '2026-07-27 15:11:09'),
(9, 'gallery/gallery-6.jpg', '{\"bn\": \"নার্সিং কলেজের শিক্ষার্থীরা\", \"en\": \"Nursing college students\"}', '{\"bn\": \"নার্সিং শিক্ষার্থী\", \"en\": \"Nursing Students\"}', '{\"bn\": \"সীতাকুণ্ড মডার্ণ নার্সিং কলেজ\", \"en\": \"Sitakund Modern Nursing College\"}', 1, 6, '2026-07-27 15:11:09', '2026-07-27 15:11:09'),
(10, 'gallery/gallery-7.jpg', '{\"bn\": \"ফার্মেসী কাউন্টার\", \"en\": \"Pharmacy counter\"}', '{\"bn\": \"ফার্মেসী\", \"en\": \"Pharmacy\"}', '{\"bn\": \"সীতাকুণ্ড মডার্ণ হসপিটাল ফার্মেসী\", \"en\": \"Sitakund Modern Hospital Pharmacy\"}', 1, 7, '2026-07-27 15:11:09', '2026-07-27 15:11:09'),
(11, 'gallery/gallery-8.jpg', '{\"bn\": \"এম্বুলেন্স সার্ভিস\", \"en\": \"Ambulance service\"}', '{\"bn\": \"এম্বুলেন্স\", \"en\": \"Ambulance\"}', '{\"bn\": \"সীতাকুণ্ড মডার্ণ হসপিটাল এম্বুলেন্স\", \"en\": \"Sitakund Modern Hospital Ambulance\"}', 1, 8, '2026-07-27 15:11:09', '2026-07-27 15:11:09');

--
-- Table: `global_settings`
--
DROP TABLE IF EXISTS `global_settings`;
CREATE TABLE `global_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `global_settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `global_settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(16, 'hist_desc', NULL, '2026-07-18 04:41:25', '2026-07-18 04:41:25'),
(17, 'hist_seo_title', NULL, '2026-07-18 04:41:25', '2026-07-18 04:41:25'),
(18, 'hist_seo_description', NULL, '2026-07-18 04:41:25', '2026-07-18 04:41:25'),
(19, 'hist_seo_keywords', 'decade', '2026-07-18 04:41:25', '2026-07-27 18:00:23'),
(20, 'hist_timeline', '[]', '2026-07-18 04:41:25', '2026-07-27 18:00:23'),
(21, 'header_site_name', 'Sitakund Modern Hospital Ltd.', '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(22, 'header_phone', '01849-727858', '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(23, 'header_email', 'sitakundmodernhospital@gmail.com', '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(24, 'footer_phone_1', '01849-727858', '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(25, 'footer_phone_2', '01974-300824', '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(26, 'footer_phone_3', '01814-158783', '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(27, 'footer_email_1', 'sitakundmodernhospital@gmail.com', '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(28, 'footer_address_line1', 'Amirabad (Sitakund South Bypass) 07', '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(29, 'footer_address_line2', 'Sitakund Municipality, Sitakund, Chattogram', '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(30, 'footer_opening_time', NULL, '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(31, 'header_tagline', '{\"en\":\"Human Life, Humane Care\",\"bn\":\"মানব জীবন মানবিক হউক\"}', '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(32, 'header_hours', '{\"en\":\"Open 24 Hours, Everyday\",\"bn\":\"২৪ ঘন্টা সেবা প্রদান করা হয়\"}', '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(33, 'header_support_text', '{\"en\":\"Emergency & Ambulance Support\",\"bn\":\"জরুরী বিভাগ ও এম্বুলেন্স সাপোর্ট\"}', '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(34, 'header_sidebar_description', '{\"en\":\"A modern hospital and diagnostic center in Sitakund, Chattogram, providing 24-hour emergency, pharmacy, ambulance and specialist doctor services.\",\"bn\":\"সীতাকুণ্ড, চট্টগ্রামের একটি আধুনিক হাসপাতাল ও ডায়াগনস্টিক সেন্টার, যেখানে ২৪ ঘন্টা জরুরী বিভাগ, ফার্মেসী, এম্বুলেন্স ও বিশেষজ্ঞ ডাক্তারের সেবা পাওয়া যায়।\"}', '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(35, 'header_book_btn_text', '{\"en\":\"Book Appointment\",\"bn\":\"অ্যাপয়েন্টমেন্ট নিন\"}', '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(36, 'header_address', '{\"en\":\"Amirabad (Sitakund South Bypass) 07, Sitakund Municipality, Sitakund, Chattogram\",\"bn\":\"আমিরাবাদ (সীতাকুণ্ড দক্ষিণ বাইপাস) ০৭, সীতাকুণ্ড পৌরসভা, সীতাকুণ্ড, চট্টগ্রাম\"}', '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(37, 'footer_brand_description', '{\"en\":\"Sitakund Modern Hospital Ltd. has been serving the people of Sitakund since 2013 with a fully equipped hospital and diagnostic center, guided by the motto \\\"Human Life, Humane Care\\\".\",\"bn\":\"\\\"মানব জীবন মানবিক হউক\\\" এই স্লোগানকে বুকে ধারণ করে সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ ২০১৩ সাল থেকে সীতাকুণ্ডবাসীকে একটি সুসজ্জিত হাসপাতাল ও ডায়াগনস্টিক সেন্টারের মাধ্যমে সেবা দিয়ে আসছে।\"}', '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(38, 'footer_newsletter_title', '{\"en\":\"Subscribe to our Newsletter\",\"bn\":\"আমাদের নিউজলেটার সাবস্ক্রাইব করুন\"}', '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(39, 'footer_copyright_text', '{\"en\":\"© Sitakund Modern Hospital Ltd. All rights reserved.\",\"bn\":\"© সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ। সর্বস্বত্ব সংরক্ষিত।\"}', '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(40, 'about_hero_title', '{\"en\":\"About Us\",\"bn\":\"\\u0986\\u09ae\\u09be\\u09a6\\u09c7\\u09b0 \\u09b8\\u09ae\\u09cd\\u09aa\\u09b0\\u09cd\\u0995\\u09c7\"}', '2026-07-27 14:42:55', '2026-07-28 05:06:28'),
(41, 'about_seo_title', '{\"en\":\"About Sitakund Modern Hospital Ltd.\",\"bn\":\"\\u09b8\\u09c0\\u09a4\\u09be\\u0995\\u09c1\\u09a3\\u09cd\\u09a1 \\u09ae\\u09a1\\u09be\\u09b0\\u09cd\\u09a3 \\u09b9\\u09b8\\u09aa\\u09bf\\u099f\\u09be\\u09b2 \\u09b2\\u09bf\\u0983 \\u09b8\\u09ae\\u09cd\\u09aa\\u09b0\\u09cd\\u0995\\u09c7\"}', '2026-07-27 14:42:55', '2026-07-28 05:06:28'),
(42, 'about_seo_description', '{\"en\":\"Learn about Sitakund Modern Hospital Ltd., a modern hospital and diagnostic center serving Sitakund, Chattogram since 2013.\",\"bn\":\"\\u09e8\\u09e6\\u09e7\\u09e9 \\u09b8\\u09be\\u09b2 \\u09a5\\u09c7\\u0995\\u09c7 \\u09b8\\u09c0\\u09a4\\u09be\\u0995\\u09c1\\u09a3\\u09cd\\u09a1, \\u099a\\u099f\\u09cd\\u099f\\u0997\\u09cd\\u09b0\\u09be\\u09ae\\u09c7\\u09b0 \\u09ae\\u09be\\u09a8\\u09c1\\u09b7\\u0995\\u09c7 \\u09b8\\u09c7\\u09ac\\u09be \\u09aa\\u09cd\\u09b0\\u09a6\\u09be\\u09a8\\u0995\\u09be\\u09b0\\u09c0 \\u098f\\u0995\\u099f\\u09bf \\u0986\\u09a7\\u09c1\\u09a8\\u09bf\\u0995 \\u09b9\\u09be\\u09b8\\u09aa\\u09be\\u09a4\\u09be\\u09b2 \\u0993 \\u09a1\\u09be\\u09af\\u09bc\\u09be\\u0997\\u09a8\\u09b8\\u09cd\\u099f\\u09bf\\u0995 \\u09b8\\u09c7\\u09a8\\u09cd\\u099f\\u09be\\u09b0 \\u09b8\\u09c0\\u09a4\\u09be\\u0995\\u09c1\\u09a3\\u09cd\\u09a1 \\u09ae\\u09a1\\u09be\\u09b0\\u09cd\\u09a3 \\u09b9\\u09b8\\u09aa\\u09bf\\u099f\\u09be\\u09b2 \\u09b2\\u09bf\\u0983 \\u09b8\\u09ae\\u09cd\\u09aa\\u09b0\\u09cd\\u0995\\u09c7 \\u099c\\u09be\\u09a8\\u09c1\\u09a8\\u0964\"}', '2026-07-27 14:42:55', '2026-07-28 05:06:28'),
(43, 'about_title', '{\"en\":\"Sitakund Modern Hospital Ltd.\",\"bn\":\"\\u09b8\\u09c0\\u09a4\\u09be\\u0995\\u09c1\\u09a3\\u09cd\\u09a1 \\u09ae\\u09a1\\u09be\\u09b0\\u09cd\\u09a3 \\u09b9\\u09b8\\u09aa\\u09bf\\u099f\\u09be\\u09b2 \\u09b2\\u09bf\\u0983\"}', '2026-07-27 14:42:55', '2026-07-28 05:06:28'),
(44, 'about_desc', '{\"en\":\"Located at the gateway to Chattogram, the commercial capital of Bangladesh, Sitakund is one of the country\'s oldest and most important upazilas, home to nearly 3,35,178 people but served by only one government upazila health complex with 50 beds. Recognizing this severe shortage, in January 2013 we established a modern hospital and diagnostic center \\u2014 \\\"Sitakund Modern Hospital Ltd.\\\" \\u2014 to ensure the people of Sitakund have access to quality modern healthcare, 24 hours a day.\",\"bn\":\"\\u09ac\\u09be\\u0982\\u09b2\\u09be\\u09a6\\u09c7\\u09b6\\u09c7\\u09b0 \\u09ac\\u09be\\u09a3\\u09bf\\u099c\\u09cd\\u09af\\u09bf\\u0995 \\u09b0\\u09be\\u099c\\u09a7\\u09be\\u09a8\\u09c0 \\u099a\\u099f\\u09cd\\u099f\\u0997\\u09cd\\u09b0\\u09be\\u09ae \\u09b6\\u09b9\\u09b0\\u09c7\\u09b0 \\u09aa\\u09cd\\u09b0\\u09ac\\u09c7\\u09b6\\u09a6\\u09cd\\u09ac\\u09be\\u09b0, \\u0990\\u09a4\\u09bf\\u09b9\\u09be\\u09b8\\u09bf\\u0995 \\u09b8\\u09cd\\u09a5\\u09be\\u09aa\\u09a8\\u09be \\u0993 \\u09aa\\u09cd\\u09b0\\u09be\\u0995\\u09c3\\u09a4\\u09bf\\u0995 \\u09b8\\u09cc\\u09a8\\u09cd\\u09a6\\u09b0\\u09cd\\u09af\\u09c7 \\u09b8\\u09ae\\u09c3\\u09a6\\u09cd\\u09a7 \\u09b8\\u09c0\\u09a4\\u09be\\u0995\\u09c1\\u09a3\\u09cd\\u09a1 \\u09ac\\u09be\\u0982\\u09b2\\u09be\\u09a6\\u09c7\\u09b6\\u09c7\\u09b0 \\u0985\\u09a8\\u09cd\\u09af\\u09a4\\u09ae \\u0997\\u09c1\\u09b0\\u09c1\\u09a4\\u09cd\\u09ac\\u09aa\\u09c2\\u09b0\\u09cd\\u09a3 \\u0993 \\u09aa\\u09cd\\u09b0\\u09be\\u099a\\u09c0\\u09a8\\u09a4\\u09ae \\u0989\\u09aa\\u099c\\u09c7\\u09b2\\u09be\\u0964 \\u09ac\\u09b0\\u09cd\\u09a4\\u09ae\\u09be\\u09a8\\u09c7 \\u09b8\\u09c0\\u09a4\\u09be\\u0995\\u09c1\\u09a3\\u09cd\\u09a1\\u09c7\\u09b0 \\u099c\\u09a8\\u09b8\\u0982\\u0996\\u09cd\\u09af\\u09be \\u09e9,\\u09e9\\u09eb,\\u09e7\\u09ed\\u09ee \\u099c\\u09a8 \\u09b9\\u09b2\\u09c7\\u0993 \\u098f\\u0996\\u09be\\u09a8\\u09c7 \\u09ae\\u09be\\u09a4\\u09cd\\u09b0 \\u09eb\\u09e6 \\u09b6\\u09af\\u09cd\\u09af\\u09be\\u09b0 \\u098f\\u0995\\u099f\\u09bf \\u09b8\\u09b0\\u0995\\u09be\\u09b0\\u09bf \\u0989\\u09aa\\u099c\\u09c7\\u09b2\\u09be \\u09b8\\u09cd\\u09ac\\u09be\\u09b8\\u09cd\\u09a5\\u09cd\\u09af \\u0995\\u09ae\\u09aa\\u09cd\\u09b2\\u09c7\\u0995\\u09cd\\u09b8 \\u09b0\\u09af\\u09bc\\u09c7\\u099b\\u09c7, \\u09af\\u09be \\u098f\\u0987 \\u09ac\\u09bf\\u09b6\\u09be\\u09b2 \\u099c\\u09a8\\u09b8\\u0982\\u0996\\u09cd\\u09af\\u09be\\u09b0 \\u099c\\u09a8\\u09cd\\u09af \\u0996\\u09c1\\u09ac\\u0987 \\u0985\\u09aa\\u09cd\\u09b0\\u09a4\\u09c1\\u09b2\\u0964 \\u098f\\u0987 \\u09b8\\u0982\\u0995\\u099f \\u09ac\\u09bf\\u09ac\\u09c7\\u099a\\u09a8\\u09be \\u0995\\u09b0\\u09c7 \\u09e8\\u09e6\\u09e7\\u09e9 \\u09b8\\u09be\\u09b2\\u09c7\\u09b0 \\u099c\\u09be\\u09a8\\u09c1\\u09af\\u09bc\\u09be\\u09b0\\u09bf\\u09a4\\u09c7 \\u0986\\u09ae\\u09b0\\u09be \\u0997\\u09a1\\u09bc\\u09c7 \\u09a4\\u09c1\\u09b2\\u09bf \\u098f\\u0995\\u099f\\u09bf \\u0986\\u09a7\\u09c1\\u09a8\\u09bf\\u0995 \\u09ae\\u09be\\u09a8\\u09c7\\u09b0 \\u09b9\\u09be\\u09b8\\u09aa\\u09be\\u09a4\\u09be\\u09b2 \\u0993 \\u09a1\\u09be\\u09af\\u09bc\\u09be\\u0997\\u09a8\\u09b8\\u09cd\\u099f\\u09bf\\u0995 \\u09b8\\u09c7\\u09a8\\u09cd\\u099f\\u09be\\u09b0 \\\"\\u09b8\\u09c0\\u09a4\\u09be\\u0995\\u09c1\\u09a3\\u09cd\\u09a1 \\u09ae\\u09a1\\u09be\\u09b0\\u09cd\\u09a3 \\u09b9\\u09b8\\u09aa\\u09bf\\u099f\\u09be\\u09b2 \\u09b2\\u09bf\\u0983\\\", \\u09af\\u09be\\u09a4\\u09c7 \\u09b8\\u09c0\\u09a4\\u09be\\u0995\\u09c1\\u09a3\\u09cd\\u09a1\\u09ac\\u09be\\u09b8\\u09c0 \\u09e8\\u09ea \\u0998\\u09a8\\u09cd\\u099f\\u09be \\u0986\\u09a7\\u09c1\\u09a8\\u09bf\\u0995 \\u09b8\\u09cd\\u09ac\\u09be\\u09b8\\u09cd\\u09a5\\u09cd\\u09af\\u09b8\\u09c7\\u09ac\\u09be \\u09a8\\u09bf\\u09b6\\u09cd\\u099a\\u09bf\\u09a4 \\u0995\\u09b0\\u09a4\\u09c7 \\u09aa\\u09be\\u09b0\\u09c7\\u0964\"}', '2026-07-27 14:42:55', '2026-07-28 05:06:28'),
(45, 'about_hours_title', '{\"en\":\"Working Hours\",\"bn\":\"\\u0995\\u09b0\\u09cd\\u09ae\\u0998\\u09a8\\u09cd\\u099f\\u09be\"}', '2026-07-27 14:42:55', '2026-07-28 05:06:28'),
(46, 'about_more_btn_text', '{\"en\":\"Read More\",\"bn\":\"\\u0986\\u09b0\\u0993 \\u09aa\\u09a1\\u09bc\\u09c1\\u09a8\"}', '2026-07-27 14:42:55', '2026-07-28 05:06:28'),
(47, 'about_mv_title', '{\"en\":\"Our Mission & Vision\",\"bn\":\"\\u0986\\u09ae\\u09be\\u09a6\\u09c7\\u09b0 \\u09b2\\u0995\\u09cd\\u09b7\\u09cd\\u09af \\u0993 \\u0989\\u09a6\\u09cd\\u09a6\\u09c7\\u09b6\\u09cd\\u09af\"}', '2026-07-27 14:42:55', '2026-07-28 05:06:28'),
(48, 'about_mv_desc', '{\"en\":\"We are committed to providing the people of Sitakund with honest, sincere and affordable healthcare, 24 hours a day, every day.\",\"bn\":\"\\u0986\\u09ae\\u09b0\\u09be \\u09a6\\u09c3\\u09a2\\u09bc\\u09a4\\u09be\\u09b0 \\u09b8\\u09be\\u09a5\\u09c7 \\u09b8\\u09c0\\u09a4\\u09be\\u0995\\u09c1\\u09a3\\u09cd\\u09a1\\u09ac\\u09be\\u09b8\\u09c0\\u09b0 \\u09a8\\u09bf\\u0995\\u099f \\u0985\\u0999\\u09cd\\u0997\\u09c0\\u0995\\u09be\\u09b0\\u09ac\\u09a6\\u09cd\\u09a7, \\u09b8\\u09ae\\u09cd\\u09aa\\u09c2\\u09b0\\u09cd\\u09a3 \\u09a8\\u09cd\\u09af\\u09be\\u09af\\u09bc-\\u09a8\\u09bf\\u09b7\\u09cd\\u09a0\\u09be\\u09b0 \\u09ae\\u09a7\\u09cd\\u09af\\u09a6\\u09bf\\u09af\\u09bc\\u09c7 \\u09e8\\u09ea \\u0998\\u09a8\\u09cd\\u099f\\u09be \\u099a\\u09bf\\u0995\\u09bf\\u09ce\\u09b8\\u09be \\u09b8\\u09c7\\u09ac\\u09be \\u09aa\\u09cd\\u09b0\\u09a6\\u09be\\u09a8 \\u0995\\u09b0\\u09be\\u09b0 \\u099c\\u09a8\\u09cd\\u09af\\u0964\"}', '2026-07-27 14:42:55', '2026-07-28 05:06:28'),
(49, 'ceo_badge_label', '{\"en\":\"Chairman\",\"bn\":\"\\u099a\\u09c7\\u09af\\u09bc\\u09be\\u09b0\\u09ae\\u09cd\\u09af\\u09be\\u09a8\"}', '2026-07-27 14:42:55', '2026-07-28 05:06:28'),
(50, 'ceo_eyebrow', '{\"en\":\"Chairman\'s Message\",\"bn\":\"\\u099a\\u09c7\\u09af\\u09bc\\u09be\\u09b0\\u09ae\\u09cd\\u09af\\u09be\\u09a8\\u09c7\\u09b0 \\u09ac\\u09be\\u09b0\\u09cd\\u09a4\\u09be\"}', '2026-07-27 14:42:55', '2026-07-28 05:06:28'),
(51, 'ceo_title', '{\"en\":\"A.K.M. Shamsul Alam (Azad)\",\"bn\":\"\\u098f. \\u0995\\u09c7. \\u098f\\u09ae \\u09b6\\u09be\\u09ae\\u09b8\\u09c1\\u09b2 \\u0986\\u09b2\\u09ae (\\u0986\\u099c\\u09be\\u09a6)\"}', '2026-07-27 14:42:55', '2026-07-28 05:06:28'),
(52, 'ceo_message', '{\"en\":\"Human civilization is a continuous journey, and modern medical science is an inseparable part of it. Over our 12-year journey, we have always stood beside the people of Sitakund and continuously worked to correct our shortcomings. \\\"Sitakund Modern Hospital Ltd.\\\" is now a registered joint-stock company, and we are moving forward to build our own modern hospital, diagnostic center and nursing college on our own land. Death is inevitable, but before that, we want to build a society where your loved ones can lead a secure life through purposeful education. \\\"Human Life, Humane Care.\\\"\",\"bn\":\"\\u09ae\\u09be\\u09a8\\u09ac \\u09b8\\u09ad\\u09cd\\u09af\\u09a4\\u09be \\u098f\\u0995\\u099f\\u09bf \\u099a\\u09b2\\u09ae\\u09be\\u09a8 \\u09aa\\u09cd\\u09b0\\u0995\\u09cd\\u09b0\\u09bf\\u09af\\u09bc\\u09be, \\u0986\\u09b0 \\u0986\\u09a7\\u09c1\\u09a8\\u09bf\\u0995 \\u099a\\u09bf\\u0995\\u09bf\\u09ce\\u09b8\\u09be \\u09ac\\u09bf\\u099c\\u09cd\\u099e\\u09be\\u09a8 \\u098f\\u0987 \\u09b8\\u09ad\\u09cd\\u09af\\u09a4\\u09be\\u09b0 \\u098f\\u0995\\u099f\\u09bf \\u0985\\u09aa\\u09b0\\u09bf\\u09b9\\u09be\\u09b0\\u09cd\\u09af \\u0985\\u0982\\u09b6\\u0964 \\u0986\\u09ae\\u09b0\\u09be \\u0986\\u09ae\\u09be\\u09a6\\u09c7\\u09b0 \\u09a6\\u09c0\\u09b0\\u09cd\\u0998 \\u09e7\\u09e8 \\u09ac\\u099b\\u09b0\\u09c7\\u09b0 \\u09aa\\u09a5 \\u099a\\u09b2\\u09be\\u09af\\u09bc \\u09b8\\u09c0\\u09a4\\u09be\\u0995\\u09c1\\u09a3\\u09cd\\u09a1 \\u09ac\\u09be\\u09b8\\u09c0\\u0995\\u09c7 \\u09b8\\u09b0\\u09cd\\u09ac\\u09a6\\u09be \\u09b8\\u09be\\u09a5\\u09c7 \\u09aa\\u09c7\\u09af\\u09bc\\u09c7\\u099b\\u09bf \\u098f\\u09ac\\u0982 \\u09ad\\u09c1\\u09b2-\\u09a4\\u09cd\\u09b0\\u09c1\\u099f\\u09bf \\u09b8\\u0982\\u09b6\\u09cb\\u09a7\\u09a8 \\u0995\\u09b0\\u09c7 \\u09b8\\u09be\\u09ae\\u09a8\\u09c7 \\u098f\\u0997\\u09bf\\u09af\\u09bc\\u09c7 \\u09af\\u09be\\u0993\\u09af\\u09bc\\u09be\\u09b0 \\u099a\\u09c7\\u09b7\\u09cd\\u099f\\u09be \\u0995\\u09b0\\u09c7\\u099b\\u09bf\\u0964 \\u09ac\\u09b0\\u09cd\\u09a4\\u09ae\\u09be\\u09a8\\u09c7 \\\"\\u09b8\\u09c0\\u09a4\\u09be\\u0995\\u09c1\\u09a3\\u09cd\\u09a1 \\u09ae\\u09a1\\u09be\\u09b0\\u09cd\\u09a3 \\u09b9\\u09b8\\u09aa\\u09bf\\u099f\\u09be\\u09b2 \\u09b2\\u09bf\\u0983\\\" \\u098f\\u0995\\u099f\\u09bf \\u099c\\u09af\\u09bc\\u09c7\\u09a8\\u09cd\\u099f\\u09b8\\u09cd\\u099f\\u0995 \\u0995\\u09cb\\u09ae\\u09cd\\u09aa\\u09be\\u09a8\\u09c0\\u09b0 \\u09a8\\u09bf\\u09ac\\u09a8\\u09cd\\u09a7\\u09bf\\u09a4 \\u09b2\\u09bf\\u09ae\\u09bf\\u099f\\u09c7\\u09a1 \\u0995\\u09cb\\u09ae\\u09cd\\u09aa\\u09be\\u09a8\\u09c0, \\u098f\\u09ac\\u0982 \\u0986\\u09ae\\u09b0\\u09be \\u09a8\\u09bf\\u099c\\u09b8\\u09cd\\u09ac \\u099c\\u09be\\u09af\\u09bc\\u0997\\u09be\\u09af\\u09bc \\u09a8\\u09bf\\u099c\\u09b8\\u09cd\\u09ac \\u09ad\\u09ac\\u09a8\\u09c7 \\u098f\\u0995\\u099f\\u09bf \\u0986\\u09a7\\u09c1\\u09a8\\u09bf\\u0995 \\u09b9\\u09be\\u09b8\\u09aa\\u09be\\u09a4\\u09be\\u09b2, \\u09a1\\u09be\\u09af\\u09bc\\u09be\\u0997\\u09a8\\u09b8\\u09cd\\u099f\\u09bf\\u0995 \\u09b8\\u09c7\\u09a8\\u09cd\\u099f\\u09be\\u09b0 \\u0993 \\u09a8\\u09be\\u09b0\\u09cd\\u09b8\\u09bf\\u0982 \\u0995\\u09b2\\u09c7\\u099c \\u0997\\u09a1\\u09bc\\u09c7 \\u09a4\\u09cb\\u09b2\\u09be\\u09b0 \\u0989\\u09a6\\u09cd\\u09af\\u09cb\\u0997 \\u09a8\\u09bf\\u09af\\u09bc\\u09c7\\u099b\\u09bf\\u0964 \\u09ae\\u09c3\\u09a4\\u09cd\\u09af\\u09c1 \\u0985\\u09a8\\u09bf\\u09ac\\u09be\\u09b0\\u09cd\\u09af, \\u09a4\\u09ac\\u09c1\\u0993 \\u0986\\u09ae\\u09b0\\u09be \\u098f\\u09ae\\u09a8 \\u098f\\u0995\\u099f\\u09bf \\u09b8\\u09ae\\u09be\\u099c \\u099a\\u09be\\u0987 \\u09af\\u09c7\\u0996\\u09be\\u09a8\\u09c7 \\u0986\\u09aa\\u09a8\\u09be\\u09b0 \\u09b8\\u09a8\\u09cd\\u09a4\\u09be\\u09a8 \\u098f\\u0995\\u099f\\u09bf \\u0995\\u09b0\\u09cd\\u09ae\\u09ae\\u09c1\\u0996\\u09c0 \\u09b6\\u09bf\\u0995\\u09cd\\u09b7\\u09be \\u09a8\\u09bf\\u09af\\u09bc\\u09c7 \\u09a8\\u09bf\\u09b0\\u09be\\u09aa\\u09a6 \\u099c\\u09c0\\u09ac\\u09a8 \\u0997\\u09a1\\u09bc\\u09c7 \\u09a4\\u09c1\\u09b2\\u09a4\\u09c7 \\u09aa\\u09be\\u09b0\\u09c7\\u0964 \\\"\\u09ae\\u09be\\u09a8\\u09ac \\u099c\\u09c0\\u09ac\\u09a8 \\u09ae\\u09be\\u09a8\\u09ac\\u09bf\\u0995 \\u09b9\\u0989\\u0995\\u0964\\\"\"}', '2026-07-27 14:42:55', '2026-07-28 05:06:28'),
(53, 'ceo_focus_label', '{\"en\":\"Our Focus\",\"bn\":\"\\u0986\\u09ae\\u09be\\u09a6\\u09c7\\u09b0 \\u0985\\u0997\\u09cd\\u09b0\\u09be\\u09a7\\u09bf\\u0995\\u09be\\u09b0\"}', '2026-07-27 14:42:55', '2026-07-28 05:06:28'),
(54, 'why_badge', '{\"en\":\"Why Choose Us\",\"bn\":\"\\u0995\\u09c7\\u09a8 \\u0986\\u09ae\\u09be\\u09a6\\u09c7\\u09b0 \\u09ac\\u09c7\\u099b\\u09c7 \\u09a8\\u09c7\\u09ac\\u09c7\\u09a8\"}', '2026-07-27 14:42:55', '2026-07-28 05:06:28'),
(55, 'why_title', '{\"en\":\"Trusted Healthcare Since 2013\",\"bn\":\"\\u09e8\\u09e6\\u09e7\\u09e9 \\u09b8\\u09be\\u09b2 \\u09a5\\u09c7\\u0995\\u09c7 \\u09ac\\u09bf\\u09b6\\u09cd\\u09ac\\u09b8\\u09cd\\u09a4 \\u09b8\\u09cd\\u09ac\\u09be\\u09b8\\u09cd\\u09a5\\u09cd\\u09af\\u09b8\\u09c7\\u09ac\\u09be\"}', '2026-07-27 14:42:55', '2026-07-28 05:06:28'),
(56, 'why_desc', '{\"en\":\"Digital 4-D color ultrasonography, ECHO, pathology, 24-hour digital X-ray & ECG, biochemistry, microbiology, serology and a diabetic center \\u2014 all under one roof.\",\"bn\":\"\\u09a1\\u09bf\\u099c\\u09bf\\u099f\\u09be\\u09b2 \\u09ea-\\u09a1\\u09bf \\u0995\\u09be\\u09b2\\u09be\\u09b0 \\u0986\\u09b2\\u09cd\\u099f\\u09cd\\u09b0\\u09be\\u09b8\\u09cb\\u09a8\\u09cb\\u0997\\u09cd\\u09b0\\u09be\\u09ab\\u09c0, \\u0987\\u0995\\u09cb, \\u09aa\\u09cd\\u09af\\u09be\\u09a5\\u09b2\\u099c\\u09bf, \\u09e8\\u09ea \\u0998\\u09a8\\u09cd\\u099f\\u09be \\u09a1\\u09bf\\u099c\\u09bf\\u099f\\u09be\\u09b2 \\u098f\\u0995\\u09cd\\u09b8-\\u09b0\\u09c7 \\u0993 \\u0987.\\u09b8\\u09bf.\\u099c\\u09bf, \\u09ac\\u09be\\u09af\\u09bc\\u09cb\\u0995\\u09c7\\u09ae\\u09bf\\u09b8\\u09cd\\u099f\\u09cd\\u09b0\\u09bf, \\u09ae\\u09be\\u0987\\u0995\\u09cd\\u09b0\\u09cb\\u09ac\\u09be\\u09af\\u09bc\\u09cb\\u09b2\\u099c\\u09c0, \\u09b8\\u09c7\\u09b0\\u09cb\\u09b2\\u099c\\u09c0 \\u0993 \\u09a1\\u09be\\u09af\\u09bc\\u09be\\u09ac\\u09c7\\u099f\\u09bf\\u0995 \\u09b8\\u09c7\\u09a8\\u09cd\\u099f\\u09be\\u09b0 \\u2014 \\u09b8\\u09ac\\u0995\\u09bf\\u099b\\u09c1 \\u098f\\u0995 \\u099b\\u09be\\u09a6\\u09c7\\u09b0 \\u09a8\\u09bf\\u099a\\u09c7\\u0964\"}', '2026-07-27 14:42:55', '2026-07-28 05:06:28'),
(57, 'contact_hero_title', '{\"en\":\"Contact Us\",\"bn\":\"যোগাযোগ করুন\"}', '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(58, 'contact_seo_title', '{\"en\":\"Contact Sitakund Modern Hospital Ltd.\",\"bn\":\"সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ - যোগাযোগ\"}', '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(59, 'contact_seo_description', '{\"en\":\"Get in touch with Sitakund Modern Hospital Ltd. for appointments, emergency care and general inquiries.\",\"bn\":\"অ্যাপয়েন্টমেন্ট, জরুরী সেবা ও সাধারণ তথ্যের জন্য সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ এর সাথে যোগাযোগ করুন।\"}', '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(60, 'contact_title', '{\"en\":\"Let\'s Get in Touch\",\"bn\":\"আমাদের সাথে যোগাযোগ করুন\"}', '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(61, 'contact_desc', '{\"en\":\"For appointments, emergency support or any inquiries, reach out to us any time — our team is available 24 hours a day.\",\"bn\":\"অ্যাপয়েন্টমেন্ট, জরুরী সেবা বা যেকোনো তথ্যের জন্য আমাদের সাথে যেকোনো সময় যোগাযোগ করুন — আমাদের টিম ২৪ ঘন্টা প্রস্তুত।\"}', '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(62, 'contact_talk_text', '{\"en\":\"Let\'s talk with us\",\"bn\":\"আমাদের সাথে কথা বলুন\"}', '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(63, 'contact_rating_text', '{\"en\":\"Trusted by our patients\",\"bn\":\"আমাদের রোগীদের আস্থার প্রতিষ্ঠান\"}', '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(64, 'contact_form_title', '{\"en\":\"Send a Message\",\"bn\":\"বার্তা পাঠান\"}', '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(65, 'contact_form_btn_text', '{\"en\":\"Send Message\",\"bn\":\"বার্তা পাঠান\"}', '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(69, 'appt_seo_keywords', '', '2026-07-27 18:00:02', '2026-07-27 18:00:02'),
(70, 'about_seo_keywords', 'sitakund, modern, hospital, located, gateway, chattogram, commercial, capital, bangladesh, country, oldest, most', '2026-07-28 05:01:11', '2026-07-28 05:06:28'),
(71, 'about_more_btn_url', NULL, '2026-07-28 05:01:11', '2026-07-28 05:01:11'),
(72, 'ceo_badge_value', NULL, '2026-07-28 05:01:11', '2026-07-28 05:01:11'),
(73, 'about_features', '[{\"en\":\"Comprehensive Specialties\",\"bn\":\"\\u09ac\\u09cd\\u09af\\u09be\\u09aa\\u0995 \\u09ac\\u09bf\\u09b6\\u09c7\\u09b7\\u09a4\\u09cd\\u09ac\"},{\"en\":\"Emergency Services\",\"bn\":\"\\u099c\\u09b0\\u09c1\\u09b0\\u09bf \\u09aa\\u09b0\\u09bf\\u09b7\\u09c7\\u09ac\\u09be\"},{\"en\":\"Intensive Care Units (ICUs)\",\"bn\":\"\\u0987\\u09a8\\u099f\\u09c7\\u09a8\\u09b8\\u09bf\\u09ad \\u0995\\u09c7\\u09af\\u09bc\\u09be\\u09b0 \\u0987\\u0989\\u09a8\\u09bf\\u099f (\\u0986\\u0987\\u09b8\\u09bf\\u0987\\u0989)\"},{\"en\":\"Telemedicine Facilities\",\"bn\":\"\\u099f\\u09c7\\u09b2\\u09bf\\u09ae\\u09c7\\u09a1\\u09bf\\u09b8\\u09bf\\u09a8 \\u09b8\\u09c1\\u09ac\\u09bf\\u09a7\\u09be\"},{\"en\":\"Multidisciplinary Team\",\"bn\":\"\\u09ac\\u09b9\\u09c1\\u09ac\\u09bf\\u09ad\\u09be\\u0997\\u09c0\\u09af\\u09bc \\u09a6\\u09b2\"},{\"en\":\"Research and Development\",\"bn\":\"\\u0997\\u09ac\\u09c7\\u09b7\\u09a3\\u09be \\u0993 \\u0989\\u09a8\\u09cd\\u09a8\\u09af\\u09bc\\u09a8\"},{\"en\":\"Advanced Imaging Services\",\"bn\":\"\\u0989\\u09a8\\u09cd\\u09a8\\u09a4 \\u0987\\u09ae\\u09c7\\u099c\\u09bf\\u0982 \\u09aa\\u09b0\\u09bf\\u09b7\\u09c7\\u09ac\\u09be\"},{\"en\":\"Rehabilitation Services\",\"bn\":\"\\u09aa\\u09c1\\u09a8\\u09b0\\u09cd\\u09ac\\u09be\\u09b8\\u09a8 \\u09aa\\u09b0\\u09bf\\u09b7\\u09c7\\u09ac\\u09be\"},{\"en\":\"Patient-Centric Approach\",\"bn\":\"\\u09b0\\u09cb\\u0997\\u09c0-\\u0995\\u09c7\\u09a8\\u09cd\\u09a6\\u09cd\\u09b0\\u09bf\\u0995 \\u09aa\\u09a6\\u09cd\\u09a7\\u09a4\\u09bf\"},{\"en\":\"Health Information Technology\",\"bn\":\"\\u09b8\\u09cd\\u09ac\\u09be\\u09b8\\u09cd\\u09a5\\u09cd\\u09af \\u09a4\\u09a5\\u09cd\\u09af \\u09aa\\u09cd\\u09b0\\u09af\\u09c1\\u0995\\u09cd\\u09a4\\u09bf\"}]', '2026-07-28 05:01:11', '2026-07-28 05:01:11'),
(74, 'about_mv_cards', '[{\"title\":{\"en\":null,\"bn\":null},\"description\":{\"en\":null,\"bn\":null}},{\"title\":{\"en\":null,\"bn\":null},\"description\":{\"en\":null,\"bn\":null}},{\"title\":{\"en\":null,\"bn\":null},\"description\":{\"en\":null,\"bn\":null}}]', '2026-07-28 05:01:11', '2026-07-28 05:01:11'),
(75, 'about_hours', '[{\"day\":{\"en\":\"Saturday\",\"bn\":\"\\u09b6\\u09a8\\u09bf\\u09ac\\u09be\\u09b0\"},\"time\":{\"en\":\"09:30 - 07:30\",\"bn\":\"\\u09e6\\u09ef:\\u09e9\\u09e6 - \\u09e6\\u09ed:\\u09e9\\u09e6\"}},{\"day\":{\"en\":\"Sunday\",\"bn\":\"\\u09b0\\u09ac\\u09bf\\u09ac\\u09be\\u09b0\"},\"time\":{\"en\":\"09:30 - 07:30\",\"bn\":\"\\u09e6\\u09ef:\\u09e9\\u09e6 - \\u09e6\\u09ed:\\u09e9\\u09e6\"}},{\"day\":{\"en\":\"Monday\",\"bn\":\"\\u09b8\\u09cb\\u09ae\\u09ac\\u09be\\u09b0\"},\"time\":{\"en\":\"09:30 - 07:30\",\"bn\":\"\\u09e6\\u09ef:\\u09e9\\u09e6 - \\u09e6\\u09ed:\\u09e9\\u09e6\"}},{\"day\":{\"en\":\"Tuesday\",\"bn\":\"\\u09ae\\u0999\\u09cd\\u0997\\u09b2\\u09ac\\u09be\\u09b0\"},\"time\":{\"en\":\"09:30 - 07:30\",\"bn\":\"\\u09e6\\u09ef:\\u09e9\\u09e6 - \\u09e6\\u09ed:\\u09e9\\u09e6\"}},{\"day\":{\"en\":\"Wednesday\",\"bn\":\"\\u09ac\\u09c1\\u09a7\\u09ac\\u09be\\u09b0\"},\"time\":{\"en\":\"09:30 - 07:30\",\"bn\":\"\\u09e6\\u09ef:\\u09e9\\u09e6 - \\u09e6\\u09ed:\\u09e9\\u09e6\"}},{\"day\":{\"en\":\"Thursday\",\"bn\":\"\\u09ac\\u09c3\\u09b9\\u09b8\\u09cd\\u09aa\\u09a4\\u09bf\\u09ac\\u09be\\u09b0\"},\"time\":{\"en\":\"09:30 - 07:30\",\"bn\":\"\\u09e6\\u09ef:\\u09e9\\u09e6 - \\u09e6\\u09ed:\\u09e9\\u09e6\"}},{\"day\":{\"en\":\"Friday\",\"bn\":\"\\u09b6\\u09c1\\u0995\\u09cd\\u09b0\\u09ac\\u09be\\u09b0\"},\"time\":{\"en\":\"09:30 - 07:30\",\"bn\":\"\\u09e6\\u09ef:\\u09e9\\u09e6 - \\u09e6\\u09ed:\\u09e9\\u09e6\"}}]', '2026-07-28 05:06:28', '2026-07-28 05:06:28');

--
-- Table: `inquiries`
--
DROP TABLE IF EXISTS `inquiries`;
CREATE TABLE `inquiries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('quote','contact_widget','contact_page') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'contact_page',
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('new','read','replied') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Table: `languages`
--
DROP TABLE IF EXISTS `languages`;
CREATE TABLE `languages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `native_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direction` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ltr',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `languages_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `languages` (`id`, `code`, `name`, `native_name`, `direction`, `is_default`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'en', 'English', 'English', 'ltr', 1, 1, 0, '2026-07-27 13:42:11', '2026-07-27 13:42:11'),
(2, 'bn', 'Bangla', 'বাংলা', 'ltr', 0, 1, 1, '2026-07-27 13:42:11', '2026-07-27 13:42:11');

--
-- Table: `management_members`
--
DROP TABLE IF EXISTS `management_members`;
CREATE TABLE `management_members` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` json DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `management_members_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `management_members` (`id`, `name`, `slug`, `role`, `photo`, `facebook_url`, `twitter_url`, `instagram_url`, `linkedin_url`, `youtube_url`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'A.K.M. Shamsul Alam (Azad)', 'akm-shamsul-alam-azad', '{\"bn\": \"চেয়ারম্যান\", \"en\": \"Chairman\"}', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2026-07-27 15:11:09', '2026-07-27 15:11:09');

--
-- Table: `migrations`
--
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_01_01_000001_create_sliders_table', 1),
(6, '2024_01_01_000002_create_global_settings_table', 1),
(7, '2024_01_02_000001_create_services_table', 1),
(8, '2024_01_02_000002_create_gallery_images_table', 1),
(9, '2024_01_02_000003_create_faqs_table', 1),
(10, '2024_01_02_000004_create_testimonials_table', 1),
(11, '2024_01_02_000005_add_image_to_faqs_table', 1),
(12, '2024_01_02_000006_create_facilities_table', 1),
(13, '2024_01_04_000001_create_blog_categories_table', 1),
(14, '2024_01_04_000001_create_roles_table', 1),
(15, '2024_01_04_000002_create_blogs_table', 1),
(16, '2024_01_04_000002_create_role_permissions_table', 1),
(17, '2024_01_04_000003_add_role_id_to_users_table', 1),
(18, '2024_01_04_000003_create_blog_comments_table', 1),
(19, '2026_06_16_061708_create_inquiries_table', 1),
(20, '2026_06_22_173135_alter_faqs_page_enum_add_faq', 1),
(21, '2026_07_06_000001_create_backups_table', 1),
(22, '2026_07_10_155923_add_star_rating_to_sliders_table', 1),
(23, '2026_07_15_144611_drop_room_booking_customer_tables', 1),
(24, '2026_07_17_060943_add_seo_fields_to_services_table', 2),
(25, '2026_07_17_083954_remove_unused_fields_from_services_table', 3),
(26, '2026_07_17_153820_create_doctors_table', 4),
(27, '2026_07_17_161529_add_sub_title_to_gallery_images_table', 5),
(28, '2026_07_17_181652_create_management_members_table', 6),
(29, '2026_07_18_045153_create_packages_table', 7),
(30, '2026_07_18_063728_create_appointments_table', 8),
(31, '2026_07_18_073928_create_awards_table', 9),
(32, '2026_07_18_090000_create_pages_table', 10),
(33, '2026_07_18_100000_drop_facilities_table', 11),
(34, '2026_07_18_110000_create_doctor_service_table', 12),
(35, '2026_07_27_090000_create_languages_table', 13),
(36, '2026_07_27_090100_convert_services_translatable_columns_to_json', 13),
(37, '2026_07_27_090200_convert_management_members_translatable_columns_to_json', 13),
(38, '2026_07_27_090300_convert_awards_translatable_columns_to_json', 13),
(39, '2026_07_27_090400_convert_blog_categories_translatable_columns_to_json', 13),
(40, '2026_07_27_090500_convert_gallery_images_translatable_columns_to_json', 13),
(41, '2026_07_27_090600_convert_doctors_translatable_columns_to_json', 13),
(42, '2026_07_27_090700_convert_packages_translatable_columns_to_json', 13),
(43, '2026_07_27_090800_convert_sliders_translatable_columns_to_json', 13),
(44, '2026_07_27_090900_convert_blogs_translatable_columns_to_json', 13),
(45, '2026_07_27_091000_convert_pages_translatable_columns_to_json', 13),
(46, '2026_07_27_091100_convert_testimonials_translatable_columns_to_json', 13),
(47, '2026_07_27_091200_convert_faqs_translatable_columns_to_json', 13),
(48, '2026_07_27_120000_create_patients_table', 14),
(49, '2026_07_27_120100_create_doctor_chambers_table', 14),
(50, '2026_07_27_120200_create_doctor_availabilities_table', 14),
(51, '2026_07_27_120300_create_doctor_leaves_table', 14),
(52, '2026_07_27_120400_add_booking_fields_to_doctors_table', 14),
(53, '2026_07_27_120500_add_booking_fields_to_appointments_table', 14),
(54, '2026_07_27_120600_add_doctor_id_to_users_table', 14),
(55, '2026_07_27_120700_create_app_notifications_table', 14),
(56, '2026_07_27_120800_make_appointment_email_nullable', 15),
(57, '2026_07_28_090000_add_document_to_appointments_table', 16),
(58, '2026_07_28_100000_add_documents_json_to_appointments_table', 17);

--
-- Table: `packages`
--
DROP TABLE IF EXISTS `packages`;
CREATE TABLE `packages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` json NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_desc` json DEFAULT NULL,
  `description` json DEFAULT NULL,
  `features` json DEFAULT NULL,
  `secondary_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `badge_value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `badge_label` json DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `seo_title` json DEFAULT NULL,
  `seo_description` json DEFAULT NULL,
  `seo_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_og_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `packages_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `packages` (`id`, `title`, `slug`, `image`, `short_desc`, `description`, `features`, `secondary_image`, `badge_value`, `badge_label`, `is_featured`, `sort_order`, `is_active`, `seo_title`, `seo_description`, `seo_keywords`, `seo_og_image`, `created_at`, `updated_at`) VALUES
(1, '{\"bn\": \"ফুল বডি চেকআপ প্যাকেজ\", \"en\": \"Full Body Checkup Package\"}', 'full-body-checkup-package', NULL, '{\"bn\": \"রক্ত পরীক্ষা, ই.সি.জি ও আল্ট্রাসোনোগ্রাফীসহ একটি পূর্ণাঙ্গ স্বাস্থ্য পরীক্ষা প্যাকেজ।\", \"en\": \"A comprehensive health screening covering blood tests, ECG and ultrasonography.\"}', '{\"bn\": \"আমাদের ফুল বডি চেকআপ প্যাকেজে প্যাথলজি, বায়োকেমিস্ট্রি, ই.সি.জি ও ডিজিটাল ৪-ডি আল্ট্রাসোনোগ্রাফী একসাথে করা হয়, যা আমাদের বিশেষজ্ঞ চিকিৎসকদের দ্বারা পর্যালোচনা করা হয়।\", \"en\": \"Our Full Body Checkup Package combines pathology, biochemistry, ECG and digital 4-D ultrasonography to give you a complete picture of your health, reviewed by our specialist physicians.\"}', '[{\"bn\": \"সম্পূর্ণ রক্ত পরীক্ষা (সিবিসি)\", \"en\": \"Complete Blood Count (CBC)\"}, {\"bn\": \"ই.সি.জি ও রক্তে সুগার পরীক্ষা\", \"en\": \"ECG & Blood Sugar Test\"}, {\"bn\": \"পেটের আল্ট্রাসোনোগ্রাফী\", \"en\": \"Abdominal Ultrasonography\"}, {\"bn\": \"ডাক্তারের পরামর্শ\", \"en\": \"Physician Consultation\"}]', NULL, '10%', '{\"bn\": \"ছাড়\", \"en\": \"Discount\"}', 1, 1, 1, NULL, NULL, NULL, NULL, '2026-07-27 15:11:09', '2026-07-27 15:11:09'),
(2, '{\"bn\": \"গর্ভকালীন সেবা প্যাকেজ\", \"en\": \"Antenatal Care Package\"}', 'antenatal-care-package', NULL, '{\"bn\": \"আমাদের স্ত্রীরোগ ও ধাত্রীবিদ্যা বিভাগের তত্ত্বাবধানে চেকআপ থেকে ডেলিভারী পর্যন্ত সম্পূর্ণ গর্ভকালীন সেবা।\", \"en\": \"Complete pregnancy care from checkup to delivery, guided by our Gynecology & Obstetrics team.\"}', '{\"bn\": \"আমাদের অভিজ্ঞ স্ত্রীরোগ ও ধাত্রীবিদ্যা সার্জনের তত্ত্বাবধানে নিয়মিত গর্ভকালীন চেকআপ, ৪-ডি আল্ট্রাসোনোগ্রাফী এবং ডেলিভারী (নরমাল বা সিজার) সেবা।\", \"en\": \"Regular antenatal checkups, 4-D ultrasonography, and delivery care (normal or caesarean) under the supervision of our experienced Gynecology & Obstetrics surgeon.\"}', '[{\"bn\": \"মাসিক গর্ভকালীন চেকআপ\", \"en\": \"Monthly Antenatal Checkup\"}, {\"bn\": \"৪-ডি আল্ট্রাসোনোগ্রাফী\", \"en\": \"4-D Ultrasonography\"}, {\"bn\": \"নরমাল ডেলিভারী / সিজার\", \"en\": \"Normal Delivery / Caesarean\"}, {\"bn\": \"প্রসব পরবর্তী ফলো-আপ\", \"en\": \"Postnatal Follow-up\"}]', NULL, NULL, '{\"bn\": \"জনপ্রিয়\", \"en\": \"Popular\"}', 1, 2, 1, NULL, NULL, NULL, NULL, '2026-07-27 15:11:09', '2026-07-27 15:11:09'),
(3, '{\"bn\": \"ডায়াবেটিক কেয়ার প্যাকেজ\", \"en\": \"Diabetic Care Package\"}', 'diabetic-care-package', NULL, '{\"bn\": \"আমাদের ডায়াবেটিক সেন্টার থেকে নিয়মিত ডায়াবেটিস পর্যবেক্ষণ ও পরামর্শ সেবা।\", \"en\": \"Regular diabetes monitoring and consultation from our Diabetic Center.\"}', '{\"bn\": \"রক্তে সুগার পর্যবেক্ষণ, এইচবিএ১সি পরীক্ষা এবং সার্টিফাইড ডায়াবেটোলজিস্টের পরামর্শসহ দীর্ঘমেয়াদী ডায়াবেটিস ব্যবস্থাপনার জন্য এই প্যাকেজ তৈরি।\", \"en\": \"Blood sugar monitoring, HbA1c testing and consultation with a certified diabetologist, designed for long-term diabetes management.\"}', '[{\"bn\": \"ফাস্টিং ও র‍্যান্ডম ব্লাড সুগার\", \"en\": \"Fasting & Random Blood Sugar\"}, {\"bn\": \"এইচবিএ১সি পরীক্ষা\", \"en\": \"HbA1c Test\"}, {\"bn\": \"ডায়াবেটোলজিস্টের পরামর্শ\", \"en\": \"Diabetologist Consultation\"}]', NULL, NULL, '{\"bn\": \"নিয়মিত পরিচর্যা\", \"en\": \"Ongoing Care\"}', 1, 3, 1, '{\"bn\": null}', '{\"bn\": null}', 'diabetic, care, package', NULL, '2026-07-27 15:11:09', '2026-07-27 17:26:34'),
(4, '{\"bn\": \"জরুরী ও এম্বুলেন্স সেবা প্যাকেজ\", \"en\": \"Emergency & Ambulance Care Package\"}', 'emergency-ambulance-care-package', NULL, '{\"bn\": \"জরুরী পরিস্থিতিতে এম্বুলেন্স পিকআপসহ ২৪ ঘন্টা জরুরী সেবা।\", \"en\": \"24-hour emergency response with ambulance pickup for critical situations.\"}', '{\"bn\": \"এম্বুলেন্স সার্ভিসসহ ২৪ ঘন্টা জরুরী বিভাগের সুবিধা, তাৎক্ষণিক চিকিৎসক মূল্যায়ন এবং হাসপাতাল প্রাঙ্গণে ফার্মেসী ও প্যাথলজি ল্যাবের সুবিধা।\", \"en\": \"Round-the-clock emergency department access with ambulance service, immediate physician assessment and access to our on-site pharmacy and pathology lab.\"}', '[{\"bn\": \"২৪/৭ এম্বুলেন্স পিকআপ\", \"en\": \"24/7 Ambulance Pickup\"}, {\"bn\": \"তাৎক্ষণিক চিকিৎসক মূল্যায়ন\", \"en\": \"Immediate Physician Assessment\"}, {\"bn\": \"হাসপাতাল প্রাঙ্গণে ফার্মেসী ও ল্যাব\", \"en\": \"On-site Pharmacy & Lab\"}]', NULL, '24/7', '{\"bn\": \"সবসময় খোলা\", \"en\": \"Always Open\"}', 1, 4, 1, '{\"bn\": null}', '{\"bn\": null}', 'emergency, ambulance, care, package', NULL, '2026-07-27 15:11:09', '2026-07-27 17:26:43');

--
-- Table: `pages`
--
DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `title` json NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `breadcrumb_title` json DEFAULT NULL,
  `hero_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `seo_title` json DEFAULT NULL,
  `seo_description` json DEFAULT NULL,
  `seo_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_og_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pages_parent_id_slug_unique` (`parent_id`,`slug`),
  CONSTRAINT `pages_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `pages` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `pages` (`id`, `parent_id`, `title`, `slug`, `breadcrumb_title`, `hero_image`, `content`, `is_active`, `sort_order`, `seo_title`, `seo_description`, `seo_keywords`, `seo_og_image`, `created_at`, `updated_at`) VALUES
(1, NULL, '{\"bn\": \"গোপনীয়তা নীতি\", \"en\": \"Privacy Policy\"}', 'privacy-policy', '{\"bn\": \"গোপনীয়তা নীতি\", \"en\": \"Privacy Policy\"}', NULL, '{\"bn\": \"<p>সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ আপনার গোপনীয়তাকে সম্মান করে। আপনার সাথে শেয়ার করা যেকোনো ব্যক্তিগত বা চিকিৎসা সংক্রান্ত তথ্য — যেমন অ্যাপয়েন্টমেন্টের বিবরণ, যোগাযোগের তথ্য ও চিকিৎসার রেকর্ড — সম্পূর্ণ গোপনীয় রাখা হয় এবং শুধুমাত্র আপনাকে মানসম্পন্ন স্বাস্থ্যসেবা প্রদানের জন্য ব্যবহার করা হয়।</p><p>আইনগত প্রয়োজন বা আপনার সরাসরি অনুমতি ব্যতীত আমরা আপনার ব্যক্তিগত তথ্য কোনো তৃতীয় পক্ষের সাথে বিক্রি বা শেয়ার করি না। আপনার তথ্য কীভাবে ব্যবহৃত হয় সে সম্পর্কে কোনো প্রশ্ন থাকলে sitakundmodernhospital@gmail.com এ যোগাযোগ করুন।</p>\", \"en\": \"<p>Sitakund Modern Hospital Ltd. respects your privacy. Any personal or medical information you share with us — including appointment details, contact information and treatment records — is kept strictly confidential and used only to provide you with quality healthcare services.</p><p>We do not sell or share your personal information with third parties, except where required by law or with your explicit consent. If you have questions about how your information is handled, please contact us at sitakundmodernhospital@gmail.com.</p>\"}', 1, 1, '{\"bn\": \"গোপনীয়তা নীতি — সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ\", \"en\": \"Privacy Policy — Sitakund Modern Hospital Ltd.\"}', '{\"bn\": \"আপনার ব্যক্তিগত ও চিকিৎসা তথ্য কীভাবে ব্যবহৃত হয় তা জানতে সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ এর গোপনীয়তা নীতি পড়ুন।\", \"en\": \"Read the privacy policy of Sitakund Modern Hospital Ltd. to understand how we handle your personal and medical information.\"}', NULL, NULL, '2026-07-18 09:26:19', '2026-07-27 15:11:09'),
(2, NULL, '{\"bn\": \"শর্তাবলী\", \"en\": \"Terms & Conditions\"}', 'terms-conditions', '{\"bn\": \"শর্তাবলী\", \"en\": \"Terms & Conditions\"}', NULL, '{\"bn\": \"<p>সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ এর সেবা, ওয়েবসাইট, অ্যাপয়েন্টমেন্ট বুকিং ও চিকিৎসা সেবা ব্যবহার করার মাধ্যমে আপনি নিম্নলিখিত শর্তাবলীতে সম্মত হচ্ছেন।</p><p>অ্যাপয়েন্টমেন্ট ডাক্তারের সময়সূচীর উপর নির্ভরশীল এবং জরুরী প্রয়োজনে পুনঃনির্ধারিত হতে পারে। এই ওয়েবসাইটে উল্লেখিত শেয়ার হোল্ডার সুবিধা, ছাড় ও অফার সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ এর অভ্যন্তরীণ নীতির উপর নির্ভরশীল এবং পূর্ব ঘোষণা ছাড়াই পরিবর্তিত হতে পারে। সকল চিকিৎসা পরামর্শ আমাদের যোগ্য ডাক্তারদের ব্যক্তিগত রোগী মূল্যায়নের ভিত্তিতে প্রদান করা হয়।</p>\", \"en\": \"<p>By using the services of Sitakund Modern Hospital Ltd., including our website, appointment booking and treatment services, you agree to the following terms.</p><p>Appointments are subject to doctor availability and may be rescheduled in case of emergencies. Shareholder benefits, discounts and offers described on this website are subject to the internal policy of Sitakund Modern Hospital Ltd. and may change without prior notice. All medical advice is provided at the discretion of our qualified doctors based on individual patient assessment.</p>\"}', 1, 2, '{\"bn\": \"শর্তাবলী — সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ\", \"en\": \"Terms & Conditions — Sitakund Modern Hospital Ltd.\"}', '{\"bn\": \"সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ এর সেবা ও ওয়েবসাইট ব্যবহারের শর্তাবলী পড়ুন।\", \"en\": \"Read the terms and conditions for using the services and website of Sitakund Modern Hospital Ltd.\"}', NULL, NULL, '2026-07-18 09:26:19', '2026-07-27 15:12:48');

--
-- Table: `password_reset_tokens`
--
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Table: `patients`
--
DROP TABLE IF EXISTS `patients`;
CREATE TABLE `patients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('male','female','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `patients_phone_index` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Table: `personal_access_tokens`
--
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Table: `role_permissions`
--
DROP TABLE IF EXISTS `role_permissions`;
CREATE TABLE `role_permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint(20) unsigned NOT NULL,
  `module_key` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `can_view` tinyint(1) NOT NULL DEFAULT '0',
  `can_create` tinyint(1) NOT NULL DEFAULT '0',
  `can_edit` tinyint(1) NOT NULL DEFAULT '0',
  `can_delete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_permissions_role_id_module_key_unique` (`role_id`,`module_key`),
  CONSTRAINT `role_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `role_permissions` (`id`, `role_id`, `module_key`, `can_view`, `can_create`, `can_edit`, `can_delete`, `created_at`, `updated_at`) VALUES
(1, 1, 'dashboard', 0, 0, 0, 0, '2026-07-15 15:03:31', '2026-07-15 15:03:31'),
(2, 1, 'inquiries', 0, 0, 0, 0, '2026-07-15 15:03:31', '2026-07-15 15:03:31'),
(3, 1, 'website-management', 0, 0, 0, 0, '2026-07-15 15:03:31', '2026-07-15 15:03:31'),
(4, 1, 'global-settings', 0, 0, 0, 0, '2026-07-15 15:03:31', '2026-07-15 15:03:31'),
(5, 1, 'email-smtp-setting', 0, 0, 0, 0, '2026-07-15 15:03:31', '2026-07-15 15:03:31'),
(6, 1, 'user-management', 0, 0, 0, 0, '2026-07-15 15:03:31', '2026-07-15 15:03:31'),
(7, 1, 'backups', 0, 0, 0, 0, '2026-07-15 15:03:31', '2026-07-15 15:03:31'),
(8, 2, 'dashboard', 1, 0, 0, 0, '2026-07-27 16:16:57', '2026-07-27 16:16:57'),
(9, 2, 'doctor-dashboard', 1, 0, 1, 0, '2026-07-27 16:16:57', '2026-07-27 16:16:57'),
(10, 3, 'dashboard', 1, 0, 0, 0, '2026-07-27 16:16:57', '2026-07-27 16:16:57'),
(11, 3, 'operator-dashboard', 1, 1, 1, 0, '2026-07-27 16:16:57', '2026-07-27 16:16:57'),
(12, 3, 'appointments', 1, 1, 1, 0, '2026-07-27 16:16:57', '2026-07-27 16:16:57');

--
-- Table: `roles`
--
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_super_admin` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `roles` (`id`, `name`, `slug`, `description`, `is_super_admin`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'super-admin', NULL, 1, 1, '2026-07-15 15:03:31', '2026-07-15 15:03:31'),
(2, 'Doctor', 'doctor', 'Access to their own appointment schedule and patient queue.', 0, 1, '2026-07-27 16:16:57', '2026-07-27 16:16:57'),
(3, 'Operator', 'operator', 'Books appointments on behalf of patients and manages the daily queue.', 0, 1, '2026-07-27 16:16:57', '2026-07-27 16:16:57');

--
-- Table: `services`
--
DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` json NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon_svg` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_desc` json DEFAULT NULL,
  `description` json DEFAULT NULL,
  `features` json DEFAULT NULL,
  `faqs` json DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `seo_title` json DEFAULT NULL,
  `seo_description` json DEFAULT NULL,
  `seo_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_og_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `services_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `services` (`id`, `title`, `slug`, `icon_svg`, `image`, `short_desc`, `description`, `features`, `faqs`, `is_featured`, `sort_order`, `is_active`, `seo_title`, `seo_description`, `seo_keywords`, `seo_og_image`, `created_at`, `updated_at`) VALUES
(1, '{\"bn\": \"জরুরী বিভাগ\", \"en\": \"Emergency Department\"}', 'emergency-department', NULL, NULL, '{\"bn\": \"জরুরী বিভাগ ২৪ ঘন্টা খোলা থাকে জরুরী রোগীদের সেবা দেওয়ার জন্য।\", \"en\": \"Emergency department open 24 hours a day for immediate patient care.\"}', '{\"bn\": \"জরুরী বিভাগ ২৪ ঘন্টা খোলা থাকে জরুরী রোগীদের সেবা দেওয়ার জন্য।\", \"en\": \"Emergency department open 24 hours a day for immediate patient care.\"}', NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(2, '{\"bn\": \"ফার্মেসী\", \"en\": \"Pharmacy\"}', 'pharmacy', NULL, NULL, '{\"bn\": \"ফার্মেসী ২৪ ঘন্টা খোলা থাকে, সকল প্রকার ন্যায্য মূল্যে ঔষধ ও ভ্যাকসিন পাওয়া যায়।\", \"en\": \"Pharmacy open 24 hours, stocking all types of genuine medicines and vaccines.\"}', '{\"bn\": \"ফার্মেসী ২৪ ঘন্টা খোলা থাকে, সকল প্রকার ন্যায্য মূল্যে ঔষধ ও ভ্যাকসিন পাওয়া যায়।\", \"en\": \"Pharmacy open 24 hours, stocking all types of genuine medicines and vaccines.\"}', NULL, NULL, 1, 2, 1, NULL, NULL, NULL, NULL, '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(3, '{\"bn\": \"এম্বুলেন্স সার্ভিস\", \"en\": \"Ambulance Service\"}', 'ambulance-service', NULL, NULL, '{\"bn\": \"২৪ ঘন্টা এম্বুলেন্স সার্ভিস চালু রয়েছে।\", \"en\": \"24-hour ambulance service for patient transport.\"}', '{\"bn\": \"২৪ ঘন্টা এম্বুলেন্স সার্ভিস চালু রয়েছে।\", \"en\": \"24-hour ambulance service for patient transport.\"}', NULL, NULL, 1, 3, 1, NULL, NULL, NULL, NULL, '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(4, '{\"bn\": \"বিশেষজ্ঞ ডাক্তার চেম্বার\", \"en\": \"Specialist Doctor Chamber\"}', 'specialist-doctor-chamber', NULL, NULL, '{\"bn\": \"প্রতিদিন বিশেষজ্ঞ ডাক্তার চেম্বারে রোগী দেখা হয়।\", \"en\": \"Daily chamber with specialist doctors for consultation.\"}', '{\"bn\": \"প্রতিদিন বিশেষজ্ঞ ডাক্তার চেম্বারে রোগী দেখা হয়।\", \"en\": \"Daily chamber with specialist doctors for consultation.\"}', NULL, NULL, 1, 4, 1, NULL, NULL, NULL, NULL, '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(5, '{\"bn\": \"ডিজিটাল ৪-ডি কালার আল্ট্রাসোনোগ্রাফী\", \"en\": \"Digital 4-D Color Ultrasonography\"}', 'digital-4-d-color-ultrasonography', NULL, NULL, '{\"bn\": \"ডিজিটাল ৪-ডি কালার আল্ট্রাসোনোগ্রাফীর মাধ্যমে নির্ভুল পরীক্ষা করা হয়।\", \"en\": \"Advanced digital 4-D color ultrasonography for accurate diagnosis.\"}', '{\"bn\": \"ডিজিটাল ৪-ডি কালার আল্ট্রাসোনোগ্রাফীর মাধ্যমে নির্ভুল পরীক্ষা করা হয়।\", \"en\": \"Advanced digital 4-D color ultrasonography for accurate diagnosis.\"}', NULL, NULL, 1, 5, 1, NULL, NULL, NULL, NULL, '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(6, '{\"bn\": \"ইকোকার্ডিওগ্রাফী\", \"en\": \"Echocardiography\"}', 'echocardiography', NULL, NULL, '{\"bn\": \"হৃদরোগ নির্ণয়ে ইকোকার্ডিওগ্রাফী পরীক্ষার সুবিধা রয়েছে।\", \"en\": \"Echocardiography (ECHO) test for heart diagnosis.\"}', '{\"bn\": \"হৃদরোগ নির্ণয়ে ইকোকার্ডিওগ্রাফী পরীক্ষার সুবিধা রয়েছে।\", \"en\": \"Echocardiography (ECHO) test for heart diagnosis.\"}', NULL, NULL, 1, 6, 1, NULL, NULL, NULL, NULL, '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(7, '{\"bn\": \"প্যাথলজি\", \"en\": \"Pathology\"}', 'pathology', NULL, NULL, '{\"bn\": \"সকল প্রকার পরীক্ষার জন্য সুসজ্জিত প্যাথলজি ল্যাব রয়েছে।\", \"en\": \"Fully equipped pathology laboratory for all types of tests.\"}', '{\"bn\": \"সকল প্রকার পরীক্ষার জন্য সুসজ্জিত প্যাথলজি ল্যাব রয়েছে।\", \"en\": \"Fully equipped pathology laboratory for all types of tests.\"}', NULL, NULL, 0, 7, 1, NULL, NULL, NULL, NULL, '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(8, '{\"bn\": \"ডিজিটাল এক্স-রে\", \"en\": \"Digital X-Ray\"}', 'digital-x-ray', NULL, NULL, '{\"bn\": \"ডিজিটাল এক্স-রে সেবা ২৪ ঘন্টা খোলা থাকে।\", \"en\": \"Digital X-Ray service open 24 hours.\"}', '{\"bn\": \"ডিজিটাল এক্স-রে সেবা ২৪ ঘন্টা খোলা থাকে।\", \"en\": \"Digital X-Ray service open 24 hours.\"}', NULL, NULL, 0, 8, 1, NULL, NULL, NULL, NULL, '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(9, '{\"bn\": \"ই.সি.জি\", \"en\": \"ECG\"}', 'ecg', NULL, NULL, '{\"bn\": \"ই.সি.জি সেবা ২৪ ঘন্টা খোলা থাকে।\", \"en\": \"ECG (Electrocardiogram) service open 24 hours.\"}', '{\"bn\": \"ই.সি.জি সেবা ২৪ ঘন্টা খোলা থাকে।\", \"en\": \"ECG (Electrocardiogram) service open 24 hours.\"}', NULL, NULL, 0, 9, 1, NULL, NULL, NULL, NULL, '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(10, '{\"bn\": \"নেবুলাইজেশন\", \"en\": \"Nebulization\"}', 'nebulization', NULL, NULL, '{\"bn\": \"শ্বাসকষ্টের রোগীদের জন্য নেবুলাইজেশন সেবা।\", \"en\": \"Nebulization treatment for respiratory patients.\"}', '{\"bn\": \"শ্বাসকষ্টের রোগীদের জন্য নেবুলাইজেশন সেবা।\", \"en\": \"Nebulization treatment for respiratory patients.\"}', NULL, NULL, 0, 10, 1, NULL, NULL, NULL, NULL, '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(11, '{\"bn\": \"ইনকিউবেটর\", \"en\": \"Incubator\"}', 'incubator', NULL, NULL, '{\"bn\": \"নবজাতকের যত্নের জন্য ইনকিউবেটর সুবিধা।\", \"en\": \"Incubator facility for newborn care.\"}', '{\"bn\": \"নবজাতকের যত্নের জন্য ইনকিউবেটর সুবিধা।\", \"en\": \"Incubator facility for newborn care.\"}', NULL, NULL, 0, 11, 1, NULL, NULL, NULL, NULL, '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(12, '{\"bn\": \"বায়োকেমিস্ট্রি (অটো অ্যানালাইজার)\", \"en\": \"Biochemistry (Auto Analyzer)\"}', 'biochemistry-auto-analyzer', NULL, NULL, '{\"bn\": \"অটো অ্যানালাইজারের মাধ্যমে দ্রুত ও নির্ভুল বায়োকেমিস্ট্রি পরীক্ষা।\", \"en\": \"Automated biochemistry analysis for fast, accurate lab results.\"}', '{\"bn\": \"অটো অ্যানালাইজারের মাধ্যমে দ্রুত ও নির্ভুল বায়োকেমিস্ট্রি পরীক্ষা।\", \"en\": \"Automated biochemistry analysis for fast, accurate lab results.\"}', NULL, NULL, 0, 12, 1, NULL, NULL, NULL, NULL, '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(13, '{\"bn\": \"মাইক্রোবায়োলজী\", \"en\": \"Microbiology\"}', 'microbiology', NULL, NULL, '{\"bn\": \"মাইক্রোবায়োলজী পরীক্ষার সুবিধা রয়েছে।\", \"en\": \"Microbiology testing services.\"}', '{\"bn\": \"মাইক্রোবায়োলজী পরীক্ষার সুবিধা রয়েছে।\", \"en\": \"Microbiology testing services.\"}', NULL, NULL, 0, 13, 1, NULL, NULL, NULL, NULL, '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(14, '{\"bn\": \"সেরোলজী\", \"en\": \"Serology\"}', 'serology', NULL, NULL, '{\"bn\": \"সেরোলজী পরীক্ষার সুবিধা রয়েছে।\", \"en\": \"Serology testing services.\"}', '{\"bn\": \"সেরোলজী পরীক্ষার সুবিধা রয়েছে।\", \"en\": \"Serology testing services.\"}', NULL, NULL, 0, 14, 1, NULL, NULL, NULL, NULL, '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(15, '{\"bn\": \"ডায়াবেটিক সেন্টার\", \"en\": \"Diabetic Center\"}', 'diabetic-center', NULL, NULL, '{\"bn\": \"ডায়াবেটিস নির্ণয় ও ব্যবস্থাপনার জন্য আলাদা ডায়াবেটিক সেন্টার।\", \"en\": \"Dedicated diabetic center for diagnosis and management of diabetes.\"}', '{\"bn\": \"ডায়াবেটিস নির্ণয় ও ব্যবস্থাপনার জন্য আলাদা ডায়াবেটিক সেন্টার।\", \"en\": \"Dedicated diabetic center for diagnosis and management of diabetes.\"}', NULL, NULL, 0, 15, 1, NULL, NULL, NULL, NULL, '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(16, '{\"bn\": \"সিজারিয়ানসহ মহিলাদের অপারেশন\", \"en\": \"Women\'s Operations & Caesarean\"}', 'womens-operations-caesarean', NULL, NULL, '{\"bn\": \"সিজারিয়ান সহ মহিলাদের যাবতীয় অপারেশন করা হয়।\", \"en\": \"Caesarean section and all types of operations for women.\"}', '{\"bn\": \"সিজারিয়ান সহ মহিলাদের যাবতীয় অপারেশন করা হয়।\", \"en\": \"Caesarean section and all types of operations for women.\"}', NULL, NULL, 0, 16, 1, NULL, NULL, NULL, NULL, '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(17, '{\"bn\": \"জেনারেল সার্জারী\", \"en\": \"General Surgery\"}', 'general-surgery', NULL, NULL, '{\"bn\": \"জেনারেল সার্জারীর যাবতীয় অপারেশন করা হয়।\", \"en\": \"All types of general surgery operations.\"}', '{\"bn\": \"জেনারেল সার্জারীর যাবতীয় অপারেশন করা হয়।\", \"en\": \"All types of general surgery operations.\"}', NULL, NULL, 0, 17, 1, NULL, NULL, NULL, NULL, '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(18, '{\"bn\": \"নাক, কান ও গলা রোগীদের অপারেশন\", \"en\": \"ENT (Nose, Ear & Throat) Operations\"}', 'ent-nose-ear-throat-operations', NULL, NULL, '{\"bn\": \"নাক, কান ও গলা রোগীদের অপারেশন করা হয়।\", \"en\": \"Operations for nose, ear and throat patients.\"}', '{\"bn\": \"নাক, কান ও গলা রোগীদের অপারেশন করা হয়।\", \"en\": \"Operations for nose, ear and throat patients.\"}', NULL, NULL, 0, 18, 1, NULL, NULL, NULL, NULL, '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(19, '{\"bn\": \"টিকাদান\", \"en\": \"Vaccination\"}', 'vaccination', NULL, NULL, '{\"bn\": \"অভিজ্ঞ ডাক্তার দ্বারা টিকাদান করা হয়।\", \"en\": \"Vaccination administered by experienced doctors.\"}', '{\"bn\": \"অভিজ্ঞ ডাক্তার দ্বারা টিকাদান করা হয়।\", \"en\": \"Vaccination administered by experienced doctors.\"}', NULL, NULL, 0, 19, 1, NULL, NULL, NULL, NULL, '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(20, '{\"bn\": \"ফটোথেরাপি\", \"en\": \"Phototherapy\"}', 'phototherapy', NULL, NULL, '{\"bn\": \"নবজাতকদের জন্য ফটোথেরাপি সেবা।\", \"en\": \"Phototherapy treatment for newborns with jaundice.\"}', '{\"bn\": \"নবজাতকদের জন্য ফটোথেরাপি সেবা।\", \"en\": \"Phototherapy treatment for newborns with jaundice.\"}', NULL, NULL, 0, 20, 1, NULL, NULL, NULL, NULL, '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(21, '{\"bn\": \"ফিজিওথেরাপী\", \"en\": \"Physiotherapy\"}', 'physiotherapy', NULL, NULL, '{\"bn\": \"ফিজিওথেরাপী সেবা প্রদান করা হয়।\", \"en\": \"Physiotherapy services for rehabilitation and pain management.\"}', '{\"bn\": \"ফিজিওথেরাপী সেবা প্রদান করা হয়।\", \"en\": \"Physiotherapy services for rehabilitation and pain management.\"}', NULL, NULL, 0, 21, 1, NULL, NULL, NULL, NULL, '2026-07-27 14:42:55', '2026-07-27 14:42:55'),
(22, '{\"bn\": \"হরমোন পরীক্ষা\", \"en\": \"Hormone Test\"}', 'hormone-test', NULL, NULL, '{\"bn\": \"হরমোন পরীক্ষার সুবিধা রয়েছে।\", \"en\": \"Hormone testing services.\"}', '{\"bn\": \"হরমোন পরীক্ষার সুবিধা রয়েছে।\", \"en\": \"Hormone testing services.\"}', NULL, NULL, 0, 22, 1, NULL, NULL, NULL, NULL, '2026-07-27 14:42:55', '2026-07-27 14:42:55');

--
-- Table: `sliders`
--
DROP TABLE IF EXISTS `sliders`;
CREATE TABLE `sliders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `label` json DEFAULT NULL,
  `title` json NOT NULL,
  `subtitle` json DEFAULT NULL,
  `description` json DEFAULT NULL,
  `button_text` json NOT NULL,
  `button_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#',
  `background_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `star_label` json DEFAULT NULL,
  `star_rating` tinyint(3) unsigned NOT NULL DEFAULT '5',
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sliders` (`id`, `label`, `title`, `subtitle`, `description`, `button_text`, `button_url`, `background_image`, `star_label`, `star_rating`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '{\"bn\": \"সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ\", \"en\": \"Sitakund Modern Hospital Ltd.\"}', '{\"bn\": \"মানব জীবন মানবিক হউক\", \"en\": \"Human Life, Humane Care\"}', '{\"bn\": \"২০১৩ সাল থেকে বিশ্বস্ত স্বাস্থ্যসেবা\", \"en\": \"Trusted Healthcare Since 2013\"}', '{\"bn\": \"২৪ ঘন্টা জরুরী বিভাগ, ফার্মেসী, এম্বুলেন্স ও বিশেষজ্ঞ ডাক্তারের সেবা নিয়ে সীতাকুণ্ডবাসীর পাশে একটি আধুনিক হাসপাতাল ও ডায়াগনস্টিক সেন্টার।\", \"en\": \"A modern hospital and diagnostic center serving Sitakund with 24-hour emergency, pharmacy, ambulance and specialist doctor services.\"}', '{\"bn\": \"অ্যাপয়েন্টমেন্ট নিন\", \"en\": \"Book Appointment\"}', '/appointment', 'sliders/0c4YuswLHEp3CyetCZ0tizBLvje4irsle5nciiU7.jpg', '{\"bn\": \"রোগীদের আস্থার প্রতিষ্ঠান\", \"en\": \"Trusted by our patients\"}', 5, 1, 1, '2026-07-27 15:11:08', '2026-07-28 04:44:06'),
(2, '{\"bn\": \"জরুরী সেবা\", \"en\": \"Emergency Care\"}', '{\"bn\": \"জরুরী বিভাগ ও এম্বুলেন্স, ২৪ ঘন্টা\", \"en\": \"Emergency & Ambulance, 24 Hours\"}', '{\"bn\": \"আমরা সবসময় আপনার পাশে\", \"en\": \"We Are Always Here For You\"}', '{\"bn\": \"জরুরী বিভাগ, ফার্মেসী ও এম্বুলেন্স সার্ভিস সারা বছর ২৪ ঘন্টা খোলা থাকে।\", \"en\": \"Emergency department, pharmacy and ambulance service open around the clock, every day of the year.\"}', '{\"bn\": \"যোগাযোগ করুন\", \"en\": \"Contact Us\"}', '/contact', 'sliders/P7eYtfI45pg3FAfJoLNbRKOTx1HDE83W3CoFx8vf.jpg', '{\"bn\": \"১২+ বছরের সেবা\", \"en\": \"12+ Years of Service\"}', 5, 2, 1, '2026-07-27 15:11:08', '2026-07-28 04:44:25'),
(3, '{\"bn\": \"ডায়াগনস্টিক সেন্টার\", \"en\": \"Diagnostic Center\"}', '{\"bn\": \"আধুনিক ডায়াগনস্টিক সুবিধা\", \"en\": \"Modern Diagnostic Facilities\"}', '{\"bn\": \"ডিজিটাল ৪-ডি আল্ট্রাসোনোগ্রাফী, ইকো, এক্স-রে সহ আরও অনেক কিছু\", \"en\": \"Digital 4-D Ultrasonography, ECHO, X-Ray & More\"}', '{\"bn\": \"ডিজিটাল ৪-ডি কালার আল্ট্রাসোনোগ্রাফী, ইকো, প্যাথলজি, ২৪ ঘন্টা ডিজিটাল এক্স-রে ও ই.সি.জি এর মাধ্যমে নির্ভুল পরীক্ষা।\", \"en\": \"Accurate diagnosis with digital 4-D color ultrasonography, ECHO, pathology, 24-hour digital X-ray and ECG.\"}', '{\"bn\": \"আমাদের সেবাসমূহ\", \"en\": \"Our Services\"}', '/services', 'sliders/urdWul8l1CNfM3CU2zQh5uDD1lwDuj2lhPEXmtmM.jpg', '{\"bn\": \"নির্ভরযোগ্য মান\", \"en\": \"Quality You Can Trust\"}', 5, 3, 1, '2026-07-27 15:11:08', '2026-07-28 04:44:36');

--
-- Table: `testimonials`
--
DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE `testimonials` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `review` json NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` json DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` decimal(2,1) NOT NULL DEFAULT '5.0',
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `testimonials` (`id`, `review`, `name`, `role`, `avatar`, `rating`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '{\"bn\": \"আমি সীতাকুণ্ড মডার্ণ হসপিটালে আমার ডেলিভারী করিয়েছি এবং ডাক্তার ও নার্সদের সেবা ছিল অসাধারণ। তারা সবকিছু পরিষ্কারভাবে বুঝিয়ে দিয়েছেন এবং আমাকে নিরাপদ বোধ করিয়েছেন।\", \"en\": \"I had my delivery at Sitakund Modern Hospital and the care from the doctors and nurses was excellent. They explained everything clearly and made me feel safe throughout.\"}', 'Rahima Begum', '{\"bn\": \"রোগী\", \"en\": \"Patient\"}', NULL, '5.0', 1, 1, '2026-07-27 15:11:09', '2026-07-27 15:11:09'),
(2, '{\"bn\": \"২৪ ঘন্টা জরুরী বিভাগ ও এম্বুলেন্স সার্ভিস আমার বাবার জরুরী মুহূর্তে অনেক সময় বাঁচিয়েছে। স্টাফরা দ্রুত, পেশাদার ও যত্নশীল ছিলেন।\", \"en\": \"The 24-hour emergency and ambulance service saved precious time when my father needed urgent care. The staff were quick, professional and caring.\"}', 'Md. Kamal Uddin', '{\"bn\": \"রোগী\", \"en\": \"Patient\"}', NULL, '5.0', 2, 1, '2026-07-27 15:11:09', '2026-07-27 15:11:09'),
(3, '{\"bn\": \"ডিজিটাল আল্ট্রাসোনোগ্রাফী ও প্যাথলজি রিপোর্ট নির্ভুল ও দ্রুত পেয়েছি। পরীক্ষার জন্য আর চট্টগ্রাম শহরে যেতে হয়নি।\", \"en\": \"The digital ultrasonography and pathology reports were accurate and quick. I did not need to travel all the way to Chattogram city for tests anymore.\"}', 'Sultana Akter', '{\"bn\": \"রোগী\", \"en\": \"Patient\"}', NULL, '5.0', 3, 1, '2026-07-27 15:11:09', '2026-07-27 15:11:09'),
(4, '{\"bn\": \"সাশ্রয়ী চিকিৎসা, ওষুধে ১০% ডিসকাউন্ট এবং বন্ধুত্বপূর্ণ ফার্মেসী স্টাফ। বাড়ির কাছেই এমন একটি প্রতিষ্ঠান পেয়ে কৃতজ্ঞ।\", \"en\": \"Affordable treatment with a 10% discount on medicines and a friendly pharmacy staff. Grateful to have such a facility close to home.\"}', 'Abdul Karim', '{\"bn\": \"রোগী\", \"en\": \"Patient\"}', NULL, '4.0', 4, 1, '2026-07-27 15:11:09', '2026-07-27 15:11:09');

--
-- Table: `users`
--
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` bigint(20) unsigned DEFAULT NULL,
  `doctor_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_foreign` (`role_id`),
  KEY `users_doctor_id_foreign` (`doctor_id`),
  CONSTRAINT `users_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE SET NULL,
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `is_active`, `created_at`, `updated_at`, `role_id`, `doctor_id`) VALUES
(1, 'Admin', 'admin@admin.com', NULL, '$2y$12$M15.BQqCdMne/l86QtzT4u6uaazbqT7ztObRST2rj15yeMcw7LEWS', NULL, 1, '2026-07-15 15:03:03', '2026-07-27 16:16:57', 1, NULL);

SET FOREIGN_KEY_CHECKS=1;
