<?php

/**
 * @param $user_ids
 * @return bool|mysqli_result
 * @about Что бы избавиться от цикла, в котором каждый раз делается запрос к базе данных, переделал запрос
 * на запрос типа "SELECT * FROM users WHERE id IN (?,?,...)"
 */
function load_users_data($user_ids)
{
    $db = mysqli_connect("localhost", "b2b", "b2btest", "b2b") OR die("Can't connect to database");
    $user_ids = $db->real_escape_string($user_ids);
    $user_ids = array_map('intval', explode(',', $user_ids));

    $user_ids_string = '(' . implode($user_ids, ',') . ')';
    $bindClause = "(" . implode(',', array_fill(0, count($user_ids), '?')) . ")";
    $bindString = str_repeat('i', count($user_ids));

    $sql = $db->prepare("SELECT * FROM users WHERE id IN " . $bindClause);
    $sql->bind_param($bindString, ...$user_ids);
    $sql->execute();

    $data = $sql->get_result();

    mysqli_close($db);

    return $data;
}

if (!empty($_GET['user_ids'])) {
    $data = load_users_data($_GET['user_ids']);

    foreach ($data as $user) {
        echo "<a href=\"/show_user.php?id={$user['id']}\">{$user['name']}</a> ";
    }
}