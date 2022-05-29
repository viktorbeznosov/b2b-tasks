<?php

/**
 * @about
 * 1. В первоначальном коде присутствовали уязвимости от SQL инъекций.
 *    Для их избежания используется функции типа real_escape_string (или addslashes) для экранирования спецсимволов.
 *    Так же используются подготовленные запросы
 * 2. Так же внутри цикла в каждой итерации происходил подключение к БД mysqli_connect и закрытие соединения mysqli_close.
 *    mysqli_connect и mysqli_close убрал из цикла
 * 3. Так же что бы избавиться от цикла, в котором каждый раз делается запрос к базе лучше сделать один запрос типа
 *    "SELECT * FROM users WHERE id IN (?,?,....)" и возвращать полученные данные, что было сделано во втором примере (папка example2)
 *
 * @param $user_ids
 * @return array
 *
 */
function load_users_data($user_ids)
{
    $db = mysqli_connect("localhost", "b2b", "b2btest", "b2b") OR die("Can't connect to database");
    $user_ids = $db->real_escape_string($user_ids);
    $user_ids = array_map('intval', explode(',', $user_ids));

    $data = array();

    foreach ($user_ids as $user_id) {
        $sql = mysqli_prepare($db, "SELECT * FROM users WHERE id = ?");
        $sql->bind_param('i', $user_id);
        $sql->execute();
        $obj = $sql->get_result()->fetch_object();
        $data[$user_id] = $obj->name;
    }

    mysqli_close($db);

    return $data;

}

if (!empty($_GET['user_ids'])) {
    $data = load_users_data($_GET['user_ids']);

    foreach ($data as $user_id=>$name) {
        echo "<a href=\"/show_user.php?id=$user_id\">$name</a> ";
    }
}

