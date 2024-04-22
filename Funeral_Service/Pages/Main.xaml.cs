using Newtonsoft.Json;
using Newtonsoft.Json.Linq;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Net.Http;
using System.Net.Http.Headers;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Navigation;
using System.Windows.Shapes;

namespace Funeral_Service.Pages
{
    /// <summary>
    /// Логика взаимодействия для Main.xaml
    /// </summary>
    public partial class Main : Page
    {
        public MainWindow mainWindow;
        public string fullName { get; set; }
        public Main(MainWindow main)
        {
            InitializeComponent();
            mainWindow = main;
            LoadData();
        }
        private async void LoadData()
        {
            try
            {
                string token = Properties.Settings.Default.Token;

                // Создаем HttpClient
                using (HttpClient client = new HttpClient())
                {
                    // Добавляем заголовок авторизации с токеном Bearer
                    client.DefaultRequestHeaders.Authorization = new AuthenticationHeaderValue("Bearer", token);

                    // Отправляем GET запрос по указанному URL
                    HttpResponseMessage response = await client.GetAsync("http://zaikin-va.tepk-it.ru/api/orders");

                    // Проверяем успешность запроса
                    if (response.IsSuccessStatusCode)
                    {
                        // Получаем содержимое ответа в виде строки
                        string responseBody = await response.Content.ReadAsStringAsync();
                        MessageBox.Show(responseBody);

                        // Десериализуем JSON в объект JObject
                        JObject jsonResponse = JObject.Parse(responseBody);

                        // Получаем массив объектов orders из свойства "data" в JSON
                        JArray ordersArray = (JArray)jsonResponse["data"];

                        // Десериализуем JSON-массив в список объектов Order
                        List<Сompounds> orders = ordersArray.ToObject<List<Сompounds>>();

                        // Привязываем список orders к источнику данных таблицы
                        dataGrid.ItemsSource = orders;
                    }
                    else
                    {
                        MessageBox.Show("Ошибка при получении данных: " + response.ReasonPhrase);
                    }
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Ошибка: " + ex.Message);
            }
        }



        // Класс для представления данных о заказах
        public class Сompounds
        {
            public int Id { get; set; } // Идентификатор заказа
            public int Quantity { get; set; } // Количество товара
            public decimal TotalPrice { get; set; } // Общая цена
            public int OrderId { get; set; } // Идентификатор заказа
            public int ProductId { get; set; } // Идентификатор товара
        }
        private void OrdersButton_Click(object sender, RoutedEventArgs e)
        {
            // Обработка нажатия кнопки "Заказы"
        }

        private void UsersButton_Click(object sender, RoutedEventArgs e)
        {
            // Обработка нажатия кнопки "Пользователи"
        }

        private void ReportsButton_Click(object sender, RoutedEventArgs e)
        {
            // Обработка нажатия кнопки "Отчеты"
        }

        private void EditButton_Click(object sender, RoutedEventArgs e)
        {
            // Обработка нажатия кнопки "Редактировать"
        }
     }
}
