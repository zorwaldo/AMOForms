<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<h1 id="formSuccess" style="display: none; color:green; text-align: center;">Форма успешно отправлена</h1>
	<div id="formContainer">
	<form id="myForm" method="POST">
    <h1>Заявка</h1>
    <hr>
    
    <label for="name"><b>Имя</b></label>
    <input type="text" placeholder="Введите имя" name="name" required><br>
    
    <label for="email"><b>Email</b></label> 
    <input type="text" placeholder="Введите электронную почту" name="email" required><br>

    <label for="phone" ><b>Номер телефона</b></label>
    <input type="text" id="phone"  name="phone" required><br>
    
    <label for="price"><b>Цена, руб</b></label>
    <input type="text" id="price" placeholder="Введите цену" name="price" required><br>
    
    <hr>
    
    <button type="submit" class="registerbutton">Отправить</button>
  </form>
  </div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function() {
    $('#myForm').submit(function(e) {
        e.preventDefault(); // Отменить стандартное действие отправки формы

        // Получить данные из формы
        var formData = $(this).serialize();

        // Отправить AJAX-запрос
        $.ajax({
            url: 'send.php', // Путь к файлу обработчику на сервере
            type: 'POST',
            data: formData,
            success: function(response) {
                // Обработка успешного ответа сервера
                console.log(response); // Вывести ответ сервера в консоль
				const responseObject = JSON.parse(response);
				const detail = responseObject.detail;
				if(detail){
				alert(detail);
				}else{
					const formContainer = document.getElementById('formContainer');
					formContainer.style.display = "none";
					const formSuccess = document.getElementById('formSuccess');
					formSuccess.style.display="inline";
				}
            },
			error: function(xhr, status, error) {
				// Обработка ошибки
				console.log(xhr.status); // Вывести код ошибки в консоль
				alert('Произошла ошибка при отправке формы.');
			}

        });
    });
});
</script>

</body>
<script src="https://unpkg.com/imask"></script>
<script src="js/masks.js"></script>
</html>