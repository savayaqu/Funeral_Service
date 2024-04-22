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
            ['name' => 'При получении, наличными'],
            ['name' => 'Кредитная карта'],
            ['name' => 'СБП'],
            ['name' => 'Bitcoin'],
        ]);

        // Создание записей для таблицы news
        DB::table('news')->insert([
            ['date' => '2023-01-21 10:00:00', 'name' => 'Новый сервис по оформлению похоронных услуг', 'short_description' => 'Представляем вам новый сервис для удобного заказа похоронных услуг.', 'long_description' => 'Дорогие клиенты, мы рады представить вам новый сервис по оформлению похоронных услуг. Теперь вы можете заказать все необходимое онлайн, не выходя из дома. Мы сделаем все возможное, чтобы облегчить вам это трудное время. Для подробной информации обращайтесь к нам.'],
            ['date' => '2023-04-20 15:30:00', 'name' => 'Расширение ассортимента венков', 'short_description' => 'Новые венки из свежих цветов уже доступны в нашем ассортименте.', 'long_description' => 'Мы рады сообщить вам, что мы расширили ассортимент венков. Теперь вы можете выбрать из большего разнообразия цветов и стилей. У нас всегда есть подходящий венок для вашего покойного. Посмотрите наши новые образцы в каталоге.'],
            ['date' => '2023-02-11 12:00:00', 'name' => 'Скидка 10% на все гробы до конца месяца', 'short_description' => 'Не упустите возможность сэкономить на гробе для вашего близкого.', 'long_description' => 'У нас для вас отличная новость! Мы предлагаем скидку 10% на все гробы до конца текущего месяца. Это отличная возможность сэкономить, не теряя в качестве. Поторопитесь сделать заказ!'],
            ['date' => '2023-05-09 09:00:00', 'name' => 'Открытие нового филиала', 'short_description' => 'Новый филиал нашего бюро появился в вашем районе.', 'long_description' => 'Мы рады сообщить вам об открытии нового филиала нашего бюро в вашем районе. Теперь вы можете получить все необходимые услуги ближе к дому. Приходите к нам и узнайте больше о наших услугах.'],
            ['date' => '2024-04-04 14:00:00', 'name' => 'Семинар по организации похоронных церемоний', 'short_description' => 'Приглашаем вас на наш бесплатный семинар.', 'long_description' => 'Мы приглашаем всех заинтересованных на наш бесплатный семинар по организации похоронных церемоний. На семинаре вы узнаете много полезной информации о процессе организации и планирования похоронных мероприятий. Приходите и получите ответы на все ваши вопросы.'],
        ]);
        // Заполнение таблицы categories
        DB::table('categories')->insert([
            ['name' => 'Кресты'],
            ['name' => 'Гробы'],
            ['name' => 'Венки'],
            ['name' => 'Траурные ленты'],
            ['name' => 'Урны'],
            ['name' => 'Ритуальные услуги']
        ]);
        // Заполнение таблицы products
        DB::table('products')->insert([
            ['name' => 'Гроб простой без постели', 'description' => 'Материал: Сосновая доска\r\nОтделка гроба: Ткань бордового цвета', 'price' => 6500, 'quantity' => 9999, 'category_id' => 2],
            ['name' => 'Гроб социальный без постели', 'description' => 'Материал: Сосновая доска\r\nОтделка гроба: Ткань бордового цвета', 'price' => 6500, 'quantity' => 9999, 'category_id' => 2],
            ['name' => 'Гроб шёлковый белый с тесьмой', 'description' => 'Материал: Сосновая доска\r\nОтделка гроба: Шелковая ткань белого цвета, отделка тесьмой по контуру', 'price' => 7500, 'quantity' => 9999, 'category_id' => 2],
            ['name' => 'Гроб полированный «Скрипка» белый', 'description' => 'Материал: Сосновая доска\r\nОтделка гроба: Эксклюзивный полированный белый гроб.', 'price' => 31000, 'quantity' => 666, 'category_id' => 2],
            ['name' => 'Крест дубовый с домиком',  'description' => NULL, 'price' => 8000, 'quantity' => 9999, 'category_id' => 1],
            ['name' => 'Крест дубовый без домика', 'description' => NULL, 'price' => 7500.00, 'quantity' => 9999, 'category_id' => 1],
            ['name' => 'Крест «Вечная память»',    'description' => NULL, 'price' => 3000.00, 'quantity' => 5, 'category_id' => 1],
            ['name' => 'Крест православный с распятием','description' => NULL, 'price' => 2600.00, 'quantity' => 777, 'category_id' => 1],
            ['name' => 'Венок 75 см', 'description' => 'Артикул: 07500\r\nЦвет: Красный\r\nМатериал: Искусственные цветы', 'price' => 1700.00, 'quantity' => 9999, 'category_id' => 3],
            [ 'name' => 'Венок 85 см', 'description' => 'Артикул: Р08503Б\r\nЦвет: Белый\r\nМатериал: Искусственные цветы', 'price' => 1900.00, 'quantity' => 9999, 'category_id' => 3],
            [ 'name' => 'Венок 105 см', 'description' => 'Артикул: Р10514\r\nЦвет: Бежевый\r\nМатериал: Искусственные цветы', 'price' => 2300.00, 'quantity' => 9999, 'category_id' => 3],
            [ 'name' => 'Венок 120 см', 'description' => 'Артикул: Р12002Е\r\nЦвет: Зеленый с белым\r\nМатериал: Искусственные цветы', 'price' => 6000.00, 'quantity' => 9999, 'category_id' => 3],
            [ 'name' => 'Лента траурная', 'description' => 'Возможны различные варианты траурных надписей', 'price' => 200.00, 'quantity' => 9999, 'category_id' => 4],
            [ 'name' => 'Урна для праха ДУ-4',  'description' => NULL,  'price' => 3190.00, 'quantity' => 1488, 'category_id' => 5],
            [ 'name' => 'Урна для праха УФ-16', 'description' => NULL,  'price' => 3290.00, 'quantity' => 1488, 'category_id' => 5],
            [ 'name' => 'Урна для праха У17Н',  'description' => NULL,  'price' => 4500.00, 'quantity' => 1488, 'category_id' => 5],
            [ 'name' => 'Урна для праха УРД-2-О','description' => NULL, 'price' => 5100.00, 'quantity' => 1488, 'category_id' => 5],
            [ 'name' => 'Выезд агента на адрес', 'description' => 'Чтобы облегчить тяжесть утраты и избавить вас от забот по самостоятельной организации похорон ваших родных, у нас предусмотрена услуга вызов ритуального агента на адрес к заказчику. На месте из каталога, предоставленного агентом, вы сможете выбрать и заказать доставку необходимых атрибутов для похорон усопшего, а также заключить договор на предоставление необходимого вам пакета услуг, который включает в себя все начиная с изделий для похорон и заканчивая бронированием места для организации поминального обеда.', 'price' => 5000.00, 'quantity' => 9999, 'category_id' => 6],
            [ 'name' => 'Доставка тела', 'description' => 'Смерть родных людей всегда большое потрясение. Поэтому, многие обращаются в агентства по организации похорон, которые берут на себя все сложности с перевозкой тела из дома в морг и обратно. Со стоимостью доставки тела можно ознакомиться в прайсе. Доставка осуществляется в заранее оговоренный день и время.\r\nПеревозка тела покойного может быть не только внутренней, но и международной. В каждой стране существуют свои законы и правила, которые необходимо соблюдать при перевозке тела, если речь идет о дальнобойной доставки тела усопшего. Одним из основных требований является наличие комплекта документов на покойного человека, который включает в себя: смертный акт, медицинское заключение о причинах смерти и другие документы.\r\nПодготовка тела к перевозке также требует особого внимания. Оно должно быть помещено в герметичный и специально предназначенный для этого контейнер. Кроме того, на тело должна быть наложена специальная противомозговая повязка, чтобы предотвратить выделение гниющих газов и запаха. Это все касается междугородних перевозок, внутригородские проходят значительно проще, об этом готовы проконсультировать по телефону.', 'price' => 2600.00, 'quantity' => 9999, 'category_id' => 6],
            [ 'name' => 'Катафалк', 'description' => 'В функциональном отношении катафалк предназначен для службы похорон и перевозки умершего из дома или больницы до кладбища. Кроме того, такой автомобиль может использоваться в качестве элемента траурной церемонии. Катафалки существуют с различным уровнем окраски и декорации, в зависимости от религиозных и культурных принципов, но как правило, все они представляют собой строгий, но очень красивый элемент траурной обстановки.\r\nХотя использование катафалка многим людям может показаться несколько запрещённым и странным делом, но в реальности это является принятой практикой в многих странах мира, где траурные обряды проводятся с большим уважением и почтением к умершему.\r\nЗаказать Катафалк для перевозки тела усопшего в Томске\r\nАренда катафалка в Томске - неотъемлемая часть для организации церемонии проводов родственника. Перевозка гроба с покойным чаще осуществляется специализированным похоронным транспортом, который предоставляется нашим агентством в границах области.', 'price' => 6500.00, 'quantity' => 9999, 'category_id' => 6],
            [ 'name' => 'Омовение, одеяние покойного', 'description' => 'Омовение и одевание покойного являются важной частью процесса похоронных обрядов. Эти этапы позволяют прощаться с ушедшим близким и подготовить тело к похоронам. Омовение покойного, также известное как орошение или орошение водой, является одним из старейших похоронных обрядов. Это обряд, при котором тело покойного тщательно очищается водой или другой жидкостью. Омовение производится для устранения любых остатков загрязнений или радости, которые могут остаться на теле.\r\nРитуал омовения и облачения покойного в одежду перед укладкой в гроб требует соблюдения некоторых правил данной процедуры, с которыми знаком не каждый. Поэтому для выполнения таких работ приглашают людей, которые хорошо знакомы с процессом. Обычно это пожилые женщины, но не обязательно. С этой услугой часто покупают и ритуальные товары, и памятники.', 'price' => 4000.00, 'quantity' => 9999, 'category_id' => 6],
            [ 'name' => 'Укладка тела в гроб', 'description' => 'Просто закинуть труп в гроб', 'price' => 300.00, 'quantity' => 9999, 'category_id' => 6],
            [ 'name' => 'Установка креста', 'description' => 'Просто поставим крест *BOOM* и он уже стоит как ХУЙ', 'price' => 1000.00, 'quantity' => 9999, 'category_id' => 6],
        ]);

        // Заполнение таблицы roles
        DB::table('roles')->insert([
            ['name' => 'Администратор', 'code' => 'admin'],
            ['name' => 'Клиент', 'code' => 'user'],
            ['name' => 'Менеджер', 'code' => 'manager'],
            ['name' => 'Сотрудник', 'code' => 'employee']
        ]);

        // Заполнение таблицы shifts
        DB::table('shifts')->insert([
            [ 'status' => 'Активна', 'date_start' => '2024-04-23 07:22:44', 'date_end' => '2024-04-23 23:22:44'],
            [ 'status' => 'Активна', 'date_start' => '2024-04-23 07:22:44', 'date_end' => '2024-04-23 23:22:44'],
            [ 'status' => 'Не активна', 'date_start' => '2024-05-23 07:22:44', 'date_end' => '2024-06-23 23:22:44'],
            [ 'status' => 'Активна', 'date_start' => '2024-06-23 07:22:44', 'date_end' => '2024-07-23 23:22:44']
        ]);
        // Заполнение таблицы пользователи
        DB::table('users')->insert([
           ['name' => 'savayaqu', 'surname' => 'savayaqu', 'patronymic' => NULL, 'login' => 'savayaqu', 'password' => 'savayaqu', 'email' => 'savayaqu@mail.ru', 'telephone' => '88005553535', 'api_token' => 'savayaqu', 'role_id' => 1, 'shift_id' => NULL],
           ['name' => 'admin', 'surname' => 'admin', 'patronymic' => NULL, 'login' => 'admin', 'password' => 'admin', 'email' => 'admin@mail.ru', 'telephone' => '22', 'api_token' => 'admin', 'role_id' => 1, 'shift_id' => NULL],
           ['name' => 'manager', 'surname' => 'manager', 'patronymic' => NULL, 'login' => 'manager', 'password' => 'manager', 'email' => 'manager@mail.ru', 'telephone' => '333', 'api_token' => 'manager', 'role_id' => 3, 'shift_id' => NULL],
           ['name' => 'employee', 'surname' => 'employee', 'patronymic' => NULL, 'login' => 'employee', 'password' => 'employee', 'email' => 'employee@mail.ru', 'telephone' => '4444', 'api_token' => 'employee', 'role_id' => 4, 'shift_id' => NULL],
           ['name' => 'ivan', 'surname' => 'ivan', 'patronymic' => NULL, 'login' => 'ivan', 'password' => 'ivan', 'email' => 'ivan@mail.ru', 'telephone' => '10', 'api_token' => 'ivan', 'role_id' => 2, 'shift_id' => NULL],
           ['name' => 'user1', 'surname' => 'user1', 'patronymic' => NULL, 'login' => 'user1', 'password' => 'user1', 'email' => 'user1@mail.ru', 'telephone' => '11', 'api_token' => 'user1', 'role_id' => 2, 'shift_id' => NULL],
           ['name' => 'user2', 'surname' => 'user2', 'patronymic' => NULL, 'login' => 'user2', 'password' => 'user2', 'email' => 'user2@mail.ru', 'telephone' => '12', 'api_token' => 'user2', 'role_id' => 2, 'shift_id' => NULL],
           ['name' => 'user3', 'surname' => 'user3', 'patronymic' => NULL, 'login' => 'user3', 'password' => 'user3', 'email' => 'user3@mail.ru', 'telephone' => '13', 'api_token' => 'user3', 'role_id' => 2, 'shift_id' => NULL],
           ['name' => 'employee2', 'surname' => 'employee2', 'patronymic' => NULL, 'login' => 'employee2', 'password' => 'employee2', 'email' => 'employee2@mail.ru', 'telephone' => '14', 'api_token' => 'employee2', 'role_id' => 4, 'shift_id' => 1],
           ['name' => 'employee3', 'surname' => 'employee3', 'patronymic' => NULL, 'login' => 'employee3', 'password' => 'employee3', 'email' => 'employee3@mail.ru', 'telephone' => '15', 'api_token' => 'employee3', 'role_id' => 4, 'shift_id' => 2],
        ]);
        // Заполнение таблицы статуса заказов
        DB::table('status_orders')->insert([
           ['name' => 'В ожидании'],
           ['name' => 'Формируется'],
           ['name' => 'Выполняется'],
           ['name' => 'Завершён'],
           ['name' => 'Отменён'],
        ]);
        // Заполнение таблицы заказы
        DB::table('orders')->insert([
            ['date_order' => '2023-04-22 15:14:15', 'payment_id' => 1, 'user_id' => 6, 'employee_id' => 4, 'status_order_id' => 4],
            ['date_order' => '2023-06-18 12:16:05', 'payment_id' => 2, 'user_id' => 7, 'employee_id' => 9, 'status_order_id' => 2],
            ['date_order' => '2023-07-03 20:20:11', 'payment_id' => 3, 'user_id' => 8, 'employee_id' => 10, 'status_order_id' => 3],
            ['date_order' => '2024-02-21 05:53:35', 'payment_id' => 4, 'user_id' => 6, 'employee_id' => NULL, 'status_order_id' => 1]
        ]);
        // Заполнение таблицы состав заказа
        DB::table('compounds')->insert([
            ['quantity' => 2, 'total_price' => 3400, 'order_id' => 1, 'product_id' => 9],
            ['quantity' => 3, 'total_price' => 600, 'order_id' => 2, 'product_id' => 13],
            ['quantity' => 1, 'total_price' => 6500, 'order_id' => 2, 'product_id' => 20],
            ['quantity' => 1, 'total_price' => 300, 'order_id' => 3, 'product_id' => 22],
            ['quantity' => 2, 'total_price' => 16000, 'order_id' => 4, 'product_id' => 5],
            ['quantity' => 1, 'total_price' => 31000, 'order_id' => 3, 'product_id' => 4],
            ['quantity' => 3, 'total_price' => 6900, 'order_id' => 4, 'product_id' => 11],
            ['quantity' => 1, 'total_price' => 3000, 'order_id' => 1, 'product_id' => 7],
        ]);
        // Заполнение таблицы отзывов
        DB::table('reviews')->insert([
           ['rating' => 5, 'description' => 'Очень красивый венок. Мне нравки. ЖЕЛАЮ ЧТОБЫ ВСЕ СДОХЛИ', 'user_id' => 6, 'product_id' => 9],
           ['rating' => 4, 'description' => 'Никому не желаю потерять близкого человека, но мне пох. Зато крест с домиком, а ты нет.', 'user_id' => 7, 'product_id' => 5],
           ['rating' => 1, 'description' => 'Это пиздец, они реально труп просто кинули', 'user_id' => 8, 'product_id' => 22],
        ]);
    }
}
