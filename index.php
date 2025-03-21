<?php 
session_start(); 

$auth = $_SESSION['auth'] ?? null;
$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']); // Очищаем сообщение об ошибке

// Получаем текущую дату
$today = new DateTime();

// Проверяем, есть ли дата рождения в сессии
if(isset($_SESSION['birthdate'])) {
    try {
        // Создаем объект DateTime из сессии
        $birthdate = new DateTime($_SESSION['birthdate']);
        
        // Создаем дату текущего года
        $currentYearBirthday = new DateTime($birthdate->format('Y-m-d'));
        $currentYearBirthday->setDate($today->format('Y'), $birthdate->format('m'), $birthdate->format('d'));

        // Проверяем, наступил ли уже ДР в этом году
        if ($currentYearBirthday < $today) {
            // Если наступил, проверяем следующий год
            $nextBirthday = clone $currentYearBirthday;
            $nextBirthday->modify('+1 year');
        } else {
            $nextBirthday = $currentYearBirthday;
        }

        $interval = $today->diff($nextBirthday);
        $daysLeft = $interval->days;

        // Проверяем точное совпадение дат для ДР
        $isBirthday = ($today->format('Y-m-d') === $currentYearBirthday->format('Y-m-d'));
    } catch (Exception $e) {
        // Если дата некорректна, удаляем её из сессии
        unset($_SESSION['birthdate']);
        $daysLeft = null;
        $isBirthday = false;
    }
} else {
    $daysLeft = null;
    $isBirthday = false;
}

// Авторизация
if(!$auth) { ?>
    <div class="auth-form">
        <?php if($error): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form action="process.php" method="post">
        <input name="login" type="text" placeholder="Логин" required>
        <input name="password" type="password" placeholder="Пароль" required>
        <!-- Добавляем необязательное поле для даты рождения -->
        <input name="birthdate" type="date" placeholder="Дата рождения">
        <input name="submit" type="submit" value="Войти">
        </form>

    </div>
<?php } else { ?>
    <p>Здравствуйте, <?php echo htmlspecialchars($_SESSION['user']); ?>!</p>
    <?php if($isBirthday): ?>
        <div class="congratulations">
            <h2>С днем рождения!</h2>
            <p>Поздравляем с праздником и дарим персональную скидку 5% на все услуги!</p>
        </div>
    <?php elseif(isset($daysLeft)): ?>
        <p>До вашего дня рождения осталось: <?php echo $daysLeft; ?> дней</p>
    <?php endif; ?>
    <a href="logout.php">Выйти</a>
<?php } ?>

    <!-- Персональная скидка -->
        
<?php if($auth): ?>
    <div class="personal-offer">
        <h3>Персональная скидка 15%</h3>
        <p>Действует в течение 24 часов с момента входа</p>
        <div id="countdown-timer"></div>
    </div>
    
    <script>
    // Заводим таймер 
    var loginTime = <?php echo $_SESSION['login_time']; ?>;
    var targetDate = new Date(loginTime * 1000 +  24 * 60 * 60 * 1000);
    
    function updateCountdown() {
        var now = new Date();
        var diff = targetDate - now;
        
        if(diff > 0) {
            var hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((diff % (1000 * 60)) / 1000);
            
            document.getElementById('countdown-timer').innerHTML = 
                'Осталось: ' + hours + ' часов ' + minutes + ' минут ' + seconds + ' секунд';
            
            setTimeout(updateCountdown, 1000);
        } else {
            document.getElementById('countdown-timer').innerHTML = 'Акция истекла';
        }
    }
    
    updateCountdown();
    </script>
<?php endif; ?>

    <!-- Фото  салона -->

<h2>Фото нашего салона:</h2>
    <div class="gallery">
        <div class="row">
            <div class="photo-caption">
                <img src="images/photo1.jpg" alt="Зал для массажа">
                <p>Зал для массажа</p>
            </div>
            <div class="photo-caption">
                <img src="images/photo2.webp" alt="Кабинет косметолога">
                <p>Кабинет косметолога</p>
            </div>
        </div>
        
        <div class="row">
            <div class="photo-caption">
                <img src="images/photo3.jpeg" alt="Зона отдыха">
                <p>Зона отдыха</p>
            </div>
            <div class="photo-caption">
                <img src="images/photo4.jpg" alt="Спа-капсула">
                <p>Спа-капсула</p>
            </div>
        </div>
</div>    

    <!-- несколько актуальных услуг для всех пользователей -->

<?php if(!$auth): ?>   
        
    <h2>Текущие акции и спецпредложения:</h2>
    <div class="offers">
        <div class="offer">
            <h3>Акция "Знакомство с салоном"</h3>
            <p>При первом посещении:</p>
            <ul>
                <li>Скидка 20% на любую процедуру</li>
                <li>Бесплатная консультация косметолога</li>
            </ul>
            <p>Действует до 31 марта 2025</p>
        </div>
        
        <div class="offer">
            <h3>Комплексное омоложение</h3>
            <p>При покупке курса из 5 процедур:</p>
            <ul>
                <li>Скидка 30% на весь курс</li>
                <li>В подарок - процедура пилинга</li>
            </ul>
            <p>Действует до 30 апреля 2025</p>
        </div>
        
        <div class="offer">
            <h3>Выходные красоты</h3>
            <p>По субботам и воскресеньям:</p>
            <ul>
                <li>Скидка 15% на все процедуры</li>
                <li>Двойной бонус на карту лояльности</li>
            </ul>
            <p>Бессрочно</p>
        </div>
    </div>
<?php endif; ?>

<!DOCTYPE html>
   

<head>
    <title>Главная страница SPA-салона</title>
    <link rel="stylesheet" href="style.css" type="text/css"/>
    
</head>

<body>

    <h2>Контактная информация:</h2>
<div class="contacts">
    <p>Адрес: г. Уфа, ул. Центральная, 123</p>
    <p>Телефон: +7 (347) 123-45-67</p>
    <p>Email: spa@example.com</p>
    <p>Режим работы: 9:00-21:00</p>
</div>

<h2>Записаться на процедуру:</h2>
<form method="post" action="booking.php" onsubmit="return confirmBooking();">
 <label>Ваше имя:</label>
 <input type="text" name="name" required><br>
 
 <label>Телефон:</label>
 <input type="text" name="phone" required><br>
 
 <label>Желаемая процедура:</label><br>
 <select name="service">
 <option value="массаж">Массаж всего тела</option>
 <option value="обертывание">Обертывания</option>
 <option value="пилинг">Пилинг</option>
 <option value="уход">Уход за лицом</option>
 <option value="маникюр">Маникюр</option>
 </select><br>
 
 <label>Удобное время:</label>
 <input type="datetime-local" name="datetime" required><br>
 
 <button type="submit">Записаться</button>
</form>

<script>
function confirmBooking() {
 // Показываем сообщение
 if (confirm('Вам позвонит менеджер для уточнения заказа')) {
 // Отменяем отправку формы
 return false;
 }
 return false;
}
</script>

</body>

<footer>
    <p>© 2025 SPA-салон "Гармония"</p>
    <p>Политика конфиденциальности | Условия использования</p>
</footer>

<html>

