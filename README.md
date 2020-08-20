Тестовое задание Oxem

Для запуска

<ul>
    <li>
    Запустить миграцию
    </li>
    <li>
    вызвать комманду artisan passport:install
    </li>
    <li>
          Запустить seeding --class=DatabaseSeeder
    </li>
    <li>
     Запустить сервер
    </li>
    <li>
    Для регистрации отправить POST XMLHttpRequest запрос на .../api/auth/register
    c полями 
        <ol>
        <li>
        name - имя пользователя
        </li>
        <li>
        email - email
        </li>        
        <li>
        password - пароль
        </li>        
        <li>
        password_confirmation - подтверждение пароля
        </li>
        </ol>
    </li>
    <li>
        Для получения Bearer токена отправить POST запрос на /api/auth/login
        c полями: email - (example@gmail.com) и password - (password) - в скобках значения указанные в Userseeder
    </li>
    <li>
        Консольная комманда - artisan filedata:seed
        Файлы products.json и categories.json распологаются в директории /storage/app
    </li>
    
</ul>
