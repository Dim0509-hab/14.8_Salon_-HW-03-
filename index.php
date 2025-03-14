<!DOCTYPE html>
<html>
<head>
    <title>Главная страница SPA-салона</title>
</head>
<body>

<?php
session_start();

$auth = $_SESSION['auth'] ?? null;
$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']); // Очищаем сообщение об ошибке

if(!$auth) {
?>
<div class="auth-form">
    <?php if($error): ?>
        <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <form action="process.php" method="post">
    <input name="login" type="text" placeholder="Логин" required>
    <input name="password" type="password" placeholder="Пароль" required>
    <input name="birthdate" type="date" placeholder="Дата рождения" required>
    <input name="submit" type="submit" value="Войти">
</form>
</div>
<?php } else { ?>
<p>Здравствуйте, <?php echo htmlspecialchars($_SESSION['user']); ?>!</p>
<a href="logout.php">Выйти</a>
<?php } ?>
    
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

<?php if($auth): ?>
<div class="personal-offer">
    <h3>Персональная скидка 15%</h3>
    <p>Действует в течение 24 часов с момента входа</p>
    <div id="countdown-timer"></div>
</div>

<script>
// Получаем время 
var loginTime = <?php echo $_SESSION['login_time']; ?>;
var targetDate = new Date(loginTime * 1000 + 24 * 60 * 60 * 1000);

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



    <h2>Контактная информация:</h2>
<div class="contacts">
    <p>Адрес: г. Уфа, ул. Центральная, 123</p>
    <p>Телефон: +7 (347) 123-45-67</p>
    <p>Email: spa@example.com</p>
    <p>Режим работы: 9:00-21:00</p>
</div>

    <h2>Записаться на процедуру:</h2>
<form method="post" action="booking.php">
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

<footer>
    <p>© 2025 SPA-салон "Гармония"</p>
    <p>Политика конфиденциальности | Условия использования</p>
</footer>

<style>

.personal-offer {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 5px;
    margin-bottom: 20px;
}

#countdown-timer {
    font-weight: bold;
    color: #17a2b8;
    margin-bottom: 10px;
}


.offers {
 display: flex;
 flex-wrap: wrap;
 justify-content: space-between;
 margin: 0 -15px;
}

.offer {
 flex: 0 0 30%;
 padding: 20px;
 margin: 15px;
 background-color: #f8f9fa;
 border-radius: 5px;
 box-shadow: 0 2px 5px rgba(0,0,0,0.1);
 transition: transform 0.3s;
}

.offer:hover {
 transform: scale(1.02);
}

.offer h3 {
 color: #17a2b8;
 margin-bottom: 10px;
}

.offer ul {
 list-style: disc;
 padding-left: 20px;
}

@media (max-width: 768px) {
.offer {
 flex: 0 0 100%;
 margin: 10px 0;
 }
}

.auth-form {
    width: 600px;
    margin: 20px auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.error-message {
    color: #dc3545;
    background-color: #f8d7da;
    border-color: #f5c6cb;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 5px;
}

input {
    width: 50%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
}

    .gallery {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    margin: 0 -10px;
}

.row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.photo-caption {
    flex: 0 0 48%;
    margin: 0 10px;
    text-align: center;
    transition: transform 0.3s;
}

.photo-caption img {
    width: 100%;
    height: auto;
}

.photo-caption p {
    font-family: Arial, sans-serif;
    font-size: 14px;
    color: #333;
    margin-top: 5px;
    background-color: rgba(255, 255, 255, 0.8);
    padding: 5px 10px;
    border-radius: 5px;
}

.photo-caption:hover {
    transform: scale(1.05);
}

@media (max-width: 768px) {
    .photo-caption {
        flex: 0 0 100%;
        margin: 0;
    }
    
    .photo-caption p {
        font-size: 12px;
    }
}

    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }
    
    .gallery {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;ы
    }
    
    .gallery img {
        width: 90%;
        margin: 5px;
        border-radius: 5px;
    }
    
    .contacts {
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 5px;
    }
    
    form {
        width: 50%;
        margin: auto;
    }
    
    form label {
        display: block;
        margin-top: 10px;
    }
    
    footer {
        text-align: center;
        margin-top: 30px;
        color: #777;
    }
</style>