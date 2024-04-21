<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Создание записей для таблицы payments
        DB::table('payments')->insert([
            ['name' => 'Наличные', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Кредитная карта', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Банковский перевод', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Электронные деньги', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Чек', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        // Создание записей для таблицы news
        DB::table('news')->insert([
            ['date' => '2024-04-21 10:00:00', 'name' => 'Новый сервис по оформлению похоронных услуг', 'short_description' => 'Представляем вам новый сервис для удобного заказа похоронных услуг.', 'long_description' => 'Дорогие клиенты, мы рады представить вам новый сервис по оформлению похоронных услуг. Теперь вы можете заказать все необходимое онлайн, не выходя из дома. Мы сделаем все возможное, чтобы облегчить вам это трудное время. Для подробной информации обращайтесь к нам.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['date' => '2024-04-20 15:30:00', 'name' => 'Расширение ассортимента венков', 'short_description' => 'Новые венки из свежих цветов уже доступны в нашем ассортименте.', 'long_description' => 'Мы рады сообщить вам, что мы расширили ассортимент венков. Теперь вы можете выбрать из большего разнообразия цветов и стилей. У нас всегда есть подходящий венок для вашего покойного. Посмотрите наши новые образцы в каталоге.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['date' => '2024-04-19 12:00:00', 'name' => 'Скидка 10% на все гробы до конца месяца', 'short_description' => 'Не упустите возможность сэкономить на гробе для вашего близкого.', 'long_description' => 'У нас для вас отличная новость! Мы предлагаем скидку 10% на все гробы до конца текущего месяца. Это отличная возможность сэкономить, не теряя в качестве. Поторопитесь сделать заказ!', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['date' => '2024-04-18 09:00:00', 'name' => 'Открытие нового филиала', 'short_description' => 'Новый филиал нашего бюро появился в вашем районе.', 'long_description' => 'Мы рады сообщить вам об открытии нового филиала нашего бюро в вашем районе. Теперь вы можете получить все необходимые услуги ближе к дому. Приходите к нам и узнайте больше о наших услугах.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['date' => '2024-04-17 14:00:00', 'name' => 'Семинар по организации похоронных церемоний', 'short_description' => 'Приглашаем вас на наш бесплатный семинар.', 'long_description' => 'Мы приглашаем всех заинтересованных на наш бесплатный семинар по организации похоронных церемоний. На семинаре вы узнаете много полезной информации о процессе организации и планирования похоронных мероприятий. Приходите и получите ответы на все ваши вопросы.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        // Создание записей для таблицы categories
        DB::table('categories')->insert([
            ['name' => 'Кресты', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Гробы', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Организация похорон', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Цветы и венки', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Ритуальные услуги', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        // Создание записей для таблицы photo_news
        DB::table('photo_news')->insert([
            ['news_id' => 1, 'path' => 'news1.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['news_id' => 2, 'path' => 'news2.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['news_id' => 3, 'path' => 'news3.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['news_id' => 4, 'path' => 'news4.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['news_id' => 5, 'path' => 'news5.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        // Создание записей для таблицы products
        DB::table('products')->insert([
            ['name' => 'Крест', 'category_id' => 1, 'price' => 250.00, 'description' => 'Крест для установки на могилу.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Гроб', 'category_id' => 2, 'price' => 500.00, 'description' => 'Деревянный гроб для захоронения.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Организация похорон', 'category_id' => 3, 'price' => 100.00, 'description' => 'Услуги по организации похорон.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Венок', 'category_id' => 4, 'price' => 100.00, 'description' => 'Венок из живых цветов.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Ритуальный агент', 'category_id' => 5, 'price' => 50.00, 'description' => 'Помощь ритуального агента.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        // Создание записей для таблицы photo_products
        DB::table('photo_products')->insert([
            ['product_id' => 1, 'path' => 'product1.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 2, 'path' => 'product2.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 3, 'path' => 'product3.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 4, 'path' => 'product4.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 5, 'path' => 'product5.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        // Создание записей для таблицы roles
        DB::table('roles')->insert([
            ['name' => 'Пользователь', 'code' => 'user', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Администратор', 'code' => 'admin', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Менеджер', 'code' => 'manager', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Оператор', 'code' => 'operator', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        // Создание записей для таблицы users
        DB::table('users')->insert([
            ['name' => 'Иван', 'surname' => 'Иванов', 'patronymic' => 'Иванович', 'login' => 'ivan123', 'password' => 'password123', 'email' => 'ivan@example.com', 'telephone' => 123456789, 'role_id' => 1,  'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Петр', 'surname' => 'Петров', 'patronymic' => 'Петрович', 'login' => 'petr456', 'password' => 'password456', 'email' => 'petr@example.com', 'telephone' => 987654321, 'role_id' => 2,  'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Анна', 'surname' => 'Сидорова', 'patronymic' => 'Ивановна', 'login' => 'anna789', 'password' => 'password789', 'email' => 'anna@example.com', 'telephone' => 555666777, 'role_id' => 3,  'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Мария', 'surname' => 'Павлова', 'patronymic' => 'Александровна', 'login' => 'maria987', 'password' => 'password987', 'email' => 'maria@example.com', 'telephone' => 111222333, 'role_id' => 1,  'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Сергей', 'surname' => 'Сергеев', 'patronymic' => 'Сергеевич', 'login' => 'sergey654', 'password' => 'password654', 'email' => 'sergey@example.com', 'telephone' => 777888999, 'role_id' => 2,  'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
