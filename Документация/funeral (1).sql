-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 21 2024 г., 17:20
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `funeral`
--

-- --------------------------------------------------------

--
-- Структура таблицы `carts`
--

CREATE TABLE `carts` (
  `id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `carts`
--

INSERT INTO `carts` (`id`, `quantity`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 1, 6, 3, NULL, NULL),
(2, 1, 6, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Кресты', '2024-04-20 18:59:42', '2024-04-20 18:59:42'),
(2, 'Гробы', '2024-04-20 18:59:42', '2024-04-20 18:59:42'),
(3, 'Организация похорон', '2024-04-20 18:59:42', '2024-04-20 18:59:42'),
(4, 'Цветы и венки', '2024-04-20 18:59:42', '2024-04-20 18:59:42'),
(5, 'Ритуальные услуги', '2024-04-20 18:59:42', '2024-04-20 18:59:42');

-- --------------------------------------------------------

--
-- Структура таблицы `compounds`
--

CREATE TABLE `compounds` (
  `id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `total_price` decimal(15,2) NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `compounds`
--

INSERT INTO `compounds` (`id`, `quantity`, `total_price`, `order_id`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 1, '555.00', 1, 1, NULL, NULL),
(2, 2, '222.00', 1, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2024_04_20_105201_create_roles_table', 1),
(3, '2024_04_20_105202_create_shifts_table', 1),
(4, '2024_04_20_105203_create_users_table', 1),
(5, '2024_04_20_105204_create_categories_table', 1),
(6, '2024_04_20_105205_create_products_table', 1),
(7, '2024_04_20_105206_create_photo_products_table', 1),
(8, '2024_04_20_105207_create_carts_table', 1),
(9, '2024_04_20_105208_create_payments_table', 1),
(10, '2024_04_20_105209_create_status_orders_table', 1),
(11, '2024_04_20_105210_create_orders_table', 1),
(12, '2024_04_20_105211_create_compounds_table', 1),
(13, '2024_04_20_105212_create_reviews_table', 1),
(14, '2024_04_20_105213_create_news_table', 1),
(15, '2024_04_20_105214_create_photo_news_table', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `id` bigint UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `long_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`id`, `date`, `name`, `short_description`, `long_description`, `created_at`, `updated_at`) VALUES
(1, '2024-04-21 10:00:00', 'Новый сервис по оформлению похоронных услуг', 'Представляем вам новый сервис для удобного заказа похоронных услуг.', 'Дорогие клиенты, мы рады представить вам новый сервис по оформлению похоронных услуг. Теперь вы можете заказать все необходимое онлайн, не выходя из дома. Мы сделаем все возможное, чтобы облегчить вам это трудное время. Для подробной информации обращайтесь к нам.', '2024-04-20 18:59:42', '2024-04-20 18:59:42'),
(2, '2024-04-20 15:30:00', 'Расширение ассортимента венков', 'Новые венки из свежих цветов уже доступны в нашем ассортименте.', 'Мы рады сообщить вам, что мы расширили ассортимент венков. Теперь вы можете выбрать из большего разнообразия цветов и стилей. У нас всегда есть подходящий венок для вашего покойного. Посмотрите наши новые образцы в каталоге.', '2024-04-20 18:59:42', '2024-04-20 18:59:42'),
(3, '2024-04-19 12:00:00', 'Скидка 10% на все гробы до конца месяца', 'Не упустите возможность сэкономить на гробе для вашего близкого.', 'У нас для вас отличная новость! Мы предлагаем скидку 10% на все гробы до конца текущего месяца. Это отличная возможность сэкономить, не теряя в качестве. Поторопитесь сделать заказ!', '2024-04-20 18:59:42', '2024-04-20 18:59:42'),
(4, '2024-04-18 09:00:00', 'Открытие нового филиала', 'Новый филиал нашего бюро появился в вашем районе.', 'Мы рады сообщить вам об открытии нового филиала нашего бюро в вашем районе. Теперь вы можете получить все необходимые услуги ближе к дому. Приходите к нам и узнайте больше о наших услугах.', '2024-04-20 18:59:42', '2024-04-20 18:59:42'),
(5, '2024-04-17 14:00:00', 'Семинар по организации похоронных церемоний', 'Приглашаем вас на наш бесплатный семинар.', 'Мы приглашаем всех заинтересованных на наш бесплатный семинар по организации похоронных церемоний. На семинаре вы узнаете много полезной информации о процессе организации и планирования похоронных мероприятий. Приходите и получите ответы на все ваши вопросы.', '2024-04-20 18:59:42', '2024-04-20 18:59:42');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `date_order` datetime NOT NULL,
  `payment_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `employee_id` bigint UNSIGNED DEFAULT NULL,
  `status_order_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `date_order`, `payment_id`, `user_id`, `employee_id`, `status_order_id`, `created_at`, `updated_at`) VALUES
(1, '2024-04-21 17:19:03', 2, 6, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `payments`
--

INSERT INTO `payments` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Наличные', '2024-04-20 18:59:42', '2024-04-20 18:59:42'),
(2, 'Кредитная карта', '2024-04-20 18:59:42', '2024-04-20 18:59:42'),
(3, 'Банковский перевод', '2024-04-20 18:59:42', '2024-04-20 18:59:42'),
(4, 'Электронные деньги', '2024-04-20 18:59:42', '2024-04-20 18:59:42'),
(5, 'Чек', '2024-04-20 18:59:42', '2024-04-20 18:59:42');

-- --------------------------------------------------------

--
-- Структура таблицы `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `photo_news`
--

CREATE TABLE `photo_news` (
  `id` bigint UNSIGNED NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `news_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `photo_news`
--

INSERT INTO `photo_news` (`id`, `path`, `news_id`, `created_at`, `updated_at`) VALUES
(1, 'news1.jpg', 1, '2024-04-20 18:59:42', '2024-04-20 18:59:42'),
(2, 'news2.jpg', 2, '2024-04-20 18:59:42', '2024-04-20 18:59:42'),
(3, 'news3.jpg', 3, '2024-04-20 18:59:42', '2024-04-20 18:59:42'),
(4, 'news4.jpg', 4, '2024-04-20 18:59:42', '2024-04-20 18:59:42'),
(5, 'news5.jpg', 5, '2024-04-20 18:59:42', '2024-04-20 18:59:42');

-- --------------------------------------------------------

--
-- Структура таблицы `photo_products`
--

CREATE TABLE `photo_products` (
  `id` bigint UNSIGNED NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `photo_products`
--

INSERT INTO `photo_products` (`id`, `path`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 'product1.jpg', 1, '2024-04-20 18:59:42', '2024-04-20 18:59:42'),
(2, 'product2.jpg', 2, '2024-04-20 18:59:42', '2024-04-20 18:59:42'),
(3, 'product3.jpg', 3, '2024-04-20 18:59:42', '2024-04-20 18:59:42'),
(4, 'product4.jpg', 4, '2024-04-20 18:59:42', '2024-04-20 18:59:42'),
(5, 'product5.jpg', 5, '2024-04-20 18:59:42', '2024-04-20 18:59:42');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(15,2) NOT NULL,
  `quantity` int NOT NULL DEFAULT '0',
  `category_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `quantity`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'Крест', 'Крест для установки на могилу.', '250.00', 0, 1, '2024-04-20 18:59:42', '2024-04-20 18:59:42'),
(2, 'Гроб', 'Деревянный гроб для захоронения.', '500.00', 0, 2, '2024-04-20 18:59:42', '2024-04-20 18:59:42'),
(3, 'Организация похорон', 'Услуги по организации похорон.', '100.00', 0, 3, '2024-04-20 18:59:42', '2024-04-20 18:59:42'),
(4, 'Венок', 'Венок из живых цветов.', '100.00', 0, 4, '2024-04-20 18:59:42', '2024-04-20 18:59:42'),
(5, 'Ритуальный агент', 'Помощь ритуального агента.', '50.00', 0, 5, '2024-04-20 18:59:42', '2024-04-20 18:59:42');

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `rating` int NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 'Пользователь', 'user', '2024-04-20 18:59:42', '2024-04-20 18:59:42'),
(2, 'Администратор', 'admin', '2024-04-20 18:59:42', '2024-04-20 18:59:42'),
(3, 'Менеджер', 'manager', '2024-04-20 18:59:42', '2024-04-20 18:59:42'),
(4, 'Оператор', 'operator', '2024-04-20 18:59:42', '2024-04-20 18:59:42');

-- --------------------------------------------------------

--
-- Структура таблицы `shifts`
--

CREATE TABLE `shifts` (
  `id` bigint UNSIGNED NOT NULL,
  `status` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_start` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `status_orders`
--

CREATE TABLE `status_orders` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `status_orders`
--

INSERT INTO `status_orders` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'В ожидании', NULL, NULL),
(2, 'В работе', NULL, NULL),
(3, 'Выполнен', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patronymic` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` bigint NOT NULL,
  `api_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `shift_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `patronymic`, `login`, `password`, `email`, `telephone`, `api_token`, `role_id`, `shift_id`, `created_at`, `updated_at`) VALUES
(6, 'Иван', 'Иванов', 'Иванович', 'ivan123', 'password123', 'ivan@example.com', 123456789, '1', 1, NULL, '2024-04-20 19:00:40', '2024-04-21 10:48:37'),
(7, 'Петр', 'Петров', 'Петрович', 'petr456', 'password456', 'petr@example.com', 987654321, NULL, 2, NULL, '2024-04-20 19:00:40', '2024-04-21 11:07:38'),
(8, 'Анна', 'Сидорова', 'Ивановна', 'anna789', 'password789', 'anna@example.com', 555666777, NULL, 3, NULL, '2024-04-20 19:00:40', '2024-04-20 19:00:40'),
(9, 'Мария', 'Павлова', 'Александровна', 'maria987', 'password987', 'maria@example.com', 111222333, NULL, 1, NULL, '2024-04-20 19:00:40', '2024-04-20 19:00:40'),
(10, 'Сергей', 'Сергеев', 'Сергеевич', 'sergey654', 'password654', 'sergey@example.com', 777888999, NULL, 2, NULL, '2024-04-20 19:00:40', '2024-04-20 19:00:40');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`),
  ADD KEY `carts_product_id_foreign` (`product_id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `compounds`
--
ALTER TABLE `compounds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compounds_order_id_foreign` (`order_id`),
  ADD KEY `compounds_product_id_foreign` (`product_id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_payment_id_foreign` (`payment_id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_employee_id_foreign` (`employee_id`),
  ADD KEY `orders_status_order_id_foreign` (`status_order_id`);

--
-- Индексы таблицы `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Индексы таблицы `photo_news`
--
ALTER TABLE `photo_news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `photo_news_news_id_foreign` (`news_id`);

--
-- Индексы таблицы `photo_products`
--
ALTER TABLE `photo_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `photo_products_path_unique` (`path`),
  ADD KEY `photo_products_product_id_foreign` (`product_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_code_unique` (`code`);

--
-- Индексы таблицы `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `status_orders`
--
ALTER TABLE `status_orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_login_unique` (`login`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_telephone_unique` (`telephone`),
  ADD KEY `users_role_id_foreign` (`role_id`),
  ADD KEY `users_shift_id_foreign` (`shift_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `compounds`
--
ALTER TABLE `compounds`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `photo_news`
--
ALTER TABLE `photo_news`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `photo_products`
--
ALTER TABLE `photo_products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `shifts`
--
ALTER TABLE `shifts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `status_orders`
--
ALTER TABLE `status_orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `compounds`
--
ALTER TABLE `compounds`
  ADD CONSTRAINT `compounds_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `compounds_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_status_order_id_foreign` FOREIGN KEY (`status_order_id`) REFERENCES `status_orders` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `photo_news`
--
ALTER TABLE `photo_news`
  ADD CONSTRAINT `photo_news_news_id_foreign` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `photo_products`
--
ALTER TABLE `photo_products`
  ADD CONSTRAINT `photo_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `users_shift_id_foreign` FOREIGN KEY (`shift_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
