SELECT
users.name, COUNT(phone_numbers.user_id) AS numbers_count
FROM `users`
INNER JOIN phone_numbers ON phone_numbers.user_id = users.id
WHERE users.gender = 2
	AND phone_numbers.phone IS NOT NULL
    AND TIMESTAMPDIFF(YEAR, FROM_UNIXTIME(users.birth_date), CURRENT_DATE) >= 18
    AND TIMESTAMPDIFF(YEAR, FROM_UNIXTIME(users.birth_date), CURRENT_DATE) <= 22
GROUP BY (phone_numbers.user_id)
